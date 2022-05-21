<?php

use App\Helper\Validation;

if(isset($_POST['btn_update_pic'])){
    $profile_picture = $_FILES['profile_picture'];

    $errors = [];

    if(!Validation::isValidImage($profile_picture['type'])){
        $errors['profile_picture'] = 'Profile picture is invalid';
    }

    if(count($errors) === 0){
        $prof_pic = uniqid().'_'.date('YmdHis').'_'.$profile_picture['name'];
        $old_pic = $user->profile_picture;
        if(move_uploaded_file($profile_picture['tmp_name'], __DIR__.'/../../../files/images/profile_pictures/'.$prof_pic)){
            $user->profile_picture = $prof_pic;
            if($user->save()){
                if($user->profile_picture && file_exists('../files/images/profile_pictures/' . $user->profile_picture)) unlink(__DIR__.'/../../../files/images/profile_pictures/'.$old_pic);
                $return_message = ['success','Profile Picture updated successfully','check'];
                $user->updateCurrentInstance();
                $_SESSION['user'] = serialize($user);
            }else{
                unlink(__DIR__.'/../../../files/images/profile_pictures/'.$prof_pic);
                $return_message = ['danger','something went wrong1','ban'];
            }
        }else{
            $return_message = ['danger','something went wrong2','ban'];
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
<form method="POST" enctype="multipart/form-data">
    <?php if ($user->profile_picture && file_exists('../files/images/profile_pictures/' . $user->profile_picture)) : ?>
        <p class="text-warning"> <i class="icon fas fa-exclamation-triangle"></i> changes are irrevarsable and take effact immidiatly! </p>
    <?php endif ?>
    <div class="form-group">
        <label>Profile Picture: </label>
        <input name="profile_picture" type="file" class="ml-4" /><br />
        <span class="text-danger"><?php if (isset($errors['profile_picture'])) echo $errors['profile_picture']; ?></span>
    </div>
    <button type="submit" name="btn_update_pic" class="btn btn-primary">Update</button>
</form>