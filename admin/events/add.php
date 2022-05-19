<?php

use App\Helper\Formater;
use App\Helper\Validation;
use App\Model\Division;
use App\Model\Event;

$divisions = Division::findAll();

if (isset($_POST['btn_post'])) {
    $division = (int) $_POST['division_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if(isset($_POST['is_public'])) $is_public = 1;
    else $is_public = 0;
    $image = $_FILES['image'];

    $errors = [];

    if(Validation::isEmpty($title)) $errors['title'] = 'Title is required';

    if(Validation::isEmpty($start_date)) $errors['start_date'] = 'Start date is required';

    if(! Validation::checkDateRange($start_date, $end_date)) $errors['end_date'] = 'End date must be greater than start date';

    if(! Validation::checkStartDate($start_date)) $errors['start_date'] = 'Start date must be greater than or equal to today';

    if(! Validation::isValidImage($image['type'])) $errors['image'] = 'Image must be a valid image';

    if(count($errors) === 0){
        $start_date = Formater::formatDateForDb($start_date);
        $end_date = Formater::formatDateForDb($end_date);
        
        $image_name = uniqid().'_'.date('YmdHis').'_'.$image['name'];
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
            $image_path = __DIR__.'/../../files/images/events/'.$image_name;
            move_uploaded_file($image['tmp_name'], $image_path);
            $return_message = ['success','Event posted successfully', 'check'];
        }else {
            $return_message = ['danger','Something went wrong', 'ban'];
        }
    }else{
        $return_message = ['danger', 'Please fix the errors', 'ban'];
    }


}
?>
<form method="POST" enctype="multipart/form-data">
    <div class="card-body">
        <?php if (isset($return_message)) : ?>
            <div class="alert alert-<?= $return_message[0]; ?> alert-dismissible">
                <i class="icon fas fa-<?= $return_message[2] ?>"></i>
                <?= $return_message[1]; ?>
            </div>
        <?php endif ?>
        <div>
            <h3>Add Event</h3>
        </div>
        <hr />
        <div class="form-group">
            <label>Division:</label>
            <select name="division_id" class="form-control select2" style="width: 100%;">
                <?php foreach($divisions as $division) : ?>
                    <option value="<?= $division->id; ?>"><?= $division->name; ?></option>
                <?php endforeach; ?> 
            </select>
        </div>
        <div class="form-group">
            <label>Title:</label>
            <input name="title" type="text" class="form-control" placeholder="Enter title">
            <span class="text-danger"><?php if(isset($errors['title'])): ?><?= $errors['title'] ?> <?php endif ?></span>
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
                    <span class="text-danger"><?php if(isset($errors['start_date'])): ?><?= $errors['start_date'] ?> <?php endif ?></span>
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
                    <span class="text-danger"><?php if(isset($errors['end_date'])): ?><?= $errors['end_date'] ?> <?php endif ?></span>
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
            <input name="image" type="file" class="ml-4" /><br/>
            <span class="text-danger"><?php if(isset($errors['image'])): ?><?= $errors['image'] ?> <?php endif ?></span>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" name="btn_post" class="btn btn-primary">Post</button>
    </div>
</form>