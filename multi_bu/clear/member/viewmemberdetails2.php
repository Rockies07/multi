<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$weblogin=strtoupper($weblogin);
	$i=0;
	$once=0;
	$newcol="";
	
	if ($_GET[memberid]<>"") {
	$_SESSION["memberid"]=$_GET[memberid];
	//$_SESSION["managerid"]=$_GET[managerid];
	}
	$memberid=$_SESSION["memberid"];
	//$managerid=$_SESSION["memberid"];
	$action=$_GET["action"];
	$hiddenf = $_POST["hiddenf"];
	$counts = $_POST["counts"];
	$reference = $_GET["ref"];
	$methody=$_GET["methody"];
	$even_once = "";
	
?>
<html>
<head><title>Main Announcement</title>

<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" media="screen" type="text/css" href="layout.css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0">
<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
	<tr>
	  <td align="center"><span class="maintitle"> <b><?php echo $memberid; ?></b> Details<br>
  </span></td>
	</tr>
  <td>
 </td>
</table>

<br>
 <?php

//-=-=-= reports
$bmreport=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
+ (select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
) as outstanding FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'");

$bmreport_pm=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')
+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid')
 and pm='1')+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_payment where memberid in 
 (select subid from submembers where memberid='$memberid') and pm='1')
) as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1'");

$outstanding=mysql_result($bmreport,0,"outstanding");
$pmdue=mysql_result($bmreport_pm,0,"pmdue");
$total = $outstanding + $pmdue;

$paydue = number_format($pmdue,2);
$outstanding = number_format($outstanding,2);
$total = number_format($total,2);
 
 
 // echo "<div align='center'><span class='bn13textwhite'>&nbsp;&nbsp;&nbsp;Total : $total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Outstanding : $outstanding&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amt Due : $paydue</span></div>";
  echo "<div align='center'><span class='bn13textwhite15'>";
  
  if ($total<0)
			echo "Total : <span class='bn13textred15'>$$total</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Total : <span class='bn13textskyblue'>$$total</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			echo "Outstanding : <span class='bn13textred15'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Outstanding : <span class='bn13textskyblue'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
	
	if ($paydue<0)
			echo "Amt Due : <span class='bn13textred15'>$$paydue</span>";
		else
			echo "Amt Due : <span class='bn13textskyblue'>$$paydue</span>";
   echo "</span></div>";
  ?>
<br>

    <?php
	$hide_me = "and clr=0";
	$bmsql=mysql_query("(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid' $hide_me)) union
	(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid = '$memberid' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' $hide_me order by bmdate asc) and NOT type = 'INT' $hide_me)	
	 order by memberid,bmdate desc, ref desc");
	 echo "(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid' $hide_me)) union
	(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid = '$memberid' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' $hide_me order by bmdate asc) and NOT type = 'INT' $hide_me)	
	 order by memberid,bmdate desc, ref desc" . "<br>";
	if($once==0) {
	$mum=mysql_result($bmsql,0,"memberid");
	?>
	<form name="member_details" action="viewmemberdetails2.php" method="post" onSubmit="return validate()">
	<table border="1" cellpadding="0" cellspacing="0" width="80%" align="center" class="stats">
<tr align="center">
<td><span class="bn13text"><?php echo $mum; ?></span>
  <td colspan="6" width="350px" align="right"></td>
  <td><span class="bn13text">Amt Due</span></td></tr>
<tr >
    
<td class="hed" width="20%"><span class="bn13text"><b>Date</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>ID</b></span></td>
<td class="hed" width="5%"><span class="bn13text"><b>@</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>Subbmcode</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>Accounts</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>Amount</b></span></td>
<td class="hed" width="35%"><span class="bn13text"><b>Remarks</b></span></td>
<td class="hed" width="5%"><span class="bn13text"><b></b></span></td>

</tr>
	
	
	<?php
	$once=1;
	}
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{
	$mim=mysql_result($bmsql,$count,"memberid");
	if ($temp_member=="") {
	$temp_member = $mim;
	$cutoff=0;
	}
	else
	{
		if ($temp_member<>$mim)
		{
		$cutoff=1;
		$temp_member="";
		}
	}
	if ($cutoff==1) {
	if ($super_dummy<0)
	echo "<tr><td colspan='5' class='hed'><span class='bn13text'><b>Sub Total:</b></span></td><td class='hed'><span class='bn13text'><b><font color='red'>$super_dummy</font></b></span></td><td colspan='2' class='hed'></td></tr>";
	else
	echo "<tr><td colspan='5' class='hed'><span class='bn13text'><b>Sub Total:</b></span></td><td class='hed'><span class='bn13text'><b><font color='blue'>$super_dummy</font></b></span></td><td colspan='2' class='hed'></td></tr>";
	
	$superamount=0;
	$once=0;
	}
	
	echo"<tr>";

	$bmdate=mysql_result($bmsql,$count,"bmdate");
	$bbb=strtotime(str_replace("-", "/",$bmdate));
	$bmdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	
	$memberid=mysql_result($bmsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");
	$bmcode=mysql_query("SELECT bmcode FROM bmcode where subbmcode='$cpyaccount'");
	$atsign=mysql_result($bmcode,0,"bmcode");
	$bilangin = mysql_num_rows($bmcode);
	if ($bilangin<>0)
	echo "<td align='center'><span class='bn13text'>$atsign</span></td>";
	else
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	
	
	if ($bilangin==0) {
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	}
	else {
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	echo "<td align='center'><span class='bn13text'>-</span></td>";	
	}
	$amount=mysql_result($bmsql,$count,"amount");
	$amount2 = number_format($amount,2);
	if ($amount2<0)
		echo "<td align='center'><span class='bn13text'><font color='red'>$amount2</font></span></td>";
		else
		echo "<td align='center'><span class='bn13text'><font color='blue'>$amount2</font></span></td>";
	//echo "<td align='center'><span class='bn13text'>$amount2</span></td>";
	$remark=mysql_result($bmsql,$count,"remark");
	if ($remark<>"")
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	else
	echo "<td align='center'><span class='bn13text'>-</span></td>";

	$clr=mysql_result($bmsql,$count,"clr");
	if ($clr==0) {
	$superamount=$superamount+$amount;
	$super_dummy = number_format($superamount,2);
	$final_amount = $final_amount + $amount;
	}

	$ref=strtoupper(mysql_result($bmsql,$count,"ref"));
	
	if ($ref_collect=="")
	$ref_collect = $ref;
	else
	$ref_collect = $ref_collect . "," . $ref;
	
	$pm=strtoupper(mysql_result($bmsql,$count,"pm"));
	
	if ($pm==0) {
		if ($bilangin<>0)
		{
		
		//echo "<td align='center'></td>";
		echo "<td align='center'><input type='checkbox' name='check_listp[]' value='$ref%placeout' disabled='disabled'></td>";
		}
		else
		{
		//echo "<td align='center'><img src='images/due.png'/></td>";
		echo "<td align='center'><input type='checkbox' name='check_listp[]' value='$ref%payment' disabled='disabled'></td>";
	}
	}
	else {
		if ($bilangin<>0)
		{
	//	echo "<td align='center'></td>";
		echo "<td align='center'><input type='checkbox' name='check_listp[]'  value='$ref%placeout' checked='checked' disabled='disabled'></td>";
		}
		else
		{
		//echo "<td align='center'><img src='images/due.png'/></td>";
		echo "<td align='center'><input type='checkbox' name='check_listp[]' value='$ref%payment' checked='checked' disabled='disabled'></td>";
	}
	}

	echo "</td></tr>";
	$memberidadv=mysql_result($bmsql,$count+1,"memberid");
	if ($cutoff==1) {
	if ($memberidadv<>$memberid) {
		if ($super_dummy<0)
		echo "<tr bgcolor='#888888'><td colspan='5' align='center' class='hed'><span class='bn13text'><b>Sub Total</b></span></td><td class='hed' ><span class='bn13text'><b><font color='red'>$super_dummy</font></b></span></td><td colspan='4' class='hed'></td></tr>";
		else
		echo "<tr bgcolor='#888888'><td colspan='5' align='center'  class='hed'><span class='bn13text'><b>Sub Total</b></span></td><td class='hed'><span class='bn13text'><b><font color='blue'>$super_dummy</font></b></span></td><td colspan='4' class='hed'></td></tr>";
		$superamount=0;
		$once=0;
			}
		}
	}
	?>
	<input type='hidden' name='refcol' value='<?php echo $ref_collect; ?>'>
	</form>
	<?php if ($superamount<>0) { ?>
	<tr >
    <td class="hed" colspan="5"><span class="bn13text"><b>Sub Total:</b></span></td>
     <td class="hed"><span class="bn13text">&nbsp;<b>
	 <?php 
	if ($superamount<0)
	echo "<font color='red'>" . number_format($superamount,2) . "</font>";
	else
	echo "<font color='blue'>" . number_format($superamount,2) . "</font>";
	  
	//  echo number_format($superamount,2); ?>
	 </b>&nbsp;</span></td>
	  <td class="hed" colspan="3"><span class="bn13text"></span></td>
</tr>
<?php } ?>
<tr><td colspan="10" class="hedache"><span class="bn13text"><b>Gross Total: <?php 
	if ($final_amount<0)
	echo "<font color='red'>" . number_format($final_amount,2) . "</font>";
	else
	echo number_format($final_amount,2);
//echo number_format($final_amount,2); 
?></b></span></td></tr>
</body>
</html>