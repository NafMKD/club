<?php

use App\Model\User;

$users = User::findAll();

if (isset($_GET['delete'])) {
    if (isset($_GET['is_confirmed']) && $_GET['is_confirmed'] == 'yes'){
        $user_delete = User::find($_GET['delete']);
        if($user_delete){
            $user_delete->delete();
            echo '<script>
                Swal.fire({
                    title: "Success",
                    text: "User has been removed.",
                    type: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location = "?list";
                });
            </script>';
        }else{
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
                    window.location.href = "?list&delete='.$_GET['delete'].'&is_confirmed=yes";
                }else{
                    window.location.href = "?list";
                }
            });</script>';
    }
}

?>
<div class="card m-1">
    <div class="card-header">
        <h3 class="card-title">users list:</h3>

        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" class="form-control float-right table_search" placeholder="Search">
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style=" width: 611px;">
        <table class="table table-bordered table-hover" id="table">
            <thead>
                <tr>
                    <th style="width: 10px;">#</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $c = 1;foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $c ?></td>
                        <?php if($user->userDetail): ?>
                            <td><?= $user->userDetail->first_name .' '. $user->userDetail->last_name?></td>
                        <?php else:?>
                            <td><?= $user->username ?></td>
                        <?php endif;?>
                        <td>
                            <a href="?view=<?= $user->id ?>" class="btn btn-info btn-xs"><i class="fas fa-eye mr-1"></i>View</a>
                            <a href="?list&delete=<?= $user->id ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i>Delete</a>
                        </td>
                    </tr>
                <?php $c++; endforeach ?>
            </tbody>
        </table>
    </div>
</div>