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
$name=$_POST[name];
/*$subcode=$_POST[subcode];
$bmname=$_POST[bmname];
$datetime=date("Y-m-d H:i:s");*/
		switch($action){
		case "Save":
		//	if(($projcode)&&($subcode)&&($bmname))
			if(($name))
				{
				$nameql=mysql_query("SELECT name FROM ranking WHERE name='$name'");
				$nameqlrow=mysql_num_rows($nameql);
					if($nameqlrow){echo "<SCRIPT language=\"JavaScript\">alert('Code Already Exists!');</SCRIPT>";$action='Add';}
					else{mysql_query("INSERT INTO ranking (no, name) VALUES('','$name')")or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('Ranking Code Entry Accepted!');</SCRIPT>";}}
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
<script type="text/javascript">
function up(o){o.value=o.value.toUpperCase().replace(/([^0-9A-Z])/g,"");}
</script>
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">View Ranking <br>
	      <br>
  </span></td>
	</tr>
    <?php
    if($action=='Add'){
	echo"<tr><td align='center'>";
	echo"<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>";
	echo"<tr><td height='10' colspan='3'></td></tr><form action='viewranking.php' method='post'>";
	echo"<tr><td align='right'><span class='bn13text'>Ranking Code</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='8' size='15' name='name' value='$name' onBlur='up(this);'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	/*echo"<tr><td align='right'><span class='bn13text'>Type</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='subcode' value='$subcode'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='right'><span class='bn13text'>Name</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='12' size='15' name='bmname' value='$bmname'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
	echo"<tr><td align='center' colspan='3'><input type='reset' value='Reset' alt='Reset'>&nbsp;&nbsp;";
	*/
	echo"<tr><td align='center' colspan='3'><input type='button' value='Cancel' onClick=\"window.location.href='viewranking.php'\">&nbsp;&nbsp;<input type='submit' value='Save' name='action' alt='Save'></td></tr>";	
	echo"</form><tr><td height='10' colspan='3'></td></tr>";
	echo"</table>";
	echo"</td></tr>";}
	else{echo"<tr><td align='left'><a href='viewranking.php?action=Add'><img src='images/new.jpg' border='0'></a></td></tr><br>";}
	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
<tr >
    <td class="hed"  width="5%"><span class="bn13text">&nbsp;<b>#</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Name</b>&nbsp;</span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT * FROM ranking order by no asc");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$serial++;
	$no=mysql_result($bmsql,$count,"no");
	echo "<td align='center'><span class='bn13text'>$no</span></td>";
	$name=mysql_result($bmsql,$count,"name");
	echo "<td align='center'><span class='bn13text'>$name</span></td>";
	echo "</form></td></tr>";}
	?>
	
</body>
</html>