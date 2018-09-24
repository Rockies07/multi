<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	//$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php

if ($_POST["datetime"]=="")
$year = date("Y");
else
$year = $_POST["datetime"];

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
	  <td align="center"><span class="bn13text">View BM Yearly</span></td>
	</tr>
   </table>
   <div align="center">
   <form action='<?php echo $PHP_SELF;?>' method='POST' name='listing' >
  <!-- From:<input class="inputDate" id="inputDate" name="datetime_from" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate"> to 
   <input class="inputDate" id="inputDate2" name="datetime_to" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate">-->
  Select Year:
   <select name="datetime" class="searchformfiled" >
   <?php if ($_POST["datetime"]<>"") { ?>
  	 <option value="<?php echo $_POST["datetime"]; ?>" selected="selected"><?php echo $_POST["datetime"]; ?></option>
	 <option value="2010">2010</option>
	 <?php } else { ?>
          <option value="2010" selected="selected">2010</option>
	<?php } ?>	  
		 <option value="2009" >2009</option>
		  <option value="2008" >2008</option>
		  <option value="2007" >2007</option>
		  <option value="2006" >2006</option>
		  <option value="2005" >2005</option>
   </select>
   <input type="submit" name="View" value="View">
   </form>
   </div><br>
<table border="1" cellpadding="0" cellspacing="0" width="90%" align="center">
<tr >
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Code</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=01&year=<?php echo $year; ?>"><b>Jan-<?php echo $year; ?></a></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=02&year=<?php echo $year; ?>">Feb-<?php echo $year; ?></a></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=03&year=<?php echo $year; ?>">Mar-<?php echo $year; ?></a></b>&nbsp;</span></td>
     <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=04&year=<?php echo $year; ?>">Apr-<?php echo $year; ?></a></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=05&year=<?php echo $year; ?>">May-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=06&year=<?php echo $year; ?>">Jun-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=07&year=<?php echo $year; ?>">Jul-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=08&year=<?php echo $year; ?>">Aug-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b<a href="viewbmmonthall.php?month=09&year=<?php echo $year; ?>">>Sep-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=10&year=<?php echo $year; ?>">Oct-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=11&year=<?php echo $year; ?>">Nov-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=12&year=<?php echo $year; ?>">Dec-<?php echo $year; ?></a></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
</tr>
    <?php
//	$bmsql=mysql_query("SELECT bmcode,subbmcode FROM bmcode");
	$bmsql=mysql_query("SELECT distinct bmcode FROM bmcode");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$bmcode=strtoupper(mysql_result($bmsql,$count,"bmcode"));
	$subbmcode=strtoupper(mysql_result($bmsql,$count,"subbmcode"));
	echo "<td align='center'><span class='bn13text'><b>$bmcode</b></span></td>";
	for($i=0;$i<12;$i++)
	{
	$j=$i+1;
//	echo date("-m-", strtotime("month")) . "<br>";
//	$enum_dates = date("Y-m-d", strtotime("-$i month"));
	//$enum_from = date("Y-m-", strtotime("-$i month")) . "01";
	//$enum_to = date("Y-m-", strtotime("-$i month")) . "31";
//	$enum_from = $year . date("-m-", strtotime("+$i month")) . "01";
//	$enum_to = $year . date("-m-", strtotime("+$i month")) . "31";

	$enum_from = $year . "0" . $j . "01";
	$enum_to = $year . "0" . $j . "31";
	if ($j>=10) {
	$enum_from = $year  . $j . "01";
	$enum_to = $year . $j . "31";
	}
/*	echo $enum_from . "<br>";
	echo $enum_to . "<br>";*/
//	echo $enum_dates . "<br>";
	//$getvalues=mysql_query("SELECT (sum(amount)+(select sum(amount) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row')) as month_amount FROM bmdatabase_payment where bmdate>='$enum_from' and bmdate<='$enum_to'");
	//$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$subbmcode' and managerid = '$weblogin'");
//	$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$subbmcode' and entriesby='$weblogin'");
	//$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$subbmcode' and entriesby='$weblogin'");
	$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode in (select subbmcode from bmcode where bmcode = '$bmcode') and entriesby='$weblogin'");
	//echo "select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode in (select subbmcode from bmcode where bmcode = '$bmcode') and entriesby='$weblogin'" . "<br>";
	//echo "select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode in (select subbmcode from bmcode where bmcode = '$bmcode') and entriesby='$weblogin'" . "<br>";
//	echo "select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$subbmcode' and entriesby='$weblogin'" . "<br>";
//	echo "select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row'" . "<br>";
//	echo "select sum(amount) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row'" . "<br>";
	$results=mysql_result($getvalues,0,"month_amount");
	
	$coltotal[$i] = ($coltotal[$i] + $results);
//	echo $coltotal[$i] , "<br>";
	$total_result = ($total_result + $results);
	//echo $total_result . "<br>";
	if ($results<>0) {
		if ($results<=0) {
			$negtopos = number_format(abs($results),2);
			echo "<td align='center'><span class='bn13text'><a href='viewbmmonthly.php?code=$bmcode$subbmcode&month=$j&year=$year'>$negtopos</a></span></td>"; }
		else {
			$postoneg = number_format((0-$results),2);
			echo "<td align='center'><span class='bn13text'><a href='viewbmmonthly.php?code=$bmcode$subbmcode&month=$j&year=$year'><font color='red'>$postoneg</font></a></span></td>";
			
			}
		}
	else
		echo "<td align='center'><a href='viewbmmonthly.php?code=$bmcode$subbmcode&month=$j&year=$year'><span class='bn13text'>0.00</a></span></td>";
	}
		if ($total_result<=0) {
		$negtopos_total_result = number_format(abs($total_result),2);
		echo "<td align='center'><span class='bn13text'><b>$negtopos_total_result</b></span></td>";
		}
		else
		{
		$postoneg_total_result = number_format((0-$total_result),2);
		echo "<td align='center'><span class='bn13text'><b><font color='red'>$postoneg_total_result</font></b></span></td>";
		}
	echo "</tr>";
	$ultra_result = ($ultra_result + $total_result);
	$total_result=0;
	}
	?>
	<tr >
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
<?php for ($jjj=0;$jjj<=11;$jjj++)  { ?>	
<?php if ($coltotal[$jjj]<=0) { $negtopos_total = number_format(abs($coltotal[$jjj]),2); ?>
  	  <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $negtopos_total; ?></b>&nbsp;</span></td>
	  <?php } else { $postoneg_total = number_format((0-$coltotal[$jjj]),2); ?>
	  <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><font color="red"><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
	  <?php } ?>
 <?php } ?>
 	<?php if ($ultra_result<=0) { $negtopos_total = number_format(abs(ultra_result),2); ?>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $negtopos_total; ?></b>&nbsp;</span></td>
	<?php } else { $postoneg_total = number_format((0-$ultra_result),2); ?>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><font color="red"><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
	<?php } ?>
</tr>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>