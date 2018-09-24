<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	////$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
//	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$weblogin=strtoupper($weblogin);
?>
<?php
$action=$_GET[action];
if($action==NULL){$action=$_POST[action];}
$row=$_GET[row];
$managerid=trim($_POST[managerid]);
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
					else{mysql_query("INSERT INTO cpyaccount (no, cpyaccount, managerid, hiddenfunds) VALUES('','$account','$managerid','0.00')")or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('Account Entry Accepted!');</SCRIPT>";}}
			else{echo "<SCRIPT language=\"JavaScript\">alert('Make Sure All Fields Are Entered!');</SCRIPT>";
			$action='Add';}
		break;
		}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/easydrag.js"></script>
<script type="text/javascript">$(function(){$("#FloaintBox").easydrag();$("#FloaintBox").ondrop(function(e, element){  });});</script> 
<style type="text/css">#FloaintBox{ border:1px solid red; background-color:#eef4d3;}#FloaintBox{width:150px; padding:10px;}</style> 
<SCRIPT language=javascript>
function openScript(url, width, height){
 var Win = window.open(url,"_blank",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}
function up(o){
o.value=o.value.toUpperCase().replace(/([^0-9A-Z-])/g,"");
}
</SCRIPT>

</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<div id="FloaintBox"> 
<b>Hidden Funds</b><br>
<?php
$clearreport=mysql_query("Select cpyaccount,sum(hiddenfunds) FROM cpyaccount group by managerid, cpyaccount asc");
	while ($row_report = mysql_fetch_array($clearreport)) 
	{
		echo $row_report[0] . "&nbsp;&nbsp;&nbsp;";
		if ($row_report[1]<0)
		echo "<span class='bn13text'><font color='red'>" . $row_report[1] . "</font></span><br>";
		else
		echo "<span class='bn13text'><font color='blue'>" . $row_report[1] . "</font></span><br>";
	}
?>	
</div>			
<!--	<div align="right">
<img src="images/arrow1.PNG" height="16" width="16" onclick="javascript:$('#FloaintBox').floatingPosition('right', 'top');">
<img src="images/arrow2.PNG" height="16" width="16" onclick="javascript:$('#FloaintBox').floatingPosition('right', 'bottom');">
<img src="images/arrow3.PNG" height="16" width="16" onclick="javascript:$('#FloaintBox').floatingPosition('left', 'bottom');">
<img src="images/arrow4.PNG" height="16" width="16" onclick="javascript:$('#FloaintBox').floatingPosition('left', 'top');">

			<button onclick="javascript:$('#FloaintBox').floatingPosition('left', 'top');">Top Left</button><br> 
				<button >Top Right</button><br> 
				<button onclick="javascript:$('#FloaintBox').floatingPosition('left', 'bottom');">Bottom Left</button><br> 
				<button onclick="javascript:$('#FloaintBox').floatingPosition('right', 'bottom');">Bottom Right</button> 
			

</div> -->
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">View Account<br>
	      <br>
<?php echo "1. Max 8 alphanumeric characters<br>2. You cannot rename the account<br>3. Account can only be deleted if you are the Manager & when no files are associated.<br><br>"; ?>
  </span></td>
	</tr>
    <?php
    if($action=='Add'){
	echo"<tr><td align='center'>";
	echo"<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>";
	echo"<tr><td height='10' colspan='3'></td></tr><form action='viewaccount.php' method='post'>";
	echo"<tr><td align='right'><span class='bn13text'>Manager ID:</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'>
	<select name='managerid'>";
	$manageridsql=mysql_query("SELECT DISTINCT managerid FROM managerid ORDER BY managerid ASC");
	while ($row_manageridsql = mysql_fetch_array($manageridsql)) 
	{
	$nihao = $row_manageridsql[0];
	echo "<option value='$nihao'>$nihao</option>";
	}
	  echo "</select></td></tr>";
	echo"<tr><td align='right'><span class='bn13text'>*Account Name:</span></td><td width='15' align='center'><span class='bn13text'>:</span></td><td align='left'><input type='text' maxlength='8' size='10' name='account' value='$account' onBlur='up(this)'></td></tr>";
	echo"<tr><td height='3' colspan='3'></td></tr>";
		echo"<tr><td align='center' colspan='3'><input type='button' value='Cancel' onClick=\"window.location.href='viewaccount.php'\">&nbsp;&nbsp;<input type='submit' value='Save' name='action' alt='Save'></td></tr>";	
	echo"</form><tr><td height='10' colspan='3'></td></tr>";
	echo"</table>";
	echo"</td></tr>";}
	else{echo"<tr><td align='left'><a href='viewaccount.php?action=Add'><img src='images/new.jpg' border='0'></a></td></tr><br>";}
	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
<tr>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Accounts</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>MD</b>&nbsp;</span></td>
  <td class="hed" ><span class="bn13text">&nbsp;<b>Funds</b>&nbsp;</span></td>
 <td class="hed" ><span class="bn13text">&nbsp;<b>Details</b>&nbsp;</span></td>
</tr>
    <?php
	//$bmsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount where managerid = '$weblogin' group by managerid, cpyaccount asc");
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
//	$fundsql=mysql_query("SELECT ifnull(sum(amount), 0)+(SELECT ifnull(sum(amount), 0) FROM bmexpenses where entriesby = '$managerid' and cpyaccount='$cpyaccount') FROM bmdatabase_payment 
//$fundsql=mysql_query("SELECT ifnull(sum(amount), 0)+(SELECT ifnull(sum(amount), 0) FROM bmexpenses where cpyaccount='$cpyaccount') FROM bmdatabase_payment where cpyaccount='$cpyaccount'");
$fundsql=mysql_query("SELECT ifnull(sum(amount), 0)+(SELECT ifnull(sum(amount), 0) FROM bmexpenses where cpyaccount='$cpyaccount')+(select ifnull(sum(hiddenfunds),0) from cpyaccount where cpyaccount='$cpyaccount') FROM bmdatabase_payment where cpyaccount='$cpyaccount'");
//echo "SELECT ifnull(sum(amount), 0)+(SELECT ifnull(sum(amount), 0) FROM bmexpenses where cpyaccount='$cpyaccount')+(select ifnull(sum(hiddenfunds),0) from cpyaccount where cpyaccount='$cpyaccount') FROM bmdatabase_payment where cpyaccount='$cpyaccount'" . "<br>";
	while ($row_funds = mysql_fetch_array($fundsql)) 
	{
		//$cpyaccount_out = $row_funds[0];
		$amount = $row_funds[0];
		//$entriesby = $row_funds[2];
		if ($amount == "" || $amount == 0)
		echo "<td align='center'><span class='bn13text'>0.00</span></td>";
		else {
			if ($amount<0)
				echo "<td align='center'><span class='bn13text'><font color='red'>$amount</font></span></td>";
			else
				echo "<td align='center'><span class='bn13text'><font color='blue'>$amount</font></span></td>";
		}
		
	}
	$account_total = $account_total + $amount;
	echo "<td align='center'><a href='viewaccountdetails.php?managerid=$managerid&account=$cpyaccount' target='_blank'><span class='bn13text'>View</span></a></td>";
	echo "</form></td></tr>";}
	$account_total = number_format($account_total,2);
	if ($account_total<0)
	echo "<tr><td colspan='2' class='hed'></td><td align='center' class='hed'><span class='bn13text'><font color='red'><b>$account_total</b></font></span></td><td class='hed'></td></tr>";
		else
echo "<tr><td colspan='2' class='hed'></td><td align='center' class='hed'><span class='bn13text'><font color='blue'><b>$account_total</b></font></span></td><td class='hed'></td></tr>";
	?>
</body>
</html>