<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
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

/*function DoesItExist($expression) {
	$sqlquery = "SELECT COUNT(*) FROM memberid WHERE " . $expression . " UNION SELECT COUNT(*) FROM submembers WHERE " . $expression . "  LIMIT 1";
	$r=mysql_fetch_row(mysql_query($sqlquery));
	return ($r[0] >= 1);
}*/
	
for ($i = 1; $i <= 30; $i++) 
{

//$sqlquery = "SELECT COUNT(*) FROM memberid WHERE memberid = '".$_POST['ID'.$i]."' UNION SELECT COUNT(*) FROM submembers WHERE subid = '".$_POST['ID'.$i]."' LIMIT 1";
//$sqlquery = "SELECT COUNT(*)+(SELECT COUNT(*) FROM submembers WHERE subid = '".$_POST['ID'.$i]."') FROM memberid WHERE memberid = '".$_POST['ID'.$i]."'";
//$sqlquery = "SELECT COUNT(*)+(SELECT COUNT(*) FROM submembers WHERE subid = '".$_POST['ID'.$i]."') FROM memberid WHERE memberid = '".$_POST['ID'.$i]."'";
$r=mysql_fetch_row(mysql_query($sqlquery));

	//if ($_POST['ID'.$i]<>"" && $r[0]<>"0") {
	//if ($_POST['ID'.$i]<>"" && $r[0]<>"0") {
	//if ($_POST['ID'.$i]<>"") {
		// values inside the form
		
		
		$projdate=$_POST['projdate'.$i];
		$sabog =(explode("/",$projdate));
		$converted_projdate = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
		
		$ProjectType=$_POST['ProjectType'.$i];
		$Voucher=$_POST['Voucher'.$i];
		$description=$_POST['description'.$i];
		$Outgoing=$_POST['Outgoing'.$i];
		$Incoming=$_POST['Incoming'.$i];
		$PaymentMode=$_POST['PaymentMode'.$i];
		$remarks=$_POST['remarks'.$i];
		
		if ($description<>'') {
		//-=-=-= insert into transactions
mysql_query("insert into transactions values('','$converted_projdate','$ProjectType','$Voucher','$description','$Outgoing','$Incoming','$PaymentMode','$remarks','$weblogin','$webdatetime','0')");
		}
		/*
		$ID = $_POST['ID'.$i]; // ID
		$eTypeAcc = $_POST['eTypeAcc'.$i]; // eTypeAcc
		$WL = $_POST['WL'.$i]; // WL
		$remarks = $_POST['remarks'.$i]; //remarks

		if ($_POST['transaction']=="wlplaceout") {
	$insert2 = "insert into bmdatabase_wlplaceout values('','$converted_datetime','$ID','$eTypeAcc','TKT','$currency','$WL',UCASE('$weblogin'),'$webdatetime','$remarks','','')";
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
	$insert2 = "insert into bmdatabase_payment values('','$converted_datetime','$ID','$eTypeAcc','TRS','$currency','$WL',UCASE('$weblogin'),'$webdatetime','$remarks','','','')";
		//echo $insert2;
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
		}*/
	//}	
/*if ($_POST['transaction']=="wlplaceout") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved W/L Placeout!'); window.location = 'wlplaceout.php';</SCRIPT>"; }
else if ($_POST['transaction']=="payment") {
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Payment!'); window.location = 'payment.php';</SCRIPT>";*/
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Transaction!'); window.location = 'project_exp.php';</SCRIPT>";
}

?>