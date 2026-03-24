<?php

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class UserDivision implements Model
{

    public function __construct(
        public int $user_id,
        public int $division_id,
        public int $is_active,
        public ?int $id,
        public ?string $created_at,
        public ?string $updated_at
    ) 
    {
    }
    /**
     * create new instance
     * 
     * @param array $data
     * @return self
     */
    public static function create(array $data): self
    {
        return new self(
            DbCast::int($data['user_id'] ?? 0),
            DbCast::int($data['division_id'] ?? 0),
            DbCast::int($data['is_active'] ?? 0),
            null,
            null,
            null,
        );
    }

    /**
     * get single record by id
     * 
     * @param int $id
     * @return self
     */
    public static function find(int $id, bool $showAll = false): ?self
    {
        $sql = "SELECT * FROM users_divisions WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if($data) {
            return new self(
                DbCast::int($data['user_id'] ?? 0),
                DbCast::int($data['division_id'] ?? 0),
                DbCast::int($data['is_active'] ?? 0),
                DbCast::intOrNull($data['id'] ?? null),
                $data['created_at'] ?? null,
                $data['updated_at'] ?? null,
            ); 
        }
        return null;
    }

    /**
     * get all records
     * 
     * @return self[]
     */
    public static function findAll(bool $showAll = false): array
    {
        $sql = "SELECT * FROM users_divisions";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $result = [];
        foreach($data as $row) {
            $result[] = new self(
                DbCast::int($row['user_id'] ?? 0),
                DbCast::int($row['division_id'] ?? 0),
                DbCast::int($row['is_active'] ?? 0),
                DbCast::intOrNull($row['id'] ?? null),
                $row['created_at'] ?? null,
                $row['updated_at'] ?? null,
            );
        }
        return $result;
    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save(): bool
    {
        if($this->id) {
            $sql = "UPDATE users_divisions SET user_id = :user_id, division_id = :division_id, is_active = :is_active, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':division_id' => $this->division_id,
                ':is_active' => $this->is_active,
                ':id' => $this->id,
            ]);
        } else {
            $sql = "INSERT INTO users_divisions (user_id, division_id, is_active, created_at, updated_at) VALUES (:user_id, :division_id, :is_active, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':division_id' => $this->division_id,
                ':is_active' => $this->is_active,
            ]);
            $this->id = (int) DB::getInstance()->lastInsertId();
        }
        $this->updateCurrentInstance();
        return true;
    }

    /**
     * delete current instance from database
     * 
     * @return bool
     */
    public function delete(): bool
    {
        if($this->id) {
            $sql = "UPDATE users_divisions SET is_active = 0 WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $this->updateCurrentInstance();
            return true;
        }
        return false;
    }

    /**
     * update current instance with data from database
     * 
     * @return bool
     */
    public function updateCurrentInstance(): bool
    {
        if($this->id) {
            $sql = "SELECT * FROM users_divisions WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if($data) {
                $this->user_id = DbCast::int($data['user_id'] ?? 0);
                $this->division_id = DbCast::int($data['division_id'] ?? 0);
                $this->is_active = DbCast::int($data['is_active'] ?? 0);
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * get all records by user id
     * 
     * @param int $user_id
     * @return Division[]
     */
    public static function findAllByUserId(int $user_id, bool $showAll = false): array
    {
        $sql = "SELECT * FROM users_divisions WHERE user_id = :user_id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $data = $stmt->fetchAll();
        $result = [];
        foreach($data as $row) {
            $result[] = Division::find(DbCast::int($row['division_id'] ?? 0));
        }
        return $result;
    }

    /**
     * 
     * get bu user id and division id
     * 
     * @param int $user_id
     * @param int $division_id
     * @return self
     */
    public static function findByUserIdAndDivisionId(int $user_id, int $division_id, bool $showAll = false): ?self
    {
        $sql = "SELECT * FROM users_divisions WHERE user_id = :user_id AND division_id = :division_id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':division_id' => $division_id,
        ]);
        $data = $stmt->fetch();
        if($data) {
            return new self(
                DbCast::int($data['user_id'] ?? 0),
                DbCast::int($data['division_id'] ?? 0),
                DbCast::int($data['is_active'] ?? 0),
                DbCast::intOrNull($data['id'] ?? null),
                $data['created_at'] ?? null,
                $data['updated_at'] ?? null,
            ); 
        }
        return null;
    }

}
