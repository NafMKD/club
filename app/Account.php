<?php 

declare(strict_types=1);

namespace App;

use App\Database\DB;
use App\Model\User;

class Account 
{
    /**
     * login
     * 
     * @param string $username
     * @param string $password
     * 
     * @return User
     */
    public static function login(string $username, string $password): ?User
    {
        $data = User::findByUsername($username);
        if($data && $data->password == md5($password)){
            $data->last_login = date('Y-m-d H:i:s');
            $data->save();
            return $data;
        }
        return null;
    }

    /**
     * logout
     * 
     * @return void
     */
    public static function logout(): void
    {
        session_destroy();
    }
}


