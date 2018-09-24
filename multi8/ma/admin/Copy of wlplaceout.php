<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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
		document.multiForm.TotalAmt.value = allWL;
	}
}
function setRemarks(){
	var i, allRemarks;
	for(i=1; i<61; i++){
		allRemarks=eval("document.multiForm.remarks"+i);
		allRemarks.value=document.multiForm.mainRemark.value;
	}
}
function saveMultiEntries(){
 
	var FormValid = true;
	var nNumCount = 0;
	var existID=eval("document.multiForm.ExtCID.value");
	var i, oID,oWL,oeTypeAcc,newCID;

	for(i=1; i<61; i++){
    	oID=eval("document.multiForm.ID"+i);
		oWL=eval("document.multiForm.WL"+i);
		oeTypeAcc=eval("document.multiForm.eTypeAcc"+i);
		newCID=eval("document.multiForm.ID"+i+".value");
		newCID = newCID.toUpperCase();
		oID.value = newCID;
		if (oID.value != ""){
			if(existID.indexOf(','+newCID+',')==-1){
				FormValid = false;
				alert("ID Doesn't exists!");
				oID.focus();
				oID.select();
			}
			else if(oeTypeAcc.value==""){
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
<script type="text/javascript" src="calendarDateInput.js"></script></head>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottomMargin="0" bgColor="#FFFFFF" leftMargin="0" topMargin="0" rightMargin="0">
<p align="center" class="text12RedBold">Multiple Invoice Submission</p>
 <form name="multiForm" method="post" action="multiInvoice.php">
<input type="hidden" name="act" value="">
<input type="hidden" name="MaxCellId" value="60">
<input type="hidden" name="ExtCID" value=",AG01FB,AG02,AG04,AG05,AG05FB,AG06,AG06A,AG06AFB,AG06FB,AG07,AG08,AG09,AG10,AG11,AG11A,AG12,AG13,AG13FB,AG14,AG14FB,AG15,AG15FB,AG16,AG17FB,AG18,AG18FB,AG19,AG20,AG21,AG24,AG24FB,AG25,AG25FB,AG26,AG26FB,AG27,AG27FB,AG28,AG28FB,AG29,AG29FB,AG30,AG30FB,AG32,AG32FB,AG32FC,AG32FD,AG35,AG39,AG39FB,AG40,AG42,AG53,AG53FB,AG54,AG54FB,AG54FC,AG55,AG55FB,AG56,AG56FB,AG58,AG58FB,AG59,AG60,AG60FB,AG61,AG61FB,AG62,AG65,AG66,AG67,AG68,AG68FB,AG69,AG70,AG71,AG71FB,AG72,AG72FB,AG73,AG73FB,AG75,AG77,AG77FB,AG79,AG79FB,AG80,AG80FB,AG81,AG81FB,AG83,AG85,AG86,AG88,AG89,AG91,AG92,AG93,AG95,AG95FB,AG96,AG96FB,AG97,AG99,AS,ASFB,C602,C603,C604,C605,C681,C682,FB,M401,M402,M404,M407,M408,M410,M411,M412,M413,M415,M416,M417,M418,M419,M421,M422,M423,M427,M430,M431,M433,M436,M440,M443,M445,M451,M453,M454,M455,M457,M461,M462,M463,M465,M466,M467,M468,M472,M473,M475,M476,M478,M479,M480,M481,M483,M484,M485,M486,M487,M488,M489,M490,P2,P2FB,Q1,Q5,Q5FB,Q6,Q6FB,Q7,Q7FB,Q8,Q8FB,QA,QAFB,QB,QBFB,QBFC,QBMK,QC,QCFB,QD,QE,QF,QH,QJ,QJFB,QK,QKFB,QN,QQ,QQFB,QR,QV,QW,QX,QXFB,R7,R9,RA,RAFB,RARC,RARCFB,RB,RBFB,RC,RD,RDFB,RE,REFB,RF,RFFB,RG,RGFB,RH,RHFB,RHFC,RJ,RJFB,RK,RL,RLFB,RM,RN,RNFB,RP,RPFB,RQ,RQFB,RT,RTFB,RZ,RZFB,SA01,SA02,TA,TAFB,TC,TCFB,TD,TDFB,TE,TF,TFFB,TG,TGFB,TH,THFB,TJ,TJFB,TK,TKFB,TM,Y01,Y03,Y04,Y07,Y11,Y12,Y13,Y16,Y18,Y19,Y20,Y21,Y23,Y24,Y25,Y26,Y27,Y28,YP003,YP17,YP18,YP18A,YP18B,YP18C,YP18D,YP21,YP23,YP24,YP26,YP28,">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFEDC7" align="center">
          <tr bgcolor="#FFEDC7" class="text12Bold"> 
            <td width="1%" align="right" nowrap><span class=""Date&nbsp;:&nbsp;</td>
            <td width="1%" align="left" class="text11" nowrap><script>DateInput('datetime', true, 'YYYY-MM-DD')</script>
              <script type="text/javascript">//<![CDATA[
					Calendar.setup({
					firstDay          : 1,
					electric          : false,
					inputField        : "date",
					button            : "trigger",
					ifFormat          : "%Y-%m-%d",
					daFormat          : "%Y-%m-%d"
					});
				//]]></script> </td>
            <td width="1%" align="left" class="text11" nowrap><input class="inputFormReadOnly" type="text" value="Invoice" name="trans_type" size="7" readonly="readonly"> 
            </td>
            <td width="5%" align="left" nowrap><span class="bn13text">Set Type</span>&nbsp;
              <select name="selectAll" class="searchformfiled" onChange="javascript : selectAllType();">
                <option value="">--Click--</option>
                <?php
				$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<option value='$data'>$data</option>";}
                ?><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option>              </select></td>
            <td width="10%" align="left" nowrap><span class="bn13text">Set Remarks</span> 
              <input name="mainRemark" type="text" class="searchformfiled" value="" onChange="javascript : setRemarks();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
            <td width="5%" align="left" nowrap><span class="bn13text">Total Amt :</span>&nbsp; <input class="searchformfiled" type="text" name="TotalAmt" value="0" size="10" tabindex="-1" readonly ></td>
            <td align="right" nowrap>&nbsp;&nbsp;
              <input type="reset" class="formButton" value="Reset" tabIndex="-1" name="reset">
              &nbsp;&nbsp;
              <input type="button" name="Save" value="Save" class="formButton" onClick="javascript: saveMultiEntries();"> 
            </td>
          </tr>
        </table>
	</td>
  </tr>
</table>
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
<tr bgcolor="#FFA800"> 
      <td align="center" nowrap>
	  <table width="100%" border="0" align="center" cellspacing="0" bordercolor="#FFA800" style="border-collapse: collapse">
  <tr class="tableheaderCell" align="center" bgcolor="#333333"> 
	<td width="10%" align="center" nowrap><strong>No.</strong></td>
	<td align="center" nowrap><strong>ID</strong></td>
	<td align="center" nowrap><strong>Type</strong></td>
	<td align="center" nowrap><strong>+/- Amount</strong></td>
	<td align="center" nowrap><strong>Remarks</strong></td>
  </tr>

  
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>3</td>
  	<td align="center"><input class="searchformfiled" tabindex="7" name="ID3" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc3" class="searchformfiled" tabindex="8" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="9" name="WL3" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks3" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>4</td>
  	<td align="center"><input class="searchformfiled" tabindex="10" name="ID4" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc4" class="searchformfiled" tabindex="11" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="12" name="WL4" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks4" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>5</td>
  	<td align="center"><input class="searchformfiled" tabindex="13" name="ID5" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc5" class="searchformfiled" tabindex="14" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="15" name="WL5" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks5" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>6</td>
  	<td align="center"><input class="searchformfiled" tabindex="16" name="ID6" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc6" class="searchformfiled" tabindex="17" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="18" name="WL6" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks6" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>7</td>
  	<td align="center"><input class="searchformfiled" tabindex="19" name="ID7" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc7" class="searchformfiled" tabindex="20" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="21" name="WL7" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks7" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>8</td>
  	<td align="center"><input class="searchformfiled" tabindex="22" name="ID8" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc8" class="searchformfiled" tabindex="23" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="24" name="WL8" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks8" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>9</td>
  	<td align="center"><input class="searchformfiled" tabindex="25" name="ID9" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc9" class="searchformfiled" tabindex="26" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>

	<td align="center"><input class="searchformfiled" tabindex="27" name="WL9" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks9" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>10</td>
  	<td align="center"><input class="searchformfiled" tabindex="28" name="ID10" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc10" class="searchformfiled" tabindex="29" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="30" name="WL10" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks10" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>11</td>
  	<td align="center"><input class="searchformfiled" tabindex="31" name="ID11" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc11" class="searchformfiled" tabindex="32" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="33" name="WL11" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks11" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>12</td>
  	<td align="center"><input class="searchformfiled" tabindex="34" name="ID12" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc12" class="searchformfiled" tabindex="35" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="36" name="WL12" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks12" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>13</td>
  	<td align="center"><input class="searchformfiled" tabindex="37" name="ID13" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc13" class="searchformfiled" tabindex="38" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="39" name="WL13" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks13" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>14</td>
  	<td align="center"><input class="searchformfiled" tabindex="40" name="ID14" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc14" class="searchformfiled" tabindex="41" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="42" name="WL14" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks14" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>15</td>
  	<td align="center"><input class="searchformfiled" tabindex="43" name="ID15" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc15" class="searchformfiled" tabindex="44" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="45" name="WL15" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks15" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>16</td>
  	<td align="center"><input class="searchformfiled" tabindex="46" name="ID16" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc16" class="searchformfiled" tabindex="47" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="48" name="WL16" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks16" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>17</td>
  	<td align="center"><input class="searchformfiled" tabindex="49" name="ID17" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc17" class="searchformfiled" tabindex="50" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="51" name="WL17" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks17" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>18</td>
  	<td align="center"><input class="searchformfiled" tabindex="52" name="ID18" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc18" class="searchformfiled" tabindex="53" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="54" name="WL18" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks18" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>19</td>
  	<td align="center"><input class="searchformfiled" tabindex="55" name="ID19" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc19" class="searchformfiled" tabindex="56" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="57" name="WL19" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks19" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>20</td>
  	<td align="center"><input class="searchformfiled" tabindex="58" name="ID20" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc20" class="searchformfiled" tabindex="59" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="60" name="WL20" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks20" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>21</td>
  	<td align="center"><input class="searchformfiled" tabindex="61" name="ID21" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc21" class="searchformfiled" tabindex="62" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="63" name="WL21" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks21" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>22</td>
  	<td align="center"><input class="searchformfiled" tabindex="64" name="ID22" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc22" class="searchformfiled" tabindex="65" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="66" name="WL22" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks22" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>23</td>
  	<td align="center"><input class="searchformfiled" tabindex="67" name="ID23" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc23" class="searchformfiled" tabindex="68" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="69" name="WL23" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks23" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>24</td>
  	<td align="center"><input class="searchformfiled" tabindex="70" name="ID24" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc24" class="searchformfiled" tabindex="71" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="72" name="WL24" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks24" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>25</td>
  	<td align="center"><input class="searchformfiled" tabindex="73" name="ID25" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc25" class="searchformfiled" tabindex="74" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="75" name="WL25" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks25" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>26</td>
  	<td align="center"><input class="searchformfiled" tabindex="76" name="ID26" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc26" class="searchformfiled" tabindex="77" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="78" name="WL26" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks26" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>27</td>
  	<td align="center"><input class="searchformfiled" tabindex="79" name="ID27" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc27" class="searchformfiled" tabindex="80" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="81" name="WL27" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks27" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>28</td>
  	<td align="center"><input class="searchformfiled" tabindex="82" name="ID28" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc28" class="searchformfiled" tabindex="83" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="84" name="WL28" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks28" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>29</td>
  	<td align="center"><input class="searchformfiled" tabindex="85" name="ID29" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc29" class="searchformfiled" tabindex="86" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="87" name="WL29" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks29" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>30</td>
  	<td align="center"><input class="searchformfiled" tabindex="88" name="ID30" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc30" class="searchformfiled" tabindex="89" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="90" name="WL30" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks30" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
</table>
	  </td>
	        <td align="center" nowrap>
	  <table width="100%" border="0" align="center" cellspacing="0" bordercolor="#FFA800" style="border-collapse: collapse">
  <tr class="tableheaderCell" align="center" bgcolor="#333333"> 
	<td width="10%" align="center" nowrap><strong>No.</strong></td>
	<td align="center" nowrap><strong>ID</strong></td>
	<td align="center" nowrap><strong>Type</strong></td>
	<td align="center" nowrap><strong>+/- Amount</strong></td>
	<td align="center" nowrap><strong>Remarks</strong></td>
  </tr>
            <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>31</td>
  	<td align="center"><input class="searchformfiled" tabindex="91" name="ID31" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc31" class="searchformfiled" tabindex="92" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="93" name="WL31" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks31" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>32</td>
  	<td align="center"><input class="searchformfiled" tabindex="94" name="ID32" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc32" class="searchformfiled" tabindex="95" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="96" name="WL32" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks32" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>33</td>
  	<td align="center"><input class="searchformfiled" tabindex="97" name="ID33" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc33" class="searchformfiled" tabindex="98" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="99" name="WL33" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks33" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>34</td>
  	<td align="center"><input class="searchformfiled" tabindex="100" name="ID34" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc34" class="searchformfiled" tabindex="101" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="102" name="WL34" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks34" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>35</td>
  	<td align="center"><input class="searchformfiled" tabindex="103" name="ID35" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc35" class="searchformfiled" tabindex="104" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="105" name="WL35" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks35" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>36</td>
  	<td align="center"><input class="searchformfiled" tabindex="106" name="ID36" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc36" class="searchformfiled" tabindex="107" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="108" name="WL36" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks36" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>37</td>
  	<td align="center"><input class="searchformfiled" tabindex="109" name="ID37" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc37" class="searchformfiled" tabindex="110" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="111" name="WL37" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks37" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>38</td>
  	<td align="center"><input class="searchformfiled" tabindex="112" name="ID38" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc38" class="searchformfiled" tabindex="113" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="114" name="WL38" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks38" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>39</td>
  	<td align="center"><input class="searchformfiled" tabindex="115" name="ID39" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc39" class="searchformfiled" tabindex="116" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="117" name="WL39" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks39" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>40</td>
  	<td align="center"><input class="searchformfiled" tabindex="118" name="ID40" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc40" class="searchformfiled" tabindex="119" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="120" name="WL40" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks40" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>41</td>
  	<td align="center"><input class="searchformfiled" tabindex="121" name="ID41" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc41" class="searchformfiled" tabindex="122" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="123" name="WL41" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks41" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>42</td>
  	<td align="center"><input class="searchformfiled" tabindex="124" name="ID42" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc42" class="searchformfiled" tabindex="125" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="126" name="WL42" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks42" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>43</td>
  	<td align="center"><input class="searchformfiled" tabindex="127" name="ID43" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc43" class="searchformfiled" tabindex="128" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="129" name="WL43" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks43" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>44</td>
  	<td align="center"><input class="searchformfiled" tabindex="130" name="ID44" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc44" class="searchformfiled" tabindex="131" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="132" name="WL44" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks44" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>45</td>
  	<td align="center"><input class="searchformfiled" tabindex="133" name="ID45" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc45" class="searchformfiled" tabindex="134" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="135" name="WL45" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks45" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>46</td>
  	<td align="center"><input class="searchformfiled" tabindex="136" name="ID46" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc46" class="searchformfiled" tabindex="137" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="138" name="WL46" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks46" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>47</td>
  	<td align="center"><input class="searchformfiled" tabindex="139" name="ID47" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc47" class="searchformfiled" tabindex="140" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="141" name="WL47" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks47" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>48</td>
  	<td align="center"><input class="searchformfiled" tabindex="142" name="ID48" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc48" class="searchformfiled" tabindex="143" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="144" name="WL48" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks48" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>49</td>
  	<td align="center"><input class="searchformfiled" tabindex="145" name="ID49" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc49" class="searchformfiled" tabindex="146" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="147" name="WL49" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks49" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>50</td>
  	<td align="center"><input class="searchformfiled" tabindex="148" name="ID50" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc50" class="searchformfiled" tabindex="149" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="150" name="WL50" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks50" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>51</td>
  	<td align="center"><input class="searchformfiled" tabindex="151" name="ID51" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc51" class="searchformfiled" tabindex="152" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="153" name="WL51" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks51" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>52</td>
  	<td align="center"><input class="searchformfiled" tabindex="154" name="ID52" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc52" class="searchformfiled" tabindex="155" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="156" name="WL52" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks52" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>53</td>
  	<td align="center"><input class="searchformfiled" tabindex="157" name="ID53" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc53" class="searchformfiled" tabindex="158" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="159" name="WL53" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks53" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>54</td>
  	<td align="center"><input class="searchformfiled" tabindex="160" name="ID54" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc54" class="searchformfiled" tabindex="161" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="162" name="WL54" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks54" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>55</td>
  	<td align="center"><input class="searchformfiled" tabindex="163" name="ID55" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc55" class="searchformfiled" tabindex="164" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="165" name="WL55" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks55" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>56</td>
  	<td align="center"><input class="searchformfiled" tabindex="166" name="ID56" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc56" class="searchformfiled" tabindex="167" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="168" name="WL56" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks56" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>57</td>
  	<td align="center"><input class="searchformfiled" tabindex="169" name="ID57" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc57" class="searchformfiled" tabindex="170" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="171" name="WL57" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks57" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>58</td>
  	<td align="center"><input class="searchformfiled" tabindex="172" name="ID58" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc58" class="searchformfiled" tabindex="173" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="174" name="WL58" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks58" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap>59</td>
  	<td align="center"><input class="searchformfiled" tabindex="175" name="ID59" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc59" class="searchformfiled" tabindex="176" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="177" name="WL59" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks59" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
  <tr align="center" class="tableCell" bgcolor="#FFFFFF"> 
  	<td width="10%" align="center" nowrap>60</td>
  	<td align="center"><input class="searchformfiled" tabindex="178" name="ID60" type="text" size="10" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><select name="eTypeAcc60" class="searchformfiled" tabindex="179" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><option value="4D">4D</option><option value="HORSE">HORSE</option><option value="SBOBET">SBOBET</option><option value="TOTO">TOTO</option></select></td>
	<td align="center"><input class="searchformfiled" tabindex="180" name="WL60" type="text" size="10" onChange="javascript: updateTotAmt();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
	<td align="center"><input name="remarks60" type="text" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
  </tr>
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
</html>
