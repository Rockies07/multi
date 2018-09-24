<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$weblogin=strtoupper($weblogin);
	$projcode=$_GET["projcode"];
	
	//-=-=-= reports
//$bmreport=mysql_query("SELECT (ifnull(SUM(outgoing),0) as outgoing,(SELECT ifnull(SUM(incoming),0) as incoming FROM transactions where projectname = '$projcode' and hidden='0'");


?>
<html>
<head><title>Project Details</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<link href="css/demos2.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
<!-- 
function win(){
window.opener.location.href="viewallprojects.php?payge=<?php echo $_SESSION["payge"]; ?>&page=<?php echo $_SESSION["pagenum"]; ?>&delimit=<?php echo $_SESSION["delimit"]; ?>&SortBy=<?php echo $_SESSION["SortBy"]; ?>&searchID=<?php echo $_SESSION["searchID"]; ?>&filter=<?php echo $_SESSION["filter"]; ?>&mayneger=<?php echo $_SESSION["mayneger"]; ?>&hiddenf=<?php echo $_SESSION["hiddenf"]; ?>&SortOrder=<?php echo $_SESSION["SortOrder"]; ?>";
self.close();
//-->
}

function validate_form(thisform)
{
	if (thisform.type.value==="" || thisform.type.value===null) {
		alert("Please select Type First");
		thisform.type.focus();
		return false;
	}
	if (thisform.accounts.value==="--Click--" || thisform.accounts.value===null || thisform.accounts.value==="") {
		alert("Please select account");
		thisform.accounts.focus();
		return false;
	}
	if (thisform.aydis.value==="" || thisform.aydis.value===null) {
		alert("ID Cannot be blank");
		thisform.aydis.focus();
		return false;
	}
	if (thisform.amount.value==="" || thisform.aydis.value===null) {
		alert("Amount Cannot be blank");
		thisform.amount.focus();
		return false;
	}
	if (isNaN(thisform.amount.value)) {
		alert("Amount should only be Numeric");
		thisform.amount.focus();
		return false;
	}
	window.opener.location.href="viewallprojects.php?payge=<?php echo $_SESSION["payge"]; ?>&page=<?php echo $_SESSION["pagenum"]; ?>&delimit=<?php echo $_SESSION["delimit"]; ?>&SortBy=<?php echo $_SESSION["SortBy"]; ?>&searchID=<?php echo $_SESSION["searchID"]; ?>&filter=<?php echo $_SESSION["filter"]; ?>&mayneger=<?php echo $_SESSION["mayneger"]; ?>&hiddenf=<?php echo $_SESSION["hiddenf"]; ?>&SortOrder=<?php echo $_SESSION["SortOrder"]; ?>";
}
</SCRIPT>
<script type="text/javascript">
	$(function() {
		$("#inputDate").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	</script>
<script type="text/javascript">
function AjaxFunction(command)
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
//alert(httpxml.responseText);
//document.addinfo.sort.style='';
//typeko = document.getElementById("type");
//element = document.getElementById("sort");
//alert(typeko.value);
//if (typeko.value=='' || typeko.value==null)
//element.style.display = '';
//else
//element.style.display = 'table-row';
/*element = document.getElementById('sort');
element.style.display = 'inline';
*/
//alert(command);
var myarray=eval(httpxml.responseText);
var myarray=eval(httpxml.responseText);
// Before adding new we must remove previously loaded elements
for (j=document.addinfo.accounts.options.length-1;j>=0;j--)
{
document.addinfo.accounts.remove(j);
}


for (i=0;i<myarray.length;i++)
{
var optn = document.createElement("OPTION");
//var fafa = myarray[i].split("%");
//alert(myarray[i]);
optn.value = myarray[i];
optn.text = myarray[i];
//if (fafa[1]!=undefined) { optn.text = fafa[0] + " [" + fafa[1] + "]"; }
//else { optn.text = fafa[0]; }
document.addinfo.accounts.options.add(optn);
} 
      }
    }
var url="gg.php";
url=url+"?command="+command;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
  }
</script>
<SCRIPT LANGUAGE="JavaScript">


function checkAll(field,exby) {
for (i = 0; i < field.length; i++)
	field[i].checked = exby.checked? true:false
}
</script>

<script type="text/javascript">
function AjaxRefresh()
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
	 // alert("ok");
window.opener.location.href="viewallprojects.php?payge=<?php echo $_SESSION["payge"]; ?>&page=<?php echo $_SESSION["pagenum"]; ?>&delimit=<?php echo $_SESSION["delimit"]; ?>&SortBy=<?php echo $_SESSION["SortBy"]; ?>&searchID=<?php echo $_SESSION["searchID"]; ?>&filter=<?php echo $_SESSION["filter"]; ?>&mayneger=<?php echo $_SESSION["mayneger"]; ?>&hiddenf=<?php echo $_SESSION["hiddenf"]; ?>&SortOrder=<?php echo $_SESSION["SortOrder"]; ?>";
      }
    }
