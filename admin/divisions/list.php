<?php

use App\Model\Division;

if (isset($_GET['delete'])) {
    if (isset($_GET['is_confirmed']) && $_GET['is_confirmed'] == 'yes'){
        $division = Division::find($_GET['delete']);
        if($division){
            $division->delete();
            echo '<script>
                Swal.fire({
                    title: "Success",
                    text: "Division has been deleted.",
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
                    text: "Division not found!",
                    icon: "error",
                    confirmButtonText: "OK"
                });</script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this division!",
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
        <h3 class="card-title">Division list:</h3>

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
                <?php $c = 1;
                foreach ($divisions as $division) : ?>
                    <tr>
                        <td><?= $c ?></td>
                        <td><?= $division->name ?></td>
                        <td>
                            <a href="?edit=<?= $division->id ?>" class="btn btn-info btn-xs"><i class="fas fa-edit mr-1"></i>Edit</a>
                            <a href="?list&delete=<?= $division->id ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i>Delete</a>
                            <a href="?members=<?= $division->id ?>" class="btn btn-primary btn-xs"><i class="fas fa-users mr-1"></i>Members</a>
                        </td>
                    </tr>
                <?php $c++;
                endforeach ?>
            </tbody>
        </table>
    </div>
</div>