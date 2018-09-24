<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	
		// get from memberid
	//$memberlist=mysql_query("SELECT memberid FROM memberid where managerid = '$weblogin'");
	$memberlist=mysql_query("SELECT memberid FROM memberid");
	while ($row_memberlist = mysql_fetch_array($memberlist)) 
	{
		if ($memlist=="") {
			$memlist = $row_memberlist[0];
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
function up(o){o.value=o.value.toUpperCase().replace(/([^0-9A-Z-])/g,"");}
function moveit(o){
if (o.name.length==3)
var a = o.name.substr(2,1);
if (o.name.length==4)
var a = o.name.substr(2,2);
var WLfocus=eval('document.multiForm.WL'+a);
WLfocus.focus();
WLfocus.select();
}

function gotoremarks(o){
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
if (o.name.length==8)
var a = (parseInt(o.name.substr(7,1))+1);
if (o.name.length==9)
var a = (parseInt(o.name.substr(7,2))+1);
var IDfocus=eval('document.multiForm.remarks'+a);
IDfocus.focus();
IDfocus.select();

}

/*function backtoid(o){
if (o.name.length==3)
var a = (parseInt(o.name.substr(2,1))+1);
if (o.name.length==4)
var a = (parseInt(o.name.substr(2,2))+1);
var IDfocus=eval('document.multiForm.ID'+a);
IDfocus.focus();
IDfocus.select();
}*/
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
			//if(existID.indexOf(','+newCID+',')==-1){
			if(existID.indexOf(newCID)==-1){
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
<!--<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/eye.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/layout.js?ver=1.0.2"></script>-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<link href="css/demos.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	$(function() {
		$("#inputDate").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottomMargin="0" bgColor="#FFFFFF" leftMargin="0" topMargin="0" rightMargin="0">
<p align="center" class="text12RedBold">Multiple Payment Submission</p>
 <form name="multiForm" method="post" action="multiInvoice.php">
 <input type="hidden" name="transaction" value="payment">
<input type="hidden" name="act" value="">
<input type="hidden" name="MaxCellId" value="60">
<input type="hidden" name="ExtCID" value="<?php echo $memlist; ?>">
<!--<input type="hidden" name="ExtCID" value=",AG01FB,AG02,AG04,AG05,AG05FB,AG06,AG06A,AG06AFB,AG06FB,AG07,AG08,AG09,AG10,AG11,AG11A,AG12,AG13,AG13FB,AG14,AG14FB,AG15,AG15FB,AG16,AG17FB,AG18,AG18FB,AG19,AG20,AG21,AG24,AG24FB,AG25,AG25FB,AG26,AG26FB,AG27,AG27FB,AG28,AG28FB,AG29,AG29FB,AG30,AG30FB,AG32,AG32FB,AG32FC,AG32FD,AG35,AG39,AG39FB,AG40,AG42,AG53,AG53FB,AG54,AG54FB,AG54FC,AG55,AG55FB,AG56,AG56FB,AG58,AG58FB,AG59,AG60,AG60FB,AG61,AG61FB,AG62,AG65,AG66,AG67,AG68,AG68FB,AG69,AG70,AG71,AG71FB,AG72,AG72FB,AG73,AG73FB,AG75,AG77,AG77FB,AG79,AG79FB,AG80,AG80FB,AG81,AG81FB,AG83,AG85,AG86,AG88,AG89,AG91,AG92,AG93,AG95,AG95FB,AG96,AG96FB,AG97,AG99,AS,ASFB,C602,C603,C604,C605,C681,C682,FB,M401,M402,M404,M407,M408,M410,M411,M412,M413,M415,M416,M417,M418,M419,M421,M422,M423,M427,M430,M431,M433,M436,M440,M443,M445,M451,M453,M454,M455,M457,M461,M462,M463,M465,M466,M467,M468,M472,M473,M475,M476,M478,M479,M480,M481,M483,M484,M485,M486,M487,M488,M489,M490,P2,P2FB,Q1,Q5,Q5FB,Q6,Q6FB,Q7,Q7FB,Q8,Q8FB,QA,QAFB,QB,QBFB,QBFC,QBMK,QC,QCFB,QD,QE,QF,QH,QJ,QJFB,QK,QKFB,QN,QQ,QQFB,QR,QV,QW,QX,QXFB,R7,R9,RA,RAFB,RARC,RARCFB,RB,RBFB,RC,RD,RDFB,RE,REFB,RF,RFFB,RG,RGFB,RH,RHFB,RHFC,RJ,RJFB,RK,RL,RLFB,RM,RN,RNFB,RP,RPFB,RQ,RQFB,RT,RTFB,RZ,RZFB,SA01,SA02,TA,TAFB,TC,TCFB,TD,TDFB,TE,TF,TFFB,TG,TGFB,TH,THFB,TJ,TJFB,TK,TKFB,TM,Y01,Y03,Y04,Y07,Y11,Y12,Y13,Y16,Y18,Y19,Y20,Y21,Y23,Y24,Y25,Y26,Y27,Y28,YP003,YP17,YP18,YP18A,YP18B,YP18C,YP18D,YP21,YP23,YP24,YP26,YP28,">-->
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFEDC7" align="center">
          <tr bgcolor="#FFEDC7" class="text12Bold"> 
		   <td align="left" nowrap class="text11">
		  <div class="demo">Date: <input type="text" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" style="width:80px">
</div></td>
            <!--<td width="1%" rowspan="2" align="right" nowrap>Date&nbsp;:&nbsp;</td>
            <td width="1%" rowspan="2" align="left" nowrap class="text11">
			&nbsp;&nbsp;&nbsp;
			<input class="inputDate" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate">&nbsp;&nbsp;-->
            <td width="1%" rowspan="2" align="left" nowrap class="text11">&nbsp;&nbsp;&nbsp;
			<input type="hidden" value="PAYMENT" name="trans_type">
			<!--<input class="inputFormReadOnly" type="text" value="PAYMENT" name="trans_type" size="10" readonly="readonly"-->&nbsp;&nbsp;&nbsp;</td>
            <td width="3%" colspan="2" rowspan="2" align="left" nowrap>&nbsp;&nbsp;&nbsp;Account:&nbsp;              <select name="selectAll" class="searchformfiled" onChange="javascript : selectAllType();" >
                <option value="">--Click--</option>
                <?php	$bmcodesql=mysql_query("SELECT cpyaccount FROM cpyaccount");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"cpyaccount");
				echo "<option value='$data'>$data</option>";}
                ?>
              </select></td>

            <td width="1%" rowspan="2" align="left" nowrap>&nbsp;&nbsp;&nbsp;Set Remarks 
              <input name="mainRemark" type="text" class="searchformfiled" value="" onChange="javascript : setRemarks();" onKeyDown="if(event.keyCode==13) event.keyCode=9;"></td>
            <td width="1%" align="right" nowrap>$</td>
            <td width="1%" align="left" nowrap><input class="searchformfiled" type="text" name="TotalAmt" value="0" size="10" tabindex="-1" readonly >
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
            <td rowspan="2" align="right" nowrap>&nbsp;&nbsp;
              <input type="reset" class="formButton" value="Reset" tabIndex="-1" name="reset">
              &nbsp;&nbsp;
              <input type="button" name="Save" value="Save" class="formButton" onClick="javascript: saveMultiEntries();">            </td>
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
	<td align="center" nowrap><strong>Account</strong></td>
	<td align="center" nowrap><strong>+/- Amount</strong></td>
	<td align="center" nowrap><strong>Remarks</strong></td>
  </tr>
  <?php for ($i=1;$i<=30;$i++) { ?>
  
            <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap><?php echo $i; ?></td>
  	<td align="center"><input name="ID<?php echo $i; ?>" type="text" class="searchformfiled" tabindex="<?php echo $i; ?>" onBlur="up(this)" onKeyDown="if(event.keyCode==13) moveit(this);" size="10" maxlength="8"></td>
	<td align="center"><select name="eTypeAcc<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><?php	$bmcodesql=mysql_query("SELECT cpyaccount FROM cpyaccount");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"cpyaccount");
				echo "<option value='$data'>$data</option>";}
                ?></select></td>
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
	<td align="center" nowrap><strong>Account</strong></td>
	<td align="center" nowrap><strong>+/- Amount</strong></td>
	<td align="center" nowrap><strong>Remarks</strong></td>
  </tr>
  <?php for ($i=31;$i<=60;$i++) { ?>
  
            <tr align="center" class="tableCell" bgcolor="#E7F1FE"> 
  	<td width="10%" align="center" nowrap><?php echo $i; ?></td>
  	<td align="center"><input name="ID<?php echo $i; ?>" type="text" class="searchformfiled" tabindex="<?php echo $i; ?>" onBlur="up(this)" onKeyDown="if(event.keyCode==13) moveit(this);" size="10" maxlength="8"></td>
	<td align="center"><select name="eTypeAcc<?php echo $i; ?>" class="searchformfiled" onKeyDown="if(event.keyCode==13) event.keyCode=9;"><option value="">--Click--</option><?php	$bmcodesql=mysql_query("SELECT cpyaccount FROM cpyaccount");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"cpyaccount");
				echo "<option value='$data'>$data</option>";}
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
</html>