var url="rr.php";
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
  }
</script>


<link href="style.css" rel="stylesheet" type="text/css">
<!--<link rel="stylesheet" href="css/datepicker.css" type="text/css" />-->

<!--<link rel="stylesheet" href="style.css" type="text/css" />
-->
</head>
<!--<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" onLoad="CountCheck();">-->
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0">
<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
	<tr>
	  <td align="center"><span class="bn13text"> <b><?php echo $memberid; ?></b> Details<br>
  </span></td>
	</tr>
  <td>
  <?php if($action=='aditional'){
  /*echo "<a href='viewprojectdetails.php.php' target='_self'><img border='0' src='images/cancel.gif' align=left></a>";}
  else{
  echo"<span class='bn13textwhite15'><a href='viewprojectdetails.php.php?action=aditional' target='_self'><img border='0' src='images/new.jpg' align=left></a>&nbsp;&nbsp;&nbsp;";
  
  if ($total<0)
			echo "Gross Total : <span class='bn13textred15'>$$total</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Gross Total : <span class='bn13textskyblue'>$$total</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			echo "Outstanding : <span class='bn13textred15'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Outstanding : <span class='bn13textskyblue'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
	
	if ($paydue<0)
			echo "Amt Due : <span class='bn13textred15'>$$paydue</span>";
		else
			echo "Amt Due : <span class='bn13textskyblue'>$$paydue</span>";*/
					
 // &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Outstanding : $$outstanding&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pending Due : $$paydue</span	>";
  
  }
  ?>
</td>
</table>
<?php
if($action=='aditional'){
if($action<>'edit'){
	$det = date('m/d/Y');
	echo "<form action='viewprojectdetails.php.php' method='post' name='addinfo' style='margin-bottom:0;' onsubmit='return validate_form(this);'>
<table bgcolor='#FFEFC6' border='1' cellpadding='0' cellspacing='0' width='80%' align='center' >
	  <tr>
    <td width='30%'><span class='bn13text'>&nbsp;Data Entry: &nbsp; 
	<select name='type' class='searchformfiled' onChange='AjaxFunction(this.value)' >
	<option value='' selected='selected'>--Click--</option>
          <option value='PLACEOUT' >W/L Placeout</option>
		  <option value='PAYMENT'>Payment</option>
        </select> </span></td>
    <td colspan='2' width='40%'><span class='bn13text'>&nbsp;Account:
	
	<select name='accounts' class='searchformfiled' >
			<option value=''>--Click--</option></select></span>
	</td>
    <td rowspan='5' >
	<table align='center' border='1' cellpadding='10' cellspacing='10' width='70%'>
        <tr>
          <td><span class='bn13text'>Total</span></td>
          <td align='right'><span class='bn13text'>$total</span></td>
        </tr>
		<tr>
          <td><span class='bn13text'>Outstanding</span></td>
          <td align='right'><span class='bn13text'>$outstanding</span></td>
        </tr>
        <tr>
          <td><span class='bn13text'>Amt Due </span></td>
          <td align='right'><span class='bn13text'>$paydue</span></td>
        </tr>
      </table>
	</td>
  </tr>";
	echo "<tr><td><span class='bn13text'>&nbsp;ID: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<select name='aydis' class='searchformfiled' >        <option value='$memberid' selected='selected'>$memberid</option>";
			//}
	/*else // assume it's subid
	{
		$memberlistsub=mysql_query("SELECT memberid FROM submembers where subid = '$memberid'");
		$mainmember=mysql_result($memberlistsub,0,"memberid");
		$memlist = $mainmember;
	
	while ($row_memberlistsub = mysql_fetch_array($memberlistsub)) 
		{
			if ($memlist=="") {
				$memlist = $row_memberlistsub[0];
			}
			else
			{		
				$memlist = $memlist . "," . $row_memberlistsub[0];
			}
		}
	
	}*/
	
	
		//-=-=-=-=		
				
				$pasabog = explode(",",$memlist);
				$bilanggo = count($pasabog);
				//echo "count: " . $bilanggo;
				//echo $pasabog[0] . "<br>";
				//echo $pasabog[1] . "<br>";
	 //	$aydis=mysql_query("SELECT subid FROM submembers where memberid='$submembers'");
		//	$aydisrow=mysql_num_rows($aydis);
			for($count=0; $count<$bilanggo; $count++)
			{
			//$data=mysql_result($aydis,$count,"subid");
			echo "<option value='$pasabog[$count]'>$pasabog[$count]</option>";
			}
	
	$hehey = date('m/d/Y');
	//echo "</td><td ><span class='bn13text'>Date:</span><input name='datetime' class='inputDate' id='inputDate' value='$det' readonly='true' /><img src='images/pikpik.gif' width='20' height='20' class='inputDate'></td>
	echo "</td><td align='left' nowrap class='text11'>
		  <div class='demo'>&nbsp;<span class='bn13text'>Date:</span> <input type='text' id='inputDate' name='datetime' value='$hehey' readonly='true' style='width:80px'></div></td></tr>";
 echo "<tr>
    <td colspan='3'><span class='bn13text'>&nbsp;Amount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='text' size='15' name='amount' maxlength='20' value='$amount'>
	<select name='currency' class='searchformfiled' >
                <option value='SGD' selected='selected'>SGD</option>";
	 	$currencysql=mysql_query("SELECT currencycode FROM currency");
			$currencysqlrow=mysql_num_rows($currencysql);
			for($count=0; $count<$currencysqlrow; $count++)
			{$data=mysql_result($currencysql,$count,"currencycode");
			echo "<option value='$data'>$data</option>";}
echo"	<span></td>
  </tr>
  <tr>
    <td colspan='3'><span class='bn13text'>&nbsp;Remarks: &nbsp;&nbsp;&nbsp; <input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></span></td>
  </tr>
  <tr>
    <td colspan='3' align='center'><input type='submit' name='Insert' value='Insert' title='Add New Member'><!--&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewprojectdetails.php.php'\" title='Cancel'>--></td>
  </tr>";
	
	
	
	echo"</table>
	</td></tr>";
	echo "<tr></tr>";
	echo"</form>";
	}                 }
	
