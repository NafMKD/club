<?php

use App\Helper\Formater;
use App\Model\Event;

$events = Event::getEventsForUser($user->id);

?>

<?php foreach ($events as $event) :
    $division = $event->hasDivision();
    $divisionHead = $division?->division_head;
    ?>

    <!-- post starts -->
    <div class="post m-1 border-bottom" style="max-width: 611px;">
        <div class="post__avatar">
            <?php if ($divisionHead && $divisionHead->profile_picture && file_exists(__DIR__ . '/../../files/images/profile_pictures/' . $divisionHead->profile_picture)) : ?>
                <img src="<?= '../files/images/profile_pictures/' . htmlspecialchars($divisionHead->profile_picture, ENT_QUOTES, 'UTF-8') ?>" alt="" />
            <?php else : ?>
                <img src="../assets/dist/img/logo.jpg" alt="" />
            <?php endif ?>
        </div>

        <div class="post__body">
            <div class="post__header">
                <div class="post__headerText">
                    <h3>
                        <?= htmlspecialchars($division?->name ?? '—', ENT_QUOTES, 'UTF-8') ?>
                        <span class="post__headerSpecial"><?= Formater::formatDateLikeXDaysAgo($event->created_at) ?></span>
                    </h3>
                </div>
                <div class="post__headerDescription">
                    <p><?= ucfirst($event->title) ?></p>
                    <p><?= $event->description ?></p>
                </div>
            </div>
            <?php if ($event->image_url && file_exists(__DIR__ . '/../../files/images/events/' . $event->image_url)) : ?>
                <img src="<?= '../files/images/events/' . $event->image_url ?>" alt="post_img" />
            <?php endif ?>
            <div class="post__footer">
                <span> Start Date : <?= Formater::formatDatePost($event->start_date) ?></span>
                <?php if ($event->end_date) : ?>
                    <span> End Date : <?= Formater::formatDatePost($event->end_date) ?> </span>
                <?php endif ?>
            </div>
        </div>
    </div>
    <!-- post ends -->

<?php endforeach ?>