<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html> <!--<![endif]-->
<head>
	<title><?php echo $title;?></title>
	
	<!-- Meta -->
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	
	<!-- Bootstrap -->
	<link href="<?php echo base_url();?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>public/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url();?>public/bootstrap/extend/bootstrap-select/bootstrap-select.css" />
	<link href="<?php echo base_url();?>public/bootstrap/extend/bootstrap-wysihtml5/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet">
	
	<!-- Bootstrap Extended -->
	<link href="<?php echo base_url();?>public/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>public/bootstrap/extend/bootstrap-wysihtml5/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url();?>public/bootstrap/extend/bootstrap-select/bootstrap-select.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>public/bootstrap/extend/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
	
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/scripts/plugins/forms/select2/select2.css"/>
	
	<!-- Notyfy -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/scripts/plugins/notifications/notyfy/themes/default.css"/>
	
	<!-- Gritter Notifications Plugin -->
	<link href="<?php echo base_url();?>public/theme/scripts/plugins/notifications/Gritter/css/jquery.gritter.css" rel="stylesheet" />
	
	<!-- JQueryUI v1.9.2 -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/scripts/plugins/system/jquery-ui-1.9.2.custom/css/smoothness/jquery-ui-1.9.2.custom.min.css" />
	
	<!-- Glyphicons -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/glyphicons.css" />

	<!-- google-code-prettify -->
	<link href="<?php echo base_url();?>public/theme/scripts/plugins/other/google-code-prettify/prettify.css" type="text/css" rel="stylesheet" />
	
	<!-- JQuery v1.8.2 -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/system/jquery-1.8.2.min.js"></script>
	
	<!-- Modernizr -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/system/modernizr.custom.76094.js"></script>
	
	<!-- Theme -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/style.css" />
	
	<!-- LESS 2 CSS -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/system/less-1.3.3.min.js"></script>
	
	<!--[if IE]><script type="text/javascript" src="<?php echo base_url();?>public/theme/scripts/plugins/other/excanvas/excanvas.js"></script><![endif]-->
	<!--[if lt IE 8]><script type="text/javascript" src="<?php echo base_url();?>public/theme/scripts/plugins/other/json2.js"></script><![endif]-->
</head>
<body>
	<!-- Start Content -->
	<div class="container-fluid">
		<div class="navbar main hidden-print">				
			<a href="index.html?lang=en" class="appbrand"><span><?php echo $sys_name;?><span><?php echo $quote;?></span></span></a>
			<button type="button" class="btn btn-navbar">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
						
			<ul class="topnav pull-right">
				<li class="account">
					<?php echo anchor('user_access/logout', '<span class="hidden-phone text">Welcome '.$this->access->get_username().'</span><i></i>',array('class' => 'glyphicons logout power'));?>
				</li>
			</ul>
						
		</div>
	