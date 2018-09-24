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
	
	$logindata=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
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
<html>
<head><title>Master Accounting</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--
body {
	background-image: url(car2.jpg);
	background-repeat: no-repeat;
	position:absolute;
	background-size: 100%;

}
-->
</style>
</head>
<!--<script language="javascript" src="js/browser.js"></script>-->
<body bgcolor="#000000">
<form action="<?php echo $PHP_SELF;?>" method="post" target="_top">
<table width="250px"  border="0" cellpadding="4" cellspacing="1" bgcolor="#333333" >
      <tr>
        <td><span class="bn13textwhite">Login ID</span></td>
        <td><input type="text" name="weblogin" size="15" maxlength="15" class="form_input"></td>
      </tr>
      <tr>
        <td><span class="bn13textwhite">Password</span></td>
        <td><input type="password" name="webpassword" size="15" maxlength="15" class="form_input"></td>
      </tr>
      <tr>
        <td><span class="bn13textwhite">Access</span></td>
        <td><input type="text" name="webaccess" size="6" maxlength="5" class="form_input">
            <img src="random.php" border="0" align="absbottom"></td>
      </tr>
      <tr>
        <td colspan="3" align="center"><!--<input type="reset" value="Clear">-->
          &nbsp;&nbsp;
          <input type="submit" name="submit" value="Enter"></td>
      </tr>
  </table>
</form>
</body></html>