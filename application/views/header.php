<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Langoor.biz</title>

    <link rel="stylesheet" href="<?php echo base_url('resources/css/bootstrap.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/bootstrap-responsive.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/ui-lightness/jquery-ui-1.8.19.custom.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/fancybox/jquery.fancybox-1.3.4.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/jstree/themes/default/style.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/style.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resources/css/print.css'); ?>" media="print"/>
    <script type="text/javascript">
        var site_url = '<?php echo site_url();?>';
    </script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-1.7.2.min.js'); ?>"></script>
    <script type="text/javascript"
            src="<?php echo base_url('resources/js/jquery-ui-1.8.19.custom.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.fancybox-1.3.4.pack.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.cookie.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-barcode-2.0.2.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery.jstree.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-ui-timepicker-addon.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/config.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resources/js/bb.js'); ?>"></script>    
</head>
<body>
<div class="notification-block"></div>
<div id="confirmation-dialog" class="hide">

</div>
<div class="container-fluid">
    <!-- @Header -->
    <div class="header-wrapper">
        <div class="pull-left logo">
            langoor.biz
        </div>
        <div class="pull-right" style="width: 58em">
            <ul class="menu">
                <li><a href="<?php echo site_url('invoice'); ?>">Billing</a></li>
                <li><a href="<?php echo site_url('purchases'); ?>">Purchases</a></li>
                <li><a href="<?php echo site_url('inventory'); ?>">Inventory</a></li>
                <li><a href="<?php echo site_url('rent'); ?>">RENT</a></li>
                <li class="search_purch">
                    <input type="text" name="search" value="" class="search_input"/>
                    <input type="image" src="<?php echo base_url('resources/img/search-invoice.png'); ?>"
                           class="search_btn"/>
                </li>
                <li class="menu_logout"><a href="<?php echo site_url("login/user_logout"); ?>">Logout</a></li>
            </ul>
        </div>
    </div>
    <!-- @Content -->
    <div class="content">