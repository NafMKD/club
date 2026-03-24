<?php 

declare(strict_types=1);

namespace App;

include __DIR__ . '/../vendor/autoload.php';

use App\Database\DB;

class Superuser 
{

    public function __construct(private \PDO $pdo) 
    {
    }

    public function register(string $username, string $password): bool
    {

        $stmt = $this->pdo->prepare('INSERT INTO users(username, password, is_superuser, is_active) VALUES (:username,:password,:is_superuser,:is_active)');

        $chek = $stmt->execute(
            [
                'username' => $username,
                'password' => $password,
                'is_superuser' => 1,
                'is_active' => 1
            ]
        );

        return $chek;
    }
}

$obj = new Superuser(DB::getInstance());

$username = '';
$password = '';
$password_confirmation = '';

echo 'Enter userame : ';
fscanf(STDIN, "%s", $username);
echo 'Enter Password : ';
fscanf(STDIN, "%s", $password);
echo 'Enter Password (again) : ';
fscanf(STDIN, "%s", $password_confirmation);

if ($password !== $password_confirmation) {
    echo 'Passwords do not match' . PHP_EOL;
    exit;
}

if ($obj->register($username, md5($password))) {
    echo 'User registered successfully' . PHP_EOL;
} else {
    echo 'User registration failed' . PHP_EOL;
}


