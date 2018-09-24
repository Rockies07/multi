<?php
session_start();
	
$weblogin=$_SESSION["weblogin"];
$webpassword=$_SESSION["webpassword"];	

include "include/include.php";

//$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
$rights=mysql_num_rows($login);
if(!$rights){header("location:index.php");}
$result="";

if ($_GET["reset"]==1) {
//echo "betlog";
$_SESSION["countzz"]="";
$_SESSION["pageNum"] = 1;
$_SESSION["delimiter"] = "";
}

$countz = 0;
$supercount = 0;
//echo $_SESSION["supercount"];
$memberidroww = 0;
$kawnnnt = "";
$page_size = "";
//if ($_POST["page_size"]=="")
if ($_POST["page_size"]=="")
	$_POST["page_size"]=200;
if ($_GET["payge"]<>"")
	$_POST["page_size"]=$_GET["payge"];

	$_SESSION["page_size"] = $_POST["page_size"];

//if ((!($_POST["Next"])) && (!($_POST["Last"])) && (!($_POST["Prev"])) && (!($_POST["First"]) )&& (!($_POST["Submit2"]))&& (!($_POST["view"])))
/*if (($_GET["submit2"]) || ($_GET["view"])){

$_SESSION["delimiter"] = "";
}*/
//
//echo $_GET["page"]; 
//if ($_GET["page"]<>"");
//$_SESSION["pageNum"] = $_GET["page"];

	//-=-=- catch back
	$payge = $_GET["payge"];
	$pagenum = $_GET["pagenum"];
	$delimit = $_GET["delimit"];
	$SortBy = $_GET["SortBy"];
	$searchID = $_GET["searchID"];
	$filter = $_GET["filter"];
	$mayneger = $_GET["mayneger"];
	$hiddenf = '1';
	$SortOrder = $_GET["SortOrder"];
	//$_POST["SortOrder"]
	
	
//	if (($_GET["payge"]<>"") && ($_GET["pagenum"]<>"")) {
	if ($_GET["payge"]<>"") {
		$_POST["page_size"] = $payge;
		$_SESSION["pageNum"] = $pagenum;
		//$delimiter = $delimit;
		$_SESSION["delimiter"] = $delimit;
		$_POST["SortBy"] = $SortBy;
		$_POST["searchID"] = $searchID;
		$_POST["filter"] = $filter;
		$_POST["mayneger"] = $mayneger;
		$_POST["hiddenf"] = $hiddenf;
		$_POST["SortOrder"] = $SortOrder;
		}
		
/*		echo $_POST["page_size"] . "<br>";
		echo $_SESSION["pageNum"] . "<br>";
		echo $_SESSION["delimiter"] . "<br>";
		echo $_POST["SortBy"] . "<br>";
		echo $_POST["searchID"] . "<br>";
		echo $_POST["filter"] . "<br>";
		echo $_POST["mayneger"] . "<br>";
		echo $_POST["hiddenf"] . "<br>";
		echo $_POST["SortOrder"] . "<br>";*/

//echo "delimiter: " . $_SESSION["delimiter"];
//	echo $_SESSION["pageNum"] . "<br>";
//	echo $_POST["page_size"] . "<br>";

