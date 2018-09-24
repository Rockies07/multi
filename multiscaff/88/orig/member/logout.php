<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	
	//-=-=-= logout timeout
	$webdatetime=	date("Y-m-d H:i:s");
	mysql_query("update member_log set logoutdate='$webdatetime' where memberid='$weblogin'");
	//-=-=-= logout timeout
	
	if(!$rights){header("location:index.php");}
	session_destroy();
	header("location:index.php");
?>