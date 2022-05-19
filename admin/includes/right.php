<?php

use App\Helper\Formater;
use App\Model\Event;

$upcommings = Event::getUpcomingEvents();

?>
<!-- widgets starts -->
<div class="widgets">
    <div class="widgets__input">
        <span class="material-icons widgets__searchIcon"> search </span>
        <input type="text" placeholder="Search" />
    </div>

    <div class="widgets__widgetContainer">
        <h2>Upcoming Events </h2>

        <?php foreach($upcommings as $upcomming) :?>
            <div class="callout callout-info">
                <h5><?= ucfirst($upcomming->title) ?></h5>

                <p>at <?= Formater::formatDatePost($upcomming->start_date) ?></p>
            </div>
        <?php endforeach ?>

    </div>
</div>
<!-- widgets ends -->