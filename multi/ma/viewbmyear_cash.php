<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$_SESSION["link1"]="";
	$_SESSION["link2"]="";
?>
<?php

if ($_POST["datetime"]=="")
{
	$year = date("Y");
}
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
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/easydrag.js"></script>
<script type="text/javascript">$(function(){$("#FloaintBox").easydrag();
$("#FloaintBox").ondrop(function(e, element){ });});</script> 
<style type="text/css">#FloaintBox{ border:1px solid red; background-color:#eef4d3;}#FloaintBox{width:120px; padding:10px;}</style> 
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">View BM Yearly (Cash)</span></td>
	</tr>
   </table>
   <div align="center">
   <form action='<?php echo $PHP_SELF;?>' method='POST' name='listing' >
  <span class="bn13textwhite">
  Select Year:</span>
   <select name="datetime">
<?PHP
if ($_POST["datetime"]=="")
{
	$selectmo=$_GET['year'];
	if($selectmo=="")
		$selectmo = date("Y");
}
else
$selectmo = $_POST["datetime"];

$year = date("Y")-3;
for ($i = 0; $i <= 10; $i++) {
if ($year==$selectmo)
$silik = "selected='selected'";
else
$silik = "";
echo "<option $silik>$year</option>"; $year++;
}
?>
</select>
   <input type="submit" name="View" value="View">
   </form>
   </div><br>
<table border="1" cellpadding="0" cellspacing="0" width="100%" align="center" class="stats">
<tr >
    <td class="hed" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=01&year=<?php echo $selectmo; ?>"><b>Jan-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=02&year=<?php echo $selectmo; ?>">Feb-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=03&year=<?php echo $selectmo; ?>">Mar-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
     <td class="hed" ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=04&year=<?php echo $selectmo; ?>">Apr-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=05&year=<?php echo $selectmo; ?>">May-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=06&year=<?php echo $selectmo; ?>">Jun-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=07&year=<?php echo $selectmo; ?>">Jul-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=08&year=<?php echo $selectmo; ?>">Aug-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=09&year=<?php echo $selectmo; ?>">Sep-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=10&year=<?php echo $selectmo; ?>">Oct-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=11&year=<?php echo $selectmo; ?>">Nov-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><a href="viewbmmonthall.php?month=12&year=<?php echo $selectmo; ?>">Dec-<?php echo $selectmo; ?></a></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
</tr>
    <?php
//	$bmsql=mysql_query("SELECT bmcode,subbmcode FROM bmcode");
	
	for($i=0;$i<12;$i++)
	{
	$j=$i+1;
//	echo date("-m-", strtotime("month")) . "<br>";
//	$enum_dates = date("Y-m-d", strtotime("-$i month"));
	//$enum_from = date("Y-m-", strtotime("-$i month")) . "01";
	//$enum_to = date("Y-m-", strtotime("-$i month")) . "31";
//	$enum_from = $selectmo . date("-m-", strtotime("+$i month")) . "01";
//	$enum_to = $selectmo . date("-m-", strtotime("+$i month")) . "31";

	$enum_from = $selectmo . "0" . $j . "01";
	$enum_to = $selectmo . "0" . $j . "31";
	if ($j>=10) {
	$enum_from = $selectmo  . $j . "01";
	$enum_to = $selectmo . $j . "31";
	}
//	$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode in (select subbmcode from bmcode where bmcode = '$bmcode')");
	
	//$getvalues=mysql_query("select sum(ifnull(amount,0))+(select ifnull(sum(amount),0) from bmcode_cleared where month_covered>='$enum_from' and month_covered<='$enum_to' and code='$bmcode') as month_amount from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode in (select subbmcode from bmcode where bmcode = '$bmcode')");
	
	$getvalues_payment=mysql_query("select ifnull(sum(ifnull(amount,0)),0) as month_amount from bmdatabase_payment where bmdate>='$enum_from' and bmdate<='$enum_to'");

	$results_payment=mysql_result($getvalues_payment,0,"month_amount");

	$results=$results_payment;
	
	$coltotal[$i] = ($coltotal[$i] + $results);
//	echo $coltotal[$i] , "<br>";
	$total_result = ($total_result + $results);
	//echo $total_result . "<br>";
	if ($results<>0) {
		if ($results>=0) {
			$negtopos = number_format(abs($results),2);
			echo "<td align='center'><span class='bn13text'><a href='viewbmmonthly_cash.php?code=$bmcode$subbmcode&month=$j&year=$selectmo'>$negtopos</a></span></td>"; }
		else {
			$postoneg = number_format((0-$results),2);
			echo "<td align='center'><span class='bn13text'><a href='viewbmmonthly_cash.php?code=$bmcode$subbmcode&month=$j&year=$selectmo'><font color='red'>$postoneg</font></a></span></td>";
			
			}
		}
	else
		echo "<td align='center'><a href='viewbmmonthly_cash.php?code=$bmcode$subbmcode&month=$j&year=$selectmo'><span class='bn13text'>0.00</a></span></td>";
	}
		if ($total_result>=0) {
		$negtopos_total_result = number_format(abs($total_result),2);
		echo "<td align='center'><span class='bn13text'><b><font color='blue'>$negtopos_total_result</font></b></span></td>";
		}
		else
		{
		$postoneg_total_result = number_format((0-$total_result),2);
		echo "<td align='center'><span class='bn13text'><b><font color='red'>$postoneg_total_result</font></b></span></td>";
		}
	echo "</tr>";
	$ultra_result = ($ultra_result + $total_result);
	$total_result=0;
	
	?>
</table>
<br>


</body>
</html>