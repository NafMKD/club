<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Coerce PDO / MySQL driver values (often strings) for strict-typed model properties.
 */
final class DbCast
{
    public static function int(mixed $value): int
    {
        return (int) $value;
    }

    public static function intOrNull(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }
}
