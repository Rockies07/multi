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
$projcode=$_POST[projcode];
/*$subcode=$_POST[subcode];
$bmname=$_POST[bmname];*/
$datetime=date("Y-m-d H:i:s");
		switch($action){
		case "Save":
		//	if(($projcode)&&($subcode)&&($bmname))
			if(($projcode))
				{
				$projcodesql=mysql_query("SELECT projcode FROM projects WHERE projcode='$projcode'");
				$projcodesqlrow=mysql_num_rows($projcodesql);
					if($projcodesqlrow){echo "<SCRIPT language=\"JavaScript\">alert('Type Exists!');</SCRIPT>";$action='Add';}
					else{mysql_query("INSERT INTO projects (no, projcode, status) VALUES('','$projcode','$datetime')")or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('Project Code Entry Accepted!');</SCRIPT>";}}
			else{echo "<SCRIPT language=\"JavaScript\">alert('Make Sure All Fields Are Entered!');</SCRIPT>";
			$action='Add';}
		break;
		/*case "Delete":
			mysql_query("DELETE FROM projcode WHERE no = '$row'");
			echo "<SCRIPT language=\"JavaScript\">alert('Bookmaker Deleted!');</SCRIPT>";
		break;*/
		/*case "Status":
			$statussql=mysql_query("SELECT status FROM projcode WHERE no='$row'");
			$data=mysql_result($statussql,0,"status");
			if($data=='0000-00-00 00:00:00'){mysql_query("UPDATE projcode SET status='$datetime' WHERE no = '$row'");}
			else{mysql_query("UPDATE projcode SET status='0000-00-00 00:00:00' WHERE no = '$row'");}
		break;*/
		}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">View Investment Type<br><br>
<?php echo "1. Max 8 alphanumeric characters<br>2. Project Code cannot be deleted.<br>3. You cannot rename the Project Code<br>"; ?>
  </span></td>
	</tr>
    <?php
    if($action=='Add'){
	echo"<tr><td align='center'>";
	echo"<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center'>";
	echo"<tr><td height='10' colspan='3'></td></tr><form action='viewinvestmenttype.php' method='post'>";
	echo"<tr><td align='right'><span class='bn13text'>Project Code</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='8' size='15' name='projcode' value='$projcode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	/*echo"<tr><td align='right'><span class='bn13text'>Type</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='subcode' value='$subcode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='right'><span class='bn13text'>Name</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='bmname' value='$bmname'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='center' colspan='3'><input type='reset' value='Reset' alt='Reset'>&nbsp;&nbsp;";
	*/
	echo"<tr><td align='center' colspan='3'><input type='button' value='Cancel' onClick=\"window.location.href='viewinvestmenttype.php'\">&nbsp;&nbsp;<input type='submit' value='Save' name='action' alt='Save'></td></tr>";	
	echo"</form><tr><td height='10' colspan='3'></td></tr>";
	echo"</table>";
	echo"</td></tr>";}
	else{echo"<tr><td align='center'><br><a href='viewinvestmenttype.php?action=Add'><img src='images/new.jpg' border='0'></a></td></tr><br>";}
	?>
</table><br>
<table cellpadding="0" cellspacing="0" width="20%" align="center" class="stats">
<tr ">
    <td align="center"  width="5%" class="hed"><span class="bn13text">&nbsp;<b>#</b>&nbsp;</span></td>
    <td align="center" class="hed"><span class="bn13text">&nbsp;<b>Project Code</b>&nbsp;</span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT * FROM projects");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{echo"<tr>";
	$serial++;
	$row=mysql_result($bmsql,$count,"no");
	echo "<td align='center'><span class='bn13text'>$serial</span></td>";
	$data=mysql_result($bmsql,$count,"projcode");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	echo "</form></td></tr>";}
	?>
	
</body>
</html>