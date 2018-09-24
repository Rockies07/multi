<?php
	session_start();
	
	include "include/include.php";
	
	$weblogin	=	$_POST[weblogin];
	$webpassword=	md5($_POST[webpassword]);
	$webaccess	=	md5($_POST[webaccess]);
	$webdatetime=	date("Y-m-d H:i:s");
	$webip		=	$_SERVER['REMOTE_ADDR'];
	
	$logindata=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$loginrow=mysql_num_rows($logindata);
	
	if(($loginrow)&&($webaccess==$_SESSION['image_random_value']))
		{$_SESSION["weblogin"]="$weblogin";
		$_SESSION["webpassword"]="$webpassword";
		mysql_query("UPDATE adminid SET datetime='$webdatetime', ipaddress='$webip' WHERE adminid='$weblogin'");
		header("location:main.php");}
	else
		{session_destroy();}
?>
<html>
<head><title>Master Accounting</title>
<link rel="stylesheet" href="style.css" type="text/css"></head>
<body bg bgcolor="#FFFFFF">
<form action="index.php" method="post" target="_top">
<table align="center" border="0">
	<tr><td colspan="3" height="120"></td></tr>
	<tr><td><span class="bn13text">Login ID</span></td><td width="15"></td><td><input type="text" name="weblogin" size="15" maxlength="15"></td></tr>
    <tr><td><span class="bn13text">Password</span></td><td width="15"></td><td><input type="password" name="webpassword" size="15" maxlength="15"></td></tr>
    <tr><td><span class="bn13text">Access</span></td><td width="15"></td><td><input type="text" name="webaccess" size="6" maxlength="5"><img src="random.php" border="0" align="absbottom"></td></tr>
    <tr><td colspan="3" align="center"><input type="reset" value="Clear">&nbsp;&nbsp;<input type="submit" value="Enter"></td></tr>
    <?php
    if(($weblogin!=NULL)||($webaccess!="d41d8cd98f00b204e9800998ecf8427e")||($webpassword!="d41d8cd98f00b204e9800998ecf8427e"))
		{echo"<tr><td colspan='3' align='center'><span class='rn12text'>Check User ID or Password!</span></td></tr>";}?>
</table></form>
</body></html>