<!-- sidebar starts -->
<div class="sidebar">
    <!-- <i class="fab fa-twitter"></i> -->
    <img src="../assets/dist/img/logo.jpg" style="height: 70px;width:70px;" class="rounded-circle mb-2" />
    <a class="sidebarOption <?php if(isset($feeds_page)) echo $feeds_page; ?>" href="index.php?list">
        <span class="material-icons"> home </span>
        <h2>Feeds</h2>
    </a>

    <a class="sidebarOption <?php if(isset($events_page)) echo $events_page; ?>" href="events.php?list">
        <span class="material-icons"> event </span>
        <h2>Events</h2>
    </a>

    <a class="sidebarOption <?php if(isset($divisions_page)) echo $divisions_page; ?>" href="divisions.php?list">
        <span class="material-icons"> category </span>
        <h2>Disvisions</h2>
    </a>

    <a class="sidebarOption <?php if(isset($users_page)) echo $users_page; ?>" href="users.php?list">
        <span class="material-icons"> group </span>
        <h2>Users</h2>
    </a>

    <a class="sidebarOption <?php if(isset($profile_page)) echo $profile_page; ?>" href="profile.php">
        <span class="material-icons"> perm_identity </span>
        <h2>Profile</h2>
    </a>

    <a href="../logout.php"><button class="sidebar__tweet btn btn-danger" >sign out</button></a>
</div>
<!-- sidebar ends -->