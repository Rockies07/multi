<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	//$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
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
		
for ($i = 1; $i <= 60; $i++) 
{

	if ($_POST['ID'.$i]<>"") {
		// values inside the form
		$ID = $_POST['ID'.$i]; // ID
		$eTypeAcc = $_POST['eTypeAcc'.$i]; // eTypeAcc
		$WL = $_POST['WL'.$i]; // WL
		$remarks = $_POST['remarks'.$i]; //remarks

		if ($_POST['transaction']=="wlplaceout") {
		// insert into the bmdatabase_invoice
//	$insert2 = "insert into bmdatabase_invoice values('','$datetime','$ID','$trans_type','$eTypeAcc','$compaccnt','$currency','$WL','$weblogin','$webdatetime','','')";
	$insert2 = "insert into bmdatabase_wlplaceout values('','$converted_datetime','$ID','$eTypeAcc','TKT','$currency','$WL',UCASE('$weblogin'),'$webdatetime','$remarks','','')";
	//echo $insert2;
		mysql_query($insert2); }
		else if ($_POST['transaction']=="payment") {
		// insert into the bmdatabase_invoice
//	$insert2 = "insert into bmdatabase_payment values('','$datetime','$ID','$trans_type','$eTypeAcc','$compaccnt','$currency','$WL','$weblogin','$webdatetime','','')";
	$insert2 = "insert into bmdatabase_payment values('','$converted_datetime','$ID','$eTypeAcc','TRS','$currency','$WL',UCASE('$weblogin'),'$webdatetime','$remarks','','','')";
		//echo $insert2;
		mysql_query($insert2); }
		}
	}	
if ($_POST['transaction']=="wlplaceout") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved W/L Placeout!'); window.location = 'wlplaceout.php';</SCRIPT>"; }
else if ($_POST['transaction']=="payment") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Payment!'); window.location = 'payment.php';</SCRIPT>";
}

?>