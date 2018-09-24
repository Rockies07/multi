<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	////$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
//	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$weblogin=strtoupper($weblogin);
	
	$managerid=$_GET[managerid];
	$account=$_GET[account];
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/easydrag.js"></script>
<script type="text/javascript">$(function(){$("#FloaintBox").easydrag();
$("#FloaintBox").ondrop(function(e, element){ });});</script> 
<style type="text/css">#FloaintBox{ border:1px solid red; background-color:#eef4d3;}#FloaintBox{width:150px; padding:10px;}</style> 
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<div id="FloaintBox"> 
<b>Hidden Funds</b><BR>
<?php
$clearreport=mysql_query("Select cpyaccount,sum(hiddenfunds) from cpyaccount group by cpyaccount");
	while ($row_report = mysql_fetch_array($clearreport)) 
	{
		echo $row_report[0] . "&nbsp;&nbsp;&nbsp;";
		if ($row_report[1]<0)
		echo "<span class='bn13text'><font color='red'>" . $row_report[1] . "</font></span><br>";
		else
		echo "<span class='bn13text'><font color='blue'>" . $row_report[1] . "</font></span><br>";
	}
?>				
</div> 
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">Account Details<br>
  </span></td>
	</tr>
   </table>
<table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
<tr>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Ref</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Date</b>&nbsp;</span></td>
  <td class="hed" ><span class="bn13text">&nbsp;<b>Entries By</b>&nbsp;</span></td>
 <td class="hed" ><span class="bn13text">&nbsp;<b>Account</b>&nbsp;</span></td>
 <td class="hed" ><span class="bn13text">&nbsp;<b>Member ID</b>&nbsp;</span></td>
 <td class="hed" ><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
</tr>
    <?php
//	$bmsql=mysql_query("SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where entriesby = '$managerid' and cpyaccount='$account' order by entriesby, cpyaccount asc");
	//$bmsql=mysql_query("SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where cpyaccount='$account' order by entriesby, cpyaccount asc");
	$bmsql=mysql_query("SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where cpyaccount='$account' order by ref desc");
//	echo "SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where cpyaccount='$account' order by ref desc";
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$ref=mysql_result($bmsql,$count,"ref");
	echo "<td align='center'><span class='bn13text'>$ref</span></td>";
	$bmdate=mysql_result($bmsql,$count,"bmdate");
	$bbb=strtotime(str_replace("-", "/",$bmdate));
	$bmdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	$entriesby=mysql_result($bmsql,$count,"entriesby");
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	$memberid=mysql_result($bmsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	$amount=mysql_result($bmsql,$count,"amount");
	//echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	if ($amount<0)
	echo "<td align='center'><span class='bn13text'><font color='red'>$amount</font></span></td>";
	else
	echo "<td align='center'><span class='bn13text'><font color='blue'>$amount</font></span></td>";
	$superamount=$superamount+$amount;
	echo "</form></td></tr>";}
	?>
	 <?php
	//$bmsql=mysql_query("SELECT ref,bmdate,entriesby,cpyaccount,amount FROM bmexpenses where entriesby = '$managerid' and cpyaccount='$account' order by entriesby, cpyaccount asc");
	$bmsql=mysql_query("SELECT ref,bmdate,entriesby,cpyaccount,amount FROM bmexpenses where cpyaccount='$account' order by bmdate desc");
//	echo "SELECT ref,bmdate,entriesby,cpyaccount,memberid,amount FROM bmdatabase_payment where entriesby = '$managerid' and cpyaccount='$account' order by entriesby, cpyaccount asc";
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$ref=mysql_result($bmsql,$count,"ref");
	echo "<td align='center'><span class='bn13text'>$ref</span></td>";
	//	$bmdate=mysql_result($bmsql,$count,"bmdate");
	$bmdate=mysql_result($bmsql,$count,"bmdate");
	$bbb=strtotime(str_replace("-", "/",$bmdate));
	$bmdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	$entriesby=mysql_result($bmsql,$count,"entriesby");
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	$amount=mysql_result($bmsql,$count,"amount");
	if ($amount<0)
	echo "<td align='center'><span class='bn13text'><font color='red'>$amount</font></span></td>";
	else
	echo "<td align='center'><span class='bn13text'><font color='blue'>$amount</font></span></td>";
	$superamount=$superamount+$amount;
	echo "</td></tr>";}
	?>
	<tr>
    <td align="center"  colspan="5" class="hed"><span class="bn13text">&nbsp;<b>Page Total:</b>&nbsp;</span></td>
     <td align="center"  class="hed"><span class="bn13text">&nbsp;<b><?php 
	  
	  $hiddenaccount=mysql_fetch_array(mysql_query("Select hiddenfunds from cpyaccount where cpyaccount='$account'"));
	  $finalamount = number_format(($superamount+$hiddenaccount[0]),2);
//	while ($row_report = $clearreport)) 
//	{
	 if ($superamount<0)
	echo "<span class='bn13text'><font color='red'><b>$finalamount</b></font></span>";
	else
	echo "<span class='bn13text'><font color='blue'><b>$finalamount</b></font></span>";
	 
	 ?></b>&nbsp;</span></td>
</tr>
</table>
</body>
</html>