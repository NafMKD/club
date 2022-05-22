<?php

use App\Model\Division;
use App\Model\UserDivision;

$divisions = Division::findAllUserAdd($user->id);


if (isset($_POST['btn_add_division'])) {
    $division = (int) $_POST['division'];

    $data = UserDivision::create([
        'user_id' => (int) $user->id,
        'division_id' => $division,
        'is_active' => 1
    ]);

    if ($data->save()) {
        $return_message = ['success', 'User division added successfully', 'check'];
    } else {
        $return_message = ['danger', 'something went wrong', 'ban'];
    }
}

if (isset($_GET['delete'])) {
    if (isset($_GET['is_confirmed']) && $_GET['is_confirmed'] == 'yes'){
        $user_division = UserDivision::findByUserIdAndDivisionId($_GET['view'],$_GET['delete']);
        if($user_division){
            $user_division->delete();
            echo '<script>
                Swal.fire({
                    title: "Success",
                    text: "User has been removed.",
                    type: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location = "?view='. $_GET['view'] .'&divisions";
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
                    window.location.href = "?view='. $_GET['view'] .'&divisions&delete='.$_GET['delete'].'&is_confirmed=yes";
                }else{
                    window.location.href = "?view='. $_GET['view'] .'&divisions";
                }
            });</script>';
    }
}

?>
<?php if (isset($return_message)) : ?>
    <div class="alert alert-<?= $return_message[0]; ?> alert-dismissible">
        <i class="icon fas fa-<?= $return_message[2]; ?>"></i>
        <?= $return_message[1]; ?>
    </div>
<?php endif ?>
<button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-division"> <i class="icon fas fa-plus"></i> Add to division</button>
<hr />
<table class="table">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Progress</th>
            <th style="width: 40px">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($user->hasDivisions()) : ?>
            <?php $c = 1;
            foreach ($user->hasDivisions() as $division) : 
                $progress = $user->getUserAttendanceProgress($division->id);
                if($progress['all'] !== 0){
                    $progress = ($progress['attended'] * 100) / $progress['all'];
                }else{
                    $progress = 100;
                }

                if($progress < 25){
                    $progress_calss = "danger";
                }elseif($progress >= 25 && $progress < 50){
                    $progress_calss = "warning";
                }elseif($progress >= 50 && $progress < 75){
                    $progress_calss = "primary";
                }else{
                    $progress_calss = "success";
                }
            ?>
                <tr>
                    <td><?= $c ?></td>
                    <td><?= $division->name ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-<?= $progress_calss ?>" style="width: <?= $progress ?>%"></div>
                        </div>
                    </td>
                    <td>
                        <a href="?view=<?= $_GET['view'] ?>&divisions&delete=<?= $division->id ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i></a>
                    </td>
                </tr>
            <?php $c++;
            endforeach ?>
        <?php endif ?>
    </tbody>
</table>


<div class="modal fade" id="modal-add-division">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Member to division</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Divisions:</label>
                        <select name="division" class="form-control select2" style="width: 100%;">
                            <?php foreach ($divisions as $division) : ?>
                                <option value="<?= $division->id ?>"><?= $division->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_add_division" class="btn btn-primary float-right"> <i class="icon fas fa-plus"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>