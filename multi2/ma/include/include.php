<?php
	date_default_timezone_set('Asia/Singapore');
	
	$dbserver	=	"multiscaff.ckqucrytaanr.ap-southeast-1.rds.amazonaws.com";
	$dbaccount	=	"multiscaff";
	$dbpassword	=	"damn5hit";
	//$dbdatabase	=	"billbase2";
	//$dbdatabase	=	"billbase2b";
	$dbdatabase	=	"billbase_multi2";

	mysql_connect("$dbserver","$dbaccount","$dbpassword")or die("Cannot Connect");
	mysql_select_db("$dbdatabase")or die("Cannot Select Data!");
	
	$mainty=mysql_query("SELECT maintenance FROM adminid");
	$main_mode=mysql_result($mainty,0,"maintenance");
	if ($main_mode=='1') {
	session_destroy();
	header( 'Location: pageblock.php' );
	}
	
//	include "browser.php";
?>
