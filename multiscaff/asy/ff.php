<?php
$code=$_GET['code'];
require "include/include.php";
$q=mysql_query("select subbmcode from bmcode where bmcode='$code' order by subbmcode asc;");
/*echo "select subbmcode from bmcode where bmcode='$code' order by subbmcode asc;";
break;*/
echo mysql_error();
$myarray=array();
$str="";
$count=mysql_num_rows($q);
while($nt=mysql_fetch_array($q)){
$str=$str . "\"$nt[subbmcode]\"".",";
}
$str=substr($str,0,(strLen($str)-1)); // Removing the last char , from the string
if ($count<>0) {
$str = "\"--Click--\"," . $str;
}
echo "new Array($str)";
?>