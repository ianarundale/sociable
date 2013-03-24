<?php foreach ($normalized_news_feed as $activity): ?>
<div class="stream-story">
    <div class="well">
        <a href="/photo/location" class="pull-left" style="margin-right: 10px;">
            <img src="http://graph.facebook.com/<?php echo $activity->from->id ?>/picture"/>
        </a>

        <div class="story-inner-content" style="display:block;">
            <a href="https://www.facebook.com/<?php echo $activity->from->id ?>"><?php echo $activity->from->name ?></a>

            <?php
            $viewArgs = array("activity" => $activity);

            switch ($activity->type) {
                case "link":
                    echo View::factory("partials/newsfeed/link", $viewArgs);
                    break;
                case "status":
                    echo View::factory("partials/newsfeed/status", $viewArgs);
                    break;
                case "photo":
                    echo View::factory("partials/newsfeed/photo", $viewArgs);
                    break;
                case "video":
                    echo View::factory("partials/newsfeed/video", $viewArgs);
                    break;
                default :
                    echo $activity->type;
            }

            ?>

            <?php if ($activity->type == "swf"): ?>
            <?php if (isset($activity->message)): ?>
                <p style="margin-left: 60px;"> SWF: <?php echo $activity->message?></p>
                <?php endif; ?>
            <?php endif;?>


        </div>
        <div class="clearfix"></div>
    </div>
</div>
<? endforeach; ?>


<div class="row span-4 visible-desktop">
    <div class="span4" style="background:red">fdsafsa</div>
    <div class="span3 offset2" style="background:blue">fdsafsda</div>
    <div class="span3" style="background:green">fdsafsa</div>
</div>