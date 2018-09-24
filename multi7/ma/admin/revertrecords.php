<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php
$action=$_GET[action];
if($action==NULL){$action=$_POST[action];}
$ref=$_GET[ref];
$pass=$_GET[pass];
$memaydi=$_GET[memaydi];
$amawnt=$_GET[amawnt];
$fiem=$_GET[fiem];
/*if ($action=='Status')
{
mysql_query("update bmcode set `show`='$show' where no = '$row'") or die(mysql_error());
echo "<SCRIPT language=\"JavaScript\">alert('Info Updated!');</SCRIPT>";

}*/

		switch($action){
		case "Delete":
			mysql_query("DELETE FROM cleared_history WHERE ref = '$ref'");
			echo "<SCRIPT language=\"JavaScript\">alert('Record Deleted!');</SCRIPT>";
		break;
		case "Return":
			if ($pass=='P') {
			mysql_query("insert into bmdatabase_payment select ref,bmdate,memberid,account_code,`type`,currency_code,amount,entriesby,entriesdate,remark,pm,clr,transref from cleared_history where ref = '$ref'");

		//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		if ($fiem==0)
		$updatetotal = "update member_total set total=total+'$amawnt', outstanding=outstanding+'$amawnt' where memberid='$maimmem'";
		else
		$updatetotal = "update member_total set total=total+'$amawnt', amountdue=amountdue+'$amawnt' where memberid='$maimmem'";
		mysql_query($updatetotal);

			}
			else {
			mysql_query("insert into bmdatabase_wlplaceout select ref,bmdate,memberid,account_code,`type`,currency_code,amount,entriesby,entriesdate,remark,pm,clr from cleared_history where ref = '$ref'");
		//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		if ($fiem==0)
		$updatetotal = "update member_total set total=total+'$amawnt', outstanding=outstanding+'$amawnt' where memberid='$maimmem'";
		else
		$updatetotal = "update member_total set total=total+'$amawnt', amountdue=amountdue+'$amawnt' where memberid='$maimmem'";
		mysql_query($updatetotal);
			}
			mysql_query("DELETE FROM cleared_history WHERE ref = '$ref'");
			echo "<SCRIPT language=\"JavaScript\">alert('Record Reverted!');</SCRIPT>";
		break;
}
?>
<html>
<head><title>Revert Records</title><link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<br>
<div align="center"><span class='maintitle'>Revert Records</span></div><br>
  <table border="1" cellpadding="0" cellspacing="0" width="95%" align="center" class="stats">

<tr >
    <td class="hed"><span class="bn13text"><b>ref</b></span></td>
    <td class="hed" ><span class="bn13text"><b>BM Date</b></span></td>
    <td class="hed" ><span class="bn13text"><b>Memberid</b></span></td>
    <td class="hed" ><span class="bn13text"><b>Account/Code</b></span></td>
	<td class="hed" ><span class="bn13text"><b>Type</b></span></td>
     <td class="hed"><span class="bn13text"><b>Currency</b></span></td>
    <td class="hed" ><span class="bn13text"><b>Amount</b></span></td>
     <td class="hed"><span class="bn13text"><b>Entriesby</b></span></td>
    <!--<td class="hed" ><span class="bn13text"><b>Entries Date</b></span></td>-->
     <td class="hed"  width="20%"><span class="bn13text"><b>Remark</b></span></td>
    <td class="hed"><span class="bn13text"><b>D</b></span></td>
	<td class="hed"><span class="bn13text"><b>H</b></span></td>
	<td class="hed"><span class="bn13text"><b>Deleted By</b></span></td>
	<td class="hed"><span class="bn13text"><b>Date Deleted</b></span></td>
	<td class="hed"><span class="bn13text"><b>Action</b></span></td>
</tr>
    <?php
	$history=mysql_query("SELECT * FROM cleared_history");
	$histrow=mysql_num_rows($history);
	echo $histrow;
	for($count=0; $count<$histrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$serial++;
	$ref=mysql_result($history,$count,"ref");
	echo "<td align='center'><span class='bn13text'>$ref</span></td>";
	$bmdate=mysql_result($history,$count,"bmdate");
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	$memberid=mysql_result($history,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	$account_code=mysql_result($history,$count,"account_code");
	echo "<td align='center'><span class='bn13text'>$account_code</span></td>";
	$type=mysql_result($history,$count,"type");
	echo "<td align='center'><span class='bn13text'>$type</span></td>";
	$currency_code=mysql_result($history,$count,"currency_code");
	echo "<td align='center'><span class='bn13text'>$currency_code</span></td>";
	$amount=mysql_result($history,$count,"amount");
	echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	$entriesby=mysql_result($history,$count,"entriesby");
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
/*	$entriesdate=mysql_result($history,$count,"entriesdate");
	echo "<td align='center'><span class='bn13text'>$entriesdate</span></td>";*/
	$remark=mysql_result($history,$count,"remark");
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	
	$pm=mysql_result($history,$count,"pm");
	if ($pm==1)
		echo "<td align='center'><img src='images/check1.jpg'/></td>";
	else
		echo "<td align='center'><img src='images/check2.jpg'/></td>";
	
	//echo "<td align='center'><span class='bn13text'>$pm</span></td>";
	$clr=mysql_result($history,$count,"clr");
		if ($clr==1)
		echo "<td align='center'><img src='images/check1.jpg'/></td>";
	else
		echo "<td align='center'><img src='images/check2.jpg'/></td>";
//	echo "<td align='center'><span class='bn13text'>$clr</span></td>";
	
	$delete_by=mysql_result($history,$count,"delete_by");
	echo "<td align='center'><span class='bn13text'>$delete_by</span></td>";
	$delete_date=mysql_result($history,$count,"delete_date");
	echo "<td align='center'><span class='bn13text'>$delete_date</span></td>";
	
	if ($type=="TKT")
		$pass = "W";
	else
		$pass = "P";
	
	echo "</form></td><td align='center'>";
	echo "<form action='revertrecords.php?action=Delete&ref=$ref&pass=$pass' method='post' style='margin-bottom:0;'>";
	echo "<a href='revertrecords.php?action=Return&ref=$ref&pass=$pass&memaydi=$memberid&amawnt=$amount&fiem=$pm' target='_self'><img border='0' src='images/undo.gif' align='left' onclick=\"return confirm('Revert Records?');\"></a>
	<input type='image' src='images/trash.gif' border='0' onclick=\"return confirm('Delete Records Permanently?');\"></form></td>";
	echo "</tr>";}
	?>
</body>
</html>