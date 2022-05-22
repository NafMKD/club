<?php
session_start();
$divisions_page = 'active';
include __DIR__ . '/../vendor/autoload.php';

$user = unserialize($_SESSION['user']);
$user_is_division_head = unserialize($_SESSION['user_is_division_head']);
$user_division_data = unserialize($_SESSION['user_division_data']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/left.php'; ?>

    <!-- feed starts -->
    <div class="feed">
        <div class="feed__header">
            <h2><?= $user_division_data->name ?></h2>
        </div>

        <!-- tweetbox starts -->
        <div class="tweetBox">

        </div>
        <!-- tweetbox ends -->

        <div class="card" style="max-width: 611px;">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link <?php if (isset($_GET['members']) || count($_GET) === 0) echo 'active' ?>" href="?members">Members</a></li>
                    <li class="nav-item"><a class="nav-link <?php if (isset($_GET['events'])) echo 'active' ?>" href="?events">Events</a></li>
                    <li class="nav-item"><a class="nav-link <?php if (isset($_GET['settings'])) echo 'active' ?>" href="?settings">Settings</a></li>
                    <li class="nav-item"><a class="nav-link <?php if (isset($_GET['attendance'])) echo 'active' ?>" href="#">Attendance</a></li>
                </ul>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['members']) || count($_GET) === 0) : ?>
                    <?php include 'divisions/members.php'; ?>
                <?php elseif (isset($_GET['events'])) : ?>
                    <?php include 'divisions/events.php'; ?>
                <?php elseif (isset($_GET['attendance'])) : ?>
                    <?php include 'divisions/inc/attendance.php'; ?>
                <?php elseif (isset($_GET['settings'])) : ?>
                    <?php include 'divisions/setting.php'; ?>
                <?php endif ?>
            </div>
        </div>

    </div>

    <?php include 'includes/right.php'; ?>

    <?php include 'includes/script.php'; ?>
    <?php if (isset($return_message)) : ?>
        <script>
            $(document).ready(function() {
                $('#modal-add-event').modal('show');
                $('#add_member').modal('show');
            });
        </script>
    <?php endif ?>
</body>

</html>