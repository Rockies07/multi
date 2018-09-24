<?php
	session_start();
	
	include "include/include.php";
if ($_POST[submit]) {
	$weblogin	=	strtoupper($_POST[weblogin]);
	$webpassword=	$_POST[webpassword];
//	echo $weblogin;
//	echo $webpassword;
	
	////$webpassword=	md5($_POST[webpassword]);
	
	$webaccess	=	md5($_POST[webaccess]);
	$webdatetime=	date("Y-m-d H:i:s");
	$webip		=	$_SERVER['REMOTE_ADDR'];
	
	$logindata=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	//echo "SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'";
	$loginrow=mysql_num_rows($logindata);
	
	if(($loginrow)&&($webaccess==$_SESSION['image_random_value']))
		{
		$_SESSION["weblogin"]="$weblogin";
		$_SESSION["webpassword"]="$webpassword";
		//mysql_query("UPDATE managerid SET datetime='$webdatetime', ipaddress='$webip' WHERE managerid='$weblogin'");
		header("location:main.php");
		}
	else
		{session_destroy();}
		}
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Shop899.net</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<link rel="stylesheet" href="css/login.css">
		<!--[if IE 6]>
			<link rel="stylesheet" href="css/ie6.css" type="text/css" />
		<![endif]-->
		<!--[if IE 7]>
			<link rel="stylesheet" href="css/ie7.css" type="text/css" />
		<![endif]-->
	</head>
	<style>
		#login_container{
			position: fixed;
			top: 40px;
		  	width: 100%;
		  	height: 100%;
		  	z-index: 999;
		}

		#login-form
		{
			position: absolute;
		    top:2%;
		    right: 5px;
		    margin: 0 auto;
		  	z-index: 1000;
		  	opacity: 1;
		}
	</style>

	<body>
		<div id="login_container">
			<div id="login-form">

			    <h3>Login</h3>

			    <fieldset>
					<form action="<?php echo $PHP_SELF;?>" method="post" target="_top">
					   <input type="text" name="weblogin" placeholder="Username"> <!-- JS because of IE support; better: placeholder="Email" -->

				        <input type="password" name="webpassword" placeholder="Password"> <!-- JS because of IE support; better: placeholder="Password" -->

				        <input type="access" name="webaccess" placeholder="Access" size="6" maxlength="5" style="width:50%;"><img src="random.php" border="0" align="absbottom"> <!-- JS because of IE support; better: placeholder="Access" -->

				        <input type="submit" name="submit" value="Login">
					</form>
				</fieldset>
			</div>
		</div>
		<div class="header">
			<div id="navigation">
				<ul>
					<li class="selected"><a href="index.php">Home</a></li>
					<li><a href="http://www.asos.com/search/new-arrival?q=new+arrival">New Arrival</a></li>
					<li><a href="http://www.asos.com/search/woman-apparel?q=woman+apparel">Apparel</a></li>
					<li><a href="http://www.asos.com/search/beauty-care?q=beauty+care">Beauty Care</a></li>
					<li><a href="http://www.clarks.sg/">Shoes</a></li>
					<li><a href="http://jemsa.com.sg/what-s-new/?gclid=CJajl5ap88YCFRMDvAodpjkKKg">Accessories</a></li>
				</ul>
			</div>
		</div> 
		<div class="body">
			<div class="featured">
				<a href="blog.html"><img src="images/advertisement.jpg" alt=""/></a>
				<div class="gallery">
					<a href="new_arrival.html"><img src="images/aurora.jpg" alt=""/></a>
					<ul class="first">
						<li><a href="new_arrival.html"><img src="images/summer-collection.jpg" alt=""/></a></li>
						<li><a href="new_arrival.html"><img src="images/beach-bride.jpg" alt="" width="390px"/></a></li>
						<li><a href="new_arrival.html"><img src="images/motherhood-apparel.jpg" alt=""/></a></li>
					</ul>
					<ul>
						<li><a href="new_arrival.html"><img src="images/fashionable.jpg" alt=""/></a></li>
						<li><a href="new_arrival.html"><img src="images/accessories.jpg" alt=""/></a></li>
						<li><a href="new_arrival.html"><img src="images/skin-perfect.jpg" alt=""/></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer">
			&nbsp;
		</div>
	</body>
</html>