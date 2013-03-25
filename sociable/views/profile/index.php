<div class="container">
    <img class="img-rounded pull-left" src="http://graph.facebook.com/<?php echo $user->id?>/picture/?type=large"
         style="margin-right: 20px;"/>

    <h1><?php echo $user->name ?>
        <small>(<?php echo $user->username?>)</small>
    </h1>
    <h5><?php echo $user->email ?></h5>

    <div class="clearfix"></div>
    <hr class="clearfix"/>


    <div class="pull-right">

    </div>

    <div class="clearfix"></div>
    <div class="row visible-desktop">
        <div class="span4">
            <h2>Work history</h2>
            <hr/>
            <?php echo View::factory("formatters/profile/work", array("work_collection" => $user->work)); ?>
        </div>
        <div class="span4">
            <h2>Education history</h2>
            <hr/>
            <?php echo View::factory("formatters/profile/education", array("education_collection" => $user->education)); ?>
        </div>

        <div class="span4" >
            <h2>Activity stream</h2>
            <hr/>
            <?php echo View::factory("formatters/profile/education", array("education_collection" => $user->education)); ?>
        </div>
    </div>

</div>