<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM clone_user WHERE username='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php
$action=$_GET[action];
if($action==NULL){$action=$_POST[action];}
//echo $action;
$numbah=$_POST[no];
//echo $numbah;
$annoumcement=$_POST[annoumcement];
$annoumcement = htmlentities($annoumcement);
$webdatetime=date("Y-m-d H:i:s");
		switch($action){
		case "added":
		if($annoumcement){
			//if ($action=='add') {
		mysql_query("INSERT INTO announcement (no, msgdescription, entriesby, entriesdate) VALUES('','$annoumcement','$weblogin','$webdatetime')")or die(mysql_error());
		echo "<SCRIPT language=\"Javascript\">alert('Announcement Created!');</SCRIPT>";
		//	}
		//	if ($action=='Update') {
		
		//	}
				}else{
		echo "<SCRIPT language=\"JavaScript\">alert('Announcement cannot be empty!');</SCRIPT>";}
		break;
		
		case "Update":
			mysql_query("Update announcement set msgdescription='$annoumcement', entriesdate='$webdatetime' where no='$numbah'")or die(mysql_error());
			//echo "Update announcement set msgdescription='$annoumcement', entriesdate='$webdatetime' where no='$numbah'";
			echo "<SCRIPT language=\"Javascript\">alert('Announcement Updated!');</SCRIPT>";
			break;
		case "delete":
		if($_POST[deleteall]=='delete')
		{mysql_query("TRUNCATE TABLE announcement");
		echo "<SCRIPT language=\"JavaScript\">alert('ALL Announcement Deleted!');</SCRIPT>";}
		else{
		$annoumcementsql=mysql_query("SELECT * FROM announcement ORDER BY entriesdate DESC");
		$annoumcementrow=mysql_num_rows($annoumcementsql);
		for($count=0; $count<$annoumcementrow; $count++)
		{$no=$_POST[$count];
		mysql_query("DELETE FROM announcement WHERE no = '$no'");}
		echo "<SCRIPT language=\"JavaScript\">alert('Announcement Deleted!');</SCRIPT>";}
		break;}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<SCRIPT LANGUAGE="JavaScript">
function Check(chk)
{
	if(document.announce.deleteall.checked==true){
	for (i = 0; i < chk.length; i++)
	chk[i].checked = true ;
	}else{
	
	for (i = 0; i < chk.length; i++)
	chk[i].checked = false ;
	}
}
</script>
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr><td align="center" colspan="3"><span class="bn13text">Announcement</span></td></tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
<?php
if($action=='add')
    {$datetime=date("D d-m-Y");
	echo"<tr><td align='center'>
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>
	<tr><td height='10' colspan='3'></td></tr>
	<tr><td width='15%' align='right' valign='top'><span class='bn13text'>Date&nbsp;</span></td><td width='5%' align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' value='$datetime' size='15' disabled></td></tr>
	<form action='announcement.php?action=added' method='post' name='announce'><tr><td align='right' valign='top'><span class='bn13text'>Message&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td><textarea name='annoumcement' cols='40' rows='5'></textarea><span class='bn12text'>&nbsp;(250 Max)</span></td></tr>
	<tr><td colspan='3' align='center'><input type='submit' value='Submit'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='announcement.php'\"></td></tr></form>
	<tr><td height='10' colspan='3'></td></tr>
	</table>
	</td></tr>";
	echo "<tr><td height='5' colspan='3'></td></tr>";}
else if ($action=='edit'){
	$message=$_GET[message];
	$numby=$_GET[no];
//	echo $numby;
	$datetime=date("D d-m-Y");
	echo"<tr><td align='center'>
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>
	<tr><td height='10' colspan='3'></td></tr>
	<tr><td width='15%' align='right' valign='top'><span class='bn13text'>Date&nbsp;</span></td><td width='5%' align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' value='$datetime' size='15' disabled></td></tr>
	<form action='announcement.php?action=Update' method='post' name='announce'><tr><td align='right' valign='top'>
	<input type='hidden' id='no' name='no' value='$numby'/>
	<span class='bn13text'>Message&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td><textarea name='annoumcement' cols='40' rows='5'>$message</textarea><span class='bn12text'>&nbsp;(250 Max)</span></td></tr>
	<tr><td colspan='3' align='center'><input type='submit' value='Update'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='announcement.php'\"></td></tr></form>
	<tr><td height='10' colspan='3'></td></tr>
	</table>
	</td></tr>";
	echo "<tr><td height='5' colspan='3'></td></tr>";}
	
else
	{echo"<tr><td align='left'><a href='announcement.php?action=add' title='Add New'><img src='images/new.jpg' border='0' /></a></td><td></td><td align='right'><form action='announcement.php?action=delete' method='post' style='margin-bottom:0;' name='announce'><input type='image' src='images/delete.jpg' border='0' value='Delete'></td></tr>";}
	?>
</table>

<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center" class="stats">
<tr >
    <td class="hed" width="13%" style="border:solid 1px #000000"><span class="bn13text">&nbsp;Date&nbsp;</span></td>
    <td class="hed" width="13%" style="border:solid 1px #000000"><span class="bn13text">&nbsp;Entries By&nbsp;</span></td>
    <td class="hed" style="border:solid 1px #000000"><span class="bn13text">&nbsp;Message&nbsp;</span></td>
	<td class="hed" style="border:solid 1px #000000"><span class="bn13text">&nbsp;&nbsp;Action</span></td>
    <td class="hed" width="5%" style="border:solid 1px #000000"><input type="checkbox" name="deleteall" value="delete" onClick="Check(document.announce.check_list)"></td>
</tr>
<?php
		$annoumcementsql=mysql_query("SELECT * FROM announcement ORDER BY entriesdate DESC");
		$annoumcementrow=mysql_num_rows($annoumcementsql);
		for($count=0; $count<$annoumcementrow; $count++)
		{if($count%2)
					{echo"<tr bgcolor='#dddddd'>";}
				else
					{echo"<tr>";}
		$data=mysql_result($annoumcementsql,$count,"entriesdate");
		$data=strtotime("$data");
		$data=date("D d-m-Y", $data);
		echo "<td align='center'><span class='bn12text'>$data</span></td>";
		$data=strtoupper(mysql_result($annoumcementsql,$count,"entriesby"));
		echo "<td align='center'><span class='bn12text'>$data</span></td>";
		$data=mysql_result($annoumcementsql,$count,"msgdescription");
		$number=mysql_result($annoumcementsql,$count,"no");
		echo "<td align='left'><span class='bn12text'>&nbsp;$data</span></td>";
		echo "<td align='center'><span class='bn12text'><a href='announcement.php?action=edit&no=$number&message=$data' target='_self'><img src='images/edit.gif' border='0' title='Edit'></span></td>";
		echo "<td align='center'><input type='checkbox' name='check_list' value='$number'></td>";
		echo"<tr>";}
?></form>
</table>
</body>
</html>