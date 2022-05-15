<?php

declare(strict_types=1);

namespace App\Model;

use App\Database\DB;

class FeedFile implements Model
{
    public ?Feed $feed;

    public function __construct(
        public int $feed_id,
        public string $file_url,
        public int $is_active,
        public ?int $id,
        public ?string $created_at,
        public ?string $updated_at
    ) 
    {   
        $this->feed = Feed::find($feed_id);
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
            $data['feed_id'],
            $data['file_url'],
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
    public static function find(int $id,bool $showAll = false): ?self
    {
        $sql = "SELECT * FROM feeds_files WHERE id = :id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        if($data){
            return new self(
                $data['feed_id'],
                $data['file_url'],
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
    public static function findAll(bool $showAll = false): array
    {
        $sql = "SELECT * FROM feeds_files";
        if(!$showAll) $sql .= " WHERE is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $feedFiles = [];
        foreach($data as $feedFileData){
            $feedFiles[] = new self(
                $feedFileData['feed_id'],
                $feedFileData['file_url'],
                $feedFileData['is_active'],
                $feedFileData['id'],
                $feedFileData['created_at'],
                $feedFileData['updated_at']
            );
        }
        return $feedFiles;
    }

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save(): bool
    {
        if($this->id){
            $sql = "UPDATE feeds_files SET feed_id = :feed_id, file_url = :file_url, is_active = :is_active, updated_at = NOW() WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':feed_id' => $this->feed_id,
                ':file_url' => $this->file_url,
                ':is_active' => $this->is_active,
                ':id' => $this->id
            ]);
        }else{
            $sql = "INSERT INTO feeds_files (feed_id, file_url, is_active, created_at, updated_at) VALUES (:feed_id, :file_url, :is_active, NOW(), NOW())";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([
                ':feed_id' => $this->feed_id,
                ':file_url' => $this->file_url,
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
    public function delete(): bool
    {
        if($this->id){
            $sql = "UPDATE feeds_files SET is_active = 0 WHERE id = :id";
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
            $sql = "SELECT * FROM feeds_files WHERE id = :id";
            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            $data = $stmt->fetch();
            if($data){
                $this->feed_id = $data['feed_id'];
                $this->file_url = $data['file_url'];
                $this->is_active = $data['is_active'];
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                $this->feed = Feed::find($this->feed_id);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * get all records by feed id
     * 
     * @param int $feed_id
     * @return self[]
     */
    public static function findAllByFeedId(int $feed_id,bool $showAll = false): array
    {
        $sql = "SELECT * FROM feeds_files WHERE feed_id = :feed_id";
        if(!$showAll) $sql .= " AND is_active = 1";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':feed_id' => $feed_id]);
        $data = $stmt->fetchAll();
        $feedFiles = [];
        foreach($data as $feedFileData){
            $feedFiles[] = new self(
                $feedFileData['feed_id'],
                $feedFileData['file_url'],
                $feedFileData['is_active'],
                $feedFileData['id'],
                $feedFileData['created_at'],
                $feedFileData['updated_at']
            );
        }
        return $feedFiles;
    }
}
