
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo app_config('web-site-name'); ?>">
    <meta name="author" content="<?php echo app_config('web-site-name'); ?>">

	<title><?php echo app_config('web-site-name'); ?> | <?php echo $this->template->title->default("Default title"); ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo site_url("assets/css/bootstrap.min.css");?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
	<link href="<?php echo site_url("assets/css/plugins/metisMenu/metisMenu.min.css");?>" rel="stylesheet">

    <!-- Custom CSS -->
	<link href="<?php echo site_url("assets/css/sb-admin-2.css?".rand(100,999));?>" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="<?php echo site_url("assets/css/font-awesome.min.css");?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="icon" type="image/png" href="<?php echo site_url('assets/img/logo.png'); ?>" />  	
</head>

<body class="login-page">

	<?php echo $this->template->content; ?>

    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo site_url("assets/js/jquery.js");?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo site_url("assets/js/bootstrap.min.js");?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo site_url('"assets/js/plugins/metisMenu/metisMenu.min.js');?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo site_url('"assets/js/sb-admin-2.js');?>"></script>
	<script>
		$(document).ajaxComplete(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$("a[title ~= 'BotDetect']").removeAttr("style");
			$("a[title ~= 'BotDetect']").removeAttr("href");
			$("a[title ~= 'BotDetect']").css('visibility', 'hidden');
			$('[data-toggle="tooltip"]').tooltip();
			$("body").removeClass("hidden");
		});
	</script>	
</body>

</html>
