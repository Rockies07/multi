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
$datetime=date("Y-m-d");
$datetime_from = $_POST["datetime_from"];
$datetime_to = $_POST["datetime_to"];
echo $datetime_from;
echo $datetime_to;
/*$today=date("Y-m-d");
$prev6 = date("Y-m-d", strtotime("-1 day")); 
$prev5 = date("Y-m-d", strtotime("-2 day")); 
$prev4 = date("Y-m-d", strtotime("-3 day")); 
$prev3 = date("Y-m-d", strtotime("-4 day")); 
$prev2 = date("Y-m-d", strtotime("-5 day")); 
$prev1 = date("Y-m-d", strtotime("-6 day")); */
$today=date("D Y-m-d");
$prev6 = date("D Y-m-d", strtotime("-1 day")); 
$prev5 = date("D Y-m-d", strtotime("-2 day")); 
$prev4 = date("D Y-m-d", strtotime("-3 day")); 
$prev3 = date("D Y-m-d", strtotime("-4 day")); 
$prev2 = date("D Y-m-d", strtotime("-5 day")); 
$prev1 = date("D Y-m-d", strtotime("-6 day")); 
?>
<html>
<head><title>Main Announcement</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/eye.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/layout.js?ver=1.0.2"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/datepicker.css" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">View BM Weekly </span></td>
	</tr>
   </table><br>
   <div align="center">
   <form action='<?php echo $PHP_SELF;?>' method='POST' name='listing' >
  <!-- From:<input class="inputDate" id="inputDate" name="datetime_from" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate"> to 
   <input class="inputDate" id="inputDate2" name="datetime_to" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate">-->From:
   <select name="datetime_from" class="searchformfiled" >
          <option value="SGD" selected="selected">SGD</option>
          <!--<option value="">--Click--</option>-->
          <?php	$currencysql=mysql_query("SELECT currencycode FROM currency");
				$currencysqlrow=mysql_num_rows($currencysql);
				for($count=0; $count<$currencysqlrow; $count++)
				{$currencycode=mysql_result($currencysql,$count,"currencycode");
				echo "<option value='$currencycode'>$currencycode</option>";}
                ?>
        </select>To
		<select name="datetime_to" class="searchformfiled" >
          <option value="SGD" selected="selected">SGD</option>
          <!--<option value="">--Click--</option>-->
          <?php	$currencysql=mysql_query("SELECT currencycode FROM currency");
				$currencysqlrow=mysql_num_rows($currencysql);
				for($count=0; $count<$currencysqlrow; $count++)
				{$currencycode=mysql_result($currencysql,$count,"currencycode");
				echo "<option value='$currencycode'>$currencycode</option>";}
                ?>
        </select>
   <input type="submit" name="View" value="View">
   </form>
   </div><br>
<table border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
<tr >
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Code</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Web</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $prev1; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $prev2; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $prev3; ?></b>&nbsp;</span></td>
     <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $prev4; ?></b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $prev5; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $prev6; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $today; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo "Total"; ?></b>&nbsp;</span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT bmcode,subbmcode FROM bmcode");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$bmcode=strtoupper(mysql_result($bmsql,$count,"bmcode"));
	echo "<td align='center'><span class='bn13text'><b>$bmcode</b></span></td>";
	$row=strtoupper(mysql_result($bmsql,$count,"subbmcode"));
	echo "<td align='center'><span class='bn13text'><b>$row</b></span></td>";
	for($i=6;$i>=0;$i--)
	{
	$enum_date = date("Y-m-d", strtotime("-$i day"));
//	$enum_from = date("Y-m-", strtotime("-$i month")) . "01";
//	$enum_to = date("Y-m-", strtotime("-$i month")) . "31";
/*	echo $enum_from . "<br>";
	echo $enum_to . "<br>";*/
//	echo $enum_dates . "<br>";
	//$getvalues=mysql_query("SELECT (sum(amount)+(select sum(amount) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row')) as month_amount FROM bmdatabase_payment where bmdate>='$enum_from' and bmdate<='$enum_to'");
	$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_wlplaceout where bmdate='$enum_date' and subbmcode='$row'");
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
	<td align="center" style="border:solid 1px #000000" ></td>
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
   	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $coltotal[6]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $coltotal[5]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $coltotal[4]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $coltotal[3]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $coltotal[2]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $coltotal[1]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $coltotal[0]; ?></b>&nbsp;</span></td>
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b><?php echo $ultra_result; ?></b>&nbsp;</span></td>
</tr>
</table>
* weekly report will base from the last 7 days starting from the current day
</body>
</html>