<?php

use App\Model\Division;
use App\Model\User;

if (!isset($_GET['attendance']) || $_GET['attendance'] == '') {
    header('Location: ?members');
    exit;
}

$att_user = User::find($_GET['attendance']);

?>
<div class="card m-1">
    <div class="card-header">
        <h3 class="card-title">Attendance list:</h3>

        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" class="form-control float-right table_search" placeholder="Search">
            </div>
        </div>
    </div>
    <div class="card-body" style=" width: 611px;">
        <dl class="row">
            <dt class="col-sm-3">Division Name : </dt>
            <dd class="col-sm-9"><?= $user_division_data->name ?></dd>
            <dt class="col-sm-3">Member Name : </dt>
            <dd class="col-sm-9">
                <?php if ($att_user->userDetail) : ?>
                    <?= $att_user->userDetail->first_name . ' ' . $att_user->userDetail->last_name ?>
                <?php else : ?>
                    <?= $att_user->username ?>
                <?php endif; ?>
            </dd>
        </dl>
        <table class="table table-bordered table-hover" id="table">
            <thead>
                <tr>
                    <th style="width: 10px;">#</th>
                    <th>Event</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $c = 1;
                foreach ($att_user->getAttendanceForDivision($user_division_data->id) as $att) : ?>
                    <tr>
                        <td><?= $c ?></td>
                        <td><?= ucwords($att->getEvent()->title) ?></td>
                        <td>
                            <?php if ($att->is_attended == 1) : ?>
                                <span class="badge badge-success">Attended</span>
                            <?php else : ?>
                                <span class="badge badge-danger">Not Attended</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php $c++;
                endforeach ?>
            </tbody>
        </table>
    </div>
</div>