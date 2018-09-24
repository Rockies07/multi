<?php
	include "include/include.php";
	
	$datetime = $_GET['value'];
	$get_year=date('Y',strtotime($datetime));
	
	$bmcodesql=mysql_query("select bmcode from bmcode where (year='both' or year is null) UNION select subbmcode as bmcode from bmdatabase_wlplaceout where year(bmdate)='$get_year' group by subbmcode having subbmcode in (select bmcode from bmcode) order by bmcode");

	$bmcodesqlrow=mysql_num_rows($bmcodesql);
	echo "<option value=''>--Click--</option>";
	for($count=0; $count<$bmcodesqlrow; $count++)
	{
		$bmcode=mysql_result($bmcodesql,$count,"bmcode");
		echo "<option value='$bmcode'>$bmcode</option>";
	}
?>