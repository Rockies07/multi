<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	////$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
//	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$weblogin=strtoupper($weblogin);
?>
<?php
$action=$_GET[action];
if($action==NULL){$action=$_POST[action];}
$row=$_GET[row];
//$managerid=$_POST[managerid];
$account=strtoupper($_POST[account]);
/*$subcode=$_POST[subcode];
$bmname=$_POST[bmname];*/
$datetime=date("Y-m-d H:i:s");
		switch($action){
		case "Save":
		//	if(($projcode)&&($subcode)&&($bmname))
			if(($account))
				{
				//$projcodesql=mysql_query("SELECT cpyaccount FROM cpyaccount WHERE managerid='$weblogin' and cpyaccount='$account'");
				$projcodesql=mysql_query("SELECT cpyaccount FROM cpyaccount WHERE cpyaccount='$account'");
				$projcodesqlrow=mysql_num_rows($projcodesql);
					if($projcodesqlrow){echo "<SCRIPT language=\"JavaScript\">alert('Account Already Exists!');</SCRIPT>";$action='Add';}
					else{mysql_query("INSERT INTO cpyaccount (no, cpyaccount, managerid, hiddenfunds) VALUES('','$account','$weblogin','0.00')")or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('Account Entry Accepted!');</SCRIPT>";}}
			else{echo "<SCRIPT language=\"JavaScript\">alert('Make Sure All Fields Are Entered!');</SCRIPT>";
			$action='Add';}
		break;
		}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<SCRIPT language=javascript>
function openScript(url, width, height){
 var Win = window.open(url,"_blank",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}
</SCRIPT>

<style>table.outline { border: 1px outset #FFAA00; }</style></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="bn13text">View Account<br>
	      <br>
<?php echo "1. Max 8 alphanumeric characters<br>2. You cannot rename the account<br>3. Account can only be deleted if you are the Manager & when no files are associated.<br><br>"; ?>
  </span></td>
	</tr>
    <?php
    if($action=='Add'){
	echo"<tr><td align='center'>";
	echo"<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>";
	echo"<tr><td height='10' colspan='3'></td></tr><form action='viewaccount.php' method='post'>";
	echo"<tr><td align='right'><span class='bn13text'>Manager ID:</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='5' size='5' name='managerid' value='$weblogin' readonly='true'></td></tr>";
	echo"<tr><td align='right'><span class='bn13text'>*Account Name:</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='8' size='10' name='account' value='$account'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
		echo"<tr><td align='center' colspan='3'><input type='button' value='Cancel' onClick=\"window.location.href='viewaccount.php'\">&nbsp;&nbsp;<input type='submit' value='Save' name='action' alt='Save'></td></tr>";	
	echo"</form><tr><td height='10' colspan='3'></td></tr>";
	echo"</table>";
	echo"</td></tr>";}
	else{echo"<tr><td align='left'><a href='viewaccount.php?action=Add'><img src='images/new.jpg' border='0'></a></td></tr><br>";}
	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="50%" align="center">
<tr >
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Accounts</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>MD</b>&nbsp;</span></td>
  <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Funds</b>&nbsp;</span></td>
 <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Details</b>&nbsp;</span></td>
</tr>
    <?php
	$bmsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount group by managerid, cpyaccount asc");
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	$managerid=mysql_result($bmsql,$count,"managerid");
	echo "<td align='center'><span class='bn13text'>$managerid</span></td>";
	
	//$fundsql=mysql_query("SELECT cpyaccount,amount,entriesby FROM bmdatabase_payment where entriesby = '$managerid'");
	//$fundsql=mysql_query("SELECT sum(amount) FROM bmdatabase_payment where entriesby = '$managerid' and cpyaccount='$cpyaccount'");
	$fundsql=mysql_query("SELECT sum(amount)+(SELECT sum(amount)FROM bmexpenses where entriesby = '$managerid' and cpyaccount='$cpyaccount') FROM bmdatabase_payment 
where entriesby = '$managerid' and cpyaccount='$cpyaccount'");
	while ($row_funds = mysql_fetch_array($fundsql)) 
	{
		//$cpyaccount_out = $row_funds[0];
		$amount = $row_funds[0];
		//$entriesby = $row_funds[2];
		echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	}
	echo "<td align='center'><a href='viewaccountdetails.php?managerid=$managerid&account=$cpyaccount' target='_blank'>View</a></td>";
	/*$data=mysql_result($bmsql,$count,"subprojcode");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	$data=mysql_result($bmsql,$count,"bmname");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	echo "<td align='center'>";
	echo"<form action='viewaccount.php?action=Status&row=$row' method='post' style='margin-bottom:0;'>";
	echo"<select name='select' id='select' onChange='this.form.submit();'>";
	$statussql=mysql_query("SELECT status FROM projcode WHERE no='$row'");
	$data=mysql_result($statussql,0,"status");
	if($data=='0000-00-00 00:00:00'){echo"<option value='Inactive' style=color:red>Disable</option><option value='Active' style=color:blue>Enable</option>";}
	else{echo"<option value='Active' style=color:blue>Enable</option><option value='Inactive' style=color:red>Disable</option>";}
	echo"</select>";
	echo"</form></td><td align='center'>";
	echo"<form action='viewaccount.php?action=Delete&row=$row' method='post' style='margin-bottom:0;'>";
	echo"<input type='image' src='images/trash.gif' border='0' onclick=\"return confirm('You Are About To Delete!');\"></form></td>";*/
	echo "</form></td></tr>";}
	?>
	
</body>
</html>