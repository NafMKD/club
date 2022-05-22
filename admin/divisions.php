<?php
session_start();
$divisions_page = 'active';
include __DIR__ . '/../vendor/autoload.php';

$divisions = \App\Model\Division::findAll();

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
            <h2 class="float-left">Divisions</h2>
            <?php if (isset($_GET['add']) || isset($_GET['edit']) || isset($_GET['members']) || isset($_GET['attendance'])) : ?>
                <a href="?list" class="float-right material-icons" style="cursor: pointer;">arrow_back</a>
            <?php else : ?>
                <a href="?add" class="float-right material-icons" style="cursor: pointer;">add_circle</a>
            <?php endif; ?>
            <br />
        </div>

        <!-- tweetbox starts -->
        <div class="tweetBox">

        </div>
        <!-- tweetbox ends -->
        <?php if (isset($_GET['edit'])) : ?>
            <?php include 'divisions/edit.php' ?>
        <?php elseif (isset($_GET['add'])) : ?>
            <?php include 'divisions/add.php' ?>
        <?php elseif (isset($_GET['members'])) : ?>
            <?php include 'divisions/member.php' ?>
        <?php elseif (isset($_GET['attendance'])) : ?>
            <?php include 'divisions/attendance.php' ?>
        <?php elseif (isset($_GET['list']) || count($_GET) == 0) : ?>
            <?php include 'divisions/list.php' ?>
        <?php endif ?>

    </div>
    <!-- feed ends -->

    <?php include 'includes/right.php'; ?>

    <?php include 'includes/script.php'; ?>
    <script>
        $(document).ready(function() {
            $('.table_search').on('keyup', function() {
                var searchsterm = $(this).val().toLowerCase();
                $('#table tbody tr').each(function() {
                    var linestr = $(this).text().toLowerCase();
                    if (linestr.indexOf(searchsterm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>
</body>

</html>