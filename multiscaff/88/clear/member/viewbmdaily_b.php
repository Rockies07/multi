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
$code=$_GET["code"];
$type=$_GET["web"];
$month=$_GET["month"];
if ($month=="01" || $month=="03" || $month=="05" || $month=="07" || $month=="08" || $month=="10" || $month=="12")
	$vilang = 31;
if ($month=="04" || $month=="06" || $month=="09" || $month=="11")
	$vilang = 30;
if ($month=="02")
	$vilang = 29;
//	echo $vilang;
$year=$_GET["year"];
$action=$_GET["action"];
$getref=$_GET["ref"];
$eamount = $_GET["eamount"];
$memberid = $_GET["memberid"];
if ($action=="save")
{
	$update_amount = "update bmdatabase_wlplaceout set  amount='$eamount' where memberid = '$memberid' and ref = '$getref'";
	mysql_query($update_amount);
	echo "<script>alert('Successfully Updated Amount.')</script>";
}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">View BM </span></td>
	</tr>
</table>
   <table border="1" cellpadding="0" cellspacing="0" width="50%" align="center">
<tr >
	<td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Date</b></span></td>
    <td align="center" style="border:solid 1px #000000" ><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
</tr><tr>
    <?php

for($x=1;$x<=$vilang;$x++) {
	if ($x<10) 
		$enum = $year . "-" . $month . "-" . "0" . $x;
	else
		$enum = $year . "-" . $month . "-" .$x;
$getvalues=mysql_query("select sum(amount) from bmdatabase_wlplaceout where bmdate='$enum' and subbmcode='$type' and entriesby='$weblogin' order by entriesdate asc");
//echo "select amount from bmdatabase_wlplaceout where bmdate='$enum' and subbmcode='$type' and entriesby='$weblogin' order by entriesdate asc";
$results = mysql_fetch_array($getvalues);
//echo $results[0] . "<br>";


//if ($results[0]<>0 && $results[0]<>"0" && $results[0]<>" ") {
//echo $results[0]; 
if ($results[0]<>"" || $results[0]=="0.00") {
echo "<tr>";
echo "<td align='center' style='border:solid 1px #000000' ><span class='bn13text'>&nbsp;<b>$enum</b></span></td>";
	if ($results[0]<0) { $negtopos_total = number_format(abs($results[0]),2);
	echo "<td align='center' style='border:solid 1px #000000' ><span class='bn13text'>&nbsp;<b><a href='viewbmdaily.php?web=$type&month=$month&year=$year&deyt=$enum'>$negtopos_total</a></b></span></td>";
	} else { $postoneg_total = number_format((0-$results[0]),2);
	echo "<td align='center' style='border:solid 1px #000000' ><span class='bn13text'>&nbsp;<b><a href='viewbmdaily.php?web=$type&month=$month&year=$year&deyt=$enum'><font color='red'>$postoneg_total</font></a></b></span></td>";
	}
echo "</tr>"; }
//else
//echo "<td align='center' style='border:solid 1px #000000' ><span class='bn13text'>&nbsp;<b>0.00</b></span></td>";


}
/*while ($row = mysql_fetch_array($getvalues)) 
	{
$entriesdate = $row[2];
$memberid=$row[0];
$amount=$row[1];
$ref = $row[3];
		echo "<form name='updaterecords' method='GET'><td align='center' style='border:solid 1px #000000' >
		<input type='hidden' id='action' name='action' value='save'>
		<input type='hidden' id='ref' name='ref' value='$ref'>
		<input type='hidden' id='code' name='code' value='$code'>
		<input type='hidden' id='web' name='web' value='$type'>		
		<input type='hidden' id='month' name='month' value='$month'>
		<input type='hidden' id='year' name='year' value='$year'>
		<input type='hidden' id='eamount' name='eamount' value='$amount'>
		<input type='hidden' id='memberid' name='memberid' value='$memberid'>		
		<span class='bn13text'>&nbsp;<b>$memberid</b></span></td>";
	echo "<td align='center' style='border:solid 1px #000000' ><span class='bn13text'>&nbsp;<b>$entriesdate</b></span></td>";
   echo "<td align='center' style='border:solid 1px #000000' ><span class='bn13text'>&nbsp;<b>$type</b>&nbsp;</span></td>";
	if($action=='edit' && $ref==$getref){echo "<td align='center' style='border:solid 1px #000000'><input type='text' id='eamount' name='eamount' size='8' maxlength='10' value='$amount'></td>";}
	else {	
   echo "<td align='center' style='border:solid 1px #000000' ><span class='bn13text'>&nbsp;<b>$amount</b>&nbsp;</span></td>"; }
   if(($action=='edit')&&($id==$serialno)){echo "<td align='center'><a href='viewbmdaily.php?code=$code&web=$type&month=$month&year=$year' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;
   <input type='image' src='images/save.gif' title='Save' name='update' ALT='Submit Form'></td>";}
else{
   echo "<td align='center' style='border:solid 1px #000000'><a href='viewbmdaily.php?action=edit&ref=$ref&code=$code&web=$type&month=$month&year=$year' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a></td>"; }*/
	
	//}
	?>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>