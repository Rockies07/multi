<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	//$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	
	// get from memberid
	//$memberlist=mysql_query("SELECT memberid FROM memberid where managerid = '$weblogin'");
	//$memberlist=mysql_query("SELECT memberid FROM memberid WHERE managerid='$weblogin'");
	$memberlist=mysql_query("SELECT memberid FROM memberid");
	while ($row_memberlist = mysql_fetch_array($memberlist)) 
	{
		if ($memlist=="") {
			$memlist = "," . $row_memberlist[0];
		}
		else
		{
			$memlist = $memlist . "," . $row_memberlist[0];
		}
		
			// get from submembers
		$memberlist2=mysql_query("SELECT subid FROM submembers where memberid = '$row_memberlist[0]'");
		while ($row_memberlist2 = mysql_fetch_array($memberlist2)) 
		{
			$memlist = $memlist . "," . $row_memberlist2[0];
		}
	}
	$memlist = $memlist . ",EXTRA,";
	//echo $memlist;
		
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Multiple Invoice Submission</title>
<script language="javascript">
// give the focus to this window
if (window.focus){
	self.focus();
}
 var ClickTimes=0;
function IsNumeric(strString){
   var strValidChars = "0123456789.-+";
   var strChar;
   var blnuser_contact = true;

   for (i = 0; i < strString.length && blnuser_contact == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnuser_contact = false;
         }
      }
   return blnuser_contact;
   }
function selectAllType(){
	var i, allTypes;
	for(i=1; i<31; i++){
		allTypes=eval("document.multiForm.ProjectType"+i);
		allTypes.value=document.multiForm.projectcode.value;
	}
}

function selectAllTypePayment(){
	var i, allTypes;
	for(i=1; i<31; i++){
		allTypes=eval("document.multiForm.PaymentMode"+i);
		allTypes.value=document.multiForm.payment_mode.value;
	}
}

function selectAllTypeDate(){
	//alert('dumaan');
	var i, allTypes;
	for(i=1; i<31; i++){
		allTypes=eval("document.multiForm.inputDate"+i);


	}
}



function updateTotAmt(){
	var i, allWL, thisWLID;
	allWL = document.multiForm.TotalAmt.value=0;
	for(i=1; i<31; i++){
		thisWLID=eval("document.multiForm.WL"+i);
		if (IsNumeric(thisWLID.value) == false){
			alert("Please Check Amount- non numeric value!");
			thisWLID.focus();
			thisWLID.select();
			break;
		}
		allWL += Number(thisWLID.value);
	//	allWL = allWL.toFixed(2);		
		document.multiForm.TotalAmt.value = allWL.toFixed(2);
	}
}
/*function setRemarks(){
	var i, allRemarks;
	for(i=1; i<31; i++){
		allRemarks=eval("document.multiForm.remarks"+i);
		//alert(document.multiForm.mainRemark.value);
		allRemarks.value=document.multiForm.remarks.value;
	}
}*/
function up(o){
AjaxFunction();
o.value=o.value.toUpperCase().replace(/([^0-9A-Z-])/g,"");
}

function moveit(o){
AjaxFunction();
if (o.name.length==3)
var a = o.name.substr(2,1);
if (o.name.length==4)
var a = o.name.substr(2,2);
var WLfocus=eval('document.multiForm.WL'+a);
WLfocus.focus();
WLfocus.select();
}

function gotoremarks(o){
AjaxFunction();
if (o.name.length==3)
var a = (parseInt(o.name.substr(2,1))+1);
if (o.name.length==4)
var a = (parseInt(o.name.substr(2,2))+1);
var IDfocus=eval('document.multiForm.ID'+a);
IDfocus.focus();
IDfocus.select();
/*var IDfocus=eval('document.multiForm.remarks'+(a-1));
IDfocus.focus();
IDfocus.select();*/
}

function backtoid(o){
AjaxFunction();
if (o.name.length==8)
var a = (parseInt(o.name.substr(7,1))+1);
if (o.name.length==9)
var a = (parseInt(o.name.substr(7,2))+1);
var IDfocus=eval('document.multiForm.remarks'+a);
IDfocus.focus();
IDfocus.select();

}

