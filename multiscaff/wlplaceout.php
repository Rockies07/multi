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
	for(i=1; i<61; i++){
		allTypes=eval("document.multiForm.eTypeAcc"+i);
		allTypes.value=document.multiForm.selectAll.value;
	}
}
function updateTotAmt(){
	var i, allWL, thisWLID;
	allWL = document.multiForm.TotalAmt.value=0;
	for(i=1; i<61; i++){
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
function setRemarks(){
	var i, allRemarks;
	for(i=1; i<61; i++){
		allRemarks=eval("document.multiForm.remarks"+i);
		allRemarks.value=document.multiForm.mainRemark.value;
	}
}
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
	var i, oID,oWL,oeTypeAcc,newCID;
	
//	alert(document.multiForm.ExtCID.value);
///	alert(existID);

	for(i=1; i<61; i++){
    	oID=eval("document.multiForm.ID"+i);
		oWL=eval("document.multiForm.WL"+i);
		oeTypeAcc=eval("document.multiForm.eTypeAcc"+i);
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
			else if(oeTypeAcc.value=="--Click--" || oeTypeAcc.value==""){
				FormValid = false;
				alert("Please Check Type- Cannot Be Empty!");
				oeTypeAcc.focus(); 	
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
	var typeko=eval('document.multiForm.eTypeAcc'+xx); 
	for (j=typeko.options.length-1;j>=0;j--)
	{
	typeko.remove(j);
	}
}
	for (xx=1;xx<=60;xx++) {
		for (i=0;i<myarray.length;i++)
		{
		var optn = document.createElement("OPTION");
		var typeko=eval('document.multiForm.eTypeAcc'+xx);  
		optn.value = myarray[i];
		optn.text = myarray[i];
		typeko.options.add(optn);
		} 
					}
      }
    }
var url="ff.php";
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
	</script>
<link href="style.css" rel="stylesheet" type="text/css">
<!--<link rel="stylesheet" href="css/datepicker.css" type="text/css" />-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottomMargin="0" bgColor="#FFFFFF" leftMargin="0" topMargin="0" rightMargin="0">
<p align="center" class="maintitle">Multiple W/L Placeout Submission</p>
 <form name="multiForm" method="post" action="multiInvoice.php">
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
			<div class="demo">Date: <input type="text" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" style="width:80px" onChange="setValueCode()"><input type="hidden" value="W/L PLACEOUT" name="trans_type">
</div>
			<!--<input class="inputDate" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" /><img src="images/pikpik.gif" width="20" height="20" class="inputDate">--> 	</td>
          	<td align="left">Code:&nbsp;
          	  <select name="code" id="code" class="searchformfiled" onChange="AjaxFunction2(this.value)" >
                
              </select></td>
            <td align="left">Web:
			<select name="selectAll" class="searchformfiled" onChange="javascript : selectAllType();" >
			<option value="">--Click--</option>
               <?php
/*				$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<option value='$data'>$data</option>";}*/
                ?>
              </select>
			  </td>

            <td  rowspan="2" align="left" nowrap>Set Remarks 
              <input name="mainRemark" type="text" class="searchformfiled" value="" onChange="javascript : setRemarks();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
            <td  align="right" nowrap>$</td>
            <td  align="left" nowrap><input class="searchformfiled" type="text" name="TotalAmt" value="0" size="10" tabindex="-1" readonly >
              <select name="currency" class="searchformfiled" >
                <option value="SGD" selected="selected">SGD</option>
                <!--<option value="">--Click--</option>-->
                <?php	$currencysql=mysql_query("SELECT currencycode FROM currency");
				$currencysqlrow=mysql_num_rows($currencysql);
				for($count=0; $count<$currencysqlrow; $count++)
				{$data=mysql_result($currencysql,$count,"currencycode");
				echo "<option value='$data'>$data</option>";}
                ?>
              </select></td>
            <td rowspan="2" align="right" nowrap><input name="Add" type="button" class="formButton" onClick="javascript: openScript('viewmember.php?action=add',1200,400);" value="  Add New Member  ">  
			<!--<input name="Refresh" type="button" class="formButton"  value="<?php echo $weblogin; ?>" onClick="AjaxFunction(this.value)">    -->     
              &nbsp;&nbsp;
              <input type="reset" class="formButton" value="Reset" tabIndex="-1" name="reset">
              &nbsp;&nbsp;
            <input type="button" name="Save" value="Save" class="formButton" onFocus="AjaxFunction();" onClick="javascript: ajax();">            </td>
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
	<td width="10%" align="center" nowrap><strong>No.</strong></td>
	<td align="center" nowrap><strong>ID</strong></td>
	<td align="center" nowrap><strong>Web</strong></td>
	<td align="center" nowrap><strong>+/- Amount</strong></td>
	<td align="center" nowrap><strong>Remarks</strong></td>
  </tr>
  <?php for ($i=1;$i<=30;$i++) { ?>
  
            <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap><?php echo $i; ?></td>
  	<td align="center"><input name="ID<?php echo $i; ?>" type="text" class="searchformfiled" tabindex="<?php echo $i; ?>" onBlur="up(this)" onKeyDown="if(event.keyCode==13) moveit(this);" size="10" maxlength="8"></td>
	<td align="center"><!--<select name="eTypeAcc<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><?php	$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<option value='$data'>$data</option>";}
                ?></select>-->
				<select name="eTypeAcc<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><!--<option value="">--Click--</option>--><?php	/*$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<option value='$data'>$data</option>";}*/
                ?></select>
				</td>
	<td align="center"><input class="searchformfiled" tabindex="<?php echo $i+1; ?>" name="WL<?php echo $i; ?>" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) gotoremarks(this);"></td>
	<td align="center"><input name="remarks<?php echo $i; ?>" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) backtoid(this);"></td>
  </tr>
  
  <?php } ?>
  
      </table>
	  </td>
	        <td align="center" nowrap>
	   <table width="100%" border="0" align="center" cellspacing="0" bordercolor="#FFA800" style="border-collapse: collapse">
  <tr class="tableheaderCell" align="center" bgcolor="#333333" style="color:#FFFFFF"> 
	<td width="10%" align="center" nowrap><strong>No.</strong></td>
	<td align="center" nowrap><strong>ID</strong></td>
	<td align="center" nowrap><strong>Web</strong></td>
	<td align="center" nowrap><strong>+/- Amount</strong></td>
	<td align="center" nowrap><strong>Remarks</strong></td>
  </tr>
  <?php for ($i=31;$i<=60;$i++) { ?>
  
            <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap><?php echo $i; ?></td>
  	<td align="center"><input name="ID<?php echo $i; ?>" type="text" class="searchformfiled" tabindex="<?php echo $i; ?>" onBlur="up(this)" onKeyDown="if(event.keyCode==13) moveit(this);" size="10" maxlength="8"></td>
	<td align="center"><select name="eTypeAcc<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><!--<option value="">--Click--</option>--><?php	/*$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<option value='$data'>$data</option>";}*/
                ?></select></td>
	<td align="center"><input class="searchformfiled" tabindex="<?php echo $i+1; ?>" name="WL<?php echo $i; ?>" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) gotoremarks(this);"></td>
	<td align="center"><input name="remarks<?php echo $i; ?>" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) backtoid(this);"></td>
  </tr>
  
  <?php } ?>
  
      </table>
	  </td>
    </tr>
  </table>
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFEDC7" align="center">
          <tr bgcolor="#FFEDC7" class="text12Bold"> 
            <td align="center" nowrap><input type="button" name="Calculate" value="Calculate" class="formButton" onClick="javascript: updateTotAmt();">&nbsp;&nbsp;
			<input type="reset" class="formButton" value="Reset" name="reset">&nbsp;&nbsp;
         	<input type="button" tabindex="181" name="Save2" value="Save" class="formButton" onClick="javascript: saveMultiEntries();"></td>
          </tr>
        </table>
	</td>
  </tr>
</table>
</form>
</body>

<script>
	function setValueCode(){
		var value = $("#inputDate").val();
	    $.ajax({
	        url: "getBMCode.php",
	        data: "value="+value,
	        cache: false,
	        success: function(msg){
	            //jika data sukses diambil dari server kita tampilkan
	            //di <select id=kota>
	            $("#code").html(msg);
	        }
	    });
		
	}

	$(document).ready(function(){
		setValueCode();
	});
</script>
</html>
