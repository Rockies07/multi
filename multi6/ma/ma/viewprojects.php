<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

$webdate=date("Y-m-d");
?>
<?php
$action=$_GET[action];
$bmref=$_GET[bmref];
$remarks=$_GET[remarks];

if ($_GET["action"]=='update') {
$ref = $_GET["ref"];
$amount = $_GET["amount"];

mysql_query("update proj_entries set amt='$amount',remarks='$remarks' where ref='$ref'") or die(mysql_error());
echo "<SCRIPT language=\"JavaScript\">alert('Amount got updated!');</SCRIPT>";
}

if ($_GET["action"]=='delete') {

$ref = $_GET["ref"];

mysql_query("delete from proj_entries where ref='$ref'") or die(mysql_error());
echo "<SCRIPT language=\"JavaScript\">alert('Entry got deleted!');</SCRIPT>";
}

if ($_POST[submit]) {
	$projcode=$_POST[projcode];
	$amount=$_POST[amount];
	$remarks=$_POST[remarks];
	$account=$_POST[account];
	$datetime=$_POST[datetime];
	$sabog =(explode("/",$datetime));
	$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
	$type=$_POST[type];
	$userid=$_POST[userid];
	$submit=$_POST[submit];
	$datetime2=date("Y-m-d H:i:s");
	$deyt=date("Y-m-d");
//	echo $amount;
	if ($amount<>"" || $amount<>"0") {
	switch($submit){
		case "Submit":
		mysql_query("INSERT INTO proj_entries (ref, date, project, stats, account, remarks, amt, submittedby, entriesdate) VALUES('', '$converted_datetime', '$projcode','$type','$account','$remarks','$amount',UCASE('$weblogin'),'$datetime2')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('New Project has been Added!');</SCRIPT>";}
		//break;
		}
		else {
	echo "<SCRIPT language=\"JavaScript\">alert('Amount is required!');</SCRIPT>";
	}
}
	?>
<html>
<head><title>Project Entries</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<link href="css/demos.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	$(function() {
		$("#inputDate").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	</script>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function numeric(o){
	if (isNaN(o.value)) {
		alert("Amount should only be Numeric");
		o.focus();
		return false;
	}
}
</script>
<script type="text/javascript">
function ValidateForm(thisform)
{
	if (thisform.projcode.value==="" || thisform.projcode.value===null) {
		alert("Project Code is required");
		thisform.projcode.focus();
		return false;
	}
	if (thisform.account.value==="" || thisform.account.value===null) {
		alert("Account required");
		thisform.account.focus();
		return false;
	}
	if (thisform.type.value==="" || thisform.type.value===null) {
		alert("Type is required");
		thisform.type.focus();
		return false;
	}
	if (thisform.amount.value==="0" || thisform.amount.value===0) {
		alert("Amount cannot be Zero");
		thisform.amount.focus();
		return false;
	}
	reWhiteSpace = new RegExp(/\s/g);
	if (reWhiteSpace.test(thisform.amount.value)) {
          alert("Amount must not contain spaces");
		  thisform.amount.focus();
          return false;
     }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">Project Entries </span></td>
	</tr>
  	<tr>
</table>
	
	<form action='<?php echo $PHP_SELF;?>' method='POST' name='projects' >
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='70%' align='center'>
	<tr><td><span class='bn13text'>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Project
	<select name="projcode" class="searchformfiled" tabindex="2">
	<?php	$projcodesql=mysql_query("SELECT projcode FROM projects");
				$projcoderow=mysql_num_rows($projcodesql);
				for($count=0; $count<$projcoderow; $count++)
				{$projcode=mysql_result($projcodesql,$count,"projcode");
				echo "<option value='$projcode'>$projcode</option>";}
                ?>
      </select></span>
	</td>
	<td><span class='bn13text'>Account
	<select name="account" class="searchformfiled" tabindex="2">
	 <?php	$cpyacctsql=mysql_query("SELECT cpyaccount FROM cpyaccount");
				$cpyacctrow=mysql_num_rows($cpyacctsql);
				for($count=0; $count<$cpyacctrow; $count++)
				{$cpyaccount=mysql_result($cpyacctsql,$count,"cpyaccount");
				echo "<option value='$cpyaccount'>$cpyaccount</option>";}
                ?>
      </select>
	    <select name="type" class="searchformfiled" >
          <option value="" selected="selected">--Select--</option>
        <option value="INV">INV</option>
		<option value="PFT">PFT</option>
		<option value="EXP">EXP</option>
		<option value="DEP">DEP</option>
        </select>
	</span>	</td>
	<td align="left" nowrap class="text11">
		  <div class="demo">Date: <input type="text" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" style="width:80px">
</div></td>
	</tr>
	<tr><td height='10' ></td></tr>
	<tr>
	  <td ><span class='bn13text'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amt&nbsp;&nbsp;
	    <input type='text' size='15' name='amount'  value='0' onBlur='numeric(this)'>
	  </span></td>
	  <td align='left'><span class='bn13text'>&nbsp;&nbsp;&nbsp;Remarks
	    <input type='text'  size='35' name='remarks'  value=''>
	  </span></td>
	 <input type='hidden' name='userid'  value='<?php echo $weblogin; ?>'>
	</tr>
	<tr><td colspan='9' align='center'><input type='submit' value='Submit' name='submit' onclick='return ValidateForm(projects);'>&nbsp;<input type='button' value='Reset' onClick"window.location.href='viewprojects.php'\"></td></tr></form>
</table>
<br><br>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center" class="stats">
	<tr >
	   <td class="hed"><span class="bn13text"><b>Date</b></span></td>
	  <td class="hed"><span class="bn13text"><b>Project</b></span></td>
	  <td class="hed"><span class="bn13text"><b>Stats</b></span></td>
	  <td class="hed"><span class="bn13text"><b>Account</b></span></td>
	  <td class="hed"><span class="bn13text"><b>Amount</b></span></td>	  
	<td class="hed"><span class="bn13text"><b>Remarks</b></span></td>
	<td class="hed"><span class="bn13text"><b>Submitted By</b></span></td>
	<td class="hed"><span class="bn13text"><b>Entry Date</b></span></td>
	<td class="hed"><span class="bn13text"><b>Action</b></span></td>
	</tr>
<?php
	$projectsql=mysql_query("SELECT * FROM proj_entries ORDER BY entriesdate DESC");
	$projectrow=mysql_num_rows($projectsql);
	for($count=0; $count<$projectrow; $count++)
	{
	$ref=mysql_result($projectsql,$count,"ref");
	$date=mysql_result($projectsql,$count,"date");
	$project=mysql_result($projectsql,$count,"project");
	$stats=mysql_result($projectsql,$count,"stats");
	$account=mysql_result($projectsql,$count,"account");
	$remarks=mysql_result($projectsql,$count,"remarks");
	$amount=mysql_result($projectsql,$count,"amt");
	$submittedby=mysql_result($projectsql,$count,"submittedby");
	$entriesdate=mysql_result($projectsql,$count,"entriesdate");
	
	$bbb=strtotime(str_replace("-", "/",$date));
	$bmdate=date("D, j M Y",$bbb);
	echo "<tr><td align='center'><span class='bn13text'>$bmdate</span></td>";
	echo "<td align='center'><span class='bn13text'>$project</span></td>";
	echo "<td align='center'><span class='bn13text'>$stats</span></td>";
	echo "<td align='center'><span class='bn13text'>$account</span></td>";
	if ($action=='edit' && $_GET["ref"]==$ref)
	{
		echo "<form action='viewprojects.php' method='get' style='margin-bottom:0;'><td align='center'><span class='bn13text'><input type='text' size='15' name='amount'  value='$amount' onChange='numeric(this)'></span></td>
		<input type='hidden' name='ref' value='$ref'><input type='hidden' name='action' value='update'><td align='center'><span class='bn13text'><input type='text' size='25' name='remarks'  value='$remarks'></span></td>";
	}
	else
	{	
		if ($amount<0)
		echo "<td align='center'><span class='bn13text'><font color='red'>$amount</font></span></td>";
		else
		echo "<td align='center'><span class='bn13text'>$amount</span></td>";
		
		echo "<td align='center'><span class='bn13text'>$remarks</span></td>";
	}
	$super_amount = $super_amount + $amount;
	
//	echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	//echo "<td align='center'><span class='bn13text'>$submittedby</span></td>";
	echo "<td align='center'><span class='bn13text'>$submittedby</span></td>";
	echo "<td align='center'><span class='bn13text'>$entriesdate</span></td>";
	  if ($action=='edit' && $_GET["ref"]==$ref)
	{
	echo "<td align='center'><a href='viewprojects.php' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' title='Save'></td></tr>";
	}
	else
	{
  echo "<td align='center'><a href='viewprojects.php?action=edit&ref=$ref' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a>&nbsp;&nbsp;<a href='viewprojects.php?action=delete&ref=$ref' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></td></tr>";
  }
  }
	?>
	<tr >
	   <td class="hed" colspan="4"><span class="bn13text"><b>Page Total:</b></span></td>
	  <td class="hed"><span class="bn13text"><b><?php echo number_format($super_amount,2); ?></b></span></td>
	<td class="hed" colspan="4"></td>
	</tr>
	</form>
</table>
</body>
</html>