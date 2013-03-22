<?php defined('SYSPATH') or die('No direct access allowed.');

if (isset($activity->story)): echo $activity->story; endif; ?>
<div class="share-link">
    <?php if (isset($activity->message)): ?>
    <p style="margin-left: 60px;"><?php echo $activity->message?></p>
    <?php endif; ?>
    <?php if (isset($activity->picture)): ?>
    <a href="<?php echo $activity->link ?>">
        <img src="<?php echo $activity->picture ?>" style="width: 90px; height: 90px"/>
    </a>
    <?php endif; ?>
    <a class="share-text" href="<?php echo $activity->link ?>">
        <?php if(isset($activity->name)):?> <div class="title"><?php echo $activity->name ?></div> <?php endif ;?>
        <?php if(isset($activity->caption)):?> <div class="title"><?php echo $activity->caption ?></div> <?php endif ;?>
        <?php if(isset($activity->description)):?> <div class="title"><?php echo $activity->description ?></div> <?php endif ;?>
    </a>
</div>