<?php
	date_default_timezone_set('Asia/Singapore');
	
	$dbserver	=	"localhost";
	$dbaccount	=	"musicave_andro";
	$dbpassword	=	"sam102699";
	$dbdatabase	=	"musicave_billbase";

	mysql_connect("$dbserver","$dbaccount","$dbpassword")or die("Cannot Connect");
	mysql_select_db("$dbdatabase")or die("Cannot Select Data!")
?>