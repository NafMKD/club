<?php

use App\Model\Division;

$divisions = Division::findAll();

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
                <?php $c=1;foreach($divisions as $division): ?>
                <tr>
                    <td><?= $c ?></td>
                    <td><?= $division->name ?></td>
                    <td>
                        <a href="?edit=<?= $division->id?>" class="btn btn-info btn-xs"><i class="fas fa-edit mr-1"></i>Edit</a>
                        <a href="?delete=<?= $division->id?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i>Delete</a>
                    </td>
                </tr>
                <?php $c++;endforeach ?>
            </tbody>
        </table>
    </div>
</div>