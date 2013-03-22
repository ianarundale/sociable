<?php defined('SYSPATH') or die('No direct access allowed.');

if (isset($activity->story)): echo $activity->story; endif; ?>

<?php if (isset($activity->link) && isset($activity->picture)): ?>
Video: <a href="<?php echo $activity->link; ?>">
    <img src="<?php echo $activity->picture?>"/>
</a>
<?php endif; ?>