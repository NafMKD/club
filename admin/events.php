<?php
session_start();
$events_page = 'active'; 
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
            <h2 class="float-left">Events</h2>
            <?php if(isset($_GET['add']) || isset($_GET['attendance'])): ?>
                <a href="?list" class="float-right material-icons" style="cursor: pointer;">arrow_back</a>
            <?php else: ?>
                <a href="?add" class="float-right material-icons" style="cursor: pointer;">add_circle</a>
            <?php endif; ?>
            <br/>
        </div>

        <!-- tweetbox starts -->
        <div class="tweetBox">

        </div>
        <!-- tweetbox ends -->

        <?php if(isset($_GET['add'])): ?>
            <?php include 'events/add.php' ?>
        <?php elseif(isset($_GET['attendance'])): ?>
            <?php include 'events/attendance.php' ?>
        <?php elseif(isset($_GET['list']) || count($_GET) == 0): ?>
            <?php include 'events/list.php' ?>
        <?php endif ?>

    </div>
    <!-- feed ends -->

    <?php include 'includes/right.php'; ?>

    <?php include 'includes/script.php'; ?>
</body>

</html>