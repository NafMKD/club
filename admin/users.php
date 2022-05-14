<?php
session_start();
$users_page = 'active'; 
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
            <h2 class="float-left">Users</h2>
            <?php if(isset($_GET['add'])): ?>
                <a href="?list" class="float-right material-icons" style="cursor: pointer;">arrow_back</a>
            <?php elseif(isset($_GET['view'])): ?>
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
            <?php include 'users/add.php' ?>
        <?php elseif(isset($_GET['view'])): ?>
            <?php include 'users/view.php' ?>
        <?php elseif(isset($_GET['list']) || count($_GET) == 0): ?>
            <?php include 'users/list.php' ?>
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