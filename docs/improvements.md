# Code improvement opportunities

This document summarizes findings from a scan of the **club** PHP project (layout, `app/` models, entry scripts, and representative `users/` / `public/` pages). It is a backlog of improvements, not a commitment to implement everything.

---

## Security (high priority)

### Password storage

- Passwords are hashed with **MD5** (`User` model, `Account::login`, profile password forms, `Superuser` CLI).
- **Improvement:** Use **`password_hash()`** with `PASSWORD_DEFAULT` (bcrypt/argon2) and **`password_verify()`** for login. Plan a one-time migration for existing MD5 hashes (e.g. verify with MD5 once, then re-hash with `password_hash` on successful login).

### Database credentials

- `app/Database/DB.php` embeds DSN, username, and password in source.
- **Improvement:** Load from **environment variables** or a **`.env`** file (excluded from git) and document required keys in a sample file.

### SQL construction

- **`Event`**: `ORDER BY start_date $order` and `ORDER BY created_at $order` interpolate `$order` into SQL. Callers currently use defaults (`ASC` / `DESC`), but the API allows arbitrary strings → **SQL injection** if ever wired to user input.
- **Improvement:** Whitelist: `if (!in_array($order, ['ASC', 'DESC'], true)) { $order = 'ASC'; }` (same for feed ordering).
- **`Event::getTodaysEvent` / `getTodaysEventForUser`**: `LIKE '%$date%'` uses a PHP-built date; safe today but pattern encourages copy-paste of unsafe interpolation.
- **Improvement:** Prefer `DATE(start_date) = :day` with a bound `:day` parameter.

### Session data

- User objects are **`serialize()`d** into `$_SESSION` (`public/login.php`, user/admin areas).
- **Improvement:** Store only **user id** (and minimal flags) in session; load `User` from DB per request, or use signed session payloads.

### Unauthenticated page access

- Example: `users/index.php` calls `unserialize($_SESSION['user'])` without checking `isset($_SESSION['user'])` first → notices/errors for guests.
- **Improvement:** Central **auth guard**: if not logged in, redirect to `public/login.php`.

---

## Reliability and correctness

### `Feed::delete()`

- After `DELETE FROM feeds`, the code calls **`updateCurrentInstance()`**, which runs `SELECT ... WHERE id = :id` for a row that no longer exists.
- **Improvement:** Clear in-memory state and return `true`, or set `$this->id = null` and skip re-fetch.

### `Event::getAttendance()`

- Auto-creates attendance rows for past events inside a getter; may have **side effects** on every read.
- **Improvement:** Move “ensure attendance rows exist” to a dedicated **command/cron** or explicit admin action.

---

## Performance

### N+1 queries

- Several loops call **`User::find($id)`**, **`Attendance::find($id)`**, etc. per row.
- **Improvement:** Batch-load by IDs (`WHERE id IN (...)`) or join in one query, then hydrate models.

---

## Code quality and maintainability

### PSR-4 and folder casing

- On case-sensitive filesystems, duplicate `app/Model` vs `app\Model` style paths can break autoloading. **Standardize** on one directory name.

### Dependency management

- `composer.json` has **`require: {}`** — no framework, no dev tools.
- **Improvement:** Add **PHPStan** or **Psalm**, **PHPUnit**, and optionally a small router if you outgrow `include` chains.

### Input validation

- `public/login.php` uses `$_POST['username']` etc. without **`isset()`** / **`??`** — can trigger notices under strict error reporting.
- **Improvement:** Validate presence and type before use.

---

## Operations and DX

- **Error logging:** With `PDO::ERRMODE_EXCEPTION`, ensure production logs errors without exposing stack traces to users.
- **HTTPS:** Enforce HTTPS and **secure session cookie** flags when deployed behind TLS.

---

## Quick wins (low effort)

| Item | Action |
|------|--------|
| Auth redirect | `isset($_SESSION['user'])` guard on user-facing pages |
| ORDER BY | Whitelist `ASC` / `DESC` only |
| Post keys | `$_POST['username'] ?? ''` or explicit validation |
| Passwords | Plan migration to `password_hash` / `password_verify` |

---

## Already in good shape

- **`declare(strict_types=1);`** in `app/` models and helpers.
- **PDO prepared statements** for most queries.
- **`DbCast`** helpers for strict int properties vs string DB values.
- **PDO** configured with `ERRMODE_EXCEPTION` and `FETCH_ASSOC` in `DB::getInstance()`.

---

*Update this file as improvements are implemented.*
