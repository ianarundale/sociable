<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="en-us"/>
    <title><?php echo $title;?></title>
    <meta name="keywords" content="<?php echo $meta_keywords;?>"/>
    <meta name="description" content="<?php echo $meta_description;?>"/>
    <meta name="copyright" content="<?php echo $meta_copywrite;?>"/>
    <?php foreach ($styles as $file => $type) {
    echo HTML::style($file, array('media' => $type)), "\n";
} ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>

    <?php if (kohana::$environment == kohana::PRODUCTION): ?>


    <?php // TODO: Insert google analytics placeholder ?>

    <?php else: ?>
    <!-- google analytics placeholder for production -->
    <?php endif;?>

    <?php // foreach($scripts as $file) { echo HTML::script($file), "\n"; }?>
    <link rel="icon" href="/favicon.png"/>


</head>
<body>

<?php echo $header; ?>

<?php echo $page_content; ?>

<?php echo $footer; ?>


<script src="http://code.jquery.com/jquery.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>
