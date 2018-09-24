<?php
	date_default_timezone_set('Asia/Singapore');
	
	$dbserver	=	"localhost";
	$dbaccount	=	"4d";
	$dbpassword	=	"goodluck199";
	//$dbdatabase	=	"billbase2";
	//$dbdatabase	=	"billbase2b";
	$dbdatabase	=	"billbase_q1_oct2012";

	mysql_connect("$dbserver","$dbaccount","$dbpassword")or die("Cannot Connect");
	mysql_select_db("$dbdatabase")or die("Cannot Select Data!")
	
//	include "browser.php";
?>
