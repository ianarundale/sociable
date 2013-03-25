<?php foreach ($education_collection as $education): ?>

    <div>
        <h4><?php echo $education->school->name ?></h4>
        <b><?php echo $education->year->name ?></b>
        <p><?php echo (isset($education->type))? $education->type:""; ?></p>
    </div>

<?php endforeach; ?>