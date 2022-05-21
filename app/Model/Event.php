<?php

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class Event implements Model
{
    public ?array $feed;

    public function __construct(
        public string $title,
        public string $description,
        public ?int $id,
        public ?int $division_id,
        public ?string $image_url,
        public ?string $start_date,
        public ?string $end_date,
        public ?int $is_public,
        public ?int $is_active,
        public ?string $created_at,
        public ?string $updated_at
    ) 
    {
        if($id) $this->feed = Feed::findAllByEventId($id);
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
            $data['title'],
            $data['description'],
            null,
            $data['division_id'],
            $data['image_url'],
            $data['start_date'],
            $data['end_date'],
            $data['is_public'],
            $data['is_active'],
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
        $sql = "SELECT * FROM events WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if ($data) {
            return new self(
                $data['title'],
                $data['description'],
                $data['id'],
                $data['division_id'],
                $data['image_url'],
                $data['start_date'],
                $data['end_date'],
                $data['is_public'],
                $data['is_active'],
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
        $sql = "SELECT * FROM events";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $events = [];
        foreach ($data as $event) {
            $events[] = new self(
                $event['title'],
                $event['description'],
                $event['id'],
                $event['division_id'],
                $event['image_url'],
                $event['start_date'],
                $event['end_date'],
                $event['is_public'],
                $event['is_active'],
                $event['created_at'],
                $event['updated_at']
            );
        }
        return $events;
    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save(): bool
    {
        if($this->id) {
            $sql = "UPDATE events SET title = :title, description = :description, division_id = :division_id, image_url = :image_url, start_date = :start_date, end_date = :end_date, is_public = :is_public, is_active = :is_active, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':title' => $this->title,
                ':description' => $this->description,
                ':division_id' => $this->division_id,
                ':image_url' => $this->image_url,
                ':start_date' => $this->start_date,
                ':end_date' => $this->end_date,
                ':is_public' => $this->is_public,
                ':is_active' => $this->is_active,
                ':id' => $this->id
            ]);
        } else {
            $sql = "INSERT INTO events (title, description, division_id, image_url, start_date, end_date, is_public, is_active, created_at, updated_at) VALUES (:title, :description, :division_id, :image_url, :start_date, :end_date, :is_public, :is_active, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':title' => $this->title,
                ':description' => $this->description,
                ':division_id' => $this->division_id,
                ':image_url' => $this->image_url,
                ':start_date' => $this->start_date,
                ':end_date' => $this->end_date,
                ':is_public' => $this->is_public,
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
    public function delete(): bool
    {
        if($this->id) {
            $sql = "UPDATE events SET is_active = 0 WHERE id = :id";
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
            $sql = "SELECT * FROM events WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if ($data) {
                $this->title = $data['title'];
                $this->description = $data['description'];
                $this->division_id = $data['division_id'];
                $this->image_url = $data['image_url'];
                $this->start_date = $data['start_date'];
                $this->end_date = $data['end_date'];
                $this->is_public = $data['is_public'];
                $this->is_active = $data['is_active'];
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                $this->feed = Feed::findAllByEventId($this->id);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * get all by division id
     * 
     * @param int $id
     * @return self[]
     */
    public static function findAllByDivisionId(int $id, bool $showAll = false): array
    {
        $sql = "SELECT * FROM events WHERE division_id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetchAll();
        $events = [];
        foreach ($data as $event) {
            $events[] = new self(
                $event['title'],
                $event['description'],
                $event['id'],
                $event['division_id'],
                $event['image_url'],
                $event['start_date'],
                $event['end_date'],
                $event['is_public'],
                $event['is_active'],
                $event['created_at'],
                $event['updated_at']
            );
        }
        return $events;
    }

    /**
     * 
     * find all by date descending
     * 
     * @return self[]
     */
    public static function findAllByDateDescending(bool $showAll = false): array
    {
        $sql = "SELECT * FROM events";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $sql .= " ORDER BY created_at DESC";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $events = [];
        foreach ($data as $event) {
            $events[] = new self(
                $event['title'],
                $event['description'],
                $event['id'],
                $event['division_id'],
                $event['image_url'],
                $event['start_date'],
                $event['end_date'],
                $event['is_public'],
                $event['is_active'],
                $event['created_at'],
                $event['updated_at']
            );
        }
        return $events;
    }

    /**
     * 
     * has division
     * 
     */
    public function hasDivision(): ?Division
    {
        if($this->division_id) {
            return Division::find($this->division_id);
        }
        return null;
    }

    /**
     * 
     * get upcoming events
     * 
     * @return self[]
     */
    public static function getUpcomingEvents(bool $showAll = false): array
    {
        $sql = "SELECT * FROM events WHERE start_date >= NOW()";
        if(!$showAll) $sql .= " AND is_active = 1";
        $sql .= " ORDER BY start_date ASC";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $events = [];
        foreach ($data as $event) {
            $events[] = new self(
                $event['title'],
                $event['description'],
                $event['id'],
                $event['division_id'],
                $event['image_url'],
                $event['start_date'],
                $event['end_date'],
                $event['is_public'],
                $event['is_active'],
                $event['created_at'],
                $event['updated_at']
            );
        }
        return $events;
    }

    /**
     * 
     * show public event
     * 
     * @param bool $showAll
     * @return self[]
     */
    public static function getPublicEvents(bool $showAll = false): array
    {
        $sql = "SELECT * FROM events WHERE is_public = 1";
        if(!$showAll) $sql .= " AND is_active = 1";
        $sql .= " ORDER BY start_date ASC";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $events = [];
        foreach ($data as $event) {
            $events[] = new self(
                $event['title'],
                $event['description'],
                $event['id'],
                $event['division_id'],
                $event['image_url'],
                $event['start_date'],
                $event['end_date'],
                $event['is_public'],
                $event['is_active'],
                $event['created_at'],
                $event['updated_at']
            );
        }
        return $events;
    }

    /**
     * 
     * get today's events
     * 
     * @param bool $showAll
     * @return self[]
     */
    public static function getTodaysEvent(bool $showAll = false) : array
    {
        $date = date('Y-m-d');
        $sql = "SELECT * FROM events WHERE start_date LIKE '%$date%'";
        if(!$showAll) $sql .= " AND is_active = 1";
        $sql .= " ORDER BY start_date ASC";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $events = [];
        foreach ($data as $event) {
            $events[] = new self(
                $event['title'],
                $event['description'],
                $event['id'],
                $event['division_id'],
                $event['image_url'],
                $event['start_date'],
                $event['end_date'],
                $event['is_public'],
                $event['is_active'],
                $event['created_at'],
                $event['updated_at']
            );
        }
        return $events;
    }

    /**
     * 
     * get members for attendance
     * 
     * @param bool $showAll
     * @return User[]
     */
    public function getMemberForAttendance(bool $showAll = false) : array
    {
        $sql = "SELECT * FROM users WHERE id NOT IN (SELECT user_id FROM attendances WHERE event_id = :event_id) AND id IN (SELECT user_id FROM users_divisions WHERE division_id = (SELECT division_id FROM events WHERE id = :event_id))";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute(['event_id' => $this->id]);
        $data = $stmt->fetchAll();
        $users = [];
        foreach ($data as $user) {
            $users[] = User::find($user['id']);
        }
        return $users;
    }
}
