<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	//$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$ctr=0;
?>
<html>
<head><title>Member Summary</title><link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr><td align="center" colspan="3"><span class="maintitle">Member Summary</span></td></tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
</table>

<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center" class="stats">
<tr >
    <td class="hed" width="13%" ><span class="bn13text"><b>&nbsp;Member&nbsp;</b></span></td>
    <?php 
	$bmlist=mysql_query("select distinct bmcode from bmcode");
	while ($row_bmlist = mysql_fetch_array($bmlist)) 
	{ 
	?>
	<td class="hed" width="13%" ><span class="bn13text"><b>
	<?php
	 echo $row_bmlist[0]; 
	 if ($bmlisting=="")
	 	$bmlisting[$ctr] = $row_bmlist[0];
	 else
		$bmlisting[$ctr] = $bmlisting[$ctr] . $row_bmlist[0];
 	 $ctr++;
	 ?>
	</b> </span></td>
	<?php }	?>	
	<td class="hed" width="13%" ><span class="bn13text"><b>Total</b></span></td>
</tr>
<?php
	$memlist=mysql_query("select memberid as mem from memberid union select subid as mem from submembers order by mem asc");
	while ($row_memlist = mysql_fetch_array($memlist)) 
	{ 
	
	for ($x=0;$x<$ctr;$x++) {
	if ($query_all=="")
	 	//$query_all = "select ifnull(sum(amount),0)";
	$query_all = "select ifnull(sum(amount),0)+(select ifnull(sum(amount),0) from backup_plan where memberid = '" . $row_memlist[0] . "' and bmcode='$bmlisting[$x]')";
	 else
		$query_all = $query_all . "," . " (select ifnull(sum(amount),0)+(select ifnull(sum(amount),0) from backup_plan where memberid = '" . $row_memlist[0] . "' and bmcode='$bmlisting[$x]') from bmdatabase_wlplaceout where memberid = '" . $row_memlist[0] . "' and subbmcode in (select subbmcode from bmcode where bmcode='$bmlisting[$x]')) as $bmlisting[$x]";
	}
	$query_all = $query_all . " from bmdatabase_wlplaceout where memberid = '" . $row_memlist[0] . "' and subbmcode in (select subbmcode from bmcode where bmcode='$bmlisting[0]')";
	
	//echo $query_all . "<br><br>";
	
	
	$codelist=mysql_query("$query_all");
//	echo "$query_all" . "<br>";
	/*	$codelist=mysql_query("select ifnull(sum(amount),0) from bmdatabase_wlplaceout where memberid = '" . $row_memlist[0] . "' and subbmcode in (select subbmcode from bmcode where bmcode='$bmlisting[0]')");
		echo "select ifnull(sum(amount),0) from bmdatabase_wlplaceout where memberid = '" . $row_memlist[0] . "' and subbmcode in (select subbmcode from bmcode where bmcode='$bmlisting[0]')" . "<br>";*/
		while ($row_code = mysql_fetch_array($codelist)) 
		{ 
		//echo "$query_all";
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
	//echo $row_code[$y];
	echo "<font color='blue'>" . $row_code[$y] . "</font>";
?> </span></td>
<?php } ?>
<td align="center" width="13%" ><span class="bn13text"><b><?php 
if ($coltotal<0)
	echo "<font color='red'>" . number_format($coltotal,2) . "</font>";
	else
	echo "<font color='blue'>" . number_format($coltotal,2) . "</font>";
	
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

	<td width="13%" height="29" align="center" class="hed"><span class="bn13text"><b>Total</b></span></td>
	<?php for ($z=0;$z<$ctr;$z++) { ?>
	<td class="hed" width="13%" ><span class="bn13text"><b><?php
	if ($cont[$z]<0)
	echo "<font color='red'>" . number_format($cont[$z],2) . "</font>";
	else
	echo "<font color='blue'>" . number_format($cont[$z],2) . "</font>";
	// echo $cont[$z]; ?></b></span></td>
	<?php } ?>
	<td class="hed" width="13%" ><span class="bn13text"><b><?php 
	if ($supertotal<0)
	echo "<font color='red'>" . number_format($supertotal,2) . "</font>";
	else
	echo "<font color='blue'>" . number_format($supertotal,2) . "</font>";
//	echo $supertotal;
	//echo $supertotal; ?></b></span></td>
</tr>
</table>
</body>
</html>