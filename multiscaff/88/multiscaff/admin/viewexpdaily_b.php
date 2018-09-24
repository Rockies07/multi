<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php
$code=$_GET["code"];
$type=$_GET["web"];
$month=$_GET["month"];
$year=$_GET["year"];
if ($_SESSION["link2x"]=="")
$_SESSION["link2x"] = "viewexpdaily_b.php?web=$type&month=$month&year=$year";
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
	$update_amount = "update bmexpenses set  amount='$eamount' where cpyaccount = '$cpyaccount' and ref = '$getref'";
	mysql_query($update_amount);
	echo "<script>alert('Successfully Updated Expenses.')</script>";
}
?>
<html>
<head><title>Main Announcement</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="css/BreadCrumb.css" type="text/css">
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script src="js/jquery.easing.1.3.js" type="text/javascript" language="JavaScript"></script>
<script src="js/jquery.jBreadCrumb.1.1.js" type="text/javascript" language="JavaScript"></script>
        <script type="text/javascript">
            jQuery(document).ready(function()
            {
                jQuery("#breadCrumb").jBreadCrumb();
            })
        </script>
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">View Expenses Daily</span></td>
	</tr>
</table>
<div id="breadCrumb" class="breadCrumb module">
                    <ul>
                        <li>
                            <a href="viewexpyear.php" style="text-decoration:none; color:#FFFFFF;"><b>Home</b></a>
                        </li>
                     	 <li>
                            <a href="<?php echo $_SESSION["link1x"]; ?>" style="text-decoration:none; color:#FFFFFF;"><b>View Expenses Monthly</b></a>
                        </li>
							 <li>
                            <b>View Expenses By Date</b>
                        </li>
                    </ul>
</div><br><br><br>
   <table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
<tr>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Date</b></span></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
</tr><tr>
    <?php

for($x=1;$x<=$vilang;$x++) {
	if ($x<10) 
		$enum = $year . "-" . $month . "-" . "0" . $x;
	else
		$enum = $year . "-" . $month . "-" .$x;
$getvalues=mysql_query("select sum(amount) from bmexpenses where bmdate='$enum' and cpyaccount='$type' order by entriesdate asc");
//echo "select sum(amount) from bmexpenses where bmdate='$enum' and cpyaccount='$type' order by entriesdate asc";
$results = mysql_fetch_array($getvalues);
//echo $results[0] . "<br>";


//if ($results[0]<>0 && $results[0]<>"0" && $results[0]<>" ") {
//echo $results[0]; 
if ($results[0]<>"" || $results[0]=="0.00") {
echo "<tr>";
echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$enum</b></span></td>";
	if ($results[0]<0) { $negtopos_total = number_format(abs($results[0]),2);
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a href='viewexpdaily.php?web=$type&month=$month&year=$year&deyt=$enum'><font color='blue'>$negtopos_total</font></a></b></span></td>";
	} else { $postoneg_total = number_format((0-$results[0]),2);
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a href='viewexpdaily.php?web=$type&month=$month&year=$year&deyt=$enum'><font color='red'>$postoneg_total</font></a></b></span></td>";
	}
echo "</tr>"; }
//else
//echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>0.00</b></span></td>";


}
/*while ($row = mysql_fetch_array($getvalues)) 
	{
$entriesdate = $row[2];
$memberid=$row[0];
$amount=$row[1];
$ref = $row[3];
		echo "<form name='updaterecords' method='GET'><td align='center'  >
		<input type='hidden' id='action' name='action' value='save'>
		<input type='hidden' id='ref' name='ref' value='$ref'>
		<input type='hidden' id='code' name='code' value='$code'>
		<input type='hidden' id='web' name='web' value='$type'>		
		<input type='hidden' id='month' name='month' value='$month'>
		<input type='hidden' id='year' name='year' value='$year'>
		<input type='hidden' id='eamount' name='eamount' value='$amount'>
		<input type='hidden' id='memberid' name='memberid' value='$memberid'>		
		<span class='bn13text'>&nbsp;<b>$memberid</b></span></td>";
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$entriesdate</b></span></td>";
   echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$type</b>&nbsp;</span></td>";
	if($action=='edit' && $ref==$getref){echo "<td align='center' ><input type='text' id='eamount' name='eamount' size='8' maxlength='10' value='$amount'></td>";}
	else {	
   echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$amount</b>&nbsp;</span></td>"; }
   if(($action=='edit')&&($id==$serialno)){echo "<td align='center'><a href='viewexpdaily.php?code=$code&web=$type&month=$month&year=$year' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;
   <input type='image' src='images/save.gif' title='Save' name='update' ALT='Submit Form'></td>";}
else{
   echo "<td align='center' ><a href='viewexpdaily.php?action=edit&ref=$ref&code=$code&web=$type&month=$month&year=$year' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a></td>"; }*/
	
	//}
	?>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>