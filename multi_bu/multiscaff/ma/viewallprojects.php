<?php
session_start();
	
$weblogin=$_SESSION["weblogin"];
$webpassword=$_SESSION["webpassword"];	

include "include/include.php";

$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
$rights=mysql_num_rows($login);
if(!$rights){header("location:index.php");}
$result="";
?>
<html>
<script type="text/javascript">
function openScript(url, width, height){
 var Win = window.open(url,"_blank",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}
function up(o){o.value=o.value.toUpperCase().replace(/([^0-9A-Z])/g,"");}
function numeric(o){
	if (isNaN(o.value)) {
		alert("Contacts  should only be Numeric");
		o.focus();
		return false;
	}
		if (o.value!="") {
	/*if (o.value.length<15) {
		alert("Contacts should only be 15 characters");
		o.focus();
		return false;
	}*/
		}
}
</script>
<link rel="stylesheet" href="style_report.css" type="text/css" />

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br><br>
<form name="sorttools" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<!--<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='1000px' align='center' class='outline'>
<tr>
<td height='10'><span class="bn12text">
			  <?php if ($_POST["page_size"] <> "") { ?>
 Page Size:<input class="searchformfiled" type="text" value="<?php echo $_POST["page_size"]; ?>" name="page_size" size="3">
			   <?php } else { ?>
 Page Size:<input class="searchformfiled" type="text" value="20" name="page_size" size="3">
 				 <?php } ?>
			
	 <input name="SortOrder" value="Desc" type="radio" <?php echo $checked1; ?>>
              Desc&nbsp;&nbsp; <input name="SortOrder" value="Asc"  type="radio" <?php echo $checked2; ?>>

              Asc&nbsp;&nbsp; &nbsp;&nbsp; <input class="formButton" name="submit2" value="Sort" type="submit">&nbsp;&nbsp;
</span>
<span class="bn12text">Show Hidden</span> <b>
<?php
$hiddenf = $_POST["hiddenf"];
if ($hiddenf==0 || $hiddenf=="") {
		$itago = 0;
		$hidden_dragon = "";
		}
else {
		$itago = 1;
		$hidden_dragon = "";
		}
		$_SESSION["hiddenf"] = $_POST["hiddenf"];
  if ($hiddenf==0) { ?>
    <input type="checkbox"  name="hiddenf" onClick="document.sorttools.submit();" value="1">
	<?php } else { ?>
	<input type="checkbox" name="hiddenf" onClick="document.sorttools.submit();" value="1" checked="checked">
	<?php } ?>
<span class="bn12text">
Sort By: 
 <select class="searchformfiled" name="SortBy" value="<?php echo $_POST["SortBy"]; ?>">
 <?php 
 if ($_POST["SortBy"] == "") {
 $selected1 = 'selected="selected"';
// $selected4 = 'selected="selected"';
 }
 if ($_POST["SortBy"] == "memberid") {
 $selected1 = 'selected="selected"';
 }
 if ($_POST["SortBy"] == "managerid") {
 $selected2 = 'selected="selected"';
 }
 if ($_POST["SortBy"] == "membername") {
 $selected3 = 'selected="selected"';
 }
 if ($_POST["SortBy"] == "ranking") {
 $selected4 = 'selected="selected"';
 }
 
 $_SESSION["SortBy"] = $_POST["SortBy"];
/*  if ($_POST["SortBy"] == "Total") {
 $selected5 = 'selected="selected"';
 }
  if ($_POST["SortBy"] == "Outstanding") {
 $selected6 = 'selected="selected"';
 }*/
 $hiddenf = $_POST["hiddenf"];
 
	if ($hiddenf==0 || $hiddenf=="")
		$hide_me = " and clr = '0'";
  ?>
                <option value="memberid" <?php echo $selected1; ?>>Member Id</option>
                <option value="managerid" <?php echo $selected2; ?>>Manager</option>
                <option value="membername" <?php echo $selected3; ?>>Name</option>
                <option value="ranking" <?php echo $selected4; ?>>Ranking</option>
				<option value="Total" <?php echo $selected5; ?>>Total</option>
				<option value="Outstanding" <?php echo $selected6; ?>>Outstanding</option>
              </select> 


  <input class="searchformfiled" name="searchID" value="<?php echo $_POST["searchID"]; ?>" size="8" type="text">
 <input class="formButton" name="view" value="View" type="submit">
Rank:<select name="filter" onchange="this.form.submit()">
<?php
$_SESSION["searchID"] = $_POST["searchID"];
$_SESSION["filter"] = $_POST["filter"];
$_SESSION["mayneger"] = $_POST["mayneger"];
if ($_POST["filter"]<>"")
		{
			$ranknow=mysql_query("SELECT name,no FROM ranking where no ='" . $_POST["filter"] . "' order by no asc");
			while ($row_rankno = mysql_fetch_array($ranknow)) 
			{
			//echo "<option value = '" . $_POST["filter"] . "'>$row_rankno[0]-$filter</option>";
			echo "<option value = '" . $_POST["filter"] . "'>$row_rankno[0]</option>";
			}
echo "<option>ALL</option>";
		}
		else
		echo "<option>ALL</option>";
		
		$rankno=mysql_query("SELECT no,name FROM ranking order by no asc");
		while ($row_rankno = mysql_fetch_array($rankno)) 
		{
		//echo "<option value='$row_rankno[0]'>$row_rankno[1]-$row_rankno[0]</option>";
		echo "<option value='$row_rankno[0]'>$row_rankno[1]</option>";
		}
		
		echo "</select>";

?>
Mngrid:<select name="mayneger" onchange="this.form.submit()">
<?php
if ($_POST["mayneger"]<>"")
		{
			echo "<option value = '" . $_POST["mayneger"] . "'>". $_POST["mayneger"] ."</option>";
			echo "<option>ALL</option>";
		}
		else
		echo "<option>ALL</option>";
		
		$managenow=mysql_query("SELECT managerid FROM managerid order by managerid asc");
		while ($row_managenow = mysql_fetch_array($managenow)) 
		{
		echo "<option value='$row_managenow[0]'>$row_managenow[0]</option>";
		}
		
		echo "</select>";

?>
</table>
--><table border="0" cellpadding="0" cellspacing="0" width="1000px" align="center">
	<tr><td align="center" colspan="3"><span class="maintitle">View Projects</span></td></tr>
    
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
	$rank=$_POST[rank];
	$remarks=$_POST[remarks];
	$contact2=$_POST[contact2];
	$datetime=date("Y-m-d H:i:s");
	if($main=='1'){$membercontact1tick=$datetime;}
	elseif($main=='2'){$membercontact2tick=$datetime;}
	else{$membercontact1tick='0000-00-00 00:00:00';
	$membercontact2tick='0000-00-00 00:00:00';}
	
	$SortBy = $_POST["SortBy"];
	$page_size = $_POST["page_size"];
	$SortOrder = $_POST["SortOrder"];
	$searchID = $_POST["searchID"];
	
	if ($searchID<>"") {
	if ($SortBy=="memberid")
		$condition = " where a.memberid like '$searchID%' ";
	if ($SortBy=="managerid")
		$condition = " where a.managerid like '$searchID%' ";
	if ($SortBy=="membername")
		$condition = " where a.membername like '$searchID%' ";
	if ($SortBy=="ranking") {
		$rankname=mysql_query("SELECT no FROM ranking where name = '$searchID'");
		$ranky=mysql_result($rankname,0,"no");
		$condition = " where a.ranking like '$ranky%' "; }
	}
	else { 
	$condition==""; 
	}
	            	
	
	// orderby
	if($SortBy <> "") {
	//$orderby = "a.memberid ," . $SortBy; }
	$orderby = " a.memberid ";
			}
	else {
	//$orderby = "a.memberid,www" . $SortBy; 
	$orderby = " a.memberid ";
	}
	
	// page size
	if($page_size <> "") {
	$pages = $page_size; }
	else {
	$pages = "20"; }
	
	// Sorting Desc/Asc
	if($_POST["SortOrder"] <> "") {
	$sort = $_POST["SortOrder"]; }
	else {
	$sort = "Asc"; }
	
	/*if ($_POST["memberbutton"]) {
		// Sorting Desc/Asc
		if($searchID <> "") {
		$ID = "where memberid like '$searchID%'"; }
		else {
		$ID = ""; }
	}
	else
	{
		if($searchID <> "") {
		$ID = "where managerid like '$searchID%'"; }
		else {
		$ID = ""; }
	}*/
	
	
	
//echo "SELECT memberid,membername,membercontact1,bankaccount,remarks,managerid FROM memberid $ID ORDER BY $orderby $sort limit $pages";
	
	
	switch($action){
		case "Submit":
		if(($memberid==NULL)||($password==NULL))
		{echo "<SCRIPT language=\"JavaScript\">alert('Error Member ID or Password is a Must!');</SCRIPT>";
		$action='add';}
		else
		{
//		$memberidsql=mysql_query("SELECT memberid FROM memberid WHERE memberid='$memberid'");
$memberidsql=mysql_query("SELECT memberid FROM memberid WHERE memberid='$memberid' union SELECT subid FROM submembers WHERE subid='$memberid'");
				$memberidrow=mysql_num_rows($memberidsql);
					if($memberidrow){echo "<SCRIPT language=\"JavaScript\">alert('MemberId Already Exists!');</SCRIPT>";$action='add';}
					else {
					
						if ($main=="")
							$main = 2;
		
			mysql_query("INSERT INTO memberid (no, memberid, password, status, managerid, membername, membercontact1, membercontact1tick, membercontact2, membercontact2tick, bankaccount, remarks, sms, datetime, ranking) VALUES('', UCASE('$memberid'), '$password', '1', '$managerid', '$name', '$contact1', '$membercontact1tick', '$contact2', '$membercontact2tick', '$bankaccount', '$remarks', '$main', '$datetime', '$rank')") or die(mysql_error());
		//-=-= insert into member_total
		mysql_query("INSERT INTO member_total (memberid, total, outstanding, amountdue) VALUES(UCASE('$memberid'), '0.00', '0.00', '0.00')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('New Member Added!');</SCRIPT>";}
		break;
			}
		}
	if($action=='add'){
	echo "<form action='viewallmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='80%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' valign='top'><span class='bn12text'>Member ID&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='memberid' size='15' maxlength='10' value='$memberid' onBlur='up(this);'>&nbsp;<select name='managerid'>";
	$manageridsql=mysql_query("SELECT DISTINCT managerid FROM managerid ORDER BY managerid ASC");
	$manageridrow=mysql_num_rows($manageridsql);
	if($managerid!=NULL){echo"<option value='$managerid'>$managerid</option>";}
		for($count=0; $count<$manageridrow; $count++)
		{$data=mysql_result($manageridsql,$count,"managerid");
		if($managerid!=$data){echo"<option value='$data'>$data</option>";}}
	  echo "</select></td><td align='right' valign='top'><span class='bn12text'>Password&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='password' name='password' size='15' maxlength='15'><td align='right' valign='top'></td>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Name&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='name' size='15' maxlength='12' value='$name'>
	<span class='bn13text'>&nbsp;Rank
	<select name='rank'>";
	$nonamesql=mysql_query("SELECT DISTINCT no,name FROM ranking ORDER BY no ASC");
	$nonamerow=mysql_num_rows($nonamesql);
	if($rank!=NULL){
	}
		for($count=0; $count<$nonamerow; $count++)
		{
		$no=mysql_result($nonamesql,$count,"no");
		$name=mysql_result($nonamesql,$count,"name");
		echo"<option value='$no'>$name-$no</option>";
	//	if($rank!=$no){echo"<option value='$no'>$name-$no</option>";}
		}
	  echo "</select></span>
	<td align='right' valign='top'><span class='bn12text'>Bank Account&nbsp;</span></td></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Mobile1&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='8' value='$contact1' onBlur='numeric(this)'>&nbsp;";
	if($main=='2'){echo"<span class='bn12text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	else{echo"<span class='bn12text'><span class='bn12text'>SMS<input type='checkbox' name='main' value='2'></span>";}
	echo"</td><td align='right' valign='top'><span class='bn12text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Mobile2&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='13' value='$contact2' onBlur='numeric(this)'></td><td align='center' valign='top' colspan='3'></td></tr>";
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Submit' title='Add New Member'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewallmember.php'\" title='Cancel New Member'></td></tr></form>";
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
	
		// get from submembers
		$memberlist2=mysql_query("SELECT subid FROM submembers where memberid = '$memberid'");
		while ($row_memberlist2 = mysql_fetch_array($memberlist2)) 
		{
			if ($submemlist=="") {
			$submemlist = $row_memberlist2[0];
		}
		else
		{
			$submemlist = $submemlist . "," . $row_memberlist2[0];
		}
		//echo $submemlist;
	}
	
	echo "<form action='viewallmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='80%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' valign='top'><span class='bn12text'>Member ID&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='memberid' size='15' maxlength='10' value='$memberid' readonly='true'>&nbsp;<select name='managerid'>";
	if ($managerid<>"")
	echo "<option value='$managerid'>$managerid</option>";
	$manageridsql=mysql_query("SELECT DISTINCT managerid FROM managerid ORDER BY managerid ASC");
	while ($row_manageridsql = mysql_fetch_array($manageridsql)) 
	{
	$nihao = $row_manageridsql[0];
	echo "<option value='$nihao'>$nihao</option>";
	}
	 echo "</select></td><td align='right' valign='top'><span class='bn12text'>Password&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='password' name='password' size='15' maxlength='15'><td align='right' valign='top'></td>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Name&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='name' size='15' maxlength='12' value='$name'><td align='right' valign='top'><span class='bn12text'>Bank Account&nbsp;</span></td></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Mobile1&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='8' value='$contact1' onBlur='numeric(this)'>&nbsp;";
	if($main=='2'){echo"<span class='bn12text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	else{echo"<span class='bn12text'><span class='bn12text'>SMS<input type='checkbox' name='main' value='2'></span>";}
	echo"</td><td align='right' valign='top'><span class='bn12text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Mobile2&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='13' value='$contact2' onBlur='numeric(this)'></td><td align='right' valign='top'><span class='bn12text'>SubID&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td valign='top' colspan='2'><span class='bn12text'>$submemlist</span></td></tr>";
	
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Update' title='Edit Member'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewallmember.php'\" title='Cancel New Member'></td></tr></form>";
  echo"<tr><td height='10' colspan='4'></td></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	
	if($action=='Update'){
	if ($password<>"") {
	mysql_query("update memberid set membername='$name',membercontact1='$contact1',sms='$main',membercontact2='$contact2',bankaccount='$bankaccount',remarks='$remarks',managerid='$managerid',password=$password where memberid = '$memberid'") or die(mysql_error());
	}
	else
	{
	mysql_query("update memberid set membername='$name',membercontact1='$contact1',sms='$main',membercontact2='$contact2',bankaccount='$bankaccount',remarks='$remarks',managerid='$managerid' where memberid = '$memberid'") or die(mysql_error());
	}
	
		echo "<SCRIPT language=\"JavaScript\">alert('Member Updated!');</SCRIPT>";
		$action='add';
		// 	break;
	}
	else if ($action == 'delete') {
	$mem = $_GET[memberid];
	/* check if member already inserted values */
			$getvalues=mysql_query("SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$mem') FROM bmdatabase_payment where memberid='$mem'");
		//	echo "SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$mem') FROM bmdatabase_payment where memberid='$mem'";
			$row_values = mysql_fetch_array($getvalues);
			//if ($row_values[0]<>'0.00' || $row_values[0]<>'' || $row_values[0]<>NULL || $row_values[0]<>0.00)
			if ($row_values[0]<>'0.00')
			{
				//echo $row_values[0];
				echo "<SCRIPT language=\"JavaScript\">alert('MemberId got an existing account record and cannot be deleted!');</SCRIPT>";$action='add';
				echo"<tr><td align='left'><a href='viewmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewmember.php.php' method='post' style='margin-bottom:0;'><select name='action' onchange='this.form.submit()'><option>ALL</option><option value='1'>Active</option><option value='0'>Inactive</option></select></form></td></tr>";
				}
			else
			{
		mysql_query("delete from memberid where memberid = '$mem'") or die(mysql_error());
//	echo "delete from memberid where memberid = '$mem'";
		echo "<SCRIPT language=\"JavaScript\">alert('Member Deleted!');</SCRIPT>";
		$action='add';
		// 	break;
		echo"<tr><td align='left'><a href='viewmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewmember.php.php' method='post' style='margin-bottom:0;'><select name='action' onchange='this.form.submit()'><option>ALL</option><option value='1'>Active</option><option value='0'>Inactive</option></select></form></td></tr>";
		}
	}
	else
	{echo"<tr><td align='left'><a href='viewallmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td></tr>";}

	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="1000px" align="center" class="stats">
	<tr align="center">
	<td class="hed" width="70px"><span class="bn12text"><b>Project ID</b></span></td>
	<td class="hed" width="70px"><span class="bn12text"><b>Outgoing Total</b></span></td>
	<td class="hed" width="70px"><span class="bn12text"><b>Incoming Total</b></span></td>
	
	<td class="hed"><span class="bn12text"><b>Total</b></span></td>
	<td class="hed" ><span class="bn12text"><b>Project Details</b></span></td>
	<td class="hed" width="28px"><span class="bn12text"><b>Ranking</b></span></td>
	<td class="hed" width="28px"><span class="bn12text"><b>MD</b></span></td>
</tr>
<?php
	$action=$_POST[action];
	// how many rows to show per page
$rowsPerPage=$_POST["page_size"];
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
	$pageNum = $_GET['page'];
}
// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
	
$memberidsql = "select projectname, ifnull(SUM(outgoing),0), ifnull(SUM(incoming),0),(select description from projects where projects.projcode=transactions.projectname) as projdesc from transactions group by projectname asc";
$pagingQuery = " LIMIT $offset, $rowsPerPage";
//echo $memberidsql . $pagingQuery;
//echo $memberidsql . $pagingQuery;
//$result = mysql_query($memberidsql . $pagingQuery); 
$result = mysql_query($memberidsql); 

while ($row_memlist = mysql_fetch_array($result)) 
{
?>
	<tr align="center">
	<td width="70px"><span class="bn12text"><b><?php echo $row_memlist[0]; // projectname ?></b></span></td>
	<td width="70px"><span class="bn12text"><b><a href="javascript: openScript('viewprojectdetails.php?projcode=<?php echo $row_memlist[0]; ?>',1000,600)"><?php echo $row_memlist[1]; // as outgoing ?></a></b></span></td>
	<td width="70px"><span class="bn12text"><b><a href="javascript: openScript('viewprojectdetails.php?projcode=<?php echo $row_memlist[0]; ?>',1000,600)"><?php echo $row_memlist[2]; // as incoming ?></a></b></span></td>
	
	<td ><span class="bn12text"><b><?php echo number_format($row_memlist[1]+$row_memlist[2],2); ?></b></span></td>
	<td ><span class="bn12text"><b><?php echo $row_memlist[3]; // as description ?></b></span></td>
	<td width="28px"><span class="bn12text"><b>--</b></span></td>
	<td width="28px"><span class="bn12text"><b>--</b></span></td>
</tr>
<?php	
$super_outgoing = $super_outgoing+$row_memlist[1];
$super_incoming = $super_incoming+$row_memlist[2];
$super_combine = $super_combine+($row_memlist[1]+$row_memlist[2]);
}
?>
<tr>
	  <td align="center" class="hed"><span class="bn12text"><b>Total: </b></span><span class="bn12text"></span></td>
	  <td align="center" class="hed"><span class="bn12text"><b><?php
	  if ($super_outgoing<0)
		echo "<font color='red'>" . number_format($super_outgoing,2) . "</font>";
		else
		echo "<font color='blue'>" . number_format($super_outgoing,2) . "</font>";
	  
	  ?></b></span></td><td align="center" class='hed'><span class="bn12text"><b>
	  <?php
	 	if ($super_incoming<0)
		echo "<font color='red'><b>" . number_format($super_incoming,2) . "</font>" . "</b></span></td>";
		else
		echo "<font color='red'><b>" . number_format($super_incoming,2) . "</font></b></span></td>";
		  
	  	if ($super_combine<0)
		echo "<td align='center' class='hed'><span class='bn12text'><b><font color='red'>". number_format($super_combine,2) . "</font></b></span></td><td colspan='7' class='hed'>&nbsp;</td>";
		else
		echo "<td align='center' class='hed'><span class='bn12text'><b><font color='blue'>". number_format($super_combine,2) . "</font></b></span></td><td colspan='7' class='hed'>&nbsp;</td>";
	
	//  echo "<td align='center'><span class='bn12text'><b>$final_due</b></span></td><td colspan='7' align='center'>&nbsp;</td>";
	    ?>
	   
  </tr>
<?php
echo "</table> <div align='center'>";
$result  = mysql_query($memberidsql.$limit) or die('Error, query failed');
$numrows = mysql_num_rows($result);
$maxPage = ceil($numrows/$rowsPerPage);
$self = $_SERVER['PHP_SELF'];
if ($pageNum > 1)
{
		$page = $pageNum - 1;
	$prev = " <a href=\"$self?page=$page&payge=".$_SESSION["page_size"]."&SortOrder=".$_SESSION["SortOrder"]."&SortBy=".$_SESSION["SortBy"]."&hiddenf=".$_SESSION["hiddenf"]."&searchID=".$_SESSION["searchID"]."&filter=".$_SESSION["filter"]."&mayneger=".$_SESSION["mayneger"]."\">[Prev]</a> ";
	

	$first = " <a href=\"$self?page=1&payge=".$_SESSION["page_size"]."&SortOrder=".$_SESSION["SortOrder"]."&SortBy=".$_SESSION["SortBy"]."&hiddenf=".$_SESSION["hiddenf"]."&searchID=".$_SESSION["searchID"]."&filter=".$_SESSION["filter"]."&mayneger=".$_SESSION["mayneger"]."\">[First Page]</a> ";
}
else
{
	$prev  = ' [<] ';       // we're on page one, don't enable 'previous' link
	$first = ' [<<] '; // nor 'first page' link
}
if ($pageNum < $maxPage)
{
	$page = $pageNum + 1;
	$next = " <a href=\"$self?page=$page&payge=".$_SESSION["page_size"]."&SortOrder=".$_SESSION["SortOrder"]."&SortBy=".$_SESSION["SortBy"]."&hiddenf=".$_SESSION["hiddenf"]."&searchID=".$_SESSION["searchID"]."&filter=".$_SESSION["filter"]."&mayneger=".$_SESSION["mayneger"]."\">[Next]</a> ";
	$last = " <a href=\"$self?page=$maxPage&payge=".$_SESSION["page_size"]."&SortOrder=".$_SESSION["SortOrder"]."&SortBy=".$_SESSION["SortBy"]."&hiddenf=".$_SESSION["hiddenf"]."&searchID=".$_SESSION["searchID"]."&filter=".$_SESSION["filter"]."&mayneger=".$_SESSION["mayneger"]."\">[Last Page]</a> ";
	
}
else
{
	$next = ' [>] ';      // we're on the last page, don't enable 'next' link
	$last = ' [>>] '; // nor 'last page' link
}
// print the page navigation link
echo "<span class='bn13textwhite'>" . $first . $prev . " Showing <strong>$pageNum</strong> of <strong>$maxPage</strong> " . $next . $last . "</span>";
?>
</div>
<input type="hidden" name="paksiw" value="1">
</form>
</div>
</body>
</html>