<?php

use App\Helper\Validation;
use App\Model\User;

if(isset($_POST['btn_add_user'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    if(isset($_POST['is_superuser'])) $is_superuser = 1;
    else $is_superuser = 0;
    if(isset($_POST['is_president'])) $is_president = 1;
    else $is_president = 0;
    $profile_picture = $_FILES['profile_picture'];

    $errors = [];
    if(Validation::isEmpty($username)){
        $errors['username'] = 'Username is required';
    }
    if(Validation::isEmpty($password)){
        $errors['password'] = 'Password is required';
    }
    if(Validation::isEmpty($password_confirmation)){
        $errors['password_confirmation'] = 'Password confirmation is required';
    }
    if($password !== $password_confirmation){
        $errors['password_confirmation'] = 'Password confirmation does not match';
    }
    if(!Validation::isValidUsername($username)){
        $errors['username'] = 'Username is invalid';
    }
    if(!Validation::isValidPassword($password)){
        $errors['password'] = 'Password is invalid';
    }
    if(!Validation::isValidImage($profile_picture['type'])){
        $errors['profile_picture'] = 'Profile picture is invalid';
    }

    if(User::isUsernameTaken($username)){
        $errors['username'] = 'Username is already taken';
    }

    if($is_president && User::isPresidentTaken()){
        $errors['is_president'] = 'There can only be one president';
    }

    if(count($errors) === 0){
        $prof_pic = uniqid().'_'.date('YmdHis').'_'.$profile_picture['name'];
        $user = User::create(
            [
                'username' => $username,
                'password' => $password,
                'is_superuser' => $is_superuser,
                'is_president' => $is_president,
                'profile_picture' => $prof_pic,
                'is_active' => 1,
            ]
        );
        if($user->save()){
            move_uploaded_file($profile_picture['tmp_name'], __DIR__.'/../../files/images/profile_pictures/'.$prof_pic);
            $return_message = ['success','User added successfully','check'];
        }else{
            $return_message = ['danger','something went wrong','ban'];
        }
    }else{
        $return_message = ['danger','Please fix the errors', 'ban'];
    }
}

?>


<form method="POST" enctype="multipart/form-data"> 
    <div class="card-body">
        <?php if (isset($return_message)) : ?>
            <div class="alert alert-<?= $return_message[0]; ?> alert-dismissible">
                <i class="icon fas fa-<?= $return_message[2] ?>"></i>
                <?= $return_message[1]; ?>
            </div>
        <?php endif ?>
        <div >
            <h3>Add user</h3>
        </div>
        <hr/>
        <div class="form-group">
            <label>Username:</label>
            <input name="username" type="text" class="form-control" placeholder="Enter username">
            <span class="text-danger"><?php if(isset($errors['username'])) echo $errors['username']; ?></span>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input name="password" type="password" class="form-control" placeholder="Enter password">
            <span class="text-danger"><?php if(isset($errors['password'])) echo $errors['password']; ?></span>
        </div>
        <div class="form-group">
            <label>Password (again):</label>
            <input name="password_confirmation" type="password" class="form-control" placeholder="Enter password">
            <span class="text-danger"><?php if(isset($errors['password_confirmation'])) echo $errors['password_confirmation']; ?></span>
        </div>
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <label class="mr-4">
                    Superuser:
                </label>
                <input name="is_superuser" type="checkbox" id="checkboxPrimary2">
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <label class="mr-4">
                    President:
                </label>
                <input name="is_president" type="checkbox" id="checkboxPrimary2"><br/>
                <span class="text-danger"><?php if(isset($errors['is_president'])) echo $errors['is_president']; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label>Profile Picture: </label>
            <input name="profile_picture" type="file" class="ml-4"/><br/>
            <span class="text-danger"><?php if(isset($errors['profile_picture'])) echo $errors['profile_picture']; ?></span>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" name="btn_add_user" class="btn btn-primary">Add</button>
    </div>
</form>