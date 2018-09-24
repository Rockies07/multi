<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	////$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
//	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$weblogin=strtoupper($weblogin);
	
	$memberid=$_GET[memberid];
	$managerid=$_GET[managerid];
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">Member Details<br>
  </span></td>
	</tr>
   </table>
<table border="1" cellpadding="0" cellspacing="0" width="50%" align="center">
<tr >
    <!--<td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Ref</b>&nbsp;</span></td>-->
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Date</b>&nbsp;</span></td>
  <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Entries By</b>&nbsp;</span></td>
<td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Type</b>&nbsp;</span></td>
<td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Subbmcode/Cpyaccount</b>&nbsp;</span></td>
 <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Member ID</b>&nbsp;</span></td>
 <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
</tr>
    <?php
	//$bmsql=mysql_query("SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where entriesby = '$managerid' and cpyaccount='$account' order by entriesby, cpyaccount asc");
	//$bmsql=mysql_query("SELECT ref,bmdate,entriesby,memberid,amount FROM bmdatabase_payment where memberid = '$memberid' union SELECT ref,bmdate,entriesby,memberid,amount FROM bmdatabase_payment where memberid = '$memberid' order by entriesby asc");
	$bmsql=mysql_query("SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount FROM bmdatabase_payment where memberid = '$memberid'");
//	echo "SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where entriesby = '$managerid' and cpyaccount='$account' order by entriesby, cpyaccount asc";
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	//$ref=mysql_result($bmsql,$count,"ref");
	//echo "<td align='center'><span class='bn13text'>$ref</span></td>";
	$bmdate=mysql_result($bmsql,$count,"bmdate");
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	$entriesby=strtoupper(mysql_result($bmsql,$count,"entriesby"));
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
	$type=mysql_result($bmsql,$count,"type");
	echo "<td align='center'><span class='bn13text'>$type</span></td>";
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	$memberid=mysql_result($bmsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	$amount=mysql_result($bmsql,$count,"amount");
	echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	$superamount=$superamount+$amount;
	echo "</form></td></tr>";}
	?>
	 <?php
	//$bmsql=mysql_query("SELECT ref,bmdate,entriesby,cpyaccount,amount FROM bmexpenses where entriesby = '$managerid' and cpyaccount='$account' order by entriesby, cpyaccount asc");
	 $bmsql=mysql_query("SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode FROM bmdatabase_wlplaceout where memberid = '$memberid' order by entriesby asc");
//	echo "SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where entriesby = '$managerid' and cpyaccount='$account' order by entriesby, cpyaccount asc";
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
/*	$ref=mysql_result($bmsql,$count,"ref");
	echo "<td align='center'><span class='bn13text'>$ref</span></td>";*/
	$bmdate=mysql_result($bmsql,$count,"bmdate");
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	$entriesby=strtoupper(mysql_result($bmsql,$count,"entriesby"));
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
	$type=mysql_result($bmsql,$count,"type");
	echo "<td align='center'><span class='bn13text'>$type</span></td>";
	$subbmcode=mysql_result($bmsql,$count,"subbmcode");
	echo "<td align='center'><span class='bn13text'>$subbmcode</span></td>";
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	$amount=mysql_result($bmsql,$count,"amount");
	echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	$superamount=$superamount+$amount;
	echo "</form></td></tr>";}
	?>
	<tr >
    <td align="center" style="border:solid 1px #000000" colspan="5"><span class="bn13text">&nbsp;<b>Page Total:</b>&nbsp;</span></td>
     <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo number_format($superamount,2); ?></b>&nbsp;</span></td>
</tr>
</body>
</html>