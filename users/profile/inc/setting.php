<?php

use App\Model\UserDetail;

if (isset($_POST['btn_update'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $year = (int) $_POST['year'];
    $student_id = $_POST['student_id'];
    $gender =  $_POST['gender'];

    $errors = [];

    if (count($errors) === 0) {
        if ($user->userDetail) {
            // update user detail
            $user->userDetail->first_name = $first_name;
            $user->userDetail->last_name = $last_name;
            $user->userDetail->phone = $phone;
            $user->userDetail->year = $year;
            $user->userDetail->student_id = $student_id;
            $user->userDetail->gender = $gender;

            if ($user->userDetail->save()) {
                $return_message = ['success', 'User detail updated successfully', 'check'];
            } else {
                $return_message = ['danger', 'something went wrong', 'ban'];
            }
        } else {
            // add user detail
            $userDetail = UserDetail::create([
                'user_id' => $user->id,
                'student_id' => $student_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'phone' => $phone,
                'year' => $year,
                'is_active' => 1
            ]);

            if ($userDetail->save()) {
                $return_message = ['success', 'User detail added successfully', 'check'];
                $user->updateCurrentInstance();
                $_SESSION['user'] = serialize($user);
            } else {
                $return_message = ['danger', 'something went wrong', 'ban'];
            }
        }
    } else {
        $return_message = ['danger', 'Please fix the errors', 'ban'];
    }
}

?>
<?php if (isset($return_message)) : ?>
    <div class="alert alert-<?= $return_message[0]; ?> alert-dismissible">
        <i class="icon fas fa-<?= $return_message[2]; ?>"></i>
        <?= $return_message[1]; ?>
    </div>
<?php endif ?>
<form method="POST">
    <div class="row">
        <div class="col-md-6 form-group">
            <label>First Name:</label>
            <input name="first_name" type="text" class="form-control" placeholder="Enter first name" <?php if ($user->userDetail) : ?> value="<?= $user->userDetail->first_name ?>" <?php endif ?>>
            <span class="text-danger"><?php if (isset($errors['first_name'])) echo $errors['first_name']; ?></span>
        </div>
        <div class="col-md-6 form-group">
            <label>Last Name:</label>
            <input name="last_name" type="text" class="form-control" placeholder="Enter last_name" <?php if ($user->userDetail) : ?> value="<?= $user->userDetail->last_name ?>" <?php endif ?>>
            <span class="text-danger"><?php if (isset($errors['last_name'])) echo $errors['last_name']; ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Phone:</label>
            <input name="phone" type="text" class="form-control" placeholder="Enter phone" <?php if ($user->userDetail) : ?> value="<?= $user->userDetail->phone ?>" <?php endif ?>>
            <span class="text-danger"><?php if (isset($errors['phone'])) echo $errors['phone']; ?></span>
        </div>
        <div class="col-md-6 form-group">
            <label>Year:</label>
            <input name="year" type="text" class="form-control" placeholder="Enter year" <?php if ($user->userDetail) : ?> value="<?= $user->userDetail->year ?>" <?php endif ?>>
            <span class="text-danger"><?php if (isset($errors['year'])) echo $errors['year']; ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Student Id:</label>
            <input name="student_id" type="text" class="form-control" placeholder="Enter student id" <?php if ($user->userDetail) : ?> value="<?= $user->userDetail->student_id ?>" <?php endif ?>>
            <span class="text-danger"><?php if (isset($errors['student_id'])) echo $errors['student_id']; ?></span>
        </div>
        <div class="col-md-6 form-group">
            <label>Gender:</label>
            <select name="gender" style="width: 100%;" class="form-control select2">
                <option <?php if ($user->userDetail) : ?> <?php if ($user->userDetail->gender == "Male") echo "Selected" ?> <?php endif ?>>Male</option>
                <option <?php if ($user->userDetail) : ?> <?php if ($user->userDetail->gender == "Female") echo "Selected" ?> <?php endif ?>>Female</option>
            </select>
            <span class="text-danger"><?php if (isset($errors['gender'])) echo $errors['gender']; ?></span>
        </div>
    </div>

    <button name="btn_update" class="btn btn-success float-right">Update</button>
</form>