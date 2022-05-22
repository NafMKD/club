<?php

use App\Helper\Validation;
use App\Model\Division;
use App\Model\User;
use App\Model\UserDivision;

$division = Division::find($user_division_data->id);

if (isset($_GET['delete'])) {
    if (isset($_GET['is_confirmed']) && $_GET['is_confirmed'] == 'yes') {
        $user_division = UserDivision::findByUserIdAndDivisionId($_GET['delete'], $division->id);
        if ($user_division) {
            $user_division->delete();
            echo '<script>
                Swal.fire({
                    title: "Success",
                    text: "User has been removed.",
                    type: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location = "?members";
                });
            </script>';
        } else {
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "user not found!",
                    icon: "error",
                    confirmButtonText: "OK"
                });</script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    window.location.href = "?members&delete=' . $_GET['delete'] . '&is_confirmed=yes";
                }else{
                    window.location.href = "?members";
                }
            });</script>';
    }
}

if(isset($_POST['add_user'])){
    $user_id = ($_POST['user_id'] === '') ? null : (int) $_POST['user_id'];

    $errros = [];

    if(!$user_id) $errros['user_id'] = 'User is required';

    if(count($errros) === 0){
        $user_division = UserDivision::create([
            'user_id' => $user_id,
            'division_id' => $division->id,
            'is_active' => 1
        ]);

        if($user_division->save()){
            $return_message = ['success', 'User added successfully', 'check'];
        }else{
            $return_message = ['danger', 'something went wrong', 'ban'];
        }
    }else{
        $return_message = ['danger', 'Please fix the errors', 'ban'];
    }
}

?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_member">
    <i class="icon fas fa-plus"></i> Add Member
</button>
<div class="modal fade" id="add_member">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Member</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php if(isset($return_message)): ?>
                    <div class="alert alert-<?= $return_message[0] ?>">
                        <?= $return_message[1] ?>
                    </div>
                <?php endif; ?>
                <form action="?members" method="post">
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control" name="user_id">
                            <option value="">Select User</option>
                            <?php foreach ($division->findAllUserToAdd() as $member) : ?>
                                <?php if ($member->userDetail) : ?>
                                    <option value="<?= $member->id ?>"><?= $member->userDetail->first_name ?> <?= $member->userDetail->last_name ?></option>
                                <?php else : ?>
                                    <option value="<?= $member->id ?>"><?= $member->username ?></option>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger"><?php if(isset($errros['user_id'])) echo $errros['user_id'] ;?> </span>
                    </div>
                    <button type="submit" name="add_user" class="btn btn-primary float-right">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br />
<div class="card m-1">
    <div class="card-header">
        <h3 class="card-title">Members list:</h3>

        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" class="form-control float-right table_search" placeholder="Search">
            </div>
        </div>
    </div>
    <div class="card-body" style=" width: 611px;">
        <dl class="row">
            <dt class="col-sm-3">Division Name : </dt>
            <dd class="col-sm-9"><?= $division->name ?></dd>
            <dt class="col-sm-3">Members count : </dt>
            <dd class="col-sm-9"><?= count($division->findAllMembers()) ?></dd>
        </dl>
        <table class="table table-bordered table-hover" id="table">
            <thead>
                <tr>
                    <th style="width: 10px;">#</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $c = 1;
                foreach ($division->findAllMembers() as $member) : ?>
                    <tr>
                        <td><?= $c ?></td>
                        <?php if ($member->userDetail) : ?>
                            <td><?= $member->userDetail->first_name . ' ' . $member->userDetail->last_name ?></td>
                        <?php else : ?>
                            <td><?= $member->username ?></td>
                        <?php endif; ?>
                        <td>
                            <a href="?members&delete=<?= $member->id ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i> Remove</a>
                            <a href="?attendance=<?= $member->id ?>" class="btn btn-primary btn-xs"><i class="fas fa-edit mr-1"></i> Attendance</a>
                        </td>
                    </tr>
                <?php $c++;
                endforeach ?>
            </tbody>
        </table>
    </div>
</div>