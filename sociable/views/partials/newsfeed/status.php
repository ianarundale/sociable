<?php defined('SYSPATH') or die('No direct access allowed.');

if (isset($activity->story)){ echo $activity->story; } ?>
<?php if (isset($activity->message)): ?>
    <p style="margin-left: 60px;"><?php echo $activity->message?></p>
<?php endif; ?>