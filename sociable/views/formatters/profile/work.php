<?php foreach ($work_collection as $work): ?>

    <div>
        <h4><?php echo $work->employer->name ?></h4>
        <b><?php echo $work->position->name ?></b>
        <p><?php echo (isset($work->description))? $work->description:""; ?></p>
    </div>

<?php endforeach; ?>