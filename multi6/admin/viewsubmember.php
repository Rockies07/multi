<?php
session_start();
	
$weblogin=$_SESSION["weblogin"];
$webpassword=$_SESSION["webpassword"];	

include "include/include.php";

$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
$rights=mysql_num_rows($login);
if(!$rights){header("location:index.php");}
?>
<html>
<link rel="stylesheet" href="style.css" type="text/css" />
<script language="javascript">
function up(o){o.value=o.value.toUpperCase().replace(/([^0-9A-Z-])/g,"");}
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr>
	  <td align="center" colspan="3"><span class="maintitle">View Member Sub ID</span></td>
	</tr>
    
  	<?php
    $action=$_GET[action];
	if($action==NULL){$action=$_POST[action];}
	$memberid=$_POST[memberid];
	$subid=$_POST[subid];
	if ($_POST[memberid]=="")
	$memberid=$_GET[memberid];
	if ($_POST[subid]=="")
	$subid=$_GET[subid];
	$datetime=date("Y-m-d H:i:s");
	$deyt=date("Y-m-d");
	$rank=$_POST[rank];
	$remark=$_POST[remark];
	$filter=$_POST[filter];
	$no = $_POST[no];
	echo $no;
//	echo $subid;

if ($filter<>"" && $filter<>"ALL") {
		$filthy = " where ranking = '$filter' ";}
	
	switch($action){
		case "Submit":
		if(($subid==NULL))
		{echo "<SCRIPT language=\"JavaScript\">alert('Error Sub ID is a Must!');</SCRIPT>";
		$action='add';}
				else
				{
				$submemberidsql=mysql_query("SELECT subid FROM submembers WHERE subid='$subid' union SELECT memberid FROM memberid WHERE memberid='$subid'");
				$submemberidrow=mysql_num_rows($submemberidsql);
					if($submemberidrow){echo "<SCRIPT language=\"JavaScript\">alert('SubID Already Exists!');</SCRIPT>";break;}
					else {		
						$memrank=mysql_query("SELECT ranking FROM memberid where memberid='$memberid'");
						$memranking=mysql_result($memrank,0,"ranking");
						echo "<td align='center'><span class='bn13text'>$name</span></td>";
							mysql_query("INSERT INTO submembers (no, memberid, subid, datetime, ranking,remark) VALUES('', '$memberid', '$subid','$datetime','$memranking','$remark')") or die(mysql_error());
						echo "<SCRIPT language=\"JavaScript\">alert('New Member Sub ID Added!');</SCRIPT>";}
						
				}		
				break;
		case "delete":
		{
			$getvalues=mysql_query("SELECT ifnull(sum(amount), 0)+(select ifnull(sum(amount), 0) from bmdatabase_wlplaceout where memberid='$subid') as total FROM bmdatabase_payment where memberid='$subid'");
			$row_values = mysql_fetch_array($getvalues);
			if ($row_values[0]<>'0.00')
			{
				echo "<SCRIPT language=\"JavaScript\">alert('MemberId got an existing account record and cannot be deleted!');</SCRIPT>";//$action='add';
			}
			else
			{
				mysql_query("delete from submembers where memberid='$memberid' and subid='$subid'") or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('Member Sub ID Deleted!');</SCRIPT>";
				break;
			}
		}
		case "update":
		{
			
			$submemberidsql=mysql_query("SELECT subid FROM submembers WHERE subid='$subid' and no<>$no union SELECT memberid FROM memberid WHERE memberid='$subid'");
		//	echo "SELECT subid FROM submembers WHERE subid='$subid' union SELECT memberid FROM memberid WHERE memberid='$subid' and no<>$no" . "<br>";
				$submemberidrow=mysql_num_rows($submemberidsql);
					if($submemberidrow){echo "<SCRIPT language=\"JavaScript\">alert('SubID Already Exists!');</SCRIPT>";break;}
					else {		
					//	$memrank=mysql_query("SELECT ranking FROM memberid where memberid='$memberid'");
					//	$memranking=mysql_result($memrank,0,"ranking");
					//	echo "<td align='center'><span class='bn13text'>$name</span></td>";
						//	mysql_query("update submembers set subid='$subid', remark='$remark' where no='$no'") or die(mysql_error());
							mysql_query("update submembers set remark='$remark' where no='$no'") or die(mysql_error());
						//	echo "update submembers set subid='$subid', remark='$remark' where no='$no'";
						echo "<SCRIPT language=\"JavaScript\">alert('Sub Member Sucessfully Updated!');</SCRIPT>";}
		}
		
		}
	if($action=='add'){
	echo "<form action='viewsubmember.php' method='post' style='margin-bottom:0;'>";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='60%' align='center' class='outline'><tr><td ></td></tr><tr><td ><span class='bn13text'>*Member Main ID</span></td><td ><span class='bn13text'>:</span></td><td><select name='memberid'>";
	$memberidsql=mysql_query("SELECT DISTINCT memberid FROM memberid ORDER BY memberid ASC");
	$memberidrow=mysql_num_rows($memberidsql);
	for($count=0; $count<$memberidrow; $count++)
		{
		$data=mysql_result($memberidsql,$count,"memberid");
		echo"<option value='$data'>$data</option>";
		}
	  echo "</select></td><td ><span class='bn13text'>*Sub ID&nbsp;</span></td><td ><span class='bn13text'>:</span></td><td align='left'><input type='text' name='subid' size='10' maxlength='15' onBlur='up(this)'><td align='right' ></td>";
	echo "<tr><input type='hidden' name='datetime' value='$deyt'><td ><span class='bn13text'>Remark&nbsp;</span></td><td ><span class='bn13text'>:</span></td><td align='left'><input type='text' name='remark' size='30' maxlength='30' ><td align='right' ></td>";
/*	<span class='bn13text'>&nbsp;Rank</td><td>:</td><td><select name='rank'>";
	$nonamesql=mysql_query("SELECT DISTINCT no,name FROM ranking ORDER BY no ASC");
	$nonamerow=mysql_num_rows($nonamesql);
	if($rank!=NULL){echo"<option value='$no'>$name-$no</option>";}
		for($count=0; $count<$nonamerow; $count++)
		{$no=mysql_result($nonamesql,$count,"no");
		$name=mysql_result($nonamesql,$count,"name");
		if($rank!=$no){echo"<option value='$no'>$name-$no</option>";}}*/
	 // echo "</select></span></td></tr>";
	  echo "</span></td></tr>";
	echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Submit' title='Add New Sub ID'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewsubmember.php'\" title='Cancel New Sub ID'></td></tr></form>";
  echo"<tr></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	else
	{
	//echo"<tr><td align='left'><a href='viewsubmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewsubmember.php.php' method='post' style='margin-bottom:0;'><select name='action' onchange='this.form.submit()'><option>ALL</option><option value='1'>Active</option><option value='0'>Inactive</option></select></form></td></tr>";
	echo"<tr><td align='left'><a href='viewsubmember.php?action=add' target='_self'><img src='images/new.jpg' border='0' title='Add'></a></td><td></td><td align='right'><form action='viewsubmember.php' method='post' style='margin-bottom:0;'><select name='filter' onchange='this.form.submit()'>";
	
		if ($_POST["filter"]<>"")
		{
			$ranknow=mysql_query("SELECT name,no FROM ranking where no ='" . $_POST["filter"] . "' order by no asc");
			while ($row_rankno = mysql_fetch_array($ranknow)) 
			{
			echo "<option value = '" . $_POST["filter"] . "'>$row_rankno[0]-$filter</option>";
			}
echo "<option>ALL</option>";
		}
		else
		echo "<option>ALL</option>";
		
		$rankno=mysql_query("SELECT no,name FROM ranking order by no asc");
		while ($row_rankno = mysql_fetch_array($rankno)) 
		{
		echo "<option value='$row_rankno[0]'>$row_rankno[1]-$row_rankno[0]</option>";
		}
		
		echo "</select></form></td></tr>";
	}

	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="70%" align="center" class="stats">
	<tr><td class="hed" width="10%"><span class="bn13text"><b>Member ID</b></span></td><td class="hed" width="15%"><span class="bn13text"><b>Name</b></span></td><td class="hed" width="10%"><span class="bn13text"><b>Sub ID</b></span></td><td class="hed"><span class="bn13text"><b>Remarks</b></span></td><td class="hed" width="15%"><span class="bn13text"><b>Action</b></span></td></tr>
<?php
	$action=$_POST[action];
	$memberidsql=mysql_query("SELECT * FROM submembers $filthy ORDER BY memberid asc");
	$memberidrow=mysql_num_rows($memberidsql);
	for($count=0; $count<$memberidrow; $count++)
	{echo "<tr>";
	$no=mysql_result($memberidsql,$count,"no");
	//echo $no . "<br>";
	$memberid=mysql_result($memberidsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	$memnamesql=mysql_query("SELECT membername FROM memberid where memberid='$memberid'");
	
	$name=mysql_result($memnamesql,0,"membername");
	$subid=mysql_result($memberidsql,$count,"subid");
	$remark=mysql_result($memberidsql,$count,"remark");
	
	if (($_GET["action"]=='edit')&&($subid==$_GET["subid"])){
	$no = $_GET["no"];
//	echo $no;
	echo "<form action='viewsubmember.php?action=update' method='post' style='margin-bottom:0;'><input type='hidden' name='no' value='$no'";
//echo "<td align='center'><input type='text' name='name' size='10' maxlength='8' value='$name'></td>";
	echo "<td align='center'><span class='bn13text'>$name</span></td>";
	//echo "<td align='center'><input type='text' name='subid' size='10' maxlength='8' onBlur='up(this)' value='$subid'></td>";
	echo "<td align='center'><span class='bn13text'>$subid</span></td>";
	echo "<td align='center'><input type='text' name='remark' size='20' maxlength='30' value='$remark'></td>";
	}
	else
	{
	echo "<td align='center'><span class='bn13text'>$name</span></td>";
	echo "<td align='center'><span class='bn13text'>$subid</span></td>";
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	}
	
	if (($_GET["action"]=='edit')&&($subid==$_GET["subid"])){
	echo "<td align='center'><a href='viewsubmember.php' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' title='Save'></td>";
	}
	else
	{
	echo "<td align='center'><span class='bn13text'>
	<a href='viewsubmember.php?action=edit&subid=$subid&no=$no' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a>&nbsp;&nbsp;
	<a href='viewsubmember.php?action=delete&memberid=$memberid&subid=$subid' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></span></td>";
	}
	//echo "<td align='center'><input type='checkbox'></td>";
	echo "</tr>";}
	?>
	</form>
</table>
</body>
</html>