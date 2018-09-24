<?php
session_start();
	
$weblogin=$_SESSION["weblogin"];
$webpassword=$_SESSION["webpassword"];	

include "include/include.php";

$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
$rights=mysql_num_rows($login);
if(!$rights){header("location:index.php");}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="calendarDateInput.js"></script><script language="javascript">
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
</script></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr><td align="center" colspan="3"><span class="bn13text">Multiple Invoice Submission</span></td></tr>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
<?php
echo "<tr><td colspan='2'>";
echo"<table border='0' cellpadding='0' cellspacing='0'><tr><td><script>DateInput('datetime', true, 'YYYY-MM-DD')</script></td><td>&nbsp;<input type='text' value='W/L Placeout' size='10' disabled='disabled'>&nbsp;</td><td>&nbsp;<span class='bn13text'>Set Type :</span>";
echo"<select name='selectAll' class='searchformfiled' onChange='javascript : selectAllType();'>";
echo "<option value=''>--Click--</option>";
	$placeoutsql=mysql_query("SELECT subbmcode FROM bmcode");
	$placeoutrow=mysql_num_rows($placeoutsql);
	for($count=0; $count<$placeoutrow; $count++)
	{$data=mysql_result($placeoutsql,$count,"subbmcode");
	echo "<option value='$data'>$data</option>";}
echo"</select>";			
echo"</td></tr></table>";
echo"</td></tr>";
echo "<tr>";
echo"<td width='50%'>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' align='center'>";
echo "<tr><td align='center'><span class='bn13text'>No</span></td><td align='center'><span class='bn13text'>ID</span></td><td align='center'><span class='bn13text'>Type</span></td><td align='center'><span class='bn13text'>+/&ndash;Amount</span></td><td align='center'><span class='bn13text'>Remarks</span></td></tr>";
for($count=0; $count<25; $count++)
{$serial++;
if($count%2)
	{echo"<tr>";}
else
	{echo"<tr bgcolor='#dddddd'>";}
echo "<td align='center'><span class='bn13text'>$serial</span></td>";
echo "<td align='center'><input type='text' name='id$count' size='5'></td>";
echo "<td align='center'><select name='eTypeAcc1' class='searchformfiled' tabindex='2' onKeyDown='if(event.keyCode==13) event.keyCode=9;'><option value=''>--Click--</option>";
	$placeoutsql=mysql_query("SELECT subbmcode FROM bmcode");
	$placeoutrow=mysql_num_rows($placeoutsql);
	for($count1=0; $count1<$placeoutrow; $count1++)
	{$data=mysql_result($placeoutsql,$count1,"subbmcode");
	echo "<option value='$data'>$data</option>";}
echo"</select></td>";
echo "<td align='center'><input type='text' name='amount$count' size='10'></td>";
echo "<td align='center'><input type='text' name='remarks$count' size='20'></td>";
echo "</tr>";
}
echo "</table>";
echo "</td>";
echo"<td width='50%'>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' align='center'>";
echo "<tr><td align='center'><span class='bn13text'>No</span></td><td align='center'><span class='bn13text'>ID</span></td><td align='center'><span class='bn13text'>Type</span></td><td align='center'><span class='bn13text'>+/&ndash;Amount</span></td><td align='center'><span class='bn13text'>Remarks</span></td></tr>";
for($count=0; $count<25; $count++)
{$serial++;
if($count%2)
	{echo"<tr>";}
else
	{echo"<tr bgcolor='#dddddd'>";}
echo "<td align='center'><span class='bn13text'>$serial</span></td>";
echo "<td align='center'><input type='text' name='id$count' size='5'></td>";
echo "<td align='center'><select><option>--Click--</option><option>4D</option></select></td>";
echo "<td align='center'><input type='text' name='amount$count' size='10'></td>";
echo "<td align='center'><input type='text' name='remarks$count' size='20'></td>";
echo "</tr>";
}
echo "</table>";
echo "</td>";
echo "</tr>";
?></table>
</body>
</html>
<!--echo"<tr><td><script>DateInput('datetime', true, 'YYYY-MM-DD')</script></td><td><input type='text' value='Invoice' size='4' readonly></td><td><span class='bn13text'>Set Type : </span><select><option>--Click--</option><option>4D</option></select></td><td><span class='bn13text'>Set Remarks : </span></td><td><input type='text'></td><td><span class='bn13text'>Total Amount : </span></td><td><input type='text'></td><td></td><td><input type='button' value='Reset'></td><td><input type='button' value='Submit'></td></tr>";
-->