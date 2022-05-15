<?php 

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class Attendance implements Model
{
    public ?User $user;
    public ?Event $event;
    /**
     * constarctor
     */
    public function __construct(
        public int $user_id,	
        public int $event_id,
        public int $is_active,
        public ?int $id,
        public ?string $created_at,
        public ?string $updated_at
    ) 
    {
        $this->user = User::find($user_id);
        $this->event = Event::find($event_id);
        return $this;
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
            $data['user_id'],
            $data['event_id'],
            $data['is_active'],
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
                $data['user_id'],
                $data['event_id'],
                $data['is_active'],
                $data['id'],
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
                $attendance['user_id'],
                $attendance['event_id'],
                $attendance['is_active'],
                $attendance['id'],
                $attendance['created_at'],
                $attendance['updated_at']
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
            $sql = "UPDATE attendances SET user_id = :user_id, event_id = :event_id, is_active = :is_active, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':event_id' => $this->event_id,
                ':is_active' => $this->is_active,
                ':id' => $this->id
            ]);
        }else{
            $sql = "INSERT INTO attendances (user_id, event_id, is_active, created_at, updated_at) VALUES (:user_id, :event_id, :is_active, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':event_id' => $this->event_id,
                ':is_active' => $this->is_active
            ]);
            $this->id = DB::getInstance()->lastInsertId();
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
                $this->user_id = $data['user_id'];
                $this->event_id = $data['event_id'];
                $this->is_active = $data['is_active'];
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                $this->user = User::find($this->user_id);
                $this->event = Event::find($this->event_id);
                return true;
            }
            return false;
        }else{
            return false;
        }
    }

}