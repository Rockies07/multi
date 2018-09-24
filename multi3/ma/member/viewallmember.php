<?php
session_start();
	
$weblogin=$_SESSION["weblogin"];
$webpassword=$_SESSION["webpassword"];	

include "include/include.php";

//$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
$rights=mysql_num_rows($login);
if(!$rights){header("location:index.php");}

if ($_POST["page_size"]=="")
	$_POST["page_size"]=100;
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
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br><br>
<form name="sorttools" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='90%' align='center' class='outline'>
<tr>
<td height='10' colspan='6'><span class="bn13text">
			  <?php if ($_POST["page_size"] <> "") { ?>
 Page Size:<input class="searchformfiled" type="text" value="<?php echo $_POST["page_size"]; ?>" name="page_size" size="3">
			   <?php } else { ?>
 Page Size:<input class="searchformfiled" type="text" value="100" name="page_size" size="3">
 				 <?php } ?>
			
			<?php 
 if ($_POST["SortOrder"] == "") {
 $checked2 = 'checked="checked"';
 }
 if ($_POST["SortOrder"] == "Desc") {
 $checked1 = 'checked="checked"';
 }
 if ($_POST["SortOrder"] == "Asc") {
 $checked2 = 'checked="checked"';
 }
 
 //-=-=-= filter
 $filter=$_POST[filter];
 if ($filter<>"" && $filter<>"ALL") {
		$filthy = " where ranking = '$filter' ";}
 $mayneger = $_POST["mayneger"];
 if ($mayneger<>"" && $mayneger<>"ALL") {
 	if ($filter<>""  && $filter<>"ALL")
		$filtmanager = " and managerid = '$mayneger' ";
	else
		$filtmanager = " where managerid = '$mayneger' ";	
		}
  ?>
			
	    <input name="SortOrder" value="Desc" type="radio" <?php echo $checked1; ?>>
              Desc&nbsp;&nbsp; <input name="SortOrder" value="Asc"  type="radio" <?php echo $checked2; ?>>

              Asc&nbsp;&nbsp; &nbsp;&nbsp; <input class="formButton" name="submit2" value="Sort" type="submit">&nbsp;&nbsp;
</span></td>
<td>
Show Hidden <b>
<?php
$hiddenf = $_POST["hiddenf"];
//echo $hiddenf;
if ($hiddenf==0 || $hiddenf=="") {
		//$hide_me = " and clr = '0'";
	//	echo "a";
		$itago = 1; }
else {
		$itago = 0;
	//	echo "b";
		}
  if ($hiddenf==0) { ?>
    <input type="checkbox"  name="hiddenf" onClick="document.sorttools.submit();" value="1">
	<?php } else { ?>
	<input type="checkbox" name="hiddenf" onClick="document.sorttools.submit();" value="1" checked="checked">
	<?php } ?>
