<?php

use App\Helper\Formater;
use App\Helper\Validation;
use App\Model\Event;

$events = Event::findAllByDivisionId($user_division_data->id);

if (isset($_GET['delete'])) {
    if (isset($_GET['is_confirmed']) && $_GET['is_confirmed'] == 'yes') {
        $delete_event = Event::find($_GET['delete']);
        if ($delete_event) {
            $delete_event->delete();
            echo '<script>
                Swal.fire({
                    title: "Success",
                    text: "User has been removed.",
                    type: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location = "?events";
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
                    window.location.href = "?events&delete=' . $_GET['delete'] . '&is_confirmed=yes";
                }else{
                    window.location.href = "?events";
                }
            });</script>';
    }
}

if (isset($_POST['btn_add_event'])) {
    $division = (int) $user_division_data->id;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if (isset($_POST['is_public'])) $is_public = 1;
    else $is_public = 0;
    $image = $_FILES['image'];

    $errors = [];

    if (Validation::isEmpty($title)) $errors['title'] = 'Title is required';

    if (Validation::isEmpty($start_date)) $errors['start_date'] = 'Start date is required';

    if (!Validation::checkDateRange($start_date, $end_date)) $errors['end_date'] = 'End date must be greater than start date';

    if (!Validation::checkStartDate($start_date)) $errors['start_date'] = 'Start date must be greater than or equal to today';

    if (!Validation::isValidImage($image['type'])) $errors['image'] = 'Image must be a valid image';

    if (count($errors) === 0) {
        $start_date = Formater::formatDateForDb($start_date);
        $end_date = Formater::formatDateForDb($end_date);

        $image_name = uniqid() . '_' . date('YmdHis') . '_' . $image['name'];
        $event = Event::create([
            'division_id' => $division,
            'title' => $title,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'is_public' => $is_public,
            'image_url' => $image_name,
            'is_active' => 1
        ]);

        if ($event->save()) {
            $image_path = __DIR__ . '/../../files/images/events/' . $image_name;
            move_uploaded_file($image['tmp_name'], $image_path);
            $return_message = ['success', 'Event posted successfully', 'check'];
        } else {
            $return_message = ['danger', 'Something went wrong', 'ban'];
        }
    } else {
        $return_message = ['danger', 'Please fix the errors', 'ban'];
    }
}

?>
<div class="card m-1">
    <div class="card-header">
        <h3 class="card-title">Event list:</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool text-primary" data-toggle="modal" data-target="#modal-add-event">
                <i class="fas fa-plus"></i> Add Event</button>
        </div>
    </div>
    <div class="card-body" style=" width: 611px;">
        <dl class="row">
            <dt class="col-sm-3">Event count : </dt>
            <dd class="col-sm-9"><?= count($events) ?></dd>
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
                foreach ($events as $event) : ?>
                    <tr>
                        <td><?= $c ?></td>
                        <td><?= ucfirst($event->title) ?></td>
                        <td>
                            <a href="?takeattendance=<?= $event->id ?>" class="btn btn-primary btn-xs"><i class="fas fa-edit mr-1"></i> Attendace</a> 
                            <a href="?events&delete=<?= $event->id ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i> Remove</a>
                        </td>
                    </tr>
                <?php $c++;
                endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-add-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if (isset($return_message)) : ?>
                        <div class="alert alert-<?= $return_message[0] ?> alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fas fa-<?= $return_message[2] ?>"></i> <?= $return_message[1] ?>
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <label>Title:</label>
                        <input name="title" type="text" class="form-control" placeholder="Enter title">
                        <span class="text-danger"><?php if (isset($errors['title'])) : ?><?= $errors['title'] ?> <?php endif ?></span>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date:</label>
                                <div class="input-group date" id="startdate" data-target-input="nearest">
                                    <input name="start_date" type="text" class="form-control datetimepicker-input" data-target="#startdate" />
                                    <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <span class="text-danger"><?php if (isset($errors['start_date'])) : ?><?= $errors['start_date'] ?> <?php endif ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date:</label>
                                <div class="input-group date" id="enddate" data-target-input="nearest">
                                    <input name="end_date" type="text" class="form-control datetimepicker-input" data-target="#enddate" />
                                    <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <span class="text-danger"><?php if (isset($errors['end_date'])) : ?><?= $errors['end_date'] ?> <?php endif ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <label class="mr-4">
                                Public:
                            </label>
                            <input name="is_public" type="checkbox" id="checkboxPrimary2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Picture: </label>
                        <input name="image" type="file" class="ml-4" /><br />
                        <span class="text-danger"><?php if (isset($errors['image'])) : ?><?= $errors['image'] ?> <?php endif ?></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_add_event" class="btn btn-primary float-right"> <i class="icon fas fa-plus"></i> Post</button>
                </div>
            </form>
        </div>
    </div>
</div>