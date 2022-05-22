<?php

use App\Model\Division;
use App\Model\User;


$division = $user_division_data;

$users = User::findAll();

if (!$division) {
    header('Location: ?members');
    exit;
}

if (isset($_POST['btn_update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $errors = [];

    if (count($errors) === 0) {
        $division->name = $name;
        $division->description = $description;

        if ($division->save()) {
            $return_message = ['success', 'Division updated successfully', 'check'];
            $user_division_data->updateCurrentInstance();
            $_SESSION['user_division_data'] = serialize($user_division_data);
        } else {
            $return_message = ['danger', 'something went wrong', 'ban'];
        }
    }
}

?>
<form method="POST">
    <div class="card-body">
        <?php if (isset($return_message)) : ?>
            <div class="alert alert-<?= $return_message[0]; ?> alert-dismissible">
                <i class="icon fas fa-<?= $return_message[2]; ?>"></i>
                <?= $return_message[1]; ?>
            </div>
        <?php endif ?>
        <div>
            <h3>Edit Division</h3>
        </div>
        <hr />
        <div class="form-group">
            <label>Name:</label>
            <input name="name" type="text" value="<?= $division->name ?>" class="form-control" placeholder="Enter title">
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="3"><?= $division->description ?> </textarea>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" name="btn_update" class="btn btn-success">Update</button>
    </div>
</form>