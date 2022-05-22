<?php

use App\Helper\Validation;
use App\Model\Attendance;
use App\Model\Division;
use App\Model\Event;

$event = Event::find($_GET['attendance']);

$division = Division::find($event->division_id);

$members = $event->getMemberForAttendance();
$date = date('Y-m-d');

if (isset($_POST['notattended'])) {


    if (explode(' ', $event->start_date)[0] == $date) {
        $data = Attendance::create([
            'user_id' => (int) $_POST['user_id'],
            'event_id' => $event->id,
            'is_attended' => 0,
            'is_active' => 1
        ]);

        if (!$data->save()) $return_message = ['danger', 'Something went wrong', 'ban'];

        $members = $event->getMemberForAttendance();
    } else {
        $return_message = ['danger', 'Cannot take attendance today', 'ban'];
    }
}

if (isset($_POST['attended'])) {

    if (explode(' ', $event->start_date)[0] == $date) {
        $data = Attendance::create([
            'user_id' => (int) $_POST['user_id'],
            'event_id' => $event->id,
            'is_attended' => 1,
            'is_active' => 1
        ]);

        if (!$data->save()) $return_message = ['danger', 'Something went wrong', 'ban'];

        $members = $event->getMemberForAttendance();
    } else {
        $return_message = ['danger', 'Cannot take attendance today', 'ban'];
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
        <?php if (isset($return_message)) : ?>
            <div class="alert alert-<?= $return_message[0]; ?> alert-dismissible">
                <i class="icon fas fa-<?= $return_message[2] ?>"></i>
                <?= $return_message[1]; ?>
            </div>
        <?php endif ?>
        <center>
            <h3>Attendance</h3>
        </center>
        <dl class="row mt-4">
            <dt class="col-sm-3">Division Name : </dt>
            <dd class="col-sm-9"><?= $division->name ?></dd>
            <dt class="col-sm-3">Members count : </dt>
            <dd class="col-sm-9"><?= count($division->findAllMembers()) ?></dd>
        </dl>
        <?php if (Validation::checkDateRange($date, $event->start_date)) : ?>
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
                    foreach ($members as $member) : ?>
                        <form method="POST">
                            <input name="user_id" value="<?= $member->id ?>" hidden>
                            <tr>
                                <td><?= $c ?></td>
                                <?php if ($member->userDetail) : ?>
                                    <td><?= $member->userDetail->first_name . ' ' . $member->userDetail->last_name ?></td>
                                <?php else : ?>
                                    <td><?= $member->username ?></td>
                                <?php endif; ?>
                                <td>
                                    <button type="submit" name="attended" class="btn btn-success btn-sm"><i class="fas fa-check "></i></button>
                                    <button type="submit" name="notattended" class="btn btn-danger btn-sm"><i class="fas fa-times "></i></button>
                                </td>
                            </tr>
                        </form>
                    <?php $c++;
                    endforeach ?>
                </tbody>
            </table>
        <?php else : ?>
            <table class="table table-bordered table-hover" id="table">
                <thead>
                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $c = 1;
                    foreach ($event->getAttendance() as $attendance) : ?>
                        <tr>
                            <td><?= $c ?></td>
                            <?php if ($attendance->getUser()->userDetail) : ?>
                                <td><?= $attendance->getUser()->userDetail->first_name . ' ' . $attendance->getUser()->userDetail->last_name ?></td>
                            <?php else : ?>
                                <td><?= $attendance->getUser()->username ?></td>
                            <?php endif; ?>
                            <td>
                                <?php if ($attendance->is_attended == 1) : ?>
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
        <?php endif ?>
    </div>
</div>