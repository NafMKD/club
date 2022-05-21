<?php
session_start();
$feeds_page = 'active'; 
include __DIR__ . '/../vendor/autoload.php';

if(isset($_POST['btn_signin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = \App\Account::login($username, $password);
    if($user){
        if($user->is_superuser == 1){
            $_SESSION['admin'] = serialize($user);
            header('Location: ../admin/index.php');
        }else{
            $_SESSION['user'] = serialize($user);
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/left.php'; ?>

    <!-- feed starts -->
    <div class="feed">
        <div class="feed__header">
            <h2>Home</h2>
        </div>
        
        <!-- tweetbox starts -->
        <div class="tweetBox">

        </div>
        <!-- tweetbox ends -->

        <?php include 'feeds/list.php' ?>

    </div>
    <!-- feed ends -->

    <?php include 'includes/right.php'; ?>

    <?php include 'includes/script.php'; ?>
</body>

</html>