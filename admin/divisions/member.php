<?php

use App\Model\Division;
use App\Model\UserDivision;

$division = Division::find($_GET['members']);


if (isset($_GET['delete'])) {
    if (isset($_GET['is_confirmed']) && $_GET['is_confirmed'] == 'yes'){
        $user_division = UserDivision::findByUserIdAndDivisionId($_GET['delete'],$division->id);
        if($user_division){
            $user_division->delete();
            echo '<script>
                Swal.fire({
                    title: "Success",
                    text: "User has been removed.",
                    type: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location = "?members='.$_GET['members'].'";
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
                    window.location.href = "?members='.$_GET['members'].'&delete='.$_GET['delete'].'&is_confirmed=yes";
                }else{
                    window.location.href = "?members='.$_GET['members'].'";
                }
            });</script>';
    }
}

?>
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
                        <?php if($member->userDetail): ?>
                            <td><?= $member->userDetail->first_name .' '. $member->userDetail->last_name?></td>
                        <?php else:?>
                            <td><?= $member->username ?></td>
                        <?php endif;?>
                        <td>
                            <a href="?members=<?= $_GET['members'] ?>&delete=<?= $member->id ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i> Remove</a>
                            <a href="?attendance=<?= $_GET['members'] ?>/<?= $member->id ?>" class="btn btn-primary btn-xs"><i class="fas fa-edit mr-1"></i> Attendance</a>
                        </td>
                    </tr>
                <?php $c++;
                endforeach ?>
            </tbody>
        </table>
    </div>
</div>