</td>
<td height='10' align="right"><span class="bn13text">
Sort By: 
 <select class="searchformfiled" name="SortBy" value="<?php echo $_POST["SortBy"]; ?>">
 <?php 
 if ($_POST["SortBy"] == "") {
 $selected1 = 'selected="selected"';
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
 $hiddenf = $_POST["hiddenf"];
 
	if ($hiddenf==0 || $hiddenf=="")
		$hide_me = " and clr = '0'";
  ?>
                <option value="memberid" <?php echo $selected1; ?>>Member Id</option>
                <option value="managerid" <?php echo $selected2; ?>>Manager</option>
                <option value="membername" <?php echo $selected3; ?>>Name</option>
                <option value="ranking" <?php echo $selected4; ?>>Ranking</option>
              </select> 


  <input class="searchformfiled" name="searchID" value="<?php echo $searchID; ?>" size="8" type="text">
 <input class="formButton" name="view" value="View" type="submit">
Rank:<select name="filter" onchange="this.form.submit()">
<?php
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
			/*$managenow=mysql_query("SELECT managerid FROM managerid where no ='" . $_POST["mayneger"] . "' order by managerid asc");
			while ($row_managenow = mysql_fetch_array($managenow)) 
			{*/
			echo "<option value = '" . $_POST["mayneger"] . "'>". $_POST["mayneger"] ."</option>";
			//}
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
</td>
</tr>
</table>
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
	
	$SortBy = $_POST["SortBy"];
	$page_size = $_POST["page_size"];
	$SortOrder = $_POST["SortOrder"];
	$searchID = $_POST["searchID"];
	
	if ($searchID<>"") {
	if ($SortBy=="memberid")
		$condition = " where memberid like '$searchID%' ";
	if ($SortBy=="managerid")
		$condition = " where managerid like '$searchID%' ";
	if ($SortBy=="membername")
		$condition = " where membername like '$searchID%' ";
	if ($SortBy=="ranking") {
		$rankname=mysql_query("SELECT no FROM ranking where name = '$searchID'");
		$ranky=mysql_result($rankname,0,"no");
		$condition = " where ranking like '$ranky%' "; }
	}
	else { $condition==""; }
	            	
	
	// orderby
	if($SortBy <> "") {
	$orderby = $SortBy; }
	else {
	$orderby = "ranking,memberid"; }
	
	// page size
	if($page_size <> "") {
	$pages = $page_size; }
	else {
	$pages = "100"; }
	
	// Sorting Desc/Asc
	if($SortOrder <> "") {
	$sort = $SortOrder; }
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
		$memberidsql=mysql_query("SELECT memberid FROM memberid WHERE memberid='$memberid'");
				$memberidrow=mysql_num_rows($memberidsql);
					if($memberidrow){echo "<SCRIPT language=\"JavaScript\">alert('MemberId Already Exists!');</SCRIPT>";$action='add';}
					else {
					
						if ($main=="")
							$main = 2;
		
		mysql_query("INSERT INTO memberid (no, memberid, password, status, managerid, membername, membercontact1, membercontact1tick, membercontact2, membercontact2tick, bankaccount, remarks, sms, datetime) VALUES('', '$memberid', '$password', '1', UCASE('$managerid'), '$name', '$contact1', '$membercontact1tick', '$contact2', '$membercontact2tick', '$bankaccount', '$remarks', '$main', '$datetime')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('New Member Added!');</SCRIPT>";}
		break;
			}
		}
	if($action=='add'){
	echo "<form action='viewallmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='60%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' valign='top'><span class='bn13text'>Member ID&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='memberid' size='15' maxlength='6' value='$memberid' onBlur='up(this);'>&nbsp;<select name='managerid'>";
	$manageridsql=mysql_query("SELECT DISTINCT managerid FROM managerid ORDER BY managerid ASC");
	$manageridrow=mysql_num_rows($manageridsql);
	if($managerid!=NULL){echo"<option value='$managerid'>$managerid</option>";}
		for($count=0; $count<$manageridrow; $count++)
		{$data=mysql_result($manageridsql,$count,"managerid");
		if($managerid!=$data){echo"<option value='$data'>$data</option>";}}
	  echo "</select></td><td align='right' valign='top'><span class='bn13text'>Password&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='password' name='password' size='15' maxlength='15'><td align='right' valign='top'></td>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Name&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='name' size='15' maxlength='12' value='$name'><td align='right' valign='top'><span class='bn13text'>Bank Account&nbsp;</span></td></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Mobile1&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='8' value='$contact1' onBlur='numeric(this)'>&nbsp;";
//	if($main=='2'){echo"<span class='bn13text'>Main<select name='main'><option value='2'>2</option><option value='1'>1</option></select></span>";}
//if($main=='2'){echo"<span class='bn13text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	//else{echo"<span class='bn13text'>Main<select name='main'><option value='1'>1</option><option value='2'>2</option></select></span>";}
	if($main=='2'){echo"<span class='bn13text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	else{echo"<span class='bn13text'><span class='bn13text'>SMS<input type='checkbox' name='main' value='2'></span>";}
	echo"</td><td align='right' valign='top'><span class='bn13text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Mobile2&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='13' value='$contact2' onBlur='numeric(this)'></td><td align='center' valign='top' colspan='3'></td></tr>";
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
	
	echo "<form action='viewallmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='60%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' valign='top'><span class='bn13text'>Member ID&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='memberid' size='15' maxlength='6' value='$memberid' readonly='true'>&nbsp;<select name='managerid'>";
	if ($managerid<>"")
	echo "<option value='$managerid'>$managerid</option>";
	$manageridsql=mysql_query("SELECT DISTINCT managerid FROM managerid ORDER BY managerid ASC");
	while ($row_manageridsql = mysql_fetch_array($manageridsql)) 
	{
	$nihao = $row_manageridsql[0];
	echo "<option value='$nihao'>$nihao</option>";
	}
	 echo "</select></td><td align='right' valign='top'><span class='bn13text'>Password&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='password' name='password' size='15' maxlength='15'><td align='right' valign='top'></td>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Name&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='name' size='15' maxlength='12' value='$name'><td align='right' valign='top'><span class='bn13text'>Bank Account&nbsp;</span></td></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Mobile1&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='8' value='$contact1' onBlur='numeric(this)'>&nbsp;";
	//if($main=='2'){echo"<span class='bn13text'>Main<select name='main'><option value='2' selected='selected'>2</option><option value='1'>1</option></select></span>";}
	//if($main=='2'){echo"<span class='bn13text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	//else{echo"<span class='bn13text'>Main<select name='main'><option value='1' selected='selected'>1</option><option value='2'>2</option></select></span>";}
	if($main=='2'){echo"<span class='bn13text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	else{echo"<span class='bn13text'><span class='bn13text'>SMS<input type='checkbox' name='main' value='2'></span>";}
	echo"</td><td align='right' valign='top'><span class='bn13text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn13text'>Mobile2&nbsp;</span></td><td align='center' valign='top'><span class='bn13text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='13' value='$contact2' onBlur='numeric(this)'></td><td align='center' valign='top' colspan='3'></td></tr>";
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Update' title='Edit Member'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewallmember.php'\" title='Cancel New Member'></td></tr></form>";
  echo"<tr><td height='10' colspan='4'></td></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	
	if($action=='Update'){
	if ($password<>"") {
	mysql_query("update memberid set membername='$name',membercontact1='$contact1',sms='$main',membercontact2='$contact2',bankaccount='$bankaccount',remarks='$remarks',managerid=UCASE('$managerid'),password=$password where memberid = UCASE('$memberid')") or die(mysql_error());
	}
	else
	{
	mysql_query("update memberid set membername='$name',membercontact1='$contact1',sms='$main',membercontact2='$contact2',bankaccount='$bankaccount',remarks='$remarks',managerid=UCASE('$managerid') where memberid = UCASE('$memberid')") or die(mysql_error());
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
				echo"<tr><td align='left'><a href='viewmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewmember.php.php' method='post' style='margin-bottom:0;'></form></td></tr>";
/*				<select name='action' onchange='this.form.submit()'><option>ALL</option><option value='1'>Active</option><option value='0'>Inactive</option></select>*/
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
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr >
	<td align="center"><span class="bn13text"><b>Member ID</b></span></td>
	<td align="center"><span class="bn13text"><b>Name</b></span></td>
	<td align="center"><span class="bn13text"><b>Total</b></span></td>
	<td align="center"><span class="bn13text"><b>Outstanding</b></span></td>
	<td align="center"><span class="bn13text"><b>Pending Due </b></span></td>
	<td align="center"><span class="bn13text"><b>Mobile1</b></span></td>
		<td align="center"><span class="bn13text"><b>Mobile2</b></span></td>
	<td align="center"><span class="bn13text"><b>Bank Account</b></span></td>
	<td align="center"><span class="bn13text"><b>Remarks</b></span></td>
<td align="center"><span class="bn13text"><b>Ranking</b></span></td>
	<td align="center"><span class="bn13text"><b>MD</b></span></td>
	<td align="center"><span class="bn13text"><b>Action</b></span></td>
<?php
	$action=$_POST[action];
//$memberidsql=mysql_query("SELECT memberid,membername,membercontact1,bankaccount,remarks,managerid FROM memberid ORDER BY datetime DESC");
//	$memberidsql=mysql_query("SELECT memberid,membername,membercontact1,bankaccount,remarks,managerid,sms,membercontact2,ranking FROM memberid $ID ORDER BY $orderby $sort limit $pages");

$memberidsql=mysql_query("SELECT memberid,membername,membercontact1,bankaccount,remarks,managerid,sms,membercontact2,ranking FROM memberid $condition $filthy $filtmanager ORDER BY $orderby $sort limit $pages");

//echo "SELECT memberid,membername,membercontact1,bankaccount,remarks,managerid,sms,membercontact2,ranking FROM memberid $condition ORDER BY $orderby $sort limit $pages" . "<br>";
	$memberidrow=mysql_num_rows($memberidsql);
//	echo $memberidrow;
	for($count=0; $count<$memberidrow; $count++)
	{
	echo "<tr>";
	$memberid=mysql_result($memberidsql,$count,"memberid");

	//store in table:
	if ($tablemem=="") {
			$tablemem = "'" . $memberid . "'";
		}
		else
		{
			$tablemem = $tablemem . ",'" . $memberid . "'";
		}
	//store in table:
		
//$getvalues=mysql_query("SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$memberid')+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid')) FROM bmdatabase_payment where memberid='$memberid'");
//$getvalues=mysql_query("SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$memberid' and pm=0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' and pm=0)),(SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$memberid' and pm=1)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where pm=1 and memberid in (select subid from submembers where memberid='$memberid')) FROM bmdatabase_payment where memberid='$memberid' and pm=1) FROM bmdatabase_payment where memberid='$memberid'");
 
 
 $bmreport=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
+ (select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
) as outstanding FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'");
$row_values1 = mysql_fetch_array($bmreport);

$bmreport_pm=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')
+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid')
 and pm='1')+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_payment where memberid in 
 (select subid from submembers where memberid='$memberid') and pm='1')
) as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1'");
 $row_values2 = mysql_fetch_array($bmreport_pm);
 
	//	echo "SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$memberid')+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid')),(SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$memberid' and pm=1)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where pm=1 and memberid in (select subid from submembers where memberid='$memberid')) FROM bmdatabase_payment where memberid='$memberid' and pm=1) FROM bmdatabase_payment where memberid='$memberid'" . "<br><br>";
			//$row_values = mysql_fetch_array($getvalues);
			$balance = $row_values1[0];
			$due = $row_values2[0];
			//echo "balance: " . $balance . "<br>";
			//echo "due: " . $due . "<br>";
			
			//$total = number_format(($balance + $due),2);
			$total = number_format($balance + $due,2);
			
			
		/*	$final_total = $final_total+($balance + $due);
			$final_due = $final_due+$due;
			$final_balance = ($final_balance+$balance)-$final_due;*/
			
			
			$final_balance = $final_balance + $balance;
			$final_due = $final_due + $due;
			
	if (($balance<>"" && $balance<>0) || ($itago==0) || ($due<>"" && $due<>0)) {
	/*echo "balance: " . $balance . "<br>";
	echo "due: " . $due . "<br>";
	echo "total: " . $total . "<br>";*/
	echo "<td align='center'><span class='bn13text'><a href='viewallmember.php?action=edit&memberid=$memberid' target='_self'>$memberid</a></span></td>";
	$membername=mysql_result($memberidsql,$count,"membername");
	echo "<td align='center'><span class='bn13text'>$membername</span></td>";
		
		//-=-= colors
		if ($total<=0)
		echo "<td align='center' ><span class='bn13textblue'><a style='color: #FF0000' href='javascript: openScript(\"viewmemberdetails.php?memberid=$memberid&managerid=$managerid\",1000,600)' target='_self'>$total</a></span></td>";
		else
		echo "<td align='center' ><span class='bn13textred'><a style='color: #0000FF' href='javascript: openScript(\"viewmemberdetails.php?memberid=$memberid&managerid=$managerid\",1000,600)' target='_self'>$total</a></span></td>";
		
	if ($balance=="" || $balance==0)
	//echo "<td align='center'><span class='bn13text'><a href='viewallmember.php?memberid=$memberid&managerid=$managerid' target='_self'>0.00</a></span></td>";
	echo "<td align='center'><span class='bn13text'>0.00</span></td>";
	else
	//echo "<td align='center'><span class='bn13text'><a href='javascript: openScript(\"viewmemberdetails.php?memberid=$memberid&managerid=$managerid\",800,600)'>$balance</a></span></td>";
		if ($balance<=0)
		echo "<td align='center' style='color: red;'><span class='bn13textred'>$balance</span></td>";
		else
		echo "<td align='center' style='color: blue;'><span class='bn13textblue'>$balance</span></td>";
		
		if ($due<=0)
		echo "<td align='center' style='color: red;'><span class='bn13textred'>$due</span></td>";
		else
		echo "<td align='center'  style='color: blue;'><span class='bn13textblue'>$due</span></td>";
	
	
	$data=mysql_result($memberidsql,$count,"membercontact1");
	if ($data<>0)
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	else
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	
	$data=mysql_result($memberidsql,$count,"membercontact2");
	if ($data<>0)
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	else
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	/*$mobile=mysql_result($memberidsql,$count,"sms");
	if($mobile=='1'){$data=mysql_result($memberidsql,$count,"membercontact1");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	else{$data=mysql_result($memberidsql,$count,"membercontact1");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	
	if($mobile=='2'){$data=mysql_result($memberidsql,$count,"membercontact2");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	else{$data=mysql_result($memberidsql,$count,"membercontact2");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";}*/
	
	
	$data=mysql_result($memberidsql,$count,"bankaccount");
	echo "<td align='center'><span class='bn13text'>$data</span></td>";
	$remarks=mysql_result($memberidsql,$count,"remarks");
	echo "<td align='center'><span class='bn13text'>$remarks</span></td>";
	
	$ranking=mysql_result($memberidsql,$count,"ranking");
	$rankname=mysql_query("SELECT name FROM ranking where no = '$ranking'");
	$rankname=mysql_result($rankname,0,"name");
	echo "<td align='center'><span class='bn13text'>$rankname</span></td>";	
	
	$managerid=mysql_result($memberidsql,$count,"managerid");	
	echo "<td align='center'><span class='bn13text'>$managerid</span></td>";
	echo "<td align='center'><span class='bn13text'><a href='viewallmember.php?action=delete&memberid=$memberid' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></span></td>";
	/*echo "<td align='center'><a href='viewallmember.php?action=edit&id=$serialno' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a>&nbsp;&nbsp;<a href='viewallmember.php?action=delete&id=$serialno' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></td>";*/
	echo "</tr>";} 
//	echo "get_memberid: " . $_GET["memberid"];
//	echo "memberid: " . $memberid;
		//if ($_GET["managerid"]==$managerid && $_GET["memberid"]==$memberid && $balance<>0)
		/*if ($_GET["memberid"]==$memberid && $balance<>0)
		{
	//	echo $ctr++;
	echo "<tr><td colspan='12'>";*/
	?>

<?php
	echo "</td></tr>";
	//	}	
	}
	 $final_total = $final_balance + $final_due;
	  $final_total = number_format($final_total,2);
	  $final_balance = number_format($final_balance,2);
	//  $final_total = number_format($final_total,2);
	  $final_due = number_format($final_due,2);
	 

	?>
	<tr >
	  <td colspan="2" align="center"><span class="bn13text"><b>Member Total: </b></span><span class="bn13text"></span></td>
	  <td align="center"><span class="bn13text"><b><?php echo $final_total; ?></b></span></td><td align="center"><span class="bn13text"><b>
	  <?php
	  $pm=strtoupper(mysql_result($bmsql2,$count2,"pm"));
	/*  if ($pm==0) {
		  if ($getvalues=="" || $getvalues==NULL)
			  echo "0.00";
		  else*/
	   		echo $final_balance . "</b></span></td>";
	//  }
	//  else
	  echo "<td align='center'><span class='bn13text'><b>$final_due</b></span></td><td colspan='7' align='center'>&nbsp;</td>";
	    ?>
	   
    </tr>
</table>
<br>
<div align="center">
<?php
//echo $tablemem;
//$total_no_pages = floor($memberidrow / $pagesize);
//$memberidrow; // all results
//$pagesize; // adtive pages

?>
<?php if ($first_page==0) { ?>
<input class="formButton" value="First Page" name="First" type="submit" disabled="disabled"> 
<?php  } else { ?>
<input class="formButton" value="First Page" name="First" type="submit"> 
<?php } ?>
<?php if ($first_page==0) { ?>
<input class="formButton" value="Previous Page" name="Prev" type="submit" disabled="disabled"> 
<?php  } else { ?>
<input class="formButton" value="Previous Page" name="Prev" type="submit"> 
<?php } ?>
<?php if ($_POST["page_size"]>$memberidrow) { ?>
<input class="formButton" value="Next Page" name="Next" onClick="document.BrowseForm.pageNo.value=2;" type="submit" disabled="disabled"> 
<?php  } else { ?>
<input class="formButton" value="Next Page" name="Next" onClick="document.BrowseForm.pageNo.value=2;" type="submit" > 
<?php  } ?>
<?php if ($_POST["page_size"]>$memberidrow) { ?>
<input class="formButton" value="Last Page" name="Last" onClick="document.BrowseForm.pageNo.value=41;" type="submit" disabled="disabled">
<?php  } else { ?>
<input class="formButton" value="Last Page" name="Last" onClick="document.BrowseForm.pageNo.value=41;" type="submit">
<?php  } ?>
	<!--	Page : 
		<?php
				   /* $fullrow=mysql_query("SELECT COUNT(memberid) FROM memberid");
					$row_fullrow = mysql_fetch_array($fullrow);
					$allrows = $row_fullrow['COUNT(memberid)'];
					echo "allrows: " . $allrows . "<br>";
					echo "pagesize: " . $_POST["page_size"] . "<br>";
					if ($_POST["page_size"]=="")
					$_POST["page_size"]=1;
				    if ($allrows<=$_POST["page_size"])
				    echo "1";				*/
					?>
			<select class="searchformfiled" size="1" name="pageNo" onChange="document.BrowseForm.submit();">
                   <?php
				 	 $fullrow=mysql_query("SELECT COUNT(memberid) FROM memberid");
					$row_fullrow = mysql_fetch_array($fullrow);
					$allrows = $row_fullrow['COUNT(memberid)'];
					if ($allrows<=$_POST["page_size"]) { ?>
				    <option value="1" selected="selected">1</option>
					<?php } else {
					
					$allrows = floor($allrows / $_POST["page_size"]);
					for ($i=1;$i<=$allrows;$i++)
							{
					?>
					 <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					 <?php
							 }
					  } ?>
  </select> of <?php echo $allrows; ?>&nbsp;&nbsp;&nbsp;Showing <?php echo $_POST["page_size"]; ?> of <?php echo $all_data; ?> Found.-->
</form>
</div>
</body>
</html>