<?php

use App\Helper\Formater;
use App\Model\Event;

$upcommings = Event::getUpcomingEvents();

$todays = Event::getTodaysEvent();

?>
<!-- widgets starts -->
<div class="widgets">
    <div class="widgets__input">
        <span class="material-icons widgets__searchIcon"> search </span>
        <input type="text" placeholder="Search" />
    </div>

    <div class="widgets__widgetContainer">
        <h2>Today's Events </h2>

        <?php foreach($todays as $today) :?>
            <div class="callout callout-info">
                <a href="events.php?attendance=<?= $today->id ?>" style="text-decoration: none;"><h5><?= ucfirst($today->title) ?></h5></a>

                <p>at <?= Formater::formatTime($today->start_date) ?></p>
            </div>
        <?php endforeach ?>

    </div>

    <div class="widgets__widgetContainer">
        <h2>Upcoming Events </h2>

        <?php foreach($upcommings as $upcomming) :?>
            <div class="callout callout-info">
                <h5><?= ucfirst($upcomming->title) ?></h5>

                <p>on <?= Formater::formatDatePost($upcomming->start_date) ?> (<?= str_replace('ago', 'left',Formater::formatDateLikeXDaysAgo($upcomming->start_date)) ?>)</p>
            </div>
        <?php endforeach ?>

    </div>
</div>
<!-- widgets ends -->