<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

//validate old password
$oldpasss=mysql_query("SELECT password FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
$row = mysql_fetch_array($oldpasss);
$oldpassy=$row[0];

// on submit
if ($_POST[change] <> "")
{
//$oldpass = md5($_POST[oldpass]);
$oldpass = $_POST[oldpass];
$newpass1 = $_POST[newpass1];
$newpass2 = $_POST[newpass2];
$savepass = $newpass1;
	if ($oldpassy <> $oldpass)
	{
		echo "<SCRIPT language=\"Javascript\">alert('Old Password does not Matched!');</SCRIPT>";
	}
	else
	{
		mysql_query("update managerid set password = '$savepass' where managerid='$weblogin' and password='$webpassword'");
		//echo "update table managerid set password = '$savepass' where managerid='$weblogin' and password='$webpassword'";
		echo "<SCRIPT language=\"Javascript\">alert('Password Sucessfully Changed!'); window.location = 'changepassword.php';</SCRIPT>";
	}

}

?>
<html>
<script type="text/javascript">
function ValidateForm(thisform)
{
		if (thisform.oldpass.value==="" || thisform.oldpass.value===null) {
			alert("Old Password required!");
			thisform.oldpass.focus();
			return false;
		}
		if (thisform.newpass1.value != thisform.newpass2.value) {
			alert("Password does not Matched");
			thisform.newpass1.focus();
			return false;
		}
		if (thisform.newpass1.value==="" || thisform.newpass1.value===null) {
			alert("New Password required!");
			thisform.newpass1.focus();
			return false;
		}
		if (thisform.newpass2.value==="" || thisform.newpass2.value===null) {
			alert("Confirm Password required!");
			thisform.newpass2.focus();
			return false;
		}
}
	</script> 
<head><title>Change Password</title><link rel="stylesheet" href="style.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr>
	  <td align="center" colspan="3"><span class="bn13text">Change Password </span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
	<tr>
	<form action='<?php echo $PHP_SELF;?>' method='POST' name='change_pass' >
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>
	<tr><td height='10' colspan='3'></td></tr>
	<tr><td width='50%' align='right' valign='top'><span class='bn13text'>Old Password&nbsp;</span></td><td width='5%' align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='password'  size='15' name='oldpass' value='<?php echo $_POST[oldpass]; ?>'> </td></tr>
	<tr><td width='50%' align='right' valign='top'><span class='bn13text'>New Password&nbsp;</span></td><td width='5%' align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text'  size='15' name='newpass1'  value='<?php echo $_POST[newpass1]; ?>'> </td></tr>
	<tr><td width='50%' align='right' valign='top'><span class='bn13text'>Confirm Password&nbsp;</span></td><td width='5%' align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text'  size='15' name='newpass2'  value='<?php echo $_POST[newpass2]; ?>'></td></tr>
	
	<tr>
	  <td colspan='3' align='center'>&nbsp;</td>
	  </tr>
	<tr><td colspan='3' align='center'><input type='submit' value='Submit' name='change' onClick='return ValidateForm(change_pass);'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='chpassword.php'\"></td></tr></form>
	<tr><td height='10' colspan='3'></td></tr>
	</table>
	</tr>
</table>

</body>
</html>