<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php
$action=$_GET[action];
if($action==NULL){$action=$_POST[action];}
$row=$_GET[row];
$bmcode=$_POST[bmcode];
$subcode=$_POST[subcode];
$bmname=$_POST[bmname];
$datetime=date("Y-m-d H:i:s");
		switch($action){
		case "Save":
			if(($bmcode)&&($subcode)&&($bmname))
				{
				$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode WHERE subbmcode='$subcode'");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
					if($bmcodesqlrow){echo "<SCRIPT language=\"JavaScript\">alert('Type Exists!');</SCRIPT>";$action='Add';}
					else{mysql_query("INSERT INTO bmcode (no, bmcode, subbmcode, bmname) VALUES('','$bmcode','$subcode','$bmname')")or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('BM Entry Accepted!');</SCRIPT>";}}
			else{echo "<SCRIPT language=\"JavaScript\">alert('Make Sure All Fields Are Entered!');</SCRIPT>";
			$action='Add';}
		break;
		case "Delete":
			mysql_query("DELETE FROM bmcode WHERE no = '$row'");
			echo "<SCRIPT language=\"JavaScript\">alert('Bookmaker Deleted!');</SCRIPT>";
		break;
		/*case "Status":
			$statussql=mysql_query("SELECT status FROM bmcode WHERE no='$row'");
			$data=mysql_result($statussql,0,"status");
			if($data=='0000-00-00 00:00:00'){mysql_query("UPDATE bmcode SET status='$datetime' WHERE no = '$row'");}
			else{mysql_query("UPDATE bmcode SET status='0000-00-00 00:00:00' WHERE no = '$row'");}
		break;*/
		}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr><td align="center"><span class="bn13text">View BM Type</span></td></tr>
    <?php
    if($action=='Add'){
	echo"<tr><td align='center'>";
	echo"<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>";
	echo"<tr><td height='10' colspan='3'></td></tr><form action='viewbookmakertype.php' method='post'>";
	echo"<tr><td align='right'><span class='bn13text'>BM Code</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='5' size='15' name='bmcode' value='$bmcode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='right'><span class='bn13text'>Type</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='subcode' value='$subcode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='right'><span class='bn13text'>Name</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='bmname' value='$bmname'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='center' colspan='3'><input type='reset' value='Reset' alt='Reset'>&nbsp;&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewbookmakertype.php'\">&nbsp;&nbsp;<input type='submit' value='Save' name='action' alt='Save'></td></tr>";	
	echo"</form><tr><td height='10' colspan='3'></td></tr>";
	echo"</table>";
	echo"</td></tr>";}
	else{echo"<tr><td align='left'><a href='viewbookmakertype.php?action=Add'><img src='images/new.jpg' border='0'></a></td></tr>";}
	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="50%" align="center">
<tr >
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b>#</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>BM Code</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Type</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Name</b>&nbsp;</span></td>
     <td align="center" style="border:solid 1px #000000" width="20%"><span class="bn13text">&nbsp;<b>Status</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b>Action</b>&nbsp;</span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT * FROM bmcode");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$serial++;
	$row=mysql_result($bmsql,$count,"no");
	echo "<td align='center'><span class='bn13text'>$serial</span></td>";
	$data=mysql_result($bmsql,$count,"bmcode");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	$data=mysql_result($bmsql,$count,"subbmcode");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	$data=mysql_result($bmsql,$count,"bmname");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	echo "<td align='center'>";
	echo"<form action='viewbookmakertype.php?action=Status&row=$row' method='post' style='margin-bottom:0;'>";
	echo"<select name='select' id='select' onChange='this.form.submit();'>";
	$statussql=mysql_query("SELECT status FROM bmcode WHERE no='$row'");
	$data=mysql_result($statussql,0,"status");
	if($data=='0000-00-00 00:00:00'){echo"<option value='Inactive' style=color:red>Disable</option><option value='Active' style=color:blue>Enable</option>";}
	else{echo"<option value='Active' style=color:blue>Enable</option><option value='Inactive' style=color:red>Disable</option>";}
	echo"</select>";
	echo"</form></td><td align='center'>";
	echo"<form action='viewbookmakertype.php?action=Delete&row=$row' method='post' style='margin-bottom:0;'>";
	echo"<input type='image' src='images/trash.gif' border='0' onclick=\"return confirm('You Are About To Delete!');\"></form></td>";
	echo "</tr>";}
	?>
</body>
</html>