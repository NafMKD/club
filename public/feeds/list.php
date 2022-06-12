<?php

use App\Helper\Formater;
use App\Helper\PostPicture;
use App\Model\Feed;

$feeds = Feed::findAllFeedView();

?>
<?php foreach ($feeds as $feed) : $file_count = count($feed->feed_file);?>
    <!-- post starts -->
    <div class="post m-1 border-bottom" style="max-width: 611px;">
        <div class="post__avatar">
            <?php if ($feed->hasUser()->profile_picture && file_exists(__DIR__ . '/../../files/images/profile_pictures/' . $feed->hasUser()->profile_picture)) : ?>
                <img src="<?= '../files/images/profile_pictures/' . $feed->hasUser()->profile_picture ?>" alt="" />
            <?php else : ?>
                <img src="../assets/dist/img/logo.jpg" alt="" />
            <?php endif ?>
        </div>

        <div class="post__body">
            <div class="post__header">
                <div class="post__headerText">
                    <h3>
                        <?= ucwords(($feed->hasUser()->userDetail) ? $feed->hasUser()->userDetail->first_name . ' ' . $feed->hasUser()->userDetail->last_name : $feed->hasUser()->username) ?>
                        <span class="post__headerSpecial"><?= Formater::formatDateLikeXDaysAgo($feed->created_at) ?></span>
                    </h3>
                </div>
                <div class="post__headerDescription">
                    <p><?= $feed->description ?></p>
                </div>
            </div>
            <style>
                img {
                    max-height: 200px;
                }
            </style>
            <?php if($file_count === 1): ?>
                <?= PostPicture::showOnePicture($feed->feed_file, '../files/images/feeds/') ?>
            <?php elseif($file_count === 2): ?>
                <?= PostPicture::showTwoPictures($feed->feed_file, '../files/images/feeds/') ?>
            <?php elseif($file_count === 3): ?>
                <?= PostPicture::showThreePictures($feed->feed_file, '../files/images/feeds/') ?>
            <?php elseif($file_count === 4): ?>
                <?= PostPicture::showFourPictures($feed->feed_file, '../files/images/feeds/') ?>
            <?php else: ?>
                <?= PostPicture::showFivePictures($feed->feed_file, '../files/images/feeds/') ?>
            <?php endif ?>
        </div>
    </div>
    <!-- post ends -->
<?php endforeach ?>