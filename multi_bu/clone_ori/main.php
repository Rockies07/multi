<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	//$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM clone_user WHERE username='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<html>
	<head><title>Manager Account</title></head>
    <frameset rows="34,*" framespacing="0" frameborder="no" border="0">
    	<frame src="header.php" scrolling="no" name="header" noresize>
        	<frameset cols="160,*" framespacing="0" frameborder="no" border="0">
            	<frame scrolling="auto" src="navigation.php" name="navigation" noresize>
                <frame src="intro.php" name="main" noresize>
			</frameset>
	</frameset><noframes></noframes>
 </html>