<?php

use App\Model\Division;
use App\Model\User;

$users = User::findAll();

if (isset($_POST['btn_add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $head = ($_POST['division_head_id'] !== "") ? (int) $_POST['division_head_id'] : null;

    $errors = [];

    if (count($errors) === 0) {
        $division = Division::create([
            'name' => $name,
            'description' => $description,
            'division_head_id' => $head,
            'is_active' => 1
        ]);

        if ($division->save()) {
            $return_message = ['success', 'Division added successfully', 'check'];
        } else {
            $return_message = ['danger', 'something went wrong', 'ban'];
        }
    } else {
        $return_message = ['danger', 'Please fix the errors', 'ban'];
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
            <h3>Add Division</h3>
        </div>
        <hr />
        <div class="form-group">
            <label>Head:</label>
            <select name="division_head_id" class="form-control select2" style="width: 100%;">
                <option value="">Not Know</option>
                <?php foreach ($users as $user) : ?>
                    <?php if ($user->userDetail) : ?>
                        <option value="<?= $user->id ?>"><?= $user->userDetail->first_name ?> <?= $user->userDetail->last_name ?></option>
                    <?php else : ?>
                        <option value="<?= $user->id ?>"><?= $user->username ?></option>
                    <?php endif ?>
                <?php endforeach ?>

            </select>
        </div>
        <div class="form-group">
            <label>Name:</label>
            <input name="name" type="text" class="form-control" placeholder="Enter title">
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" name="btn_add" class="btn btn-primary">Add</button>
    </div>
</form>