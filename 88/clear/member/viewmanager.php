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
<script type="text/javascript">
function up(o){o.value=o.value.toUpperCase().replace(/([^0-9A-Z])/g,"");}
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr><td align="center" colspan="3"><span class="bn13text">View Manager</span></td></tr>
	<tr><td align="left"><a href='viewmanager.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td></tr>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr ><td align="center"><span class="bn13text">#</span></td><td align="center"><span class="bn13text">MD</span></td><td align="center"><span class="bn13text">Password</span></td><td align="center"><span class="bn13text">BM Report</span></td><td align="center"><span class="bn13text">BM Account</span></td><td align="center"><span class="bn13text">IM Report</span></td><td align="center"><span class="bn13text">IM Account</span></td><td align="center"><span class="bn13text">Status</span></td><td align="center"><span class="bn13text">Last Access</span></td><td align="center"><span class="bn13text">Access IP</span></td><td align="center"><span class="bn13text">&nbsp;</span></td><td align="center"><span class="bn13text">Action</span></td></tr>
<?php
		$action=$_GET[action];
		$managerid=$_POST[managerid];
		$password=$_POST[password];
		$bmreport=$_POST[bmreport];
		$bmaccount=$_POST[bmaccount];
		$imreport=$_POST[imreport];
		$imaccount=$_POST[imaccount];
		$status=$_POST[status];
		$datetime=date("D d-m-Y");
		$ip=$_SERVER['REMOTE_ADDR'];
		$webdatetime=date("Y-m-d H:i:s");
		$id=$_GET[id];
		
		switch($action){
		case "added":
		$addexisit=mysql_query("SELECT no FROM managerid WHERE managerid='$managerid'");
		$addexisitrow=mysql_num_rows($addexisit);
		if($addexisitrow==NULL){
		if($password){mysql_query("INSERT INTO managerid (no, managerid, password, bmreport, bmaccounting, imreport, imaccounting, status, datetime, ipaddress) VALUES('', '$managerid ', '$password', '$bmreport', '$bmaccount', '$imreport', '$imaccount', '$status', '$webdatetime', '$ip')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('Manager Added!');</SCRIPT>";}
		else{$action='add';
		echo "<SCRIPT language=\"JavaScript\">alert('Password Empty! Account Not Created!');</SCRIPT>";}}
		else{echo "<SCRIPT language=\"JavaScript\">alert('Manager Exisit!');</SCRIPT>";}
		break;
		case "delete":
		mysql_query("DELETE FROM managerid WHERE no = '$id'");
		echo "<SCRIPT language=\"JavaScript\">alert('Manager Account Deleted!');</SCRIPT>";
		break;
		case "update":
		if($password){mysql_query("UPDATE managerid SET managerid='$managerid', password='$password', bmreport='$bmreport', bmaccounting='$bmaccount', imreport='$imreport', imaccounting='$imaccount', status='$status', datetime='$webdatetime', ipaddress='$ip' WHERE no='$id'");
		echo "<SCRIPT language=\"JavaScript\">alert('Account Updated!');</SCRIPT>";}
		else{mysql_query("UPDATE managerid SET managerid='$managerid', bmreport='$bmreport', bmaccounting='$bmaccount', imreport='$imreport', imaccounting='$imaccount', status='$status', datetime='$webdatetime', ipaddress='$ip' WHERE no='$id'");
		echo "<SCRIPT language=\"JavaScript\">alert('Account Updated! Password not Changed!');</SCRIPT>";}
		break;
		}


		$manageridsql=mysql_query("SELECT * FROM managerid ORDER BY datetime DESC");
		$manageridrow=mysql_num_rows($manageridsql);
		for($count=0; $count<$manageridrow; $count++)
		{
		$serialno=mysql_result($manageridsql,$count,"no");
		if(($action=='edit')&&($id==$serialno)){echo"<form action='viewmanager.php?action=update&id=$serialno' method='post' style='margin-bottom:0;'>";}
		if($count%2)
					{echo"<tr bgcolor='#dddddd'>";}
				else
					{echo"<tr>";}
		$serial++;
		echo "<td align='center'><span class='bn12text'>$serial</span></td>";
		$data=mysql_result($manageridsql,$count,"managerid");
		if(($action=='edit')&&($id==$serialno)){echo "<td align='center'><input type='text' name='managerid' size='8' maxlength='10' value='$data' onkeyup='up(this)'></td>";}
		else{echo "<td align='center'><span class='bn12text'>$data</span></td>";}
		
		if(($action=='edit')&&($id==$serialno)){echo "<td align='center'><input type='text' name='password' size='10' maxlength='20'></td>";}
		else{echo "<td align='center'><span class='bn12text'><b>****</b></span></td>";}		
		
		$data=mysql_result($manageridsql,$count,"bmreport");
		if(($action=='edit')&&($id==$serialno)){
		if($data){echo "<td align='center'><input type='checkbox' name='bmreport' checked='checked' value='1'></td>";}
		else{echo "<td align='center'><input name='bmreport' type='checkbox' value='1'></td>";}}
		else{if($data){echo "<td align='center'><input type='checkbox' checked='checked' disabled='disabled'/></td>";}
		else{echo "<td align='center'><input type='checkbox' disabled='disabled'/></td>";}}
		
		$data=mysql_result($manageridsql,$count,"bmaccounting");
		if(($action=='edit')&&($id==$serialno)){
		if($data){echo "<td align='center'><input type='checkbox' name='bmaccount' checked='checked' value='1'></td>";}
		else{echo "<td align='center'><input name='bmaccount' type='checkbox' value='1'></td>";}}
		else{if($data){echo "<td align='center'><input type='checkbox' checked='checked' disabled='disabled'/></td>";}
		else{echo "<td align='center'><input type='checkbox' disabled='disabled'/></td>";}}
		
		$data=mysql_result($manageridsql,$count,"imreport");
		if(($action=='edit')&&($id==$serialno)){
		if($data){echo "<td align='center'><input type='checkbox' name='imreport' checked='checked' value='1'></td>";}
		else{echo "<td align='center'><input name='imreport' type='checkbox' value='1'></td>";}}
		else{if($data){echo "<td align='center'><input type='checkbox' checked='checked' disabled='disabled'/></td>";}
		else{echo "<td align='center'><input type='checkbox' disabled='disabled'/></td>";}}
		
		$data=mysql_result($manageridsql,$count,"imaccounting");
		if(($action=='edit')&&($id==$serialno)){
		if($data){echo "<td align='center'><input type='checkbox' name='imaccount' checked='checked' value='1'></td>";}
		else{echo "<td align='center'><input name='imaccount' type='checkbox' value='1'></td>";}}
		else{if($data){echo "<td align='center'><input type='checkbox' checked='checked' disabled='disabled'/></td>";}
		else{echo "<td align='center'><input type='checkbox' disabled='disabled'/></td>";}}
		
		$data=mysql_result($manageridsql,$count,"status");
		if(($action=='edit')&&($id==$serialno)){
		if($data){echo"<td align='center'><select name='status'><option value='1'>Active</option><option value='0'>Inactive</option></select></td>";}
		else{echo"<td align='center'><select name='status'><option value='0'>Inactive</option><option value='1'>Active</option></select></td>";}}
		else{
		if($data){echo "<td align='center'><span class='bn12text'><input type='text' size='5' value='Active' disabled='disabled'/></span></td>";}
		else{echo "<td align='center'><span class='bn12text'><input type='text' size='5' value='Inactive' disabled='disabled'/></span></td>";}}
		
		$data=mysql_result($manageridsql,$count,"datetime");
		$data=strtotime("$data");
		$data=date("D d-m-Y", $data);
		echo "<td align='center'><span class='bn12text'>$data</span></td>";
		
		$data=mysql_result($manageridsql,$count,"ipaddress");
		echo "<td align='center'><span class='bn12text'>$data</span></td>";		
		
		$onoff=mysql_result($manageridsql,$count,"status");
		if($onoff){echo"<td align='center'><img src='images/online.gif' border='0' title='Online'></td>";}
		else{echo"<td align='center'><img src='images/offline.gif' border='0' title='Offline'></td>";}

if(($action=='edit')&&($id==$serialno)){echo "<td align='center'><a href='viewmanager.php' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' title='Save'></td>";}
else{echo "<td align='center'><a href='viewmanager.php?action=edit&id=$serialno' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a>&nbsp;&nbsp;<a href='viewmanager.php?action=delete&id=$serialno' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></td>";}
		
		echo "</tr>";
		if(($action=='edit')&&($id==$serialno)){echo"</form>";}
		}
?>
<?php
if($action=='add'){echo "<form action='viewmanager.php?action=added' method='post'><tr><td align='center'><span class='bn13text'>#</span></td><td align='center'><input type='text' name='managerid' size='8' maxlength='10' value='$managerid' onkeyup='up(this)'/></td><td align='center'><span class='bn13text'><input type='password' name='password' size='10' maxlength='20'/></span></td><td align='center'><input name='bmreport' type='checkbox' value='1'></td><td align='center'><input name='bmaccount' type='checkbox' value='1'></td><td align='center'><input name='imreport' type='checkbox' value='1'><td align='center'><input name='imaccount' type='checkbox' value='1'></td><td align='center'>
<select name='status'>
  <option value='1'>Active</option>
  <option value='0'>Inactive</option>
</select>
</td><td align='center'><span class='bn13text'>$datetime</span></td><td align='center'><span class='bn13text'>$ip</span></td><td align='center'>
<img src='images/offline.gif' border='0' title='Offline'></td><td align='center'><a href='viewmanager.php' target='_self'><img src='images/cancel.gif' border='0' title='Cancel'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' title='Save'></td></tr></form>";}
?>
</table>
</body>
</html>