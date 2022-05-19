<?php

use App\Helper\Validation;
use App\Model\Event;
use App\Model\Feed;
use App\Model\FeedFile;

$events = Event::findAll();

if (isset($_POST['btn_post'])) {
    $event_id = ($_POST['event_id'] === '') ? null : (int) $_POST['event_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $images = $_FILES['image'];

    $errors = [];

    if (Validation::isEmpty($title)) $errors['title'] = 'Title is required';

    for ($i = 0; $i < count($images['name']); $i++) {
        if (!Validation::isValidImage($images['type'][$i])) $errors['image'] = 'Image must be a valid image';
    }
    if(count($images['name']) > 5) $errors['image'] = 'You can only upload max 5 images';

    if (count($errors) === 0) {
        $feed = Feed::create([
            'user_id' => unserialize($_SESSION['admin'])->id,
            'title' => $title,
            'description' => $description,
            'is_active' => 1,
            'event_id' => $event_id,
        ]);

        if ($feed->save()) {
            for ($i = 0; $i < count($images['name']); $i++) {
                $image_name = uniqid() . '_' . date('YmdHis') . '_' . $images['name'][$i];
                $image_path = __DIR__ . '/../../files/images/feeds/' . $image_name;
                $feedFile = FeedFile::create([
                    'feed_id' => $feed->id,
                    'file_url' => $image_name,
                    'is_active' => 1
                ]);
                if ($feedFile->save()) {
                    move_uploaded_file($images['tmp_name'][$i], $image_path);
                    $return_message = ['success', 'Feed posted successfully', 'check'];
                } else {
                    $return_message = ['danger', 'File upload error', 'ban'];
                }
            }
        } else {
            $return_message = ['danger', 'Something went wrong', 'ban'];
        }
    } else {
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
            <h3>Add Feed</h3>
        </div>
        <hr />
        <div class="form-group">
            <label>Event:</label>
            <select name="event_id" class="form-control select2" style="width: 100%;">
                <option value="">No event</option>
                <?php foreach ($events as $event) : ?>
                    <option value="<?= $event->id ?>"><?= ucfirst($event->title) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label>Title:</label>
            <input name="title" type="text" class="form-control" placeholder="Enter title">
            <span class="text-danger"><?php if (isset($errors['title'])) : ?><?= $errors['title'] ?><?php endif ?></span>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label>Pictures: </label>
            <input name="image[]" multiple type="file" class="ml-4" /><br />
            <span class="text-danger"><?php if (isset($errors['image'])) : ?><?= $errors['image'] ?><?php endif ?></span>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" name="btn_post" class="btn btn-primary">Post</button>
    </div>
</form>