<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$mem = $_GET["memberid"];
	$year = $_GET["year"];
?>
<html>
<head><title>Member History Details</title><link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr>
	  <td align="center" colspan="3"><span class="bn13text">Member <b><?php echo $memlist; ?></b> History Stamement</span></td>
	</tr>
   </table>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center" class="stats">
<tr >
    <td align="center" width="13%" class="hed"><span class="bn13text"><b>Type</b></span></td>
	 <?php 
	$months=mysql_query("select distinct substr(bmdate,1,7) from backup_plan where substr(bmdate,1,4)='$year' and memberid='$mem' order by bmdate asc");
//	echo "select distinct substr(bmdate,1,7) from backup_plan where substr(bmdate,1,4)='$year' and memberid='$mem' order by bmdate asc" . "<br>";
//	echo "select distinct substr(bmdate,1,7) from backup_plan where substr(bmdate,1,4)='$year' and memberid='$mem' order by bmdate asc";
//	echo "select distinct substr(bmdate,1,7) from member_history where substr(bmdate,1,4)='$year' order by bmdate asc";
	while ($row_months = mysql_fetch_array($months)) 
	{ 
	?>
	<td align="center" width="13%"  class="hed"><span class="bn13text"><b>
	<?php
	$bbb=strtotime(str_replace("-", "/",$row_months[0]."-31"));
	$bmdate=date("M Y",$bbb);
	// echo $row_months[0]; 
	 echo $bmdate; 
	 if ($monthlist=="")
	 	$monthlist[$ctr] = $row_months[0];
	 else
		$monthlist[$ctr] = $monthlist[$ctr] . $row_months[0];
 	 $ctr++;
	 ?>
	</b> </span></td>
	<?php }	?>	
	<td align="center" width="13%"  class="hed"><span class="bn13text"><b>Total</b></span></td>
	</tr>
<?php
	$memlist=mysql_query("select distinct subbmcode from backup_plan order by subbmcode asc");
	while ($row_memlist = mysql_fetch_array($memlist)) 
	{ 
	
	for ($x=0;$x<$ctr;$x++) {
	if ($query_all=="")
	 	$query_all = "select ifnull(sum(amount),0)";
	 else
		$query_all = $query_all . "," . " (select ifnull(sum(amount),0) from backup_plan where memberid = '$mem' and subbmcode = '" . $row_memlist[0] . "' and substr(bmdate,1,4)='$year'";
	}
	$query_all = $query_all . " from backup_plan where memberid = '$mem' and subbmcode = '" . $row_memlist[0] . "' and substr(bmdate,1,4)='$year'";

	//echo $query_all . "<br><br>";
	$codelist=mysql_query("$query_all");
	//echo "$query_all" . "<br>";
	/*	$codelist=mysql_query("select ifnull(sum(amount),0) from bmdatabase_wlplaceout where memberid = '" . $row_memlist[0] . "' and subbmcode in (select subbmcode from bmcode where bmcode='$bmlisting[0]')");
		echo "select ifnull(sum(amount),0) from bmdatabase_wlplaceout where memberid = '" . $row_memlist[0] . "' and subbmcode in (select subbmcode from bmcode where bmcode='$bmlisting[0]')" . "<br>";*/
		while ($row_code = mysql_fetch_array($codelist)) 
		{ 
		//echo "$query_all";
//		echo $row_code[0] . "<br><br>";
	?>
<tr >
<td align="center" width="13%" ><span class="bn13text"><b><?php echo $row_memlist[0]; ?></b></span></td>
<?php
for ($y=0;$y<$ctr;$y++) {
$coltotal = $coltotal + $row_code[$y];
$cont[$y] = $cont[$y] + $row_code[$y];
?>
<td align="center" width="13%" ><span class="bn13text">
<?php
if ($row_code[$y]<0)
	echo "<font color='red'>" . $row_code[$y] . "</font>";
	else
	echo $row_code[$y];
?> </span></td>
<?php } ?>
<td align="center" width="13%" ><span class="bn13text"><b><?php 
if ($coltotal<0)
	echo "<font color='red'>" . number_format($coltotal,2) . "</font>";
	else
	echo number_format($coltotal,2);
	
//echo number_format($coltotal,2); 
?></b></span></td>
</tr>
<?php
$supertotal = $supertotal + $coltotal;
$query_all = "";
$coltotal = "";

	}
//echo $row_memlist[0] . "<br>";
	}
?>
<tr>

	<td align="center" width="13%" ><span class="bn13text"><b>Total</b></span></td>
	<?php for ($z=0;$z<$ctr;$z++) { ?>
	<td align="center" width="13%" ><span class="bn13text"><b><?php
	if ($cont[$z]<0)
	echo "<font color='red'>" . number_format($cont[$z],2) . "</font>";
	else
	echo number_format($cont[$z],2);
	// echo $cont[$z]; ?></b></span></td>
	<?php } ?>
	<td align="center" width="13%" ><span class="bn13text"><b><?php 
	if ($supertotal<0)
	echo "<font color='red'>" . number_format($supertotal,2) . "</font>";
	else
	echo number_format($supertotal,2);
	//echo $supertotal; ?></b></span></td>
</tr>
</table>
</body>
</html>