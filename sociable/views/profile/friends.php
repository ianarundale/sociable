<div class="container">
<?php foreach($friends as $friend): ?>
    <div class="well">
        <img class="img-rounded" src="http://graph.facebook.com/<?php echo $friend->id ?>/picture"/>
        <b><?php echo $friend->name ?></b>
    </div>
<?php endforeach; ?>
</div>