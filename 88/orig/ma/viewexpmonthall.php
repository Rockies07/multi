<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php
$super_ref="";
//echo "Please check later, doing testing. Thanks.";
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
$getref=$_GET["refy"];
$eamount = $_GET["eamount"];
$memberid = $_GET["memberid"];
$remark = $_GET["remark"];    
$ebm  = $_GET[ebm];        
if ($action=="save")
{
	//$update_amount = "update bmdatabase_wlplaceout set amount='$eamount',remark='$remark' where memberid = '$memberid' and ref = '$getref'";
	$update_amount = "update bmexpenses set cpyaccount='$ebm', amount='$eamount',remark='$remark' where ref = '$getref'";
	//echo $update_amount . "<br>";
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
	  <td align="center"><span class="maintitle">View Expenses </span></td>
	</tr>
</table>
<div id="breadCrumb" class="breadCrumb module">
                    <ul>
                        <li>
                            <a href="viewexpyear.php" style="text-decoration:none; color:#FFFFFF;"><b>Home</b></a>
                        </li>
                     	 <li>
                            <b>View Yearly Expenses (All Accounts)</b>
                        </li>
					
                    </ul>
</div><br><br><br>
   <table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
<tr>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Date</b></span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Type</b></span></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Amount</b></span></td>
</tr><tr>
    <?php

for($x=1;$x<=$vilang;$x++) {
	if ($x<10) 
		$enum = $year . "-" . $month . "-" . "0" . $x;
	else
		$enum = $year . "-" . $month . "-" .$x;
//$getvalues=mysql_query("select sum(amount) from bmdatabase_wlplaceout where bmdate='$enum' and subbmcode='$type' and entriesby='$weblogin' order by entriesdate asc");
$getvalues=mysql_query("select sum(amount),cpyaccount,ref from bmexpenses where bmdate='$enum' group by
 cpyaccount order by entriesdate asc");
 //echo "select sum(amount),cpyaccount,ref from bmexpenses where bmdate='$enum' group by  cpyaccount order by entriesdate asc" . "<br>";
//echo "select sum(amount),subbmcode from bmdatabase_wlplaceout where bmdate='$enum' and entriesby='$weblogin' group by subbmcode order by entriesdate asc" . "<br>";
//$results = mysql_fetch_array($getvalues);
//echo $results[0] . "<br>";
while ($row = mysql_fetch_array($getvalues)) 
	{
	$ref = $row[2];
	$super_ref = $ref;
//echo "$row[0]";
//if ($row[0]<>0 && $row[0]<>"0" && $row[0]<>" ") {
echo "<tr>";
echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$enum</b></span></td>";
echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$row[1]</b></span></td>";
	if ($row[0]<0) { $negtopos_total = number_format(abs($row[0]),2);
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a name='$ref' href='viewexpmonthall.php?code=$code&web=$type&month=$month&year=$year&type=$row[1]&bmdate=$enum&action=star#$super_ref''><font color='blue'>$negtopos_total</font></a></b></span></td>";
	} else { $postoneg_total = number_format((0-$row[0]),2);
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a name='$ref' href='viewexpmonthall.php?code=$code&web=$type&month=$month&year=$year&type=$row[1]&bmdate=$enum&action=star#$super_ref''><font color='red'>$postoneg_total</font></a></b></span></td></tr>";
/*	$code=$_GET["code"];
$type=$_GET["web"];
$month=$_GET["month"];*/
	}
	//if ($_GET["action"]=="star") {
	if ($_GET["bmdate"]==$enum && $_GET["type"]==$row[1]) {
	$deyt = $_GET["bmdate"];
	$cpyaccount = $_GET["type"];
	echo "<tr><td colspan='2'>
	<form name='updaterecords' method='GET'>
	<input type='hidden' id='action' name='action' value='save'>
	<input type='hidden' id='code' name='code' value='$code'>
	<input type='hidden' id='web' name='web' value='$type'>
	<input type='hidden' id='month' name='month' value='$month'>
	<input type='hidden' id='year' name='year' value='$year'>
	<input type='hidden' id='type' name='type' value='$row[1]'>
	<input type='hidden' id='bmdate' name='bmdate' value='$enum'>
	
	<table border='0' cellpadding='0' cellspacing='0' align='right' width='400' class='stats'>";
	echo "<tr><td class='hed'  bgcolor='#888888'><span class='bn13text'>&nbsp;<b>Cpyaccount</b></span></td>";
	echo "<td class='hed'  bgcolor='#888888' ><span class='bn13text'>&nbsp;<b>Amount</b></span></td>";
	echo "<td class='hed'  bgcolor='#888888' ><span class='bn13text'>&nbsp;<b>Remark</b></span></td>";
	echo "<td class='hed'  bgcolor='#888888' ><span class='bn13text'>&nbsp;<b>Action</b></span></td></tr>";
	
	$sqlenumerate=mysql_query("select cpyaccount,amount,remark,ref from bmexpenses where bmdate='$deyt' and cpyaccount='$cpyaccount' order by ref asc");
//	echo "select memberid,amount,remark from bmdatabase_wlplaceout where bmdate='$deyt' and subbmcode='$subbmcode' order by entriesdate asc" . "<br>";
	
	while ($row_enum = mysql_fetch_array($sqlenumerate)) 
	{
	
	echo "<tr>";
	$ref=$_GET["ref"];
	//echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$row_enum[2]</b></span></td></tr>";
//	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$row_enum[2]</b></span></td></tr>";
//if($action=='edit' && $ref==$getref){
//echo "row_enum[3]: " . $row_enum[3] . "==" . "ref: " . $ref . "<br>";
 if(($action=='edit')&&($row_enum[3]==$ref)){
  echo"<td align='center'  >";
  echo "<select name='ebm'>";
  $bmsqldata=mysql_query("select cpyaccount from cpyaccount");
	$bmsqlrows=mysql_num_rows($bmsqldata);
  echo ">>$bmsqlrows";
  echo"<option value='$row_enum[0]'>$row_enum[0]</option>";
  for($iy=0; $iy<$bmsqlrows; $iy++)
  {$iddata=mysql_result($bmsqldata,$iy,"cpyaccount");
  echo"<option value='$iddata'>$iddata</option>";}
  echo "</select></td>";
	echo "<td align='center' ><input type='text' id='eamount' name='eamount' size='8' maxlength='10' value='$row_enum[1]'></td>";
	echo "<td align='center' ><input type='text' id='remark' name='remark' size='20' maxlength='20' value='$row_enum[2]'>
	<input type='hidden' id='refy' name='refy' value='$row_enum[3]'>
	</td>";
	
	}
	else {
    echo"<td align='center'  ><span class='bn13text'>&nbsp;<b>$row_enum[0]</b></span></td>";
	if ($row_enum[1]<0)
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><font color='red'>$row_enum[1]</font></b></span></td>";
	else
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><font color='blue'>$row_enum[1]</font></b></span></td>";
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$row_enum[2]</b></span></td>";
	/*if ($amount<0)
		 echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><font color='red'>$amount</font></b>&nbsp;</span></td>";
		 else
		 echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$amount</b>&nbsp;</span></td>";*/
		 }
//	echo "2row_enum[3]: " . $row_enum[3] . "==" . "ref: " . $ref . "<br>";
	 if(($action=='edit')&&($row_enum[3]==$ref)){echo "<td align='center'><a href='viewexpmonthall.php?code=$code&web=$type&month=$month&year=$year&type=$row[1]&bmdate=$enum&ref=$row_enum[3]#$super_ref' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;
		   <input type='image' src='images/save.gif' title='Save' name='update' ALT='Submit Form'></td>";}
		else{
		   echo "<td align='center' ><a href='viewexpmonthall.php?code=$code&web=$type&month=$month&year=$year&type=$row[1]&bmdate=$enum&action=edit&ref=$row_enum[3]#$super_ref' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a></td>"; }
//	echo "";
	}
	//echo "</table><td></tr>";
	echo "</table>";
	}
	$last_total = $last_total+$row[0];
 //}
	}
}
if ($last_total<0) { $negtopos_total = number_format(abs($last_total),2);
echo "<tr><td colspan='2'></td><td align='center'  ><span class='bn13text'>&nbsp;<b><font color='blue'>$negtopos_total</font></b></span></td></tr>";
} else { $postoneg_total = number_format((0-$last_total),2);
echo "<tr><td colspan='2'></td><td align='center'  ><span class='bn13text'>&nbsp;<b><font color='red'>$postoneg_total</font></b></span></td></tr>";
}
	?>
	</form>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>