<?php
session_start();
$itlog=$_SESSION['weblogin'];
$command=$_GET['command'];
require "include/include.php";
if ($command=="PLACEOUT")
$q=mysql_query("select distinct subbmcode as result from bmcode order by subbmcode asc;");
else
$q=mysql_query("select distinct cpyaccount as result from cpyaccount where managerid='$itlog' order by cpyaccount asc;");
//$q=mysql_query("select subbmcode from bmcode where bmcode='$code' order by subbmcode asc;");
/*echo "select subbmcode from bmcode where bmcode='$code' order by subbmcode asc;";
break;*/
echo mysql_error();
$myarray=array();
$str="";
$count=mysql_num_rows($q);
while($nt=mysql_fetch_array($q)){	
$str=$str . "\"$nt[result]\"".",";
}
$str=substr($str,0,(strLen($str)-1)); // Removing the last char , from the string
if ($count<>0) {
$str = "\"--Click--\"," . $str;
}
echo "new Array($str)";
?>