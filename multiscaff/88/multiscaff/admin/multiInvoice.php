<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

//preparing to insert the info from the top bar
$datetime = $_POST['datetime'];
//echo $datetime . "<br>";
$sabog =(explode("/",$datetime));
$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
//echo $converted_datetime . "<br>";

$trans_type = $_POST['trans_type'];
$mainRemark = $_POST['mainRemark'];
$TotalAmt = $_POST['TotalAmt'];
$compaccnt = $_POST['compaccnt'];
$currency = $_POST['currency'];
$webdatetime=date("Y-m-d H:i:s");

/*//-=-= random ref_number
$code=md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
$pageref = substr($code,0,5);

		// insert into the submission_details
		$insert = "insert into submission_details values('','$datetime','$trans_type','$mainRemark','$TotalAmt','$webdatetime','$pageref')";
		mysql_query($insert);
		
		// get refno		
		$query_refno = mysql_query("SELECT refno FROM submission_details WHERE pageref='$pageref'");
		$temp_refno = mysql_fetch_array($query_refno);
		$temprefno = $temp_refno[0];*/

function DoesItExist($expression) {
	$sqlquery = "SELECT COUNT(*) FROM memberid WHERE " . $expression . " UNION SELECT COUNT(*) FROM submembers WHERE " . $expression . "  LIMIT 1";
	$r=mysql_fetch_row(mysql_query($sqlquery));
	return ($r[0] >= 1);
}
		
for ($i = 1; $i <= 60; $i++) 
{

	if ($_POST['ID'.$i]<>"" && DoesItExist("memberid = '".$_POST['ID'.$i]."'")) {
		// values inside the form
		$ID = $_POST['ID'.$i]; // ID
		$eTypeAcc = $_POST['eTypeAcc'.$i]; // eTypeAcc
		$WL = $_POST['WL'.$i]; // WL
		$remarks = $_POST['remarks'.$i]; //remarks

		if ($_POST['transaction']=="wlplaceout") {
		// insert into the bmdatabase_invoice
		$insert2 = "insert into bmdatabase_wlplaceout values('','$converted_datetime','$ID','$eTypeAcc','TKT','$currency','$WL','$weblogin','$webdatetime','$remarks','','')";
		mysql_query($insert2);
	
		//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$ID'),(select memberid from memberid where memberid='$ID'),(select memberid from submembers where subid='$ID')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		$updatetotal = "update member_total set total=total+'$WL', outstanding=outstanding+'$WL' where memberid='$maimmem'";
		mysql_query($updatetotal);
		}
		else if ($_POST['transaction']=="payment") {
		// insert into the bmdatabase_invoice
	$insert2 = "insert into bmdatabase_payment values('','$converted_datetime','$ID','$eTypeAcc','TRS','$currency','$WL','$weblogin','$webdatetime','$remarks','','','')";
		mysql_query($insert2); 
		//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$ID'),(select memberid from memberid where memberid='$ID'),(select memberid from submembers where subid='$ID')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		mysql_query($getmainmember);
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		$updatetotal = "update member_total set total=total+'$WL', outstanding=outstanding+'$WL' where memberid='$maimmem'";
		mysql_query($updatetotal);
		}
		}
	}	
if ($_POST['transaction']=="wlplaceout") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Invoice!'); window.location = 'wlplaceout.php';</SCRIPT>"; }
else if ($_POST['transaction']=="payment") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Payment!'); window.location = 'payment.php';</SCRIPT>";
}

?>