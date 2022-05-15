<?php 

declare(strict_types=1);

namespace App\Model;

interface Model
{

    /**
     * create new instance
     * 
     * @param array $data
     * @return self
     */
    public static function create(array $data):self;

    /**
     * get single record by id
     * 
     * @param int $id
     * @return self
     */
    public static function find(int $id):?self;

    /**
     * get all records
     * 
     * @return self[]
     */
    public static function findAll():array;

    /**
     * save current instance to database
     * 
     * @return bool
     */
    public function save():bool;

    /**
     * delete current instance from database
     * 
     * @return bool
     */
    public function delete():bool;

    /**
     * update current instance with data from database
     * 
     * @return bool
     */
    public function updateCurrentInstance():bool;

}