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
		case "Delete":
			mysql_query("DELETE FROM projects WHERE no = '$row'");
			echo "<SCRIPT language=\"JavaScript\">alert('Bookmaker Deleted!');</SCRIPT>";
		break;
		/*case "Status":
			$statussql=mysql_query("SELECT status FROM projects WHERE no='$row'");
			$data=mysql_result($statussql,0,"status");
			if($data=='0000-00-00 00:00:00'){mysql_query("UPDATE projcode SET status='$datetime' WHERE no = '$row'");}
			else{mysql_query("UPDATE projects SET status='0000-00-00 00:00:00' WHERE no = '$row'");}
		break;*/
		}
?>
<html>
<head><title>Project Entries</title><link rel="stylesheet" href="style.css" type="text/css" />
<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">View Investment Type<br>
  </span></td>
	</tr>
    <?php
    if($action=='Add'){
	echo"<tr><td align='center'>";
	echo"<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>";
	echo"<tr><td height='10' colspan='3'></td></tr><form action='investmententry.php' method='post'>";
	echo"<tr><td align='right'><span class='bn13text'>Select Project</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='8' size='15' name='projcode' value='$projcode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	/*echo"<tr><td align='right'><span class='bn13text'>Type</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='subcode' value='$subcode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='right'><span class='bn13text'>Name</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='bmname' value='$bmname'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='center' colspan='3'><input type='reset' value='Reset' alt='Reset'>&nbsp;&nbsp;";
	*/
	echo"<tr><td align='center' colspan='3'><input type='button' value='Cancel' onClick=\"window.location.href='investmententry.php'\">&nbsp;&nbsp;<input type='submit' value='Save' name='action' alt='Save'></td></tr>";	
	echo"</form><tr><td height='10' colspan='3'></td></tr>";
	echo"</table>";
	echo"</td></tr>";}
	else{echo"<tr><td align='left'><a href='investmententry.php?action=Add'><img src='images/new.jpg' border='0'></a></td></tr><br>";}
	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="80%" align="center">
<tr bordercolor="#000000" bgcolor="#888888">
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b>Date</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Project</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Stats</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Account</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000" width="40%"><span class="bn13text">&nbsp;<b>Remarks</b>&nbsp;</span></td>
	 <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Amt</b>&nbsp;</span></td>
	  <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Submitted By</b>&nbsp;</span></td>
	   <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Action</b></span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT * FROM proj_entries");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
//	$serial++;
	$date=mysql_result($bmsql,$count,"date");
	echo "<td align='center'><span class='bn13text'>$date</span></td>";
	$project=mysql_result($bmsql,$count,"project");
	echo "<td align='center'><span class='bn13text'>$project</span></td>";
	$stats=mysql_result($bmsql,$count,"stats");
	echo "<td align='center'><span class='bn13text'>$stats</span></td>";
	$account=mysql_result($bmsql,$count,"account");
	echo "<td align='center'><span class='bn13text'>$account</span></td>";
	$remarks=mysql_result($bmsql,$count,"remarks");
	echo "<td align='center'><span class='bn13text'>$remarks</span></td>";
	$amt=mysql_result($bmsql,$count,"amt");
	echo "<td align='center'><span class='bn13text'>$amt</span></td>";
	$submittedby=mysql_result($bmsql,$count,"submittedby");
	echo "<td align='center'><span class='bn13text'>$submittedby</span></td>";
	echo"<form action='investmententry.php?action=Delete&row=$row' method='post' style='margin-bottom:0;'>";
	echo"<input type='image' src='images/trash.gif' border='0' onclick=\"return confirm('You Are About To Delete!');\"></form></td>";
	/*$data=mysql_result($bmsql,$count,"subprojcode")
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	$data=mysql_result($bmsql,$count,"bmname");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	echo "<td align='center'>";
	echo"<form action='investmententry.php?action=Status&row=$row' method='post' style='margin-bottom:0;'>";
	echo"<select name='select' id='select' onChange='this.form.submit();'>";
	$statussql=mysql_query("SELECT status FROM projcode WHERE no='$row'");
	$data=mysql_result($statussql,0,"status");
	if($data=='0000-00-00 00:00:00'){echo"<option value='Inactive' style=color:red>Disable</option><option value='Active' style=color:blue>Enable</option>";}
	else{echo"<option value='Active' style=color:blue>Enable</option><option value='Inactive' style=color:red>Disable</option>";}
	echo"</select>";
	echo"</form></td><td align='center'>";
	echo"<form action='investmententry.php?action=Delete&row=$row' method='post' style='margin-bottom:0;'>";
	echo"<input type='image' src='images/trash.gif' border='0' onclick=\"return confirm('You Are About To Delete!');\"></form></td>";*/
	echo "</form></td></tr>";}
	?>
	
</body>
</html>