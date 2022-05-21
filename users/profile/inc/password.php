<?php

use App\Helper\Validation;

if(isset($_POST['btn_update_pass'])){
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $new_pass_confirmation = $_POST['new_pass_confirmation'];

    $errors = [];

    if(Validation::isEmpty($old_pass)) $errors['old_pass'] = 'Old Password is required';
    if(Validation::isEmpty($new_pass)) $errors['new_pass'] = 'New Password is required';
    if(Validation::isEmpty($new_pass_confirmation)) $errors['new_pass_confirmation'] = 'Password confirmation is required';

    if($new_pass !== $new_pass_confirmation ) $errors['new_pass_confirmation'] = 'Password confirmation does not match';

    if(md5($old_pass) !== $user->password) $errors['old_pass'] = 'Old Password not correct';

    if(count($errors) === 0){
        $user->password = md5($new_pass);

        if($user->save()){
            $return_message = ['success','Password updated successfully','check'];
            $user->updateCurrentInstance();
            $_SESSION['user'] = serialize($user);
        }else{
            $return_message = ['danger','something went wrong','ban'];
        }
    }else{
        $return_message = ['danger','Please fix the errors', 'ban'];
    }
}

?>
<?php if (isset($return_message)) : ?>
    <div class="alert alert-<?= $return_message[0]; ?> alert-dismissible">
        <i class="icon fas fa-<?= $return_message[2]; ?>"></i>
        <?= $return_message[1]; ?>
    </div>
<?php endif ?>
<form method="POST">
    <div class="form-group">
        <label>Old Password: </label>
        <input name="old_pass" type="password" class="form-control" placeholder="Enter old password" />
        <span class="text-danger"><?php if (isset($errors['old_pass'])) echo $errors['old_pass']; ?></span>
    </div>

    <div class="form-group">
        <label>Naw Password: </label>
        <input name="new_pass" type="password" class="form-control" placeholder="Enter new password" />
        <span class="text-danger"><?php if (isset($errors['new_pass'])) echo $errors['new_pass']; ?></span>
    </div>

    <div class="form-group">
        <label>New Password (again): </label>
        <input name="new_pass_confirmation" type="password" class="form-control" placeholder="Enter new password again" />
        <span class="text-danger"><?php if (isset($errors['new_pass_confirmation'])) echo $errors['new_pass_confirmation']; ?></span>
    </div>
    <button type="submit" name="btn_update_pass" class="btn btn-primary">Update</button>
</form>