function ajax(){
AjaxFunction();
saveMultiEntries();
}
function saveMultiEntries(){
	var FormValid = true;
	var nNumCount = 0;
	var existID=eval("document.multiForm.ExtCID.value");
	var i, oID,oWL,oProjectType,newCID;
	
//	alert(document.multiForm.ExtCID.value);
///	alert(existID);

	for(i=1; i<31; i++){
    	oID=eval("document.multiForm.ID"+i);
		oWL=eval("document.multiForm.WL"+i);
		oProjectType=eval("document.multiForm.ProjectType"+i);
		newCID=eval("document.multiForm.ID"+i+".value");
		//newCID = newCID.toUpperCase();
		oID.value = newCID;
		if (oID.value != ""){
		if(existID.indexOf(','+newCID+',')==-1){
		//if(existID.indexOf(newCID)==-1){
				FormValid = false;
				alert("ID Doesn't exists!");
				oID.focus();
				oID.select();
			}
			else if(oProjectType.value=="--Click--" || oProjectType.value==""){
				FormValid = false;
				alert("Please Check Type- Cannot Be Empty!");
				oProjectType.focus(); 	
			}  
			else if (IsNumeric(oWL.value) == false){
				FormValid = false;
				alert("Please Check Amount- non numeric value!");
				oWL.focus();
			}
			else if(oWL.value==""){
				FormValid = false;
				alert("Please Check Amount- Cannot Be Empty!");
				oWL.focus(); 	
			}  
			else if(oWL.value=="0"){
				FormValid = false;
				alert("Please Check Amount- Cannot Be Zero!");
				oWL.select();	
			}
			else{
                nNumCount+=1;
      		}
		}
	}
	if (FormValid == true){
		if(ClickTimes>0){
			alert('Your request is being processed, please wait...');
			return false;	
		}else{
		 	if (nNumCount>0){
				ClickTimes=ClickTimes+1;
				document.multiForm.act.value='Save';
				document.multiForm.ExtCID.disabled=true;
				document.multiForm.submit();
			}else{
        		alert("Please Enter At Least 1 Entry!");
        		return false;
      		}
		}
	}
 }
</script>
<script type="text/javascript">
function AjaxFunction(weblogin)
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
var myarray=eval(httpxml.responseText);
var memberid = "";
for (i=0;i<myarray.length;i++)
{
memberid = memberid + "," + myarray[i];
//alert(myarray[i]);
}
document.multiForm.ExtCID.value = memberid;
      }
    }
var url="dd.php";
//url=url+"?managerid="+weblogin;
url=url+"?sid="+Math.random();
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
  }
  
</script>
<script type="text/javascript">
function AjaxFunction2(code)
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
var myarray=eval(httpxml.responseText);
// Before adding new we must remove previously loaded elements
for (j=document.multiForm.selectAll.options.length-1;j>=0;j--)
{
document.multiForm.selectAll.remove(j);
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
document.multiForm.selectAll.options.add(optn);
} 

for (xx=1;xx<=60;xx++) {
	var typeko=eval('document.multiForm.ProjectType'+xx); 
	for (j=typeko.options.length-1;j>=0;j--)
	{
	typeko.remove(j);
	}
}
	for (xx=1;xx<=60;xx++) {
		for (i=0;i<myarray.length;i++)
		{
		var optn = document.createElement("OPTION");
		var typeko=eval('document.multiForm.ProjectType'+xx);  
		optn.value = myarray[i];
		optn.text = myarray[i];
		typeko.options.add(optn);
		} 
					}
      }
    }
var url="hh.php";
url=url+"?code="+code;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
  }
  
</script>
<SCRIPT language=javascript>
function openScript(url, width, height){
 var Win = window.open(url,"_blank",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}
</SCRIPT>

<!--<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/eye.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/layout.js?ver=1.0.2"></script>-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<link href="css/demos.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	$(function() {
		$("#inputDate").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	
	$(function() {
		$("#inputDate1").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate2").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate3").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate4").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate5").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate6").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate7").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate8").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate9").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate10").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate11").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate12").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate13").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate14").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate15").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate16").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate17").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate18").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate19").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate20").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate21").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate22").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate23").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate24").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate25").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate26").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate27").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate28").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate29").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	$(function() {
		$("#inputDate30").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	
	/*for (x=1;x<30;x++){
//	alert(x);
//	x += '';
	$(function() {
		$("#inputDate"+x).datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	}*/
	
	</script>
<link href="style.css" rel="stylesheet" type="text/css">
<!--<link rel="stylesheet" href="css/datepicker.css" type="text/css" />-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottomMargin="0" bgColor="#FFFFFF" leftMargin="0" topMargin="0" rightMargin="0">
<p align="center" class="maintitle">Project Expenses  Submission</p>
 <form name="multiForm" method="post" action="multiInsert.php">
 <input type="hidden" name="transaction" value="wlplaceout">
<input type="hidden" name="act" value="">
<input type="hidden" name="MaxCellId" value="60">
<input type="hidden" name="ExtCID" value="<?php echo $memlist; ?>">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFEDC7" align="center">
          <tr bgcolor="#FFEDC7" class="text12Bold"> 
<!--            <td rowspan="2" align="right" nowrap>Date</td>-->
            <td align="left" nowrap class="text11">
			<!--<div class="demo">Date: <input type="text" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" style="width:80px" onChange="javascript : selectAllTypeDate();">--><input type="hidden" value="W/L PLACEOUT" name="trans_type">
</div>
			</td>
          	<td align="left">Project:&nbsp;
          	  <select name="projectcode" class="searchformfiled" onChange="javascript : selectAllType();" >
                <option value="">--Click--</option>
                <?php	
				$projcodesql=mysql_query("SELECT projcode FROM projects order by projcode asc");
				$projcodesqlrow=mysql_num_rows($projcodesql);
				for($count=0; $count<$projcodesqlrow; $count++)
				{$projcode=mysql_result($projcodesql,$count,"projcode");
				echo "<option value='$projcode'>$projcode</option>";}
                ?>
              </select></td>
			  
			  <td align="left">MOP:&nbsp;
          	    <select name="payment_mode" class="searchformfiled" onChange="javascript : selectAllTypePayment();" >
                <option value="">--Click--</option>
                <?php	
				$paymodesql=mysql_query("SELECT paymentmode FROM paymentmode order by paymentmode asc");
				$paymodesqlsqlrow=mysql_num_rows($paymodesql);
				for($count=0; $count<$paymodesqlsqlrow; $count++)
				{$paymentmode=mysql_result($paymodesql,$count,"paymentmode");
				echo "<option value='$paymentmode'>$paymentmode</option>";}
                ?>
              </select></td>
			  
            <!--<td  rowspan="2" align="left" nowrap>Set Remarks 
              <input name="c" type="text" class="searchformfiled" value="" onChange="javascript : setRemarks();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>-->
            <td  align="right" nowrap>$</td>
            <td  align="left" nowrap><input class="searchformfiled" type="text" name="TotalAmt" value="0" size="10" tabindex="-1" readonly >
              <!--<select name="currency" class="searchformfiled" >
                <option value="SGD" selected="selected">SGD</option>
              <?php	/*$currencysql=mysql_query("SELECT currencycode FROM currency");
				$currencysqlrow=mysql_num_rows($currencysql);
				for($count=0; $count<$currencysqlrow; $count++)
				{$data=mysql_result($currencysql,$count,"currencycode");
				echo "<option value='$data'>$data</option>";}*/
                ?>
              </select>--></td>
            <td rowspan="2" align="right" nowrap><!--<input name="Add" type="button" class="formButton" onClick="javascript: openScript('viewmember.php?action=add',1200,400);" value="  Add New Member  ">  -->
			<!--<input name="Refresh" type="button" class="formButton"  value="<?php echo $weblogin; ?>" onClick="AjaxFunction(this.value)">    -->     
              &nbsp;&nbsp;
              <input type="reset" class="formButton" value="Reset" tabIndex="-1" name="reset">
              &nbsp;&nbsp;
			 <!-- <input type="button" name="Save" value="Save" class="formButton" onFocus="AjaxFunction();"  onClick="javascript: ajax();" >-->
            <input type="submit" name="Save" value="Save" class="formButton" onFocus="AjaxFunction();"  onClick="javascript: ajax();" >         </td>
          </tr>
        </table>	
	</td>
  </tr>
</table>
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
<tr bgcolor="#FFA800"> 
      <td align="center" nowrap>
	  <table width="100%" border="0" align="center" cellspacing="0" bordercolor="#FFA800" style="border-collapse: collapse">
  <tr class="tableheaderCell" align="center" bgcolor="#333333" style="color:#FFFFFF"> 
	<td width="1%" align="center" nowrap><strong>No.</strong></td>
	<td align="center" nowrap><strong>Date</strong></td>
	<td width="5%" align="center" nowrap><strong>Project</strong></td>
	<td width="5%" align="center" nowrap><strong>Voucher No.</strong></td>
	<td width="10%" align="center" nowrap><strong>Description</strong></td>
	<td width="5%" align="center" nowrap><strong>Outgoing</strong></td>
	<td width="5%" align="center" nowrap><strong>Incoming</strong></td>
	<td width="5%"align="center" nowrap><strong>Mode of Payment</strong></td>
	<td align="center" nowrap><strong>Remarks</strong></td>
  </tr>
  <?php for ($i=1;$i<=30;$i++) { ?>
  
            <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td align="center" nowrap><?php echo $i; ?></td>
  	<td align="center">
	<!--<input type="text" id="datecontainer<?php echo $i; ?>" name="datecontainer<?php echo $i; ?>" readonly="true" style="width:80px">-->
	<input type="text" id="inputDate<?php echo $i; ?>" name="projdate<?php echo $i; ?>" value="<?php echo date("m/d/Y"); ?>" readonly="true" style="width:80px">
	<!--<input name="ID<?php echo $i; ?>" type="text" class="searchformfiled" tabindex="<?php echo $i; ?>" onBlur="up(this)" onKeyDown="if(event.keyCode==13) moveit(this);" size="10" maxlength="8">-->
	</td>
	<td align="center"><!--<select name="ProjectType<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><?php	$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<option value='$data'>$data</option>";}
                ?></select>-->
				<select name="ProjectType<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"  tabindex="<?php echo $i+1; ?>"><?php	
				$projcodesql=mysql_query("SELECT projcode FROM projects order by projcode asc");
				$projcodesqlrow=mysql_num_rows($projcodesql);
				for($count=0; $count<$projcodesqlrow; $count++)
				{$projcode=mysql_result($projcodesql,$count,"projcode");
				echo "<option value='$projcode'>$projcode</option>";}
				
				/*$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<option value='$data'>$data</option>";}*/
                ?></select>				</td>
	<td align="center"><input class="searchformfiled" tabindex="<?php echo $i+1; ?>" name="Voucher<?php echo $i; ?>" type="text" size="10"></td>
	<td align="center">
	<textarea cols="25" rows="2" name="description<?php echo $i; ?>" style="background:#FFFFFF" onKeyUp="textLimit(this, 60);"></textarea>
	<!--<input name="description<?php echo $i; ?>" width="300" type="text" class="searchformfiled"   tabindex="2">--></td>
	
	<td align="center">
				<input class="searchformfiled" tabindex="<?php echo $i+1; ?>" name="Outgoing<?php echo $i; ?>" type="text" size="10" onChange="javascript: updateTotAmt();"  >			</td>
				
		<td align="center">
				<input class="searchformfiled" tabindex="<?php echo $i+1; ?>" name="Incoming<?php echo $i; ?>" type="text" size="10" onChange="javascript: updateTotAmt();" >				</td>
				
			<td align="center">
				<select name="PaymentMode<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"  tabindex="<?php echo $i+1; ?>"><?php	
				$paymodesql=mysql_query("SELECT paymentmode FROM paymentmode order by paymentmode asc");
				$paymodesqlsqlrow=mysql_num_rows($paymodesql);
				for($count=0; $count<$paymodesqlsqlrow; $count++)
				{$paymentmode=mysql_result($paymodesql,$count,"paymentmode");
				echo "<option value='$paymentmode'>$paymentmode</option>";}
                ?></select>				</td>
	<td align="center">
	
	  <textarea cols="15" rows="2" name="remarks<?php echo $i; ?>" style="background:#FFFFFF" onKeyUp="textLimit(this, 60);" tabindex="<?php echo $i+1; ?>"></textarea>
	 <!-- <input name="remarks<?php echo $i; ?>" width="300" type="text" class="searchformfiled" tabindex="<?php echo $i+1; ?>">--></td>
  </tr>
  
  <?php } ?>
      </table>	  </td>
    </tr>
  </table>
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFEDC7" align="center">
          <tr bgcolor="#FFEDC7" class="text12Bold"> 
            <td align="center" nowrap><input type="button" name="Calculate" value="Calculate" class="formButton" onClick="javascript: updateTotAmt();">&nbsp;&nbsp;
			<input type="reset" class="formButton" value="Reset" name="reset">&nbsp;&nbsp;
         	<!--<input type="button" tabindex="181" name="Save2" value="Save" class="formButton" onClick="javascript: saveMultiEntries();">-->
			<input type="submit" tabindex="181" name="Save2" value="Save" class="formButton" onClick="javascript: saveMultiEntries();"></td>
          </tr>
		  
		  
        </table>
	</td>
  </tr>
</table>
</form>
</body>
</html>
