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
$deyt=$_GET["deyt"];
$code=$_GET["code"];
$type=$_GET["web"];
$month=$_GET["month"];
$year=$_GET["year"];
$action=$_GET["action"];
$getref=$_GET["ref"];
$eamount = $_GET["eamount"];
$cpyaccount = $_GET["cpyaccount"];
$remark = $_GET["remark"];
if ($action=="save")
{
	$update_amount = "update bmexpenses set amount='$eamount',remark='$remark' where cpyaccount = '$cpyaccount' and ref = '$getref'";
//	echo $update_amount;
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
	  <td align="center"><span class="maintitle"><b>View Expenses Daily (<?php echo $deyt; ?>)</b></span></td>
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
                            <a href="<?php echo $_SESSION["link2x"]; ?>" style="text-decoration:none; color:#FFFFFF;"><b>View Expenses By Date</b></a>
                        </li>
						</li>
							 <li>
                            <b>View Expenses Details</b>
                        </li>
                    </ul>
</div><br><br><br>
   <table border="1" cellpadding="0" cellspacing="0" width="90%" align="center" class="stats">
<tr>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Code</b>&nbsp;</span></td>
	<td class="hed" ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
	<td class="hed" ><span class="bn13text">&nbsp;<b>Remarks</b>&nbsp;</span></td>
	<td class="hed" ><span class="bn13text">&nbsp;<b>Action</b>&nbsp;</span></td>
</tr>
    <?php
/*$code=$_GET["code"];
$type=$_GET["type"];
$year=$_GET["year"];
$month=$_GET["month"];*/
if (strlen($month)==1)
$month = "0" . $month;

	$enum_from = $year . "-" . $month . "-" . "01";
	$enum_to = $year . "-" . $month . "-" . "31";
//$getvalues=mysql_query("select memberid,amount,entriesdate,ref from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$type' and entriesby='$weblogin' order by entriesdate asc");
$getvalues=mysql_query("select cpyaccount,amount,entriesdate,ref,remark from bmexpenses where bmdate='$deyt' and cpyaccount='$type' order by ref asc");


while ($row = mysql_fetch_array($getvalues)) 
	{
$entriesdate = $row[2];
$cpyaccount=$row[0];
$amount=$row[1];
$ref = $row[3];
$remark = $row[4];
		echo "<form name='updaterecords' method='GET'>
		<input type='hidden' id='action' name='action' value='save'>
		<input type='hidden' id='ref' name='ref' value='$ref'>
		<input type='hidden' id='code' name='code' value='$code'>
		<input type='hidden' id='web' name='web' value='$type'>		
		<input type='hidden' id='month' name='month' value='$month'>
		<input type='hidden' id='deyt' name='deyt' value='$deyt'>
		<input type='hidden' id='year' name='year' value='$year'>
		<input type='hidden' id='eamount' name='eamount' value='$amount'>
		<input type='hidden' id='cpyaccount' name='cpyaccount' value='$cpyaccount'>";
//	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$entriesdate</b></span></td>";
   echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$type</b>&nbsp;</span></td>";
	if($action=='edit' && $ref==$getref){
	/*	if ($amount<0) { $negtopos_total = number_format(abs($amount),2);
		echo "<td align='center' ><input type='text' id='eamount' name='eamount' size='8' maxlength='10' value='$negtopos_total'></td>";
		} else { $postoneg_total = number_format((0-$amount),2);
		echo "<td align='center' ><input type='text' id='eamount' name='eamount' size='8' maxlength='10' value='$postoneg_total'></td>";
		}*/
		echo "<td align='center' ><input type='text' id='eamount' name='eamount' size='8' maxlength='10' value='$amount'></td>";
		
	echo "<td align='center' ><input type='text' id='remark' name='remark' size='40' maxlength='35' value='$remark'></td>";}
	else {	
	/*	if ($amount<0) { $negtopos_total = number_format(abs($amount),2);
	   echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$negtopos_total</b>&nbsp;</span></td>";
	   } else { $postoneg_total = number_format((0-$amount),2);
		 echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$postoneg_total</b>&nbsp;</span></td>";
		 }*/
		 if ($amount<0)
		 echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><font color='red'>$amount</font></b>&nbsp;</span></td>";
		 else
		 echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><font color='blue'>$amount</font></b>&nbsp;</span></td>";
		 
   echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$remark</b>&nbsp;</span></td>"; }
   if(($action=='edit')&&($id==$serialno)){echo "<td align='center'><a href='viewexpdaily.php?code=$code&web=$type&month=$month&year=$year&deyt=$deyt' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;
   <input type='image' src='images/save.gif' title='Save' name='update' ALT='Submit Form'></td>";}
else{
   echo "<td align='center' ><a href='viewexpdaily.php?action=edit&ref=$ref&code=$code&web=$type&month=$month&year=$year&deyt=$deyt' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a></td>"; }
	echo "</tr></form>";
	}
	?>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>