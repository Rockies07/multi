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
$action=$_GET[action];
if($action==NULL){$action=$_POST[action];}
$row=$_GET[row];
$paymentmode=$_POST[paymentmode];
/*$subcode=$_POST[subcode];
$bmname=$_POST[bmname];*/
$datetime=date("Y-m-d H:i:s");
		switch($action){
		case "Save":
		//	if(($paymentmode)&&($subcode)&&($bmname))
			if(($paymentmode))
				{
				$paymentmodesql=mysql_query("SELECT paymentmode FROM projects WHERE paymentmode='$paymentmode'");
				$paymentmodesqlrow=mysql_num_rows($paymentmodesql);
					if($paymentmodesqlrow){echo "<SCRIPT language=\"JavaScript\">alert('Type Exists!');</SCRIPT>";$action='Add';}
					else{mysql_query("INSERT INTO paymentmode (no, paymentmode, status) VALUES('','$paymentmode','$datetime')")or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('Project Mode Entry Accepted!');</SCRIPT>";}}
			else{echo "<SCRIPT language=\"JavaScript\">alert('Make Sure All Fields Are Entered!');</SCRIPT>";
			$action='Add';}
		break;
		/*case "Delete":
			mysql_query("DELETE FROM paymentmode WHERE no = '$row'");
			echo "<SCRIPT language=\"JavaScript\">alert('Bookmaker Deleted!');</SCRIPT>";
		break;*/
		/*case "Status":
			$statussql=mysql_query("SELECT status FROM paymentmode WHERE no='$row'");
			$data=mysql_result($statussql,0,"status");
			if($data=='0000-00-00 00:00:00'){mysql_query("UPDATE paymentmode SET status='$datetime' WHERE no = '$row'");}
			else{mysql_query("UPDATE paymentmode SET status='0000-00-00 00:00:00' WHERE no = '$row'");}
		break;*/
		}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">View Payment Mode <br>
	      <br>
<?php //echo "1. Max 8 alphanumeric characters<br>2. Project Code cannot be deleted.<br>3. You cannot rename the Project Code<br>"; ?>
  </span></td>
	</tr>
    <?php
    if($action=='Add'){
	echo"<tr><td align='center'>";
	echo"<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center'>";
	echo"<tr><td height='10' colspan='3'></td></tr><form action='paymentmode.php' method='post'>";
	echo"<tr><td align='right'><span class='bn13text'>Payment Mode</span></td><td width='15' align='center'><span class='bn13text'></span></td><td align='left'><input type='text' maxlength='8' size='15' name='paymentmode' value='$paymentmode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='center' colspan='3'><input type='button' value='Cancel' onClick=\"window.location.href='paymentmode.php'\">&nbsp;&nbsp;<input type='submit' value='Save' name='action' alt='Save'></td></tr>";	
	echo"</form><tr><td height='10' colspan='3'></td></tr>";
	echo"</table>";
	echo"</td></tr>";}
	else{echo"<tr><td align='center'><br><a href='paymentmode.php?action=Add'><img src='images/new.jpg' border='0'></a></td></tr><br>";}
	?>
</table><br>
<table cellpadding="0" cellspacing="0" width="20%" align="center" class="stats">
<tr>
    <td align="center"  width="5%" class="hed"><span class="bn13text">&nbsp;<b>#</b>&nbsp;</span></td>
    <td align="center" class="hed"><span class="bn13text">&nbsp;<b>Project Code</b>&nbsp;</span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT * FROM paymentmode");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{echo"<tr>";
	$serial++;
	$row=mysql_result($bmsql,$count,"no");
	echo "<td align='center'><span class='bn13text'>$serial</span></td>";
	$data=mysql_result($bmsql,$count,"paymentmode");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	echo "</form></td></tr>";}
	?>
	
</body>
</html>