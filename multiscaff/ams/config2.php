<?php
/*	$servername	=	"localhost";
	$dbusername	=	"root";
	$dbpassword	=	"";
	$dbname	=	"billbase";*/

	$dbserver	=	"localhost";
	$dbaccount	=	"4d";
	$dbpassword	=	"goodluck199";
	$dbdatabase	=	"billbase";
////////////////////////////////////////
////// DONOT EDIT BELOW  /////////
///////////////////////////////////////

connecttodb($servername,$dbname,$dbusername,$dbpassword);
function connecttodb($servername,$dbname,$dbuser,$dbpassword)
{
global $link;
$link=mysql_connect ("$servername","$dbuser","$dbpassword");
if(!$link){die("Could not connect to MySQL");}
mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
}

?>