<?php
if (isset($_POST['btn_submit'])) {
    $division = $_POST['division_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_public = $_POST['is_public'];
    $image = $_FILES['image'];

    $image_name = 'Event_' . uniqid() . '_' . $image['name'];
    $data = \App\Model\Event::create([
        'division_id' => $division,
        'title' => $title,
        'description' => $description,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'is_public' => $is_public ?? 0,
        'image_url' => $image_name
    ]);

    if ($data->save()) {
        $image_path = '../files/events/' . $image_name;
        move_uploaded_file($image['tmp_name'], $image_path);
        $add_message = ['success','Event added successfully'];
    } else {
        $add_message = ['danger','Something went wrong'];
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <div class="card-body">
        <?php if (isset($add_message)) : ?>
            <div class="alert alert-<?= $add_message[0]; ?> alert-dismissible">
                <i class="icon fas fa-ban"></i>
                <?= $add_message[1]; ?>
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
            <input name="image" type="file" class="ml-4" />
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" name="btn_submit" class="btn btn-primary">Post</button>
    </div>
</form>