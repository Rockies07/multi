<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

//$webdate=date("Y-m-d");
$webdate=date("Y-m-d H:i:s");
$month1 = $_POST["M1"];
$month2 = $_POST["M2"];
$year1 = $_POST["Y1"];
$year2 = $_POST["Y2"];

$enum_from = $year1 . $month1 . "01";
$enum_to = $year2 . $month2 . "31";

if ($_POST["Clear"]=='Clear') {
	
	//updating of accounts hidden funds
	$cpyaccountsql=mysql_query("Select distinct cpyaccount from cpyaccount order by cpyaccount");
	while ($row_cpyaccount = mysql_fetch_array($cpyaccountsql)) 
	{
		//$amountpaysql=mysql_query("select sum(amount) from bmdatabase_payment where cpyaccount='" . $row_cpyaccount[0] . "' and clr='1'");
		$amountpaysql=mysql_query("select sum(amount) from bmdatabase_payment where cpyaccount='" . $row_cpyaccount[0] . "' and clr='1' and bmdate>='$enum_from' and bmdate<='$enum_to'");
		while ($row_amountpay = mysql_fetch_array($amountpaysql)) 
		{
			
			//echo "account: " . $row_cpyaccount[0] . " Amount: " . $row_amountpay[0];
			mysql_query("update cpyaccount set hiddenfunds = (hiddenfunds+'".$row_amountpay[0]."') where cpyaccount='" . $row_cpyaccount[0] . "'");
		}
	}
	
	mysql_query("delete from bmdatabase_payment where clr='1' and bmdate>='$enum_from' and bmdate<='$enum_to'");
	
/*	$firsttime=mysql_num_rows(mysql_query("select count(*) from backup_plan"));
	if ($firsttime==0) {
		echo "firsttime=" . $firsttime . "<br>";
		mysql_query("insert into backup_plan select (select b.bmcode from bmcode b where b.subbmcode=a.subbmcode) as bmcode,a.subbmcode,
	a.bmdate,a.amount,a.memberid from bmdatabase_wlplaceout a where a.clr='1'");
		mysql_query("delete from bmdatabase_wlplaceout where clr='1'"); }
	else
	{*/
		/*echo "madami=" . "select (select b.bmcode from bmcode b where b.subbmcode=a.subbmcode) as bmcode,a.subbmcode,
a.bmdate,a.amount,a.memberid from bmdatabase_wlplaceout a where a.clr='1' and bmdate>='$enum_from' and bmdate<='$enum_to'" . "<br>";*/
		$listall = mysql_query("select (select b.bmcode from bmcode b where b.subbmcode=a.subbmcode) as bmcode,a.subbmcode,
a.bmdate,a.amount,a.memberid from bmdatabase_wlplaceout a where a.clr='1' and bmdate>='$enum_from' and bmdate<='$enum_to'");
		while ($row_mem = mysql_fetch_array($listall)) 
			{
				$bmcode	= $row_mem[0];
				$subbmcode = $row_mem[1];
				$bmdate	= $row_mem[2];
				$amount	= $row_mem[3];
				$memberid = $row_mem[4];
			$checkit = mysql_num_rows(mysql_query("select amount from backup_plan where bmcode='$bmcode' and subbmcode='$subbmcode' and bmdate='$bmdate' and memberid='$memberid'"));
//echo "select amount from backup_plan where bmcode='$bmcode' and subbmcode='$subbmcode' and bmdate='$bmdate' and memberid='$memberid'<br>";
			if ($checkit<>0) {
			//update
		mysql_query("update backup_plan set amount=amount+'$amount' where bmcode='$bmcode' and subbmcode='$subbmcode' and bmdate='$bmdate' and memberid='$memberid'");
		//echo "update backup_plan set amount=amount+'$amount' where bmcode='$bmcode' and subbmcode='$subbmcode' and bmdate='$bmdate' and memberid='$memberid'<br>";
		}
			else {
			//insert
		mysql_query("insert into backup_plan (bmcode,subbmcode,bmdate,amount,memberid) values ('$bmcode','$subbmcode','$bmdate','$amount','$memberid')");
		//echo "insert into backup_plan ('$bmcode','$subbmcode','$bmdate','$amount','$memberid')"<br>";
		}
			
			}
//	}
	
	mysql_query("delete from bmdatabase_wlplaceout where clr='1' and bmdate>='$enum_from' and bmdate<='$enum_to'");
	
	/*//clear data from bmdatabase_payment all hidden transactions
	mysql_query("delete from bmdatabase_payment where clr='1'");
	//clear data from bmdatabase_payment all hidden transactions
	mysql_query("delete from bmdatabase_wlplaceout where clr='1'");*/
	
	echo "<SCRIPT language=\"JavaScript\">alert('Successfully Cleared/Transferred Hidden Data');</SCRIPT>";
}
	?>
<html>
<head><title>Clear Record</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<div align="center">
<span class='maintitle'>Clear Hidden Records</span>
<form action='<?php echo $PHP_SELF;?>' method='POST'>

<span class="bn13textwhite">From:</span> <select size="1" name="M1">
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
<select size="1" name="Y1">
<option value="2012">2012</option>
<option value="2011">2011</option>
<option value="2010" selected="selected">2010</option>
<option value="2009">2009</option>
<option value="2008">2008</option>
</select>

<span class="bn13textwhite">To:</span>

<select size="1" name="M2">
<option value="01">January</option>
<option value="02">February</option>
<option value="03">March</option>
<option value="04">April</option>
<option value="05">May</option>
<option value="06">June</option>
<option value="07">July</option>
<option value="08">August</option>
<option value="09">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
<select size="1" name="Y2">
<option value="2012">2012</option>
<option value="2011">2011</option>
<option value="2010" selected="selected">2010</option>
<option value="2009">2009</option>
<option value="2008">2008</option>
</select>

<input type='submit' value='Clear' name='Clear' onClick="return confirm('You Are About To Clear Records!');">
</form>
</div>
</table>
</body>
</html>