if($action=='edit'){
	$referee=$_GET["ref"];
//	echo $_GET["methodz"];
	if ($_GET["methodz"]=='payment') {
		$editbm=mysql_query("select * from bmdatabase_payment where ref='$referee'");
		//echo "select * from bmdatabase_payment where ref='$referee'"; 
		}
	else {
		$editbm=mysql_query("select * from bmdatabase_wlplaceout where ref='$referee'");
		//echo "select * from bmdatabase_wlplaceout where ref='$referee'";
		 }
	
	$bmdate=mysql_result($editbm,$count,"bmdate");
	$memberid_active=mysql_result($editbm,$count,"memberid");
	//echo $memberid;
	$remark=mysql_result($editbm,$count,"remark");
	$amount=mysql_result($editbm,$count,"amount");
	$cpyaccount=mysql_result($editbm,$count,"cpyaccount");
	$currencycode=mysql_result($editbm,$count,"currencycode");
	//$type=mysql_result($editbm,$count,"type");
	$subbmcode=mysql_result($editbm,$count,"subbmcode");
	$shabug=explode("-",$bmdate);
	$newdit =  $shabug[1] . "/" . substr($shabug[2],0,2) . "/" . $shabug[0];
	$det = $newdit; //date('m/d/Y');
	echo "<form action='viewprojectdetails.php.php' method='post' name='info' style='margin-bottom:0;' >";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='80%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' ><span class='bn13text'>Date&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><input name='datetime' class='inputDate' id='inputDate' value='$det' readonly='true' />";
	

	  echo "</select></td><td align='right' ><span class='bn13text'>ID&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'>
	  <select name='currency' class='searchformfiled' >
                <option value='submembers' selected='selected'>$memberid_active</option>";
	 	$aydis=mysql_query("SELECT subid FROM submembers where memberid='submembers'");
			$aydisrow=mysql_num_rows($aydis);
			for($count=0; $count<$aydisrow; $count++)
			{$data=mysql_result($aydis,$count,"subid");
			echo "<option value='$data'>$data</option>";}

	echo "</select><td align='right' ></td><tr><td align='right' ><span class='bn13text'>Remarks&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remark'>
	<td align='right' ><span class='bn13text'>Amount&nbsp;</span></td></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='amount' maxlength='20' value='$amount'></span>
	<select name='currency' class='searchformfiled' >
                <option value='SGD' selected='selected'>SGD</option>";
	 	$currencysql=mysql_query("SELECT currencycode FROM currency");
			$currencysqlrow=mysql_num_rows($currencysql);
			for($count=0; $count<$currencysqlrow; $count++)
			{$data=mysql_result($currencysql,$count,"currencycode");
			echo "<option value='$data'>$data</option>";}
       
	echo "</select></td></tr><tr><td align='right' ><span class='bn13text'>Type&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><select name='type' class='searchformfiled' onChange='AjaxFunction(this.value)' >";
	
	if ($_GET["methodz"]=='payment')
		echo "<option value='PAYMENT' selected='selected'>Payment</option>";
	else if ($_GET["methodz"]=='placeout')
		echo "<option value='PLACEOUT' selected='selected'>W/L Placeout</option>";
	else
	echo "<option value='' selected='selected'>--Click--</option>";

	echo "<option value='PLACEOUT' >W/L Placeout</option>
		  <option value='PAYMENT'>Payment</option>
        </select>&nbsp;";
	
	echo"</td><td align='right' ><span class='bn13text'>Account&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'>
	<select name='accounts' class='searchformfiled' >";
	if ($subbmcode<>"")
		echo "<option value='$subbmcode'>$subbmcode</option></select></td></tr>";
	if ($cpyaccount<>"")
		echo "<option value='$cpyaccount'>$cpyaccount</option></select></td></tr>";
	//else
	//	echo "<option value=''>--Click--</option></select></td></tr>";
		echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Update' title='Update Details'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewprojectdetails.php.php'\" title='Cancel'></td></tr><input type='hidden' name='refy' value='$referee'></form>";
  echo"<tr><td height='10' colspan='4'></td></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	?>
<br>

<strong>

	<form name="member_details" action="viewprojectdetails.php.php" method="post" onSubmit="return validate()">
	<table border="1" cellpadding="0" cellspacing="0" width="90%" align="center" class="stats">
<td class="hed" width="20%"><span class="bn13text"><b>Date</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>Voucher No.</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>Description</b></span></td>
<td class="hed" width="5%"><span class="bn13text"><b>Outgoing</b></span></td>
<td class="hed"  width="10%"><span class="bn13text"><b>Incoming</b></span></td>
<td class="hed"  width="10%"><span class="bn13text"><b>Mode of Payment</b></span></td>
<td class="hed" width="35%"><span class="bn13text"><b>Remarks</b></span></td>
<!--<td class="hed"  width="5%"><span class="bn13text"><b><input type="checkbox" name="allp"  onClick="checkAll(document.member_details['check_listp[]'],this)"></b></span></td>
 <td class="hed"  width="5%"><span class="bn13text"><b><input type="checkbox" name="allh" onClick="checkAll(document.member_details['check_listh[]'],this)" ></b></span></td>
--> 
<td class="hed"  width="10%"><span class="bn13text"><b>Action</b></span></td>
</tr>
	
	
	<?php
	
	$transreport=mysql_query("SELECT * FROM transactions where projectname = '$projcode' and hidden='0'");
	echo "SELECT * FROM transactions where projectname = '$projcode' and hidden='0'";
	while ($row_trans = mysql_fetch_array($transreport)) 
	{
?>
	<!--$trans_date=mysql_result($bmsql,$count,"trans_date");
	$project_name=mysql_result($bmsql,$count,"project_name");
	$voucherno=mysql_result($bmsql,$count,"voucherno");
	$description=mysql_result($bmsql,$count,"description");
	$outgoing=mysql_result($bmsql,$count,"outgoing");
	$incoming=mysql_result($bmsql,$count,"incoming");
	$modeofpayment=mysql_result($bmsql,$count,"modeofpayment");
	$remarks=mysql_result($bmsql,$count,"remarks");-->
	<tr>
	<td align='center'><span class='bn13text'><?php echo $row_trans[1]; // trans_date ?></span></td>
	<!--<td align='center'><span class='bn13text'><?php echo $row_trans[2]; // project_name ?></span></td>-->
	<td align='center'><span class='bn13text'><?php echo $row_trans[3]; // voucherno ?></span></td>
	<td align='center'><span class='bn13text'><?php echo $row_trans[4]; // description ?></span></td>
	<td align='center'><span class='bn13text'><?php echo $row_trans[5]; // outgoing 
	?></span></td>
	<td align='center'><span class='bn13text'><?php echo $row_trans[6]; // incoming ?></span></td>
	<td align='center'><span class='bn13text'><?php echo $row_trans[7]; // modeofpayment ?></span></td>
	<td align='center'><span class='bn13text'><?php echo $row_trans[8]; // remarks ?></span></td>
	<td align='center'><span class='bn13text'><a href="#">Edit Delete</a></span></td>
	</tr>
	<?php }	?>
</form>
<tr><td colspan="10" align="center" bgcolor="#888888" class="hedache"><span class="bn13text"><b>Gross Total: <?php 
	if ($final_amount<0)
	echo "<font color='red'>" . number_format($final_amount,2) . "</font>";
	else
	echo number_format($final_amount,2);

?></b></span></td></tr>
<table align="center">
<tr>
<td>
<input type=button onClick="win();" value="Close Window">
</td></tr></table>
</body>
</html>