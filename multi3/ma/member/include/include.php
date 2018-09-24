<?php
	date_default_timezone_set('Asia/Singapore');
	
	$dbserver	=	"moneylender.cfnetl3snysz.us-east-1.rds.amazonaws.com";
	$dbaccount	=	"ml_admin";
	$dbpassword	=	"domybest.300811";
	$dbdatabase	=	"billbase_ms";

	mysql_connect("$dbserver","$dbaccount","$dbpassword")or die("Cannot Connect");
	mysql_select_db("$dbdatabase")or die("Cannot Select Data!")
	
//	include "browser.php";
?>
