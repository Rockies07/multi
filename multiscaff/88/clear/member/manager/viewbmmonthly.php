<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php
$datetime=date("Y-m-d");
$current_month=date("M") . "-" . date("Y");
$prev11 = date("M", strtotime("-1 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev10 = date("M", strtotime("-2 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev9 = date("M", strtotime("-3 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev8 = date("M", strtotime("-4 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev7 = date("M", strtotime("-5 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev6 = date("M", strtotime("-6 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev5 = date("M", strtotime("-7 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev4 = date("M", strtotime("-8 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev3 = date("M", strtotime("-9 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev2 = date("M", strtotime("-10 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev1 = date("M", strtotime("-11 month")) . "-" . date("Y", strtotime("-1 month")); 
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">View BM Monthly</span></td>
	</tr>
   </table>
<table border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
<tr >
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b>Type</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $prev1; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $prev2; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $prev3; ?></b>&nbsp;</span></td>
     <td align="center" style="border:solid 1px #000000" width="20%"><span class="bn13text">&nbsp;<b><?php echo $prev4; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $prev5; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $prev6; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $prev7; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $prev8; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $prev9; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $prev10; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $prev11; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $current_month; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo "Total"; ?></b>&nbsp;</span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT subbmcode FROM bmcode");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$row=strtoupper(mysql_result($bmsql,$count,"subbmcode"));
	echo "<td align='center'><span class='bn13text'><b>$row</b></span></td>";
	for($i=11;$i>=0;$i--)
	{
//	$enum_dates = date("Y-m-d", strtotime("-$i month"));
	$enum_from = date("Y-m-", strtotime("-$i month")) . "01";
	$enum_to = date("Y-m-", strtotime("-$i month")) . "31";
/*	echo $enum_from . "<br>";
	echo $enum_to . "<br>";*/
//	echo $enum_dates . "<br>";
	//$getvalues=mysql_query("SELECT (sum(amount)+(select sum(amount) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row')) as month_amount FROM bmdatabase_payment where bmdate>='$enum_from' and bmdate<='$enum_to'");
	$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row'");
//	echo "select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row'" . "<br>";
//	echo "select sum(amount) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row'" . "<br>";
	$results=mysql_result($getvalues,0,"month_amount");
	$coltotal[$i] = number_format(($coltotal[$i] + $results),2);
	$total_result = number_format(($total_result + $results),2);
	if ($results<>0)
		echo "<td align='center'><span class='bn13text'>$results</span></td>";
	else
		echo "<td align='center'><span class='bn13text'>0.00</span></td>";
	}
		echo "<td align='center'><span class='bn13text'><b>$total_result</b></span></td>";
	echo "</tr>";
	$ultra_result = number_format(($ultra_result + $total_result),2);
	$total_result=0;
	}
	?>
	<tr >
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $coltotal[11]; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $coltotal[10]; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $coltotal[9]; ?></b>&nbsp;</span></td>
     <td align="center" style="border:solid 1px #000000" width="20%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[8]; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[7]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[6]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[5]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[4]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[3]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[2]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[1]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $coltotal[0]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b><?php echo $ultra_result; ?></b>&nbsp;</span></td>
</tr>
</body>
</html>