//echo $delimiter;3
//	echo $_SESSION["pageNum"];
if ($delimiter>$_POST["page_size"])
$delimiter = $_POST["page_size"];

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
<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='1000px' align='center' class='outline'>
<tr>
<td height='10'><span class="bn12text">
			  <?php if ($_POST["page_size"] <> "") { ?>
 Page Size:<input class="searchformfiled" type="text" value="<?php echo $_POST["page_size"]; ?>" name="page_size" size="3">
			   <?php } else { ?>
 Page Size:<input class="searchformfiled" type="text" value="200" name="page_size" size="3">
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
 
 $_SESSION["SortOrder"] = $_POST["SortOrder"];
 
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
</span>
 <b>
<?php
$hiddenf = '1';
//echo $hiddenf;
if ($hiddenf==0 || $hiddenf=="") {
		//$hide_me = " and clr = '0'";
	//	echo "a";
		$itago = 0;
		$hidden_dragon = "";
/*		$hidden_dragon = " where
(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout 
 where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from 
 submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)
 +(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')
  +(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from 
  bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) 
  from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in
   (select subid from submembers where memberid=a.memberid) and pm='1')<>0.00 ";*/
		//$itagow = ; 
		}
else {
		$itago = 1;
		$hidden_dragon = "";
		//$itagow =
	//	echo "b";
		}
		$_SESSION["hiddenf"] = $_POST["hiddenf"];
  /*if ($hiddenf==0) { ?>
    <input type="checkbox"  name="hiddenf" onClick="document.sorttools.submit();" value="1">
	<?php } else { ?>
	<input type="checkbox" name="hiddenf" onClick="document.sorttools.submit();" value="1" checked="checked">
	<?php } */?>
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

	$hide_me = " ";
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
</table>
<table border="0" cellpadding="0" cellspacing="0" width="1000px" align="center">
	<tr><td align="center" colspan="3"><span class="maintitle">View Member</span></td></tr>
    
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
	$pages = "200"; }
	
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
	echo "<form action='viewallmemberb.php' method='post' style='margin-bottom:0;'>";
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
	<td align='right' valign='top'><span class='bn12text'>Site&nbsp;</span></td></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Incharge&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='30' value='$contact1'>&nbsp;";
	if($main=='2'){echo"<span class='bn12text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	else{echo"<span class='bn12text'><span class='bn12text'>SMS<input type='checkbox' name='main' value='2'></span>";}
	echo"</td><td align='right' valign='top'><span class='bn12text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Mobile&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='13' value='$contact2' onBlur='numeric(this)'></td><td align='center' valign='top' colspan='3'></td></tr>";
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Submit' title='Add New Member'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewallmemberb.php'\" title='Cancel New Member'></td></tr></form>";
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
	
	echo "<form action='viewallmemberb.php' method='post' style='margin-bottom:0;'>";
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
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Name&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='name' size='15' maxlength='12' value='$name'><td align='right' valign='top'><span class='bn12text'>Site&nbsp;</span></td></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='bankaccount' maxlength='20' value='$bankaccount'></span></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Incharge&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact1' size='15' maxlength='30' value='$contact1'>&nbsp;";
	if($main=='2'){echo"<span class='bn12text'>SMS<input type='checkbox' name='main' value='1' checked='checked'></span>";}
	else{echo"<span class='bn12text'><span class='bn12text'>SMS<input type='checkbox' name='main' value='2'></span>";}
	echo"</td><td align='right' valign='top'><span class='bn12text'>Remark&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></td></tr>";
	echo "<tr><td align='right' valign='top'><span class='bn12text'>Mobile&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td align='left'><input type='text' name='contact2' size='15' maxlength='13' value='$contact2' onBlur='numeric(this)'></td><td align='right' valign='top'><span class='bn12text'>SubID&nbsp;</span></td><td align='center' valign='top'><span class='bn12text'>:</span></td><td valign='top' colspan='2'><span class='bn12text'>$submemlist</span></td></tr>";
	
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Update' title='Edit Member'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewallmemberb.php'\" title='Cancel New Member'></td></tr></form>";
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
	{echo"<tr><td align='left'><a href='viewallmemberb.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td></tr>";}

	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="1000px" align="center" class="stats">
	<tr align="center">
	<td class="hed" width="30px"><span class="bn12text"><b>ID</b></span></td>
	<td class="hed"><span class="bn12text"><b><div align="center">Name</div></b></span></td>
	<td class="hed"><span class="bn12text"><b><!--<a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; text-decoration:none; font-weight:normal; ' href='#'>-->Total<!--</a>--></b></span></td>
	<td class="hed"><span class="bn12text"><b><!--<a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; text-decoration:none; font-weight:normal; ' href='#'>-->Outstanding<!--</a>--></b></span></td>
	<td class="hed"><span class="bn12text"><b>Amount  Due </b></span></td>
	<td class="hed" ><span class="bn12text"><b>Incharge</b></span></td>
	<td class="hed" width="200px"><span class="bn12text"><b>Site</b></span></td>
	<td class="hed" width="200px"><span class="bn12text"><b>Remarks</b></span></td>
<td class="hed" width="28px"><span class="bn12text"><b>Ranking</b></span></td>
	<td class="hed" width="28px"><span class="bn12text"><b>MD</b></span></td>
	<!--<td class="hed"><span class="bn12text"><b>Action</b></span></td>-->
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

/*echo $rowsPerPage . "<br>";
echo $offset . "<br>";
echo $pageNum . "<br>";*/
	
//$memberidsql = "select a.memberid,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') as outstanding,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as pmdue,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') +(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as total,a.membername,a.membercontact1,a.bankaccount,a.remarks,a.sms,a.membercontact2,a.ranking,a.status,a.managerid from memberid a $hidden_dragon $condition $filthy $filtmanager ORDER BY $orderby $sort";

//$memberidsql = "select a.memberid,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') as outstanding,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as pmdue,a.membername,a.membername,a.membercontact1,a.bankaccount,a.remarks,a.sms,a.membercontact2,a.ranking,a.status,a.managerid from memberid a $hidden_dragon $condition $filthy $filtmanager ORDER BY $orderby $sort";

$memberidsql = "select a.memberid,a.membername,a.membercontact1,a.bankaccount,a.remarks,a.sms,a.membercontact2,a.ranking,a.status,a.managerid from memberid a $hidden_dragon $condition $filthy $filtmanager ORDER BY $orderby $sort";

//echo $memberidsql;

//,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') as outstanding,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as pmdue

//,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') +(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as total,

//echo "select a.memberid,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') as outstanding,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as pmdue,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') +(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as total,a.membername,a.membercontact1,a.bankaccount,a.remarks,a.sms,a.membercontact2,a.ranking,a.status,a.managerid from memberid a $hidden_dragon $condition $filthy $filtmanager ORDER BY $orderby $sort";

//echo "select a.memberid,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') as outstanding,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as pmdue,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') +(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as total,a.membername,a.membercontact1,a.bankaccount,a.remarks,a.sms,a.membercontact2,a.ranking,a.status,a.managerid from memberid a $condition $filthy $filtmanager ORDER BY $orderby $sort" . "<br>";

$pagingQuery = " LIMIT $offset, $rowsPerPage";
//echo $memberidsql . $pagingQuery;
$result = mysql_query($memberidsql . $pagingQuery); 
//echo $memberidsql . $pagingQuery;
//echo "select a.memberid,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') as outstanding,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as pmdue,(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='0')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=0)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='0') +(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid=a.memberid) and pm='1')+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid=a.memberid and pm=1)+(select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid=a.memberid) and pm='1') as total,a.membername,a.membercontact1,a.bankaccount,a.remarks,a.sms,a.membercontact2,a.ranking,a.status,a.managerid from memberid a $condition $filthy $filtmanager ORDER BY $orderby $sort" . "<br>";
//$full_values = mysql_fetch_array($memberidsql);



	//$memberidroww=mysql_num_rows($memberidsql . $pagingQuery);
while ($row_memlist = mysql_fetch_array($result)) 
{

	/*$sqloutstanding ="call outstanding('$row_memlist[0]',@outamount);";
	$doquery = mysql_query($sqloutstanding);
	$sqlpegrp ="select @outamount";
	$doquery = mysql_query($sqlpegrp);
	$r=mysql_fetch_assoc($doquery);
	$outstanding = $r['@outamount'];
	
	$sqldue ="call pmdue('$row_memlist[0]',@outpmdue);";
	$doquery = mysql_query($sqldue);
	$sqlpegrp ="select @outpmdue";
	$doquery = mysql_query($sqlpegrp);
	$r=mysql_fetch_assoc($doquery);
	$pmdue = $r['@outpmdue'];*/

	$longtuts = mysql_query("select total,outstanding,amountdue from member_total where memberid='$row_memlist[0]'");
//	
//	$ranking=mysql_result($longtuts,0,"total");
	$outstanding=mysql_result($longtuts,0,"outstanding");
	
	//$sqlGetPmDueFPlaceout=mysql_query("SELECT IFNULL(SUM(amount),0) as totalDueFPlaceout FROM bmdatabase_wlplaceout WHERE memberid IN (SELECT subid FROM submembers WHERE memberid='$row_memlist[0]') AND pm='1'");
	//$getPmDueFPlaceout=mysql_result($sqlGetPmDueFPlaceout,0,"totalDueFPlaceout");
	
	//$sqlGetPmDueFPayt=mysql_query("SELECT IFNULL(SUM( ),0) as totalDueFPayment FROM bmdatabase_payment WHERE memberid  IN (SELECT subid FROM submembers WHERE memberid='$row_memlist[0]') AND NOT TYPE = 'INT' AND pm='1'");
	//$getPmDueFPayment=mysql_result($sqlGetPmDueFPayment,0
	
	$pmdue=mysql_result($longtuts,0,"amountdue") ;
	
	$utot = mysql_query("select logindate from member_log where memberid='$row_memlist[0]'");
	$logindate=mysql_result($utot,0,"logindate");
	
	$totel = $outstanding + $pmdue;
	$super_total = $super_total + $totel;
	$super_outstanding = $super_outstanding + $outstanding;
	$super_due = $super_due + $pmdue;
	
//-=-=- insertion to new table
$total = number_format(($outstanding + $pmdue),2);
//mysql_query("INSERT INTO member_total (memberid, total, outstanding, amountdue) VALUES('$row_memlist[0]', '$totel', '$outstanding', '$pmdue')") or die(mysql_error());

//	$total = number_format(($outstanding + $pmdue),2);
	if ($total<>'0.00' && $itago==0) {
	echo "<td align='center'><a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; font-weight:normal;  ' href='viewallmemberb.php?action=edit&memberid=$row_memlist[0]&page=".$_GET["page"]."&payge=".$_SESSION["page_size"]."&SortOrder=".$_SESSION["SortOrder"]."&SortBy=".$_SESSION["SortBy"]."&hiddenf=".$_SESSION["hiddenf"]."&searchID=".$_SESSION["searchID"]."&filter=".$_SESSION["filter"]."&mayneger=".$_SESSION["mayneger"]."' target='_self'>$row_memlist[0]</a></td>";// memberid
	echo "<td align='center'><span class='bn12text'>$row_memlist[1]</span></td>"; // membername
		
		//-=-= colors
		if ($total<0) {
		if ($_GET["page"]=="") $_GET["page"] = 1;
		echo "<td align='center' ><a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:red; font-weight:normal; ' href='javascript: openScript(\"viewmemberdetailsb.php?memberid=$row_memlist[0]&managerid=$row_memlist[10]&payge=$page_size&pagenum=". $_GET["page"] . "&delimit=".$_SESSION["delimiter"]."&SortBy=". $_POST["SortBy"] . "&searchID=". $_POST["searchID"] . "&filter=". $_POST["filter"] . "&mayneger=". $_POST["mayneger"] . "&hiddenf=". $_POST["hiddenf"] . "&SortOrder=". $_POST["SortOrder"] . "&renew=1\",1000,600)' target='_self'>$total</a></td>";
		}
		else {
		if ($_GET["page"]=="") $_GET["page"] = 1;
			echo "<td align='center' ><a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:blue; font-weight:normal; ' href='javascript: openScript(\"viewmemberdetailsb.php?memberid=$row_memlist[0]&managerid=$row_memlist[10]&payge=$page_size&pagenum=". $_GET["page"] . "&delimit=".$_SESSION["delimiter"]."&SortBy=". $_POST["SortBy"] . "&searchID=". $_POST["searchID"] . "&filter=". $_POST["filter"] . "&mayneger=". $_POST["mayneger"] . "&hiddenf=". $_POST["hiddenf"] . "&SortOrder=". $_POST["SortOrder"] . "&renew=1\",1000,600)' target='_self'>$total</a></td>";
			
			}
			
/*	if ($outstanding<=="" || $outstanding<==0.00)
	echo "<td align='center'><span class='bn12text'>0.00</span></td>";
	else*/
		if ($outstanding<0)
		echo "<td align='center' ><span style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:red; font-weight:normal; '>".number_format($outstanding,2)."</span></td>";
		else
		echo "<td align='center' ><span style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:blue; font-weight:normal; '>".number_format($outstanding,2)."</span></td>";
		
		if ($pmdue<0)
		echo "<td align='center' style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:red; font-weight:normal; '><span class='bn12textred'>".number_format($pmdue,2)."</span></td>";
		else
		echo "<td align='center'  style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:blue; font-weight:normal; '><span class='bn12textblue'>".number_format($pmdue,2)."</span></td>";
	
	
	if ($row_memlist[2]<>"0")
	echo "<td align='center'><span class='bn12text'>$row_memlist[2]</span></td>"; // contact1
	else
	echo "<td align='center'><span class='bn12text'>-</span></td>";
	
	/*if ($row_memlist[6]<>"0")
	echo "<td align='center'><span class='bn12text'>$row_memlist[6]</span></td>"; // contact2
	else
	echo "<td align='center'><span class='bn12text'>-</span></td>";*/
	
	$bbb=strtotime(str_replace("-", "/",$logindate));
	$logindater=date("j/m/y H:i",$bbb);
	

	if ($row_memlist[3]<>"")
	echo "<td align='center'><span class='bn12text'>$row_memlist[3]</span></td>"; // bank
	else
	echo "<td align='center'><span class='bn12text'>-</span></td>";
	
	if ($row_memlist[4]<>"")
	echo "<td align='center'><span class='bn12text'>$row_memlist[4]</span></td>"; // remarks
	else
	echo "<td align='center'><span class='bn12text'>-</span></td>";
	
	$ranking=mysql_result($memberidsql,$countz,"ranking");
	$rankname=mysql_query("SELECT name FROM ranking where no = '".$row_memlist[7]."'");
	$rankname=mysql_result($rankname,0,"name");
	echo "<td align='center'><span class='bn12text'>$rankname</span></td>";	 // rank
	//echo "<td align='center'><span class='bn12text'></span></td>";	
	
	echo "<td align='center'><span class='bn12text'>$row_memlist[9]</span></td>";	 // manager
	echo "</tr>"; 

/*	$super_total = $super_total + $total;
	$super_outstanding = $super_total + $outstanding;
	$super_due = $super_due + $pmdue;*/
	}
	else
	if ($itago==1) {
	echo "<td align='center'><a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; font-weight:normal;  ' href='viewallmemberb.php?action=edit&memberid=$row_memlist[0]' target='_self'>$row_memlist[0]</a></td>";// memberid
	echo "<td align='center'><span class='bn12text'>$row_memlist[1]</span></td>"; // membername
		
		//-=-= colors
		if ($outstanding<0) {
		if ($_GET["page"]=="") $_GET["page"] = 1;
		echo "<td align='center' ><a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:red; font-weight:normal; ' href='javascript: openScript(\"viewmemberdetailsb.php?memberid=$row_memlist[0]&managerid=$row_memlist[10]&payge=$page_size&pagenum=". $_GET["page"] . "&delimit=".$_SESSION["delimiter"]."&SortBy=". $_POST["SortBy"] . "&searchID=". $_POST["searchID"] . "&filter=". $_POST["filter"] . "&mayneger=". $_POST["mayneger"] . "&hiddenf=". $_POST["hiddenf"] . "&SortOrder=". $_POST["SortOrder"] . "&renew=1\",1000,600)' target='_self'>$total</a></td>"; }
		else {
		if ($_GET["page"]=="") $_GET["page"] = 1;
			echo "<td align='center' ><a style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:blue; font-weight:normal; ' href='javascript: openScript(\"viewmemberdetailsb.php?memberid=$row_memlist[0]&managerid=$row_memlist[10]&payge=$page_size&pagenum=". $_GET["page"] . "&delimit=".$_SESSION["delimiter"]."&SortBy=". $_POST["SortBy"] . "&searchID=". $_POST["searchID"] . "&filter=". $_POST["filter"] . "&mayneger=". $_POST["mayneger"] . "&hiddenf=". $_POST["hiddenf"] . "&SortOrder=". $_POST["SortOrder"] . "&renew=1\",1000,600)' target='_self'>$total</a></td>";
			
			}
			
/*	if ($outstanding<=="" || $outstanding<==0.00)
	echo "<td align='center'><span class='bn12text'>0.00</span></td>";
	else*/
		if ($outstanding<0)
		echo "<td align='center' ><span style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:red; font-weight:normal; '>".number_format($outstanding,2)."</span></td>";
		else
		echo "<td align='center' ><span style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:blue; font-weight:normal; '>".number_format($outstanding,2)."</span></td>";
		
		if ($pmdue<0)
		echo "<td align='center' style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:red; font-weight:normal; '><span class='bn12textred'>".number_format($pmdue,2)."</span></td>";
		else
		echo "<td align='center'  style='font-family:Arial, Helvetica, sans-serif; vertical-align:middle; font-size:12px; color:blue; font-weight:normal; '><span class='bn12textblue'>".number_format($pmdue,2)."</span></td>";
	
	
	if ($row_memlist[2]<>0)
	echo "<td align='center'><span class='bn12text'>$row_memlist[2]</span></td>"; // contact1
	else
	echo "<td align='center'><span class='bn12text'>-</span></td>";
	
	$bbb=strtotime(str_replace("-", "/",$logindate));
	$logindater=date("j/m/y H:i",$bbb);
	
	if ($logindate<>"0000-00-00 00:00:00" && $logindate<>'')
	echo "<td align='center'><span class='bn12text'>$logindater</span></td>"; // last login
	else
	echo "<td align='center'><span class='bn12text'>------</span></td>";

	if ($row_memlist[3]<>"")
	echo "<td align='center'><span class='bn12text'>$row_memlist[3]</span></td>"; // bank
	else
	echo "<td align='center'><span class='bn12text'>-</span></td>";
	
	if ($row_memlist[4]<>"")
	echo "<td align='center'><span class='bn12text'>$row_memlist[4]</span></td>"; // remarks
	else
	echo "<td align='center'><span class='bn12text'>-</span></td>";
	
	$ranking=mysql_result($memberidsql,$countz,"ranking");
	$rankname=mysql_query("SELECT name FROM ranking where no = '".$row_memlist[7]."'");
	$rankname=mysql_result($rankname,0,"name");
	echo "<td align='center'><span class='bn12text'>$rankname</span></td>";	 // rank
	//echo "<td align='center'><span class='bn12text'></span></td>";	
	
	echo "<td align='center'><span class='bn12text'>$row_memlist[9]</span></td>";	 // manager
	echo "</tr>"; 

/*	$super_total = $super_total + $total;
	$super_outstanding = $super_total + $outstanding;
	$super_due = $super_due + $pmdue;*/
	}
	
}
?>
<tr>
	  <td colspan="2" align="center" class="hed"><span class="bn12text"><b>Member Total: </b></span><span class="bn12text"></span></td>
	  <td align="center" class="hed"><span class="bn12text"><b><?php
	  if ($super_total<0)
		echo "<font color='red'>" . number_format($super_total,2) . "</font>";
		else
		echo "<font color='blue'>" . number_format($super_total,2) . "</font>";
	  
	  ?></b></span></td><td align="center" class='hed'><span class="bn12text"><b>
	  <?php
	 	if ($super_outstanding<0)
		echo "<font color='red'><b>" . number_format($super_outstanding,2) . "</font>" . "</b></span></td>";
		else
		echo "<font color='red'><b>" . number_format($super_outstanding,2) . "</font></b></span></td>";
		  
	  	if ($super_due<0)
		echo "<td align='center' class='hed'><span class='bn12text'><b><font color='red'>". number_format($super_due,2) . "</font></b></span></td><td colspan='7' class='hed'>&nbsp;</td>";
		else
		echo "<td align='center' class='hed'><span class='bn12text'><b><font color='blue'>". number_format($super_due,2) . "</font></b></span></td><td colspan='7' class='hed'>&nbsp;</td>";
	
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