<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

//preparing to insert the info from the top bar
$datetime = $_POST['datetime'];
$trans_type = $_POST['trans_type'];
$mainRemark = $_POST['mainRemark'];
$TotalAmt = $_POST['TotalAmt'];
$compaccnt = $_POST['compaccnt'];
$currency = $_POST['currency'];
$webdatetime=date("Y-m-d H:i:s");

//-=-= random ref_number
$code=md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
$pageref = substr($code,0,5);

		// insert into the submission_details
		$insert = "insert into submission_details values('','$datetime','$trans_type','$mainRemark','$TotalAmt','$webdatetime','$pageref')";
		mysql_query($insert);
		
		// get refno		
		$query_refno = mysql_query("SELECT refno FROM submission_details WHERE pageref='$pageref'");
		$temp_refno = mysql_fetch_array($query_refno);
		$temprefno = $temp_refno[0];
		
for ($i = 1; $i <= 60; $i++) 
{

	if ($_POST['ID'.$i]<>"") {
		// values inside the form
		$ID = $_POST['ID'.$i]; // ID
		$eTypeAcc = $_POST['eTypeAcc'.$i]; // eTypeAcc
		$WL = $_POST['WL'.$i]; // WL
		$remarks = $_POST['remarks'.$i]; //remarks

		// insert into the member_submission
		$insert2 = "insert into member_submission values('$ID','$eTypeAcc','$WL','$remarks','$temprefno','$pageref')";
		mysql_query($insert2);
	}	
}
if ($_POST['transaction']=="wlplaceout") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Invoice!'); window.location = 'wlplaceout.php';</SCRIPT>"; }
else if ($_POST['transaction']=="payment") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Payment!'); window.location = 'wlplaceout.php';</SCRIPT>";
}
?>