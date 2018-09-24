<?php
	date_default_timezone_set('Asia/Singapore');
	
	$dbserver	=	"multiscaff.ckqucrytaanr.ap-southeast-1.rds.amazonaws.com";
	$dbaccount	=	"multiscaff";
	$dbpassword	=	"damn5hit";
	//$dbdatabase	=	"billbase2";
	//$dbdatabase	=	"billbase2b";
	$dbdatabase	=	"billbase_multi4";

	mysql_connect("$dbserver","$dbaccount","$dbpassword")or die("Cannot Connect");
	mysql_select_db("$dbdatabase")or die("Cannot Select Data!")
	
//	include "browser.php";
?>
