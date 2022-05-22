<?php
session_start();
$feeds_page = 'active'; 
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
            <h2>Home</h2>
        </div>
        
        <!-- tweetbox starts -->
        <div class="tweetBox">

        </div>
        <!-- tweetbox ends -->

        <?php include 'feeds/list.php' ?>

    </div>
    <!-- feed ends -->

    <?php include 'includes/right.php'; ?>

    <?php include 'includes/script.php'; ?>
</body>

</html>