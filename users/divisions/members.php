<?php

use App\Model\Division;

$division = Division::find($user_division_data->id);

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
        <dl class="row">
            <dt class="col-sm-3">Division Name : </dt>
            <dd class="col-sm-9"><?= $division->name ?></dd>
            <dt class="col-sm-3">Members count : </dt>
            <dd class="col-sm-9"><?= count($division->findAllMembers()) ?></dd>
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
                foreach ($division->findAllMembers() as $member) : ?>
                    <tr>
                        <td><?= $c ?></td>
                        <?php if($member->userDetail): ?>
                            <td><?= $member->userDetail->first_name .' '. $member->userDetail->last_name?></td>
                        <?php else:?>
                            <td><?= $member->username ?></td>
                        <?php endif;?>
                        <td>
                            <a href="?members&delete=<?= $member->id ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash mr-1"></i> Remove</a>
                        </td>
                    </tr>
                <?php $c++;
                endforeach ?>
            </tbody>
        </table>
    </div>
</div>