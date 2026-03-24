<?php

use App\Helper\Formater;
use App\Helper\PostPicture;
use App\Model\Feed;

$feeds = Feed::findAllFeedView();

?>
<?php foreach ($feeds as $feed) :
    $feedAuthor = $feed->hasUser();
    $file_count = count($feed->feed_file ?? []);
    $authorLabel = $feedAuthor
        ? (($feedAuthor->userDetail)
            ? ucwords($feedAuthor->userDetail->first_name . ' ' . $feedAuthor->userDetail->last_name)
            : ucwords($feedAuthor->username))
        : '—';
    ?>
    <!-- post starts -->
    <div class="post m-1 border-bottom" style="max-width: 611px;">
        <div class="post__avatar">
            <?php if ($feedAuthor && $feedAuthor->profile_picture && file_exists(__DIR__ . '/../../files/images/profile_pictures/' . $feedAuthor->profile_picture)) : ?>
                <img src="<?= '../files/images/profile_pictures/' . htmlspecialchars($feedAuthor->profile_picture, ENT_QUOTES, 'UTF-8') ?>" alt="" />
            <?php else : ?>
                <img src="../assets/dist/img/logo.jpg" alt="" />
            <?php endif ?>
        </div>

        <div class="post__body">
            <div class="post__header">
                <div class="post__headerText">
                    <h3>
                        <?php if ($feedAuthor) : ?>
                        <a href="users.php?view=<?= (int) $feedAuthor->id ?>"><?= htmlspecialchars($authorLabel, ENT_QUOTES, 'UTF-8') ?></a>
                        <?php else : ?>
                        <?= htmlspecialchars($authorLabel, ENT_QUOTES, 'UTF-8') ?>
                        <?php endif ?>
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