<?php

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class User implements Model
{
    public ?UserDetail $userDetail;

    public function __construct(
        public string $username,
        public string $password,
        public ?int $id,
        public ?string $last_login,
        public ?int $is_superuser,
        public ?int $is_president,
        public ?string $profile_picture,
        public ?int $is_active,
        public ?string $deactivated_at,
        public ?string $created_at,
        public ?string $updated_at
    ) 
    {
        if($id) $this->userDetail = UserDetail::findByUserId($id);
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
            $data['username'],
            md5($data['password']),
            null,
            null,
            $data['is_superuser'],
            $data['is_president'],
            $data['profile_picture'],
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
     * @param bool $showAll
     * @return self
     */
    public static function find(int $id,bool $showAll = false): ?self
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if ($data) {
            return new self(
                $data['username'],
                $data['password'],
                $data['id'],
                $data['last_login'],
                $data['is_superuser'],
                $data['is_president'],
                $data['profile_picture'],
                $data['is_active'],
                $data['deactivated_at'],
                $data['created_at'],
                $data['updated_at']
            );
        }
        return null;
    }

    /**
     * get all records
     * 
     * @param bool $showAll
     * @return self[]
     */
    public static function findAll(bool $showAll = false): array
    {
        $sql = "SELECT * FROM users";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $users = [];
        foreach ($data as $user) {
            $users[] = new self(
                $user['username'],
                $user['password'],
                $user['id'],
                $user['last_login'],
                $user['is_superuser'],
                $user['is_president'],
                $user['profile_picture'],
                $user['is_active'],
                $user['deactivated_at'],
                $user['created_at'],
                $user['updated_at']
            );
        }
        return $users;
    }

    /**
     * 
     * check if the username is already taken
     * 
     * @param string $username
     * @return boolean
     */
    public static function isUsernameTaken(string $username): bool
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':username' => $username]);
        $data = $stmt->fetch();
        return $data ? true : false;
    }

    /**
     * 
     * check if president is already taken
     * 
     * @return boolean
     */
    public static function isPresidentTaken(): bool
    {
        $sql = "SELECT * FROM users WHERE is_president = :is_president";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':is_president' => 1]);
        $data = $stmt->fetch();
        return $data ? true : false;
    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            $sql = "UPDATE users SET username = :username, password = :password, last_login = :last_login, is_superuser = :is_superuser, is_president = :is_president, profile_picture = :profile_picture, is_active = :is_active, deactivated_at = :deactivated_at, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':username' => $this->username,
                ':password' => $this->password,
                ':last_login' => $this->last_login,
                ':is_superuser' => $this->is_superuser,
                ':is_president' => $this->is_president,
                ':profile_picture' => $this->profile_picture,
                ':is_active' => $this->is_active,
                ':deactivated_at' => $this->deactivated_at,
                ':id' => $this->id
            ]);
        } else {
            $sql = "INSERT INTO users (username, password, last_login, is_superuser, is_president, profile_picture, is_active, deactivated_at, created_at, updated_at) VALUES (:username, :password, :last_login, :is_superuser, :is_president, :profile_picture, :is_active, :deactivated_at, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':username' => $this->username,
                ':password' => $this->password,
                ':last_login' => $this->last_login,
                ':is_superuser' => $this->is_superuser,
                ':is_president' => $this->is_president,
                ':profile_picture' => $this->profile_picture,
                ':is_active' => $this->is_active,
                ':deactivated_at' => $this->deactivated_at
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
        if ($this->id) {
            $sql = "UPDATE users SET is_active = 0 WHERE id = :id";
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
        if ($this->id) {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if ($data) {
                $this->username = $data['username'];
                $this->password = $data['password'];
                $this->last_login = $data['last_login'];
                $this->is_superuser = $data['is_superuser'];
                $this->is_president = $data['is_president'];
                $this->profile_picture = $data['profile_picture'];
                $this->is_active = $data['is_active'];
                $this->deactivated_at = $data['deactivated_at'];
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                $this->userDetail = UserDetail::findByUserId($this->id);
                return true;
            }
            return false;
        }
        return false;    
    }

    /**
     * get user by username
     * 
     * @param string $username
     * @return self
     */
    public static function findByUsername(string $username, bool $showAll=false): ?self
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':username' => $username]);
        $data = $stmt->fetch();
        if ($data) {
            return new self(
                $data['username'],
                $data['password'],
                $data['id'],
                $data['last_login'],
                $data['is_superuser'],
                $data['is_president'],
                $data['profile_picture'],
                $data['is_active'],
                $data['deactivated_at'],
                $data['created_at'],
                $data['updated_at']
            );
        }
        return null;
    }

    /**
     * 
     * get user attendance progresss
     * 
     * @param int $division_id
     * @return ?array
     */
    public function getUserAttendanceProgress(int $division_id, bool $showAll = false) : ?array
    {
        $sql = "SELECT COUNT(*) FROM attendances WHERE event_id IN (SELECT id FROM events WHERE division_id = :division_id) AND is_attended = 1 AND user_id = :user_id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':division_id' => $division_id, 'user_id' => $this->id]);
        $data = $stmt->fetch();

        $sql2 = "SELECT COUNT(*) FROM events WHERE division_id = :division_id ";
        if(!$showAll) $sql2 .= " AND is_active = 1";
        $stmt2 = DB::getInstance()->prepare($sql2);
        $stmt2->execute([':division_id' => $division_id]);
        $data2 = $stmt2->fetch();
        
        return ['attended'=>$data[0], 'all'=>$data2[0]];
    }

    /**
     * 
     * get all user divisions
     * 
     * @return array
     */
    public function hasDivisions() : ?array
    {
        if($this->id) return UserDivision::findAllByUserId($this->id);
        else return null;
    }

    /**
     * 
     * get attendace for division
     * 
     * @param int $division_id
     * @return array
     */
    public function getAttendanceForDivision(int $division_id, bool $showAll = false) : array
    {
        $sql = "SELECT * FROM attendances WHERE event_id IN (SELECT id FROM events WHERE division_id = :division_id) AND user_id = :user_id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':division_id' => $division_id, 'user_id' => $this->id]);
        $data = $stmt->fetchAll();
        $attendances = [];
        foreach($data as $attendance) {
            $attendances[] = Attendance::find($attendance['id']);
        }
        return $attendances;
    }

}
