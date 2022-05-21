<?php

if (empty($_GET['view'])) {
    header('Location: ?list');
    exit;
}

use App\Helper\Formater;
use App\Model\User;

$user = User::find($_GET['view']);

if (!$user) {
    header('Location: ?list');
    exit;
}
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
            <li class="nav-item"><a class="nav-link <?php if(!isset($_GET['settings']) && !isset($_GET['divisions'])) echo 'active'; ?>" href="?view=<?= $_GET['view']?>" >Detail</a></li>
            <li class="nav-item"><a class="nav-link <?php if(isset($_GET['settings'])) echo 'active'; ?>" href="?view=<?= $_GET['view']?>&settings" >Settings</a></li>
            <li class="nav-item"><a class="nav-link <?php if(isset($_GET['divisions'])) echo 'active'; ?>" href="?view=<?= $_GET['view']?>&divisions" >Divisions</a></li>
        </ul>
    </div><!-- /.card-header -->
    <div class="card-body" style="width: 611px;">
        <?php if(!isset($_GET['settings']) && !isset($_GET['divisions'])): ?>
            <?php include 'inc/detail.php'; ?>
        <?php elseif(isset($_GET['settings'])): ?>
            <?php include 'inc/setting.php'; ?>
        <?php elseif(isset($_GET['divisions'])): ?>
            <?php include 'inc/division.php'; ?>
        <?php endif ?>
    </div>
</div>