<?php

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class Division implements Model
{
    public ?array $event;
    public ?array $members;
    public ?User $division_head;

    public function __construct(
        public string $name,
        public string $description,
        public int $is_active,
        public ?int $id,
        public ?int $division_head_id,
        public ?string $created_at,
        public ?string $updated_at

    ) 
    {
        if($division_head_id) $this->division_head = User::find($division_head_id);
        if($id) $this->members = UserDivision::findAllByDivisionId($id);
        if($id) $this->event = Event::findAllByDivisionId($id);
        return $this;
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
            $data['name'],
            $data['description'],
            $data['is_active'],
            null,
            $data['division_head_id'],
            null,
            null
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
        $sql = "SELECT * FROM divisions WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if ($data) {
            return new self(
                $data['name'],
                $data['description'],
                $data['is_active'],
                $data['id'],
                $data['division_head_id'],
                $data['created_at'],
                $data['updated_at']
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
        $sql = "SELECT * FROM divisions";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $divisions = [];
        foreach ($data as $division) {
            $divisions[] = new self(
                $division['name'],
                $division['description'],
                $division['is_active'],
                $division['id'],
                $division['division_head_id'],
                $division['created_at'],
                $division['updated_at']
            );
        }
        return $divisions;
    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save(): bool
    {
        if($this->id) {
            $sql = "UPDATE divisions SET name = :name, description = :description, is_active = :is_active, division_head_id = :division_head_id, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':description' => $this->description,
                ':is_active' => $this->is_active,
                ':division_head_id' => $this->division_head_id,
                ':id' => $this->id
            ]);
        } else {
            $sql = "INSERT INTO divisions (name, description, is_active, division_head_id, created_at, updated_at) VALUES (:name, :description, :is_active, :division_head_id, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':description' => $this->description,
                ':is_active' => $this->is_active,
                ':division_head_id' => $this->division_head_id
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
            $sql = "UPDATE divisions SET is_active = 0 WHERE id = :id";
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
            $sql = "SELECT * FROM divisions WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if ($data) {
                $this->name = $data['name'];
                $this->description = $data['description'];
                $this->is_active = $data['is_active'];
                $this->division_head_id = $data['division_head_id'];
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                if($this->division_head_id) $this->division_head = User::find($this->division_head_id);
                $this->members = UserDivision::findAllByDivisionId($this->id);
                $this->event = Event::findAllByDivisionId($this->id);
                return true;
            }
            return false;
        }
        return false;
    }
}
