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
<script type="text/javascript">
function up(o){o.value=o.value.toUpperCase().replace(/([^0-9A-Z])/g,"");}
function numeric(o){
	if (isNaN(o.value)) {
		alert("Contacts  should only be Numeric");
		o.focus();
		return false;
	}
		if (o.value!="") {
	if (o.value.length<8) {
		alert("Contacts should be 8 characters");
		o.focus();
		return false;
	}
		}
}
</script>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr><td align="center" colspan="3"><span class="bn13text">View Member</span></td></tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
  	<?php
    $action=$_GET[action];
	if($action==NULL){$action=$_POST[action];}
	$memberid=$_POST[memberid];
	$managerid=$_POST[managerid];
	$password=$_POST[password];
	$name=$_POST[name];
	$bankaccount=$_POST[bankaccount];
	$contact1=$_POST[contact1];
	$main=$_POST[main];
	$remarks=$_POST[remarks];
	$contact2=$_POST[contact2];
	$datetime=date("Y-m-d H:i:s");
	if($main=='1'){$membercontact1tick=$datetime;}
	elseif($main=='2'){$membercontact2tick=$datetime;}
	else{$membercontact1tick='0000-00-00 00:00:00';
	$membercontact2tick='0000-00-00 00:00:00';}
	
	switch($action){
		case "Submit":
		if(($memberid==NULL)||($password==NULL))
		{echo "<SCRIPT language=\"JavaScript\">alert('Error Member ID or Password is a Must!');</SCRIPT>";
		$action='add';}
		else
		{mysql_query("INSERT INTO memberid (no, memberid, password, status, managerid, membername, membercontact1, membercontact1tick, membercontact2, membercontact2tick, bankaccount, remarks, sms, datetime) VALUES('', '$memberid', '$password', '1', '$managerid', '$name', '$contact1', '$membercontact1tick', '$contact2', '$membercontact2tick', '$bankaccount', '$remarks', '$main', '$datetime')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('New Member Added!');</SCRIPT>";}
		break;
		}
	if($action=='add'){
	echo "<form action='viewmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='60%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' valign='top'><span class='bn13text'>Member ID&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='memberid' size='15' maxlength='12' value='$memberid' onBlur='up(this);'>&nbsp;<select name='managerid'>";
	$manageridsql=mysql_query("SELECT DISTINCT managerid FROM mamagerid ORDER BY managerid ASC");
	$manageridrow=mysql_num_rows($manageridsql);
	if($managerid!=NULL){echo"<option value='$managerid'>$managerid</option>";}
		for($count=0; $count<$manageridrow; $count++)
		{$data=mysql_result($manageridsql,$count,"managerid");
		if($managerid!=$data){echo"<option value='$data'>$data</option>";}}
	  echo "</select></td><td align='right' valign='top'><span class='bn13text'>Password&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='password' name='password' size='15' maxlength='15'><td align='right' valign='top'></td>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Name&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='name' size='15' maxlength='12' value='$name'><td align='right' valign='top'><span class='bn13text'>Bank Account&nbsp;</span></td></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Contact1&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='15' value='$contact1' onBlur='numeric(this)'>&nbsp;";
	if($main=='2'){echo"<span class='bn13text'>Main<select name='main'><option value='2'>2</option><option value='1'>1</option></select></span>";}
	else{echo"<span class='bn13text'>Main<select name='main'><option value='1'>1</option><option value='2'>2</option></select></span>";}
	echo"</td><td align='right' valign='top'><span class='bn13text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Contact2&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='15' value='$contact2' onBlur='numeric(this)'></td><td align='center' valign='top' colspan='3'></td></tr>";
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Submit' title='Add New Member'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewmember.php'\" title='Cancel New Member'></td></tr></form>";
  echo"<tr><td height='10' colspan='4'></td></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	
	if($action=='edit'){
	$memberid=$_GET[memberid];
	$memberlist=mysql_query("SELECT managerid,membername,membercontact1,bankaccount,remarks,sms,membercontact2 FROM memberid where memberid = '$memberid'");
	while ($row_memberlist = mysql_fetch_array($memberlist)) 
	{
		$managerid = $row_memberlist[0];
		$name = $row_memberlist[1];
		$contact1 = $row_memberlist[2];
		$sms = $row_memberlist[5];
		$contact2 = $row_memberlist[6];
		$bankaccount = $row_memberlist[3];
		$remarks = $row_memberlist[4];
	}
	
	echo "<form action='viewmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='60%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' valign='top'><span class='bn13text'>Member ID&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='memberid' size='15' maxlength='12' value='$memberid' readonly='true'>&nbsp;<select name='managerid'>";
	$manageridsql=mysql_query("SELECT DISTINCT managerid FROM mamagerid ORDER BY managerid ASC");
	$manageridrow=mysql_num_rows($manageridsql);
	if($managerid!=NULL){echo"<option value='$managerid'>$managerid</option>";}
		for($count=0; $count<$manageridrow; $count++)
		{$data=mysql_result($manageridsql,$count,"managerid");
		if($managerid!=$data){echo"<option value='$data'>$data</option>";}
		else if ($managerid==$data) {
		echo"<option value='$data' selected='selected'>$data</option>";	}}
	  echo "</select></td>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Name&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='name' size='15' maxlength='12' value='$name'><td align='right' valign='top'><span class='bn13text'>Bank Account&nbsp;</span></td></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Contact1&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='8' value='$contact1' onBlur='numeric(this)'>&nbsp;";
	if($main=='2'){echo"<span class='bn13text'>Main<select name='main'><option value='2' selected='selected'>2</option><option value='1'>1</option></select></span>";}
	else{echo"<span class='bn13text'>Main<select name='main'><option value='1' selected='selected'>1</option><option value='2'>2</option></select></span>";}
	echo"</td><td align='right' valign='top'><span class='bn13text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Contact2&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='8' value='$contact2' onBlur='numeric(this)'></td><td align='center' valign='top' colspan='3'></td></tr>";
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Update' title='Edit Member'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewmember.php'\" title='Cancel New Member'></td></tr></form>";
  echo"<tr><td height='10' colspan='4'></td></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	
	if($action=='Update'){
	mysql_query("update memberid set membername='$name',membercontact1='$contact1',sms='$main',membercontact1='$contact2',bankaccount='$bankaccount',remarks='$remarks',managerid='$managerid' where memberid = '$memberid'") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('Member Updated!');</SCRIPT>";
		$action='add';
		// 	break;
	}
	
	else
	{echo"<tr><td align='left'><a href='viewmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewmember.php.php' method='post' style='margin-bottom:0;'><select name='action' onchange='this.form.submit()'><option>ALL</option><option value='1'>Active</option><option value='0'>Inactive</option></select></form></td></tr>";}

	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr ><td align="center"><span class="bn13text">#</span></td><td align="center"><span class="bn13text">Member ID</span></td><td align="center"><span class="bn13text">Password</span></td><td align="center"><span class="bn13text">Status</span></td><td align="center"><span class="bn13text">Mobile</span></td>
	<td align="center"><span class="bn13text">Name</span></td><td align="center"><span class="bn13text">Mobile</span></td><td align="center"><span class="bn13text">SMS</span></td><td align="center"><span class="bn13text">Bank Account</span></td><td align="center"><span class="bn13text">Remarks</span></td><td align="center"><span class="bn13text">MD</span></td>
	<td align="center"><span class="bn13text">Action</span></td></tr>
<?php
	$action=$_POST[action];
	$memberidsql=mysql_query("SELECT * FROM memberid ORDER BY datetime DESC");
	$memberidrow=mysql_num_rows($memberidsql);
	for($count=0; $count<$memberidrow; $count++)
	{echo "<tr>";
	$serial++;
	echo "<td align='center'><span class='bn13text'>$serial</span></td>";
	$memberid=mysql_result($memberidsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	echo "<td align='center'><span class='bn13text'>****</span></td>";
	$data=mysql_result($memberidsql,$count,"status");
		if($data){echo "<td align='center'><span class='bn12text'><input type='text' size='5' value='Active' disabled='disabled'/></span></td>";}
		else{echo "<td align='center'><span class='bn12text'><input type='text' size='5' value='Inactive' disabled='disabled'/></span></td>";}
			$data=mysql_result($memberidsql,$count,"sms");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";

	$data=mysql_result($memberidsql,$count,"membername");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	$mobile=mysql_result($memberidsql,$count,"sms");
	if($mobile=='1'){$data=mysql_result($memberidsql,$count,"membercontact1");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	else{$data=mysql_result($memberidsql,$count,"membercontact2");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	if($mobile=='1'){
		$data=mysql_result($memberidsql,$count,"membercontact1tick"); 
		if($data=='0000-00-00 00:00:00'){echo "<td align='center'><input type='checkbox' disabled='disabled'/></td>";}
		else{echo "<td align='center'><input type='checkbox' checked='checked' disabled='disabled'/></td>";}}
	else{
		$data=mysql_result($memberidsql,$count,"membercontact2tick"); 
		if($data=='0000-00-00 00:00:00'){echo "<td align='center'><input type='checkbox' disabled='disabled'/></td>";}
		else{echo "<td align='center'><input type='checkbox' checked='checked' disabled='disabled'/></td>";}}	
	$data=mysql_result($memberidsql,$count,"bankaccount");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	$data=mysql_result($memberidsql,$count,"remarks");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
		$data=mysql_result($memberidsql,$count,"managerid");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	echo "<td align='center'><a href='viewmember.php?action=edit&memberid=$memberid' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a>&nbsp;&nbsp;<a href='viewmember.php?action=delete&id=$serialno' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></td>";
	echo "</tr>";}
	?>
</table>
</body>
</html>