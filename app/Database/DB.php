<?php 

declare(strict_types=1);

namespace App\Database;

class DB 
{
    private static ?\PDO $pdo = null;

    public static function getInstance(): \PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                'mysql:host=localhost;dbname=web_club',
                'root',
                ''
            );
        }
        return self::$pdo;
    }
}
