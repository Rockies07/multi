<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<base href="<?PHP echo base_url(); ?>">
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/fonts/ptsans/stylesheet.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/fonts/icomoon/style.css" media="screen">

<link rel="stylesheet" type="text/css" href="assets/css/login.css" media="screen">

<link rel="stylesheet" type="text/css" href="assets/css/mws-theme.css" media="screen">

<title>Login Page</title>

</head>

<body>

    <div id="mws-login-wrapper">
	
        <div id="mws-login">
		<div id="mws-logo-container">
        
        	<!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->

        </div>
            <h1>Login </h1>
			<div style='color:red'><?PHP echo validation_errors(); ?></div>
            <div class="mws-login-lock"><i class="icon-lock"></i></div>
            <div id="mws-login-form">
			<?PHP
			$attributes = array('class' => 'mws-form');
			echo form_open('c_verifylogin', $attributes); 
			?>
                    <div class="mws-form-row">
                        <div class="mws-form-item">
                            <input type="text" name="username" class="mws-login-username required" placeholder="username">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <div class="mws-form-item">
                            <input type="password" name="password" class="mws-login-password required" placeholder="password">
                        </div>
                    </div>
                    
                    <div class="mws-form-row">
                        <input type="submit" value="Login" class="btn mws-login-button" style="height:40px; font-size:20px; font-weight:bold; width:100px; float:right;">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Plugins -->
    <script src="assets/js/libs/jquery-1.8.3.min.js"></script>
    <script src="assets/js/libs/jquery.placeholder.min.js"></script>
    <script src="assets/custom-plugins/fileinput.js"></script>
    
    <!-- jQuery-UI Dependent Scripts -->
    <script src="assets/jui/js/jquery-ui-effects.min.js"></script>

    <!-- Plugin Scripts -->
    <script src="assets/plugins/validate/jquery.validate-min.js"></script>

    <!-- Login Script -->
    <script src="assets/js/core/login.js"></script>

</body>
</html>
