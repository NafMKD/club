<?php 

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class Attendance implements Model
{
    /**
     * constarctor
     */
    public function __construct(
        public int $user_id,	
        public int $event_id,
        public int $is_attended,
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
    public static function create(array $data):self
    {
        return new self(
            DbCast::int($data['user_id'] ?? 0),
            DbCast::int($data['event_id'] ?? 0),
            DbCast::int($data['is_attended'] ?? 0),
            DbCast::int($data['is_active'] ?? 0),
            null,
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
    public static function find(int $id, bool $showAll = false):?self
    {
        $sql = "SELECT * FROM attendances WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if($data){
            return new self(
                DbCast::int($data['user_id'] ?? 0),
                DbCast::int($data['event_id'] ?? 0),
                DbCast::int($data['is_attended'] ?? 0),
                DbCast::int($data['is_active'] ?? 0),
                DbCast::intOrNull($data['id'] ?? null),
                $data['created_at'] ?? null,
                $data['updated_at'] ?? null
            );
        }
        return null;
    }

    /**
     * get all records
     * 
     * @return self[]
     */
    public static function findAll(bool $showAll = false):array
    {
        $sql = "SELECT * FROM attendances";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $attendances = [];
        foreach ($data as $attendance) {
            $attendances[] = new self(
                DbCast::int($attendance['user_id'] ?? 0),
                DbCast::int($attendance['event_id'] ?? 0),
                DbCast::int($attendance['is_attended'] ?? 0),
                DbCast::int($attendance['is_active'] ?? 0),
                DbCast::intOrNull($attendance['id'] ?? null),
                $attendance['created_at'] ?? null,
                $attendance['updated_at'] ?? null
            );
        }
        return $attendances;

    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save():bool
    {
        if($this->id){
            $sql = "UPDATE attendances SET user_id = :user_id, event_id = :event_id, is_attended = :is_attended, is_active = :is_active, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':event_id' => $this->event_id,
                ':is_attended' => $this->is_attended,
                ':is_active' => $this->is_active,
                ':id' => $this->id
            ]);
        }else{
            $sql = "INSERT INTO attendances (user_id, event_id, is_attended, is_active, created_at, updated_at) VALUES (:user_id, :event_id, :is_attended, :is_active, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':event_id' => $this->event_id,
                ':is_attended' => $this->is_attended,
                ':is_active' => $this->is_active
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
    public function delete():bool
    {
        if($this->id){
            $sql = "UPDATE attendances SET is_active = 0 WHERE id = :id";
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
    public function updateCurrentInstance():bool
    {
        if($this->id){
            $sql = "SELECT * FROM attendances WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if($data){
                $this->user_id = DbCast::int($data['user_id'] ?? 0);
                $this->event_id = DbCast::int($data['event_id'] ?? 0);
                $this->is_attended = DbCast::int($data['is_attended'] ?? 0);
                $this->is_active = DbCast::int($data['is_active'] ?? 0);
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                return true;
            }
            return false;
        }else{
            return false;
        }
    }

    /**
     * get current user
     * 
     * @return ?User
     */
    public function getUser(): ?User
    {
        if($this->user_id)return User::find($this->user_id);
        return null;
    }


    /**
     * get current event
     * 
     * @return ?Event
     */
    public function getEvent(): ?Event
    {
        if($this->event_id)return Event::find($this->event_id);
        return null;
    }

}