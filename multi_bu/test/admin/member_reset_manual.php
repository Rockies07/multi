<?php
session_start();
set_time_limit(0);
include "include/include.php";
//-=-=-=-=

if ($_POST["Reset"]=='Reset') {

mysql_query("truncate table member_total;") or die(mysql_error());
$memberidsql = "select a.memberid from memberid a ORDER BY a.memberid asc";
$result = mysql_query($memberidsql); 
while ($row_memlist = mysql_fetch_array($result)) 
{
	$sqloutstanding ="call outstanding('$row_memlist[0]',@outamount);";
	$doquery = mysql_query($sqloutstanding);
	$sqlpegrp ="select @outamount";
	$doquery = mysql_query($sqlpegrp);
	$r=mysql_fetch_assoc($doquery);
	$outstanding = $r['@outamount'];
	
	$sqldue ="call pmdue('$row_memlist[0]',@outpmdue);";
	$doquery = mysql_query($sqldue);
	$sqlpegrp ="select @outpmdue";
	$doquery = mysql_query($sqlpegrp);
	$r=mysql_fetch_assoc($doquery);
	$pmdue = $r['@outpmdue'];
	
	$totel = $outstanding + $pmdue;
	$super_total = $super_total + $totel;
	$super_outstanding = $super_outstanding + $outstanding;
	$super_due = $super_due + $pmdue;
	
//-=-=- insertion to new table
mysql_query("INSERT INTO member_total (memberid, total, outstanding, amountdue) VALUES('$row_memlist[0]', '$totel', '$outstanding', '$pmdue')") or die(mysql_error());
	}
	echo "done";
} // reset records
?>
<html>
<head><title>Clear Record</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<div align="center">
<span class='maintitle'>Reset Member Records </span>
<form action='<?php echo $PHP_SELF;?>' method='POST'>
<input type='submit' value='Reset' name='Reset' onClick="return confirm('You Are About To Reset Records!');">
</form>
</div>
</table>
</body>
</html>