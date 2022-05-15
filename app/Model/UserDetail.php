<?php 

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class UserDetail implements Model
{
    public ?User $user;

    public function __construct(
        public int $user_id,
        public string $student_id,
        public string $first_name,
        public string $last_name,
        public string $gender,
        public string $phone,
        public string $year,
        public int $is_active,
        public ?int $id,
        public ?string $created_at,
        public ?string $updated_at
    ) 
    {
        $this->user = User::find($user_id);
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
            $data['student_id'],
            $data['first_name'],
            $data['last_name'],
            $data['gender'],
            $data['phone'],
            $data['year'],
            $data['is_active'],
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
    public static function find(int $id, bool $showAll = false):?self
    {
        $sql = "SELECT * FROM users_details WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if($data){
            return new self(
                $data['user_id'],
                $data['student_id'],
                $data['first_name'],
                $data['last_name'],
                $data['gender'],
                $data['phone'],
                $data['year'],
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
        $sql = "SELECT * FROM users_details";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $result = [];
        foreach($data as $row){
            $result[] = new self(
                $row['user_id'],
                $row['student_id'],
                $row['first_name'],
                $row['last_name'],
                $data['gender'],
                $data['phone'],
                $data['year'],
                $data['is_active'],
                $data['id'],
                $data['created_at'],
                $data['updated_at']
            );
        }
        return $result;
    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save():bool
    {
        if($this->id){
            $sql = "UPDATE users_details SET user_id = :user_id, student_id = :student_id, first_name = :first_name, last_name = :last_name,phone = :phone, gender = :gender, year = :year, is_active = :is_active, updated_at = NOW() WHERE id = :id ";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':student_id' => $this->student_id,
                ':first_name' => $this->first_name,
                ':last_name' => $this->last_name,
                ':phone' => $this->phone,
                ':gender' => $this->gender,
                ':is_active' => $this->is_active,
                ':year' => $this->year,
                ':id' => $this->id
            ]);
        }else{  
            $sql = "INSERT INTO users_details (user_id, student_id, first_name, last_name, phone, gender, year, is_active, created_at, updated_at) VALUES (:user_id, :student_id, :first_name, :last_name, :phone, :gender, :year, :is_active, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':student_id' => $this->student_id,
                ':first_name' => $this->first_name,
                ':last_name' => $this->last_name,
                ':phone' => $this->phone,
                ':gender' => $this->gender,
                ':is_active' => $this->is_active,
                ':year' => $this->year,
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
            $sql = "UPDATE users_details SET is_active = 0 WHERE id = :id";
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
            $sql = "SELECT * FROM users_details WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if($data){
                $this->user_id = $data['user_id'];
                $this->student_id = $data['student_id'];
                $this->first_name = $data['first_name'];
                $this->last_name = $data['last_name'];
                $this->gender = $data['gender'];
                $this->phone = $data['phone'];
                $this->year = $data['year'];
                $this->is_active = $data['is_active'];
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                $this->user = User::find($this->user_id);
                return true;
            }
            return false;
        }
        return false;            
    }
}