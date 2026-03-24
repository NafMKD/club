<?php

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class Feed implements Model
{
    public ?array $feed_file;

    public function __construct(
        public int $user_id,
        public string $title,
        public string $description,
        public int $is_active,
        public ?int $id,
        public ?int $event_id,
        public ?string $created_at,
        public ?string $updated_at
    ) 
    {
        if ($id !== null && $id !== 0) {
            $this->feed_file = FeedFile::findAllByFeedId($id);
        }
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
            $data['title'],
            $data['description'],
            DbCast::int($data['is_active'] ?? 0),
            null,
            DbCast::intOrNull($data['event_id'] ?? null),
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
    public static function find(int $id,bool $showAll = false): ?self
    {
        $sql = "SELECT * FROM feeds WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if($data){
            return new self(
                DbCast::int($data['user_id'] ?? 0),
                $data['title'],
                $data['description'],
                DbCast::int($data['is_active'] ?? 0),
                DbCast::intOrNull($data['id'] ?? null),
                DbCast::intOrNull($data['event_id'] ?? null),
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
    public static function findAll(bool $showAll = false): array
    {
        $sql = "SELECT * FROM feeds";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $feeds = [];
        foreach ($data as $feed) {
            $feeds[] = new self(
                DbCast::int($feed['user_id'] ?? 0),
                $feed['title'],
                $feed['description'],
                DbCast::int($feed['is_active'] ?? 0),
                DbCast::intOrNull($feed['id'] ?? null),
                DbCast::intOrNull($feed['event_id'] ?? null),
                $feed['created_at'] ?? null,
                $feed['updated_at'] ?? null
            );
        }
        return $feeds;
    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            $sql = "UPDATE feeds SET user_id = :user_id, title = :title, description = :description, is_active = :is_active, event_id = :event_id, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':title' => $this->title,
                ':description' => $this->description,
                ':is_active' => $this->is_active,
                ':event_id' => $this->event_id,
                ':id' => $this->id
            ]);
        } else {
            $sql = "INSERT INTO feeds (user_id, title, description, is_active, event_id, created_at, updated_at) VALUES (:user_id, :title, :description, :is_active, :event_id, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':title' => $this->title,
                ':description' => $this->description,
                ':is_active' => $this->is_active,
                ':event_id' => $this->event_id
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
        if($this->id){
            $sql = "DELETE FROM feeds WHERE id = :id";
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
        if($this->id){
            $sql = "SELECT * FROM feeds WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if($data){
                $this->user_id = DbCast::int($data['user_id'] ?? 0);
                $this->title = $data['title'];
                $this->description = $data['description'];
                $this->is_active = DbCast::int($data['is_active'] ?? 0);
                $this->event_id = DbCast::intOrNull($data['event_id'] ?? null);
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                $this->feed_file = FeedFile::findAllByFeedId($this->id);
                return true;
            }
        }
        return false;
    }

    /**
     * get all feeds by event id
     * 
     * @param int $event_id
     * @return self[]
     */
    public static function findAllByEventId(int $event_id, bool $showAll=false): array
    {
        $sql = "SELECT * FROM feeds WHERE event_id = :event_id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':event_id' => $event_id]);
        $data = $stmt->fetchAll();
        $feeds = [];
        foreach ($data as $feed) {
            $feeds[] = new self(
                DbCast::int($feed['user_id'] ?? 0),
                $feed['title'],
                $feed['description'],
                DbCast::int($feed['is_active'] ?? 0),
                DbCast::intOrNull($feed['id'] ?? null),
                DbCast::intOrNull($feed['event_id'] ?? null),
                $feed['created_at'] ?? null,
                $feed['updated_at'] ?? null
            );
        }
        return $feeds;
    }

    /**
     * get all records for feed view
     * 
     * @return self[]
     */
    public static function findAllFeedView(string $order = 'DESC', bool $showAll = false): array
    {
        $sql = "SELECT * FROM feeds";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $sql .= " ORDER BY created_at $order";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $feeds = [];
        foreach ($data as $feed) {
            $feeds[] = new self(
                DbCast::int($feed['user_id'] ?? 0),
                $feed['title'],
                $feed['description'],
                DbCast::int($feed['is_active'] ?? 0),
                DbCast::intOrNull($feed['id'] ?? null),
                DbCast::intOrNull($feed['event_id'] ?? null),
                $feed['created_at'] ?? null,
                $feed['updated_at'] ?? null
            );
        }
        return $feeds;
    }

    /**
     * 
     * has user
     * 
     * @return ?User
     */
    public function hasUser(): ?User
    {
        if($this->user_id){
            return User::find($this->user_id);
        }
        return null;
    }
}
