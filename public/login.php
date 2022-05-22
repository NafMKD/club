<?php 


if(isset($_POST['btn_signin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = \App\Account::login($username, $password);
    if($user){
        if($user['user_data']->is_superuser == 1){
            $_SESSION['admin'] = serialize($user['user_data']);
            header('Location: ../admin/index.php');
        }else{
            $_SESSION['user'] = serialize($user['user_data']);
            $_SESSION['user_is_division_head'] = serialize($user['is_division_head']);
            $_SESSION['user_division_data'] = serialize($user['division_data']);
            header('Location: ../users/index.php');
        }
    }else{
        $err_message_signin = 'Incorrect Credentials';
    }
}

if(isset($_POST['btn_signup'])){
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];
    $password_confirmation = $_POST['new_password_confirmation'];
   
    if($password == $password_confirmation){
        $user = \App\Model\User::create([
            'username' => $username,
            'password' => $password,
            'is_superuser' => 0,
            'is_president'=> 0,
            'profile_picture'=> null,
            'is_active'=> 1
        ]);
        if($user->save()){
            $_SESSION['user'] = serialize($user);
            header('Location: ../users/index.php');
        }else{
            $err_message_signup = 'Something went wrong';
        }
    }else{
        $err_message_signup = 'Password does not match';
    }
}