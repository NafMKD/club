<?php

use App\Helper\Formater;

$user = unserialize($_SESSION['admin']);

?>

<div class="card card-primary m-1">
    <div class="card-body box-profile">
        <div class="text-center">
            <?php if ($user->profile_picture && file_exists('../files/images/profile_pictures/' . $user->profile_picture)) : ?>
                <img class="profile-user-img img-fluid img-circle" src="<?= '../files/images/profile_pictures/' . $user->profile_picture ?>" alt="User profile picture">
            <?php else : ?>
                <img class="profile-user-img img-fluid img-circle" src="../assets/dist/img/logo.jpg" alt="User profile picture">
            <?php endif; ?>
        </div>
        <?php if ($user->userDetail) : ?>
            <h3 class="profile-username text-center"><?= $user->userDetail->first_name . ' ' . $user->userDetail->last_name ?></h3>
        <?php else : ?>
            <h3 class="profile-username text-center"><?= $user->username ?></h3>
        <?php endif; ?>
        <p class="text-muted text-center">Since <?= Formater::formatMonthYear($user->created_at) ?></p>
    </div>
</div>

<div class="card m-1">
    <div class="card-header p-2">
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link <?php if(count($_GET) === 0) echo 'active'; ?>" href="profile.php">Detail</a></li>
            <li class="nav-item"><a class="nav-link <?php if(isset($_GET['divisions'])) echo 'active'; ?>" href="?divisions">Divisions</a></li>
            <li class="nav-item"><a class="nav-link <?php if(isset($_GET['settings'])) echo 'active'; ?>" href="?settings">Settings</a></li>
            <li class="nav-item"><a class="nav-link <?php if(isset($_GET['profPic'])) echo 'active'; ?>" href="?profPic">Profile picture</a></li>
            <li class="nav-item"><a class="nav-link <?php if(isset($_GET['password'])) echo 'active'; ?>" href="?password">Password</a></li>
        </ul>
    </div><!-- /.card-header -->
    <div class="card-body" style="width: 611px;">
        <?php if(count($_GET) === 0): ?>
            <?php include 'inc/detail.php'; ?>
        <?php elseif(isset($_GET['divisions'])): ?>
            <?php include 'inc/division.php'; ?>
        <?php elseif(isset($_GET['settings'])): ?>
            <?php include 'inc/setting.php'; ?>
        <?php elseif(isset($_GET['profPic'])): ?>
            <?php include 'inc/profpic.php'; ?>
        <?php elseif(isset($_GET['password'])): ?>
            <?php include 'inc/password.php'; ?>
        <?php endif ?>
    </div>
</div>