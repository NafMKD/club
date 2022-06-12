<?php


?>
    <table class="table">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Progress</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($user->hasDivisions()) : ?>
            <?php $c = 1;
            foreach ($user->hasDivisions() as $division) : 
                $progress = $user->getUserAttendanceProgress($division->id);
                if($progress['all'] !== 0){
                    $progress = ($progress['attended'] * 100) / $progress['all'];
                    if($progress === 0 ) $progress++;
                }else{
                    $progress = 100;
                }

                if($progress < 25){
                    $progress_calss = "danger";
                }elseif($progress >= 25 && $progress < 50){
                    $progress_calss = "warning";
                }elseif($progress >= 50 && $progress < 75){
                    $progress_calss = "primary";
                }else{
                    $progress_calss = "success";
                }
            ?>
                <tr>
                    <td><?= $c ?></td>
                    <td><?= $division->name ?></td>
                    <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-<?= $progress_calss ?>" style="width: <?= $progress ?>%"></div>
                        </div>
                    </td>
                </tr>
            <?php $c++;
            endforeach ?>
        <?php endif ?>
    </tbody>
</table>
