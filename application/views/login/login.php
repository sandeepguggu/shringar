<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Langoor.biz</title>

    <link rel="stylesheet" href="<?php echo base_url('resources/css/bootstrap.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/bootstrap-responsive.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/ui-lightness/jquery-ui-1.8.19.custom.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/fancybox/jquery.fancybox-1.3.4.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/style.css'); ?>"/>

    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-1.7.2.min.js'); ?>"></script>
    <script type="text/javascript"
            src="<?php echo base_url('resources/js/jquery-ui-1.8.19.custom.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.fancybox-1.3.4.pack.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.cookie.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/application.js'); ?>"></script>
</head>
<body
    style='background: url("<?php echo base_url('resources/img/background.png'); ?>") repeat-x scroll center top #2C4762'>
<form action="<?php echo site_url("login/user_login"); ?>" method="post">
    <div class="login">
        <div class="logo">langoor.biz</div>
        <div class="login-form">
            <input type="text" placeholder="User Name" name="username"
                   value="<?php if (isset($username)) echo $username; ?>"/>
            <input type="password" placeholder="Password" name="password" value=""/>
        </div>
        <?php if (isset($error_message)): ?>
        <div class="login-error">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-info login-submit">Log in</button>
    </div>
</form>
</body>