<?php
session_start();
	
$weblogin=$_SESSION["weblogin"];
$webpassword=$_SESSION["webpassword"];	

include "include/include.php";

$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
$rights=mysql_num_rows($login);
if(!$rights){header("location:index.php");}
?>
<html>
<link rel="stylesheet" href="style.css" type="text/css" />
<script language="javascript">
function up(o){o.value=o.value.toUpperCase().replace(/([^0-9A-Z])/g,"");}
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr>
	  <td align="center" colspan="3"><span class="bn13text">View Member Sub ID</span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
  	<?php
    $action=$_GET[action];
	if($action==NULL){$action=$_POST[action];}
	$memberid=$_POST[memberid];
	$subid=$_POST[subid];
	if ($_POST[memberid]=="")
	$memberid=$_GET[memberid];
	if ($_POST[subid]=="")
	$subid=$_GET[subid];
	$datetime=date("Y-m-d H:i:s");
	$deyt=date("Y-m-d");
	
	switch($action){
		case "Submit":
		if(($subid==NULL))
		{echo "<SCRIPT language=\"JavaScript\">alert('Error Sub ID is a Must!');</SCRIPT>";
		$action='add';}
				else
				{
				$submemberidsql=mysql_query("SELECT subid FROM submembers WHERE subid='$subid'");
				$submemberidrow=mysql_num_rows($submemberidsql);
					if($submemberidrow){echo "<SCRIPT language=\"JavaScript\">alert('SubID Already Exists!');</SCRIPT>";break;}
					else {		
						mysql_query("INSERT INTO submembers (no, memberid, subid, datetime) VALUES('', '$memberid', '$subid','$datetime')") or die(mysql_error());
						echo "<SCRIPT language=\"JavaScript\">alert('New Member Sub ID Added!');</SCRIPT>";}
						
				}		
				break;
		case "delete":
		{
		mysql_query("delete from submembers where memberid='$memberid' and subid='$subid'") or die(mysql_error());
	//	echo "delete from submembers where memberid='$memberid' and subid='$subid'";
		echo "<SCRIPT language=\"JavaScript\">alert('Member Sub ID Deleted!');</SCRIPT>";
		break;
		}
		
		}
	if($action=='add'){
	echo "<form action='viewsubmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='60%' align='center' class='outline'><tr><td ></td></tr><tr><td ><span class='bn13text'>*Member Main ID</span></td><td ><span class='bn13text'>:</span></td><td><select name='memberid'>";
	$memberidsql=mysql_query("SELECT DISTINCT memberid FROM memberid ORDER BY memberid ASC");
	$memberidrow=mysql_num_rows($memberidsql);
	for($count=0; $count<$memberidrow; $count++)
		{
		$data=mysql_result($memberidsql,$count,"memberid");
		echo"<option value='$data'>$data</option>";
		}
	  echo "</select></td><td ><span class='bn13text'>*Sub ID&nbsp;</span></td><td ><span class='bn13text'>:</span></td><td align='left'><input type='text' name='subid' size='5' maxlength='4' onBlur='up(this)'><td align='right' ></td>";
	echo "<tr><td ><span class='bn13text'>Date&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><input type='text' name='datetime' size='15' maxlength='15' value='$deyt' readonly='true'></td><td align='center' valign='top' colspan='3'></td></tr>";
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Submit' title='Add New Sub ID'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewsubmember.php'\" title='Cancel New Sub ID'></td></tr></form>";
  echo"<tr></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	else
	{
	//echo"<tr><td align='left'><a href='viewsubmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewsubmember.php.php' method='post' style='margin-bottom:0;'><select name='action' onchange='this.form.submit()'><option>ALL</option><option value='1'>Active</option><option value='0'>Inactive</option></select></form></td></tr>";
	echo"<tr><td align='left'><a href='viewsubmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewsubmember.php' method='post' style='margin-bottom:0;'></form></td></tr>";
	}

	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr ><td align="center"><span class="bn13text">Member Main ID</span></td><td align="center"><span class="bn13text">Sub ID</span></td><td align="center"><span class="bn13text">Created</span></td><td align="center"><span class="bn13text">Action</span></td><td align="center"><span class="bn13text"><input type="checkbox"></span></td></tr>
<?php
	$action=$_POST[action];
	$memberidsql=mysql_query("SELECT * FROM submembers ORDER BY datetime DESC");
	$memberidrow=mysql_num_rows($memberidsql);
	for($count=0; $count<$memberidrow; $count++)
	{echo "<tr>";
	$memberid=mysql_result($memberidsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	$subid=mysql_result($memberidsql,$count,"subid");
	echo "<td align='center'><span class='bn13text'>$subid</span></td>";
	$data=mysql_result($memberidsql,$count,"datetime");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	echo "<td align='center'><span class='bn13text'><a href='viewsubmember.php?action=delete&memberid=$memberid&subid=$subid'>Delete</a></span></td>";
	echo "<td align='center'><input type='checkbox'></td>";
	echo "</tr>";}
	?>
</table>
</body>
</html>