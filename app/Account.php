<?php

declare(strict_types=1);

namespace App;

use App\Database\DB;
use App\Model\Division;
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
        if ($data && $data->password == md5($password)) {
            $data->last_login = date('Y-m-d H:i:s');
            $data->save();
            $division_head = self::checkUserIsDivisionHead($data);
            return [
                'user_data' => $data, 
                'is_division_head' => ($division_head) ? true : false, 
                'division_data' => ($division_head) ? $division_head : null
            ];
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

    /**
     * 
     * check if the user is division head
     * 
     * @param User $user
     * @return Division|bool
     */
    private static function checkUserIsDivisionHead(User $user): Division|bool
    {
        $division = Division::findByUserId($user->id);
        if ($division) return $division;
        return false;
    }
}
