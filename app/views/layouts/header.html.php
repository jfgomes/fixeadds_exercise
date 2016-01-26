<!DOCTYPE html>
<html lang="pt-pt">
    <head>
        <title>FixeAds Exercise</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="/public/assets/css/app.min.css" />
        <link rel="shortcut icon" type="image/png" href="/public/favicon.ico" />
    </head>
    <body>
        <?php /* Success output generic message area */ ?>
        <?php if (isset($params['success'])) { ?>
            <div class="generic_success_msg">
                <?php echo $params['success']; ?>
            </div>
        <?php } ?>

        <?php /* Fail output generic message area */ ?>
        <?php if (isset($params['fail'])) { ?>
            <div class="generic_error_msg">
                <?php echo $params['fail']; ?>
            </div>
        <?php } ?>
 