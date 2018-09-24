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
	
	<!-- JQueryUI v1.9.2 -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/scripts/plugins/system/jquery-ui-1.9.2.custom/css/smoothness/jquery-ui-1.9.2.custom.min.css" />
	
	<!-- Glyphicons -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/glyphicons.css" />
	
	<!-- Uniform -->
	<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/forms/pixelmatrix-uniform/css/uniform.default.css" />

	<!-- JQuery v1.8.2 -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/system/jquery-1.8.2.min.js"></script>
	
	<!-- Theme -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/style.css" />
	
	<style>
		body{
			background:#f5f5f5;
		}
		
		.validation_wrapper p{
			width:280px;
		}
	</style>
</head>
<body>
	
	<!-- Start Content -->
	<div class="container-fluid login">
		<div id="login">
			<?php echo form_open($action, $attribute)?>
				<div class="widget widget-4">
					<div class="widget-head">
						<h4 class="heading">Restricted area</h4>
					</div>
				</div>
				<h2 class="glyphicons unlock form-signin-heading"><i></i> Please sign in</h2>
				<?php 
					if(validation_errors())
					{
				?>						
						<div class="validation_wrapper">
							<?php echo validation_errors(); ?>
						</div>
				<?php 
					}
				?>
				<div class="uniformjs">
					<input type="text" id="username" name="username" class="input-block-level" placeholder="Username"/>
					<input type="password" id="password" name="password" class="input-block-level" placeholder="eg. X8df!90EO" /> 
					<label class="checkbox"><input type="checkbox" value="remember-me">Remember me</label>
				</div>
				<button class="btn btn-large btn-primary" type="submit">Sign in</button>
			</form>
		</div>				
	</div>
	
	<!-- Common Demo Script -->
	<script src="<?php echo base_url();?>public/theme/scripts/demo/common.js"></script>
	
	<!-- Uniform -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/forms/pixelmatrix-uniform/jquery.uniform.min.js"></script>
	
	<!-- Bootstrap Script -->
	<script src="<?php echo base_url();?>public/bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Bootstrap Extended -->
	<script src="<?php echo base_url();?>public/bootstrap/extend/bootstrap-select/bootstrap-select.js"></script>
	<script src="<?php echo base_url();?>public/bootstrap/extend/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	
</body>
</html>