<?php
session_start();
$profile_page = 'active'; 
include __DIR__ . '/../vendor/autoload.php';
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
            <h2>Profile</h2>
        </div>
        
        <!-- tweetbox starts -->
        <div class="tweetBox">

        </div>
        <!-- tweetbox ends -->

        <?php include 'profile/view.php' ?>

    </div>
    <!-- feed ends -->

    <?php include 'includes/right.php'; ?>

    <?php include 'includes/script.php'; ?>
</body>

</html>