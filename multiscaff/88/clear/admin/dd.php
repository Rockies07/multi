<?php
//$managerid=$_GET['managerid'];
require "include/include.php";

// get from memberid
	$memberlist=mysql_query("SELECT memberid FROM memberid");
	while ($row_memberlist = mysql_fetch_array($memberlist)) 
	{
		if ($memlist=="") {
			$memlist = "'" . $row_memberlist[0] . "'";
		}
		else
		{
			$memlist = $memlist . "," . "'" . $row_memberlist[0] . "'";
		}
		
			// get from submembers
		$memberlist2=mysql_query("SELECT subid FROM submembers where memberid = '$row_memberlist[0]'");
		while ($row_memberlist2 = mysql_fetch_array($memberlist2)) 
		{
			$memlist = $memlist . "," . "'" . $row_memberlist2[0] . "'";
		}
	}



//$q=mysql_query("SELECT memberid FROM memberid where managerid = '$managerid';");
//$q=mysql_query("SELECT memberid FROM memberid;");
//$memberlist=mysql_query("SELECT memberid FROM memberid where managerid = '$managerid'");
//echo mysql_error();
$myarray=array();
$str="";
$str=$memlist;
/*$count=mysql_num_rows($q);
while($nt=mysql_fetch_array($q)){
$str=$str . "\"$nt[memberid]\"".",";
}
$str=substr($str,0,(strLen($str)-1)); // Removing the last char , from the string*/
echo "new Array($str)";
?>