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
	$memcount=0;
	
	if ($_GET[memberid]<>"") {
	$_SESSION["memberid"]=$_GET[memberid];
	$_SESSION["managerid"]=$_GET[managerid];
	}
	//$memberid=$_SESSION["memberid"];
	$memberid=$weblogin;
	$managerid=$_SESSION["memberid"];
	$action=$_GET["action"];
	$hiddenf = $_POST["hiddenf"];
	$counts = $_POST["counts"];
	$reference = $_GET["ref"];
	$methody=$_GET["methody"];
	$even_once = "";
	
	if ($hiddenf==0 || $hiddenf=="")
		$hide_me = " and clr = '0'";
	
//	echo $hide_me;
//	echo $_POST["counts"] . "<br><br>";
	
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

?>
<html>
<head><title>Main Announcement</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<link href="css/demos2.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" media="screen" type="text/css" href="layout.css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0">
<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
	<tr>
	  <td align="center"><span class="bn13text"> <b><?php echo $memberid; ?></b> Details<br>
  </span></td>
	</tr>
  <td>
  <?php
  
	echo "<span class='bn13textwhite15'>";
  if ($total<0)
			echo "Gross Total : <span class='bn13textred15'>$$total</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Gross Total : <span class='bn13textskyblue'>$$total</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			echo "Outstanding : <span class='bn13textred15'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Outstanding : <span class='bn13textskyblue'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
	
	if ($paydue<0)
			echo "Amt Due : <span class='bn13textred15'>$$paydue</span>";
		else
			echo "Amt Due : <span class='bn13textskyblue'>$$paydue</span></span>";
  ?>
</td>
</table>
<br>

<strong>

    <?php
	$hide_me = "and clr=0";
	$bmsql=mysql_query("(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid' $hide_me)) union
	(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid = '$memberid' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' $hide_me order by bmdate desc) and NOT type = 'INT' $hide_me) order by (case when memberid = '$memberid' then 0 else 1 end),memberid asc,bmdate desc, ref desc");
	
	// order by memberid,bmdate desc, ref desc");
	 
	if($once==0) {
	$mum=mysql_result($bmsql,0,"memberid");
	?>
	<form name="member_details" action="viewmemberdetails.php" method="post" onSubmit="return validate()">
	<table border="1" cellpadding="0" cellspacing="0" width="90%" align="center" class="stats">
	<tr>
	</tr>
<tr align="center">
<td><span class="bn13text"><?php echo $mum; ?></span>
  <td colspan="6" width="350px" align="left" class="hedacheblack"><span class="bn13text">
  <?php
$indivmem=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0')) 
 as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')) 
 FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'");

$outstanding2=mysql_result($indivmem,0,"outstanding");
$pmdue2=mysql_result($indivmem,0,"pmdue");
$total2 = $outstanding2 + $pmdue2;

if ($total2<0)
			echo "<b>Sub Total : <span class='bn13textred12'>$$total2</span></b>&nbsp;&nbsp;&nbsp;";
		else
			echo "<b>Sub Total : <span class='bn13textskybluer'>$$total2</span></b>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			echo "<b>Outstanding : <span class='bn13textred12'>$$outstanding2</span></b>&nbsp;&nbsp;&nbsp;";
		else
			echo "<b>Outstanding : <span class='bn13textskybluer'>$$outstanding2</span></b>&nbsp;&nbsp;&nbsp;";
	
	if ($pmdue2<0)
			echo "<b>Amt Due : <span class='bn13textred12'>$$pmdue2</span></b>";
		else
			echo "<b>Amt Due : <span class='bn13textskybluer'>$$pmdue2</span></b>";
?>
 </td>
  <td><span class="bn13text">D</span></td>
  <input name="hideme" type="hidden" value="">
 </tr>
<tr >
    
<td class="hed" width="20%"><span class="bn13text"><b>Date</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>ID</b></span></td>
<td class="hed" width="5%"><span class="bn13text"><b>@</b></span></td>
<td class="hed"  width="10%"><span class="bn13text"><b>Subbmcode</b></span></td>
<td class="hed"  width="10%"><span class="bn13text"><b>Accounts</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>Amount</b></span></td>
<td class="hed" width="35%"><span class="bn13text"><b>Remarks</b></span></td>
<td class="hed"  width="5%"><span class="bn13text"></span></td>

 
</tr>
	
	
	<?php
	//echo "3333";
	$once=1;
	//echo $once;
	}
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{
	$mim=mysql_result($bmsql,$count,"memberid");
//	echo $mim . "<br>";
	//echo $temp_member . "<br>";;

	//$ref=mysql_result($bmsql,$count,"ref");
	//echo "<td align='center'><span class='bn13text'>$ref</span></td>";
	$bmdate=mysql_result($bmsql,$count,"bmdate");
	$bbb=strtotime(str_replace("-", "/",$bmdate));
	$bmdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	
	$memberid=mysql_result($bmsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	//echo "<td align='center'><span class='bn13text'>-</span></td>";
	//$type=mysql_result($bmsql,$count,"type");
/*	echo "<td align='center'><span class='bn13text'>$type</span></td>";
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");*/
	/*$type=mysql_result($bmsql,$count,"type");
	echo "<td align='center'><span class='bn13text'>$type</span></td>";*/
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");
	$bmcode=mysql_query("SELECT bmcode FROM bmcode where subbmcode='$cpyaccount'");
	$atsign=mysql_result($bmcode,0,"bmcode");
	$bilangin = mysql_num_rows($bmcode);
//	echo $bilangin . "<br>";
//	echo $atsign . "<br>";
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
/*	$memberid=mysql_result($bmsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";*/
	$amount=mysql_result($bmsql,$count,"amount");
	$amount2 = number_format($amount,2);
	//echo "<td align='center'><span class='bn13text'>$amount2</span></td>";
		if ($amount2<0)
		echo "<td align='center'><span class='bn13text'><font color='red'>$amount2</font></span></td>";
		else
		echo "<td align='center'><span class='bn13text'><font color='blue'>$amount2</font></span></td>";
	$remark=mysql_result($bmsql,$count,"remark");
	if ($remark<>"")
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	else
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	//$clr=strtoupper(mysql_result($bmsql,$count,"clr"));
	$clr=mysql_result($bmsql,$count,"clr");
//	if ($clr==0) {
	$superamount=$superamount+$amount;
	$super_dummy = number_format($superamount,2);
	$final_amount = $final_amount + $amount;
//	}
//	echo $superamount . "<br>";
	/*$entriesby=strtoupper(mysql_result($bmsql,$count,"entriesby"));
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";*/
		//pm and clr
	$ref=strtoupper(mysql_result($bmsql,$count,"ref"));
	
	if ($ref_collect=="")
	$ref_collect = $ref;
	else
	$ref_collect = $ref_collect . "," . $ref;
	
	if ($atsign=="") {
		if ($ref_collectp=="")
		$ref_collectp = $ref;
		else
		$ref_collectp = $ref_collectp . "," . $ref;
	}
	else
	{
		if ($ref_collectw=="")
		$ref_collectw = $ref;
		else
		$ref_collectw = $ref_collectw . "," . $ref;
	}
		
	$pm=strtoupper(mysql_result($bmsql,$count,"pm"));
	
	if ($pm==0) {
		if ($bilangin<>0)
			echo "<td align='center'><img src='images/check2.jpg'/></td>";
		else
			echo "<td align='center'><img src='images/check2.jpg'/></td>";
	}
	else {
		if ($bilangin<>0)
			echo "<td align='center'><img src='images/check1.jpg'/></td>";
		else
			echo "<td align='center'><img src='images/check1.jpg'/></td>";
	}
	
	
	echo "</td></tr>";
	$memberidadv=mysql_result($bmsql,$count+1,"memberid");
	if ($mim<>$memberid || $mim<>$memberidadv && $memberidadv<>"") {
		if ($super_dummy<0) {
		$indivmem=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='0')) 
 as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='1')) 
 FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='0'");

$outstanding2=mysql_result($indivmem,0,"outstanding");
$pmdue2=mysql_result($indivmem,0,"pmdue");
$total2 = $outstanding2 + $pmdue2;

	if ($total2<0)
			$gtot = "Sub Total : <span class='bn13textred12'>$$total2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gtot = "Sub Total : <span class='bn13textskybluer'>$$total2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			$gout = "Outstanding : <span class='bn13textred12'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gout = "Outstanding : <span class='bn13textskybluer'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($pmdue2<0)
			$gdue = "Amt Due : <span class='bn13textred12'>$$pmdue2</span>";
		else
			$gdue = "Amt Due : <span class='bn13textskybluer'>$$pmdue2</span>";
	
	
	if ($super_dummy<0)
	echo "
	<tr><td colspan='10' height='30px' class='mates'></td><tr>
	<tr bgcolor='#888888'><td ><span class='bn13text'>$memberidadv</span></td><td colspan='6' align='center' class='hedacheblack'><span class='bn13text'><b>$gtot $gout 	$gdue</b></span></td> <td><span class='bn13text'>D</span></td><input name='hideme' type='hidden' value=''></tr><tr >   
<td class='hed' width='20%'><span class='bn13text'><b>Date</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>ID</b></span></td>
<td class='hed' width='5%'><span class='bn13text'><b>@</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Subbmcode</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Accounts</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>Amount</b></span></td>
<td class='hed' width='35%'><span class='bn13text'><b>Remarks</b></span></td>
<td class='hed'  width='5%'></td> </tr>";
		}
		else { 
	//	echo "<br>" . "jerbax" . "<br>";
		$indivmem=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='0')) 
 as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='1')) 
 FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='0'");

$outstanding2=mysql_result($indivmem,0,"outstanding");
$pmdue2=mysql_result($indivmem,0,"pmdue");
$total2 = $outstanding2 + $pmdue2;

	if ($total2<0)
			$gtot = "Sub Total : <span class='bn13textred12'>$$total2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gtot = "Sub Total : <span class='bn13textskybluer'>$$total2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			$gout = "Outstanding : <span class='bn13textred12'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gout = "Outstanding : <span class='bn13textskybluer'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($pmdue2<0)
			$gdue = "Amt Due : <span class='bn13textred12'>$$pmdue2</span>";
		else
			$gdue = "Amt Due : <span class='bn13textskybluer'>$$pmdue2</span>";
	
	
//	if ($super_dummy<0)
	echo "
	<tr><td colspan='10' height='30px' class='mates'></td><tr>
	<tr bgcolor='#888888'><td ><span class='bn13text'>$memberidadv</span></td><td colspan='6' align='center' class='hedacheblack'><span class='bn13text'><b>$gtot $gout 	$gdue</b></span></td> <td><span class='bn13text'>D</span></td><input name='hideme' type='hidden' value=''></tr><tr >   
<td class='hed' width='20%'><span class='bn13text'><b>Date</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>ID</b></span></td>
<td class='hed' width='5%'><span class='bn13text'><b>@</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Subbmcode</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Accounts</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>Amount</b></span></td>
<td class='hed' width='35%'><span class='bn13text'><b>Remarks</b></span></td>
<td class='hed'  width='5%'></td></tr>";
		//echo "<tr bgcolor='#888888'><td colspan='5' align='center'  class='hed'><span class='bn13text'><b>Sub Total</b></span></td><td class='hed'><span class='bn13text'><b><font color='red'>$super_dummy</font></b></span></td><td colspan='4' class='hed'></td></tr>";
		$superamount=0;
		$once=0;
		}
		}
//		}
	}
	?>
	<input type='hidden' name='refcol' value='<?php echo $ref_collect; ?>'>
	<input type='hidden' name='refcolw' value='<?php echo $ref_collectw; ?>'>
	<input type='hidden' name='refcolp' value='<?php echo $ref_collectp; ?>'>
	</form>
<tr><td colspan="10" align="center" bgcolor="#888888" class="hedache"><span class="bn13text"><b>Gross Total: <?php 
	if ($final_amount<0)
	echo "<font color='red'>" . number_format($final_amount,2) . "</font>";
	else
	echo number_format($final_amount,2);

?></b></span></td></tr>
</body>
</html>