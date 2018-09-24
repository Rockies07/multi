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
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">View BM Monthly</span></td>
	</tr>
   </table>
   <div align="center">
   <form action='<?php echo $PHP_SELF;?>' method='POST' name='listing' >
  <!-- From:<input class="inputDate" id="inputDate" name="datetime_from" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate"> to 
   <input class="inputDate" id="inputDate2" name="datetime_to" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate">
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
   </div><br>-->
<table border="1" cellpadding="0" cellspacing="0" width="90%" align="center">
<tr >
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Code</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Web</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
</tr>
    <?php
$code=$_GET["code"];
$month=$_GET["month"];
$year=$_GET["year"];
if (strlen($month)==1)
$month = "0" . $month;
	$enum_from = $year . "-" . $month . "-" . "01";
	$enum_to = $year . "-" . $month . "-" . "31";
	
	$bmsql=mysql_query("SELECT subbmcode FROM bmcode where bmcode = '$code'");
//	echo "SELECT subbmcode FROM bmcode where bmcode = '$code'" . "<br>";
	$bmrow=mysql_num_rows($bmsql);
while ($row_bmsql = mysql_fetch_array($bmsql)) 
	{
$count++;
if ($count%2)
	{echo"<tr>";}
	else
{echo"<tr bgcolor='#CCCCCC'>";}
if ($count==1)
echo "<td align='center' rowspan='$bmrow'><span class='bn13text'><b>$code</b></span></td>";

echo "<td align='center'><span class='bn13text'><b>$row_bmsql[0]</b></span></td>";


//	$getvalues=mysql_query("select IFNULL(sum(amount),0),subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' and entriesby='$weblogin'");
	$getvalues=mysql_query("select IFNULL(sum(amount),0) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' and entriesby='$weblogin'  order by ref asc");
//	echo "select IFNULL(sum(amount),0) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' and entriesby='$weblogin'  order by ref asc" . "<br>";
//	echo "select IFNULL(sum(amount),0),subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' and entriesby='$weblogin'";
while ($row_getvalues = mysql_fetch_array($getvalues)) 
	{
		
	if ($row_getvalues[0]=="")
		echo "<td align='center'><span class='bn13text'><b>0.00</b></span></td>";
	else {
		if ($row_getvalues[0]<=0) { $negtopos_total = number_format(abs($row_getvalues[0]),2);
		echo "<td align='center'><a href='viewbmdaily_b.php?web=$row_bmsql[0]&month=$month&year=$year'><span class='bn13text'><b>$negtopos_total</b></span></td>";
		} else { $postoneg_total = number_format((0-$row_getvalues[0]),2);
		echo "<td align='center'><a href='viewbmdaily_b.php?web=$row_bmsql[0]&month=$month&year=$year'><span class='bn13text'><b><font color='red'>$postoneg_total</font></b></span></td>";
		}
		}
		$super_total = $super_total + $row_getvalues[0];
	}
}
	?>
	<tr >
	<td align="center" style="border:solid 1px #000000" ></td>
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
	<?php if ($super_total<=0) { $negtopos_total = number_format(abs($super_total),2); ?>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><?php echo $negtopos_total; ?></b>&nbsp;</span></td>
    <?php } else { $postoneg_total = number_format((0-$super_total),2); ?>
	<td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b><font color='red'><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
	<?php } ?>
</tr>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>