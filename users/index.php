<?php
session_start();
$feeds_page = 'active';
include __DIR__ . '/../vendor/autoload.php';

$user = unserialize($_SESSION['user']);
$user_is_division_head = unserialize($_SESSION['user_is_division_head']);
$user_division_data = unserialize($_SESSION['user_division_data']);

$check = $user_division_data === null;

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
        <?php if ($check) : ?>
            <div class="feed__header">
                <h2 >Home</h2>
            </div>
        <?php else : ?>
            <div class="feed__header">
                <h2 class="float-left">Home</h2>
                <?php if (isset($_GET['add'])) : ?>
                    <a href="?list" class="float-right material-icons" style="cursor: pointer;">arrow_back</a>
                <?php else : ?>
                    <a href="?add" class="float-right material-icons" style="cursor: pointer;">add_circle</a>
                <?php endif; ?>
                <br />
            </div>
        <?php endif ?>

        <!-- tweetbox starts -->
        <div class="tweetBox">

        </div>
        <!-- tweetbox ends -->

        <?php if (isset($_GET['add'])) : ?>
            <?php include 'feeds/add.php' ?>
        <?php elseif (isset($_GET['list']) || count($_GET) == 0) : ?>
            <?php include 'feeds/list.php' ?>
        <?php endif ?>

    </div>
    <!-- feed ends -->

    <?php include 'includes/right.php'; ?>

    <?php include 'includes/script.php'; ?>
</body>

</html>