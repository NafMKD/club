<?php

use App\Helper\Formater;

?>
<dl class="row">
    <dt class="col-sm-4">user id:</dt>
    <dd class="col-sm-8"><?= $user->id ?></dd>
    <dt class="col-sm-4">Username:</dt>
    <dd class="col-sm-8"><?= $user->username ?></dd>
    <?php if ($user->userDetail) : ?>
        <?php if ($user->userDetail->student_id) : ?>
            <dt class="col-sm-4">student id:</dt>
            <dd class="col-sm-8"><?= $user->userDetail->student_id ?></dd>
        <?php endif ?>
        <?php if ($user->userDetail->first_name) : ?>
            <dt class="col-sm-4">Full Name:</dt>
            <dd class="col-sm-8"><?= $user->userDetail->first_name . ' ' . $user->userDetail->last_name ?></dd>
        <?php endif ?>
        <?php if ($user->userDetail->phone) : ?>
            <dt class="col-sm-4">Phone:</dt>
            <dd class="col-sm-8"><?= $user->userDetail->phone ?></dd>
        <?php endif ?>
        <?php if ($user->userDetail->gender) : ?>
            <dt class="col-sm-4">Gender:</dt>
            <dd class="col-sm-8"><?= $user->userDetail->gender ?></dd>
        <?php endif ?>
        <?php if ($user->userDetail->year) : ?>
            <dt class="col-sm-4">Year:</dt>
            <dd class="col-sm-8"><?= $user->userDetail->year ?></dd>
        <?php endif ?>
    <?php endif ?>
    <dt class="col-sm-4">Last Login:</dt>
    <dd class="col-sm-8"><?= Formater::formatDate($user->last_login) ?></dd>
    <dt class="col-sm-4">Registered date:</dt>
    <dd class="col-sm-8"><?= Formater::formatDate($user->created_at) ?> </dd>
    <dt class="col-sm-4">Last update:</dt>
    <dd class="col-sm-8"><?= Formater::formatDate($user->updated_at) ?></dd>
</dl>