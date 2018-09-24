<?php
//preparing to insert the info
//from the top bar

$datetime = $_POST['datetime'];
$trans_type = $_POST['trans_type'];
$selectAll = $_POST['selectAll'];
$mainRemark = $_POST['mainRemark'];
$TotalAmt = $_POST['TotalAmt'];

for ($i = 1; $i <= 60; $i++) 
{
// values inside the form
$ID = $_POST['ID'.$i]; // ID
$eTypeAcc = $_POST['eTypeAcc'.$i]; // eTypeAcc
$WL = $_POST['WL'.$i]; // WL
$remarks = $_POST['remarks'.$i]; //remarks

// insert into the table
$insert = "insert into _ values('$ID','$eTypeAcc','$WL','$remarks')";
mysql_query($insert);

echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Payment!'); window.location = "index.php";</SCRIPT>";}
}
?>