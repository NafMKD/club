<?php 

if(isset($_POST['btn_signin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = \App\Account::login($username, $password);
    if($user){
        if($user->is_superuser == 1){
            $_SESSION['admin'] = $user;
            header('Location: ../admin/index.php');
        }else{
            $_SESSION['user'] = $user;
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
            $_SESSION['user'] = $user;
            header('Location: ../users/index.php');
        }else{
            $err_message_signup = 'Something went wrong';
        }
    }else{
        $err_message_signup = 'Password does not match';
    }
}

?>
<!-- widgets starts -->
<div class="widgets">
    <div class="widgets__input">
        <span class="material-icons widgets__searchIcon"> search </span>
        <input type="text" placeholder="Search" />
    </div>

    <div class="widgets__widgetContainer">
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="card-title">New here?</h3>
            </div>
            <div class="card-body">
                <p>Sign up now to get your own personalized timeline!</p>
                <div class="social-auth-links text-center mt-2 mb-3">
                    <a data-toggle="modal" href="#modal-signin" class="btn btn-block btn-primary">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign in
                    </a>
                    <a data-toggle="modal" href="#modal-signup" class="btn btn-block btn-danger">
                        <i class="fas fa-user-plus mr-2"></i> Sign up
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- widgets ends -->

<div class="modal fade" id="modal-signin">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <div class="login-box">
                    <div class="card-header text-center">
                        <a class="h1"><b>CSEC</b> ASTU</a>
                    </div>
                    <div class="card-body">
                        <?php if(isset($err_message_signin)): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <i class="icon fas fa-ban"></i> 
                                <?php echo $err_message_signin; ?>
                            </div>
                        <?php endif ?>
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="username" placeholder="username" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button name="btn_signin" type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Sign in
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-signup">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <div class="login-box">
                    <div class="card-header text-center">
                        <a class="h1"><b>CSEC</b> ASTU</a>
                    </div>
                    <div class="card-body">
                        <?php if(isset($err_message_signup)): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <i class="icon fas fa-ban"></i> 
                                <?php echo $err_message_signup; ?>
                            </div>
                        <?php endif ?>
                        <p class="login-box-msg">Sign up to be part of...</p>
                        <form method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control " name="new_username" placeholder="username" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control " name="new_password" placeholder="Password" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control " name="new_password_confirmation" placeholder="confirm Password" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" name="btn_signup" class="btn btn-primary btn-block">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Sign up
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>