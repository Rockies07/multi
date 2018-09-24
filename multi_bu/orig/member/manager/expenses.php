<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

$webdate=date("Y-m-d");
?>
<?php

	$amount=$_POST[amount];
	$remarks=$_POST[remarks];
	$account=$_POST[account];
	$datetime=$_POST[datetime];
	$currency=$_POST[currency];
	$userid=$_POST[userid];
	$submit=$_POST[submit];
	$datetime=date("Y-m-d H:i:s");
	$sabog =(explode("/",$datetime));
	$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
	$deyt=date("Y-m-d");
	
	switch($submit){
		case "Submit":
		mysql_query("INSERT INTO bmexpenses (ref, bmdate, type, cpyaccount, currencycode, amount, remark, entriesby, entriesdate) VALUES('', '$deyt', 'EXP','$account','$currency','-$amount','$remarks','$weblogin','$converted_datetime')") or die(mysql_error());
		//echo "INSERT INTO bmexpenses (ref, bmdate, type, cpyaccount, currencycode, amount, remark, entriesby, entriesdate) VALUES('', '$deyt', 'EXP','$account','$currency','$amount','$remarks','$weblogin','$datetime')";
		echo "<SCRIPT language=\"JavaScript\">alert('New Expenses has been Added!');</SCRIPT>";}
		//break;

	?>
<html>
<head><title>Expenses</title><script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/eye.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/layout.js?ver=1.0.2"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/datepicker.css" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
<script type="text/javascript">
function numeric(o){
	if (isNaN(o.value)) {
		alert("Contacts  should only be Numeric");
		o.focus();
		return false;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
	  <td align="center" colspan="7"><span class="bn13text">Expenses <?php echo strtoupper($weblogin); ?></span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
	<tr>
	<form action='<?php echo $PHP_SELF;?>' method='POST' name='change_pass' >
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='65%' align='center' class='outline'>
	<tr><td height='10' colspan='7'></td></tr>
	<tr>
	  <td width='9%' align='right' valign='top'><span class='bn13text'>&nbsp;&nbsp;&nbsp;Amt&nbsp;&nbsp;</span></td>
	  <td width='23%' align='left' valign='top'><input type='text' size='15' name='amount'  value='sdf' id='amount' ></td>
	  <td width="6%" align='left'><span class="bn13text">&nbsp;&nbsp;&nbsp;Account&nbsp;&nbsp;</span></td>
	  <td width="31%" align='left'><select name="account" class="searchformfiled" tabindex="2">
     <!--   <option value="">--Click--</option>-->
        <?php	$bmcodesql=mysql_query("SELECT cpyaccount FROM cpyaccount");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"cpyaccount");
				echo "<option value='$data'>$data</option>";}
                ?>
      </select></td>
	  <td width="7%" align='left'><span class="bn13text">Date </span></td>
	  <td width="24%" align='left' nowrap class='text11'><input name="datetime" class="inputDate" id="inputDate" value="<?php echo date("m/d/Y"); ?>" /></td>
	</tr>
	<tr>
	  <td width='9%' align='right' valign='top'><span class='bn13text'>&nbsp;&nbsp;&nbsp;Remarks</span></td>
	  <td width='23%' align='left' valign='top'><input type='text'  size='35' name='remarks'  value=''></td>
	  <td align='left'><span class="bn13text">&nbsp;&nbsp;&nbsp;Currency&nbsp;&nbsp;</span></td>
	  <td align='left'><select name="currency" class="searchformfiled" >
			<option value="SGD" selected="selected">SGD</option>
              <option value="">--Click--</option>
			 <?php	$currencysql=mysql_query("SELECT currencycode FROM currency");
				$currencysqlrow=mysql_num_rows($currencysql);
				for($count=0; $count<$currencysqlrow; $count++)
				{$data=mysql_result($currencysql,$count,"currencycode");
				echo "<option value='$data'>$data</option>";}
                ?>
            </select></td>
	  
	  <td align='left'><span class="bn13text"> ID </span></td>
	  <td align='left'><input type='text'  size='15' name='userid'  value='<?php echo $weblogin; ?>' style="background-color:#66CCFF" disabled="disabled"></td></tr>
	<tr><td width='9%' align='right' valign='top'>&nbsp;</td>
	<td width='23%' align='center' valign='top'>&nbsp;</td>
	  <td align='left'>&nbsp;</td>
	  <td align='left'>&nbsp;</td>
	  
	  <td align='left'>&nbsp;</td>
	  <td align='left'>&nbsp;</td></tr>
	<tr><td colspan='7' align='center'><input type='submit' value='Submit' name='submit'>&nbsp;<input type='button' value='Reset' onClick=\"window.location.href='internaltransfer.php'\"></td></tr></form>
	<tr><td height='10' colspan='7'></td></tr>
	</table>
<br><br>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr >
	  <td align="center"><span class="bn13text">MD</span></td>
	  <td align="center"><span class="bn13text">Account</span></td>
	  <td align="center"><span class="bn13text">Amount</span></td>
	  <td align="center"><span class="bn13text">Currency</span></td>
	  <td align="center"><span class="bn13text">Remarks</span></td>
	  <td align="center"><span class="bn13text">Date</span></td>
	</tr>
<?php
	//$action=$_POST[action];
	$expensesql=mysql_query("SELECT entriesby,cpyaccount,amount,currencycode,remark,entriesdate FROM bmexpenses ORDER BY entriesdate DESC");
//	echo "SELECT entriesby,cpyaccount,amount,currencycode,remark,entriesdate FROM bmexpenses ORDER BY entriesdate DESC";
	$expensesrow=mysql_num_rows($expensesql);
	for($count=0; $count<$expensesrow; $count++)
	{echo "<tr>";
	$entriesby=mysql_result($expensesql,$count,"entriesby");
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
	$cpyaccount=mysql_result($expensesql,$count,"cpyaccount");
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	$amount=mysql_result($expensesql,$count,"amount");
	echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	$currencycode=mysql_result($expensesql,$count,"currencycode");
	echo "<td align='center'><span class='bn13text'>$currencycode</span></td>";
	$remark=mysql_result($expensesql,$count,"remark");
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	$entriesdate=mysql_result($expensesql,$count,"entriesdate");
	echo "<td align='center'><span class='bn13text'>$entriesdate</span></td>";
	/*echo "<td align='center'><span class='bn13text'><a href='viewsubmember.php?action=delete&memberid=$memberid&subid=$subid'>Delete</a></span></td>";
	echo "<td align='center'><input type='checkbox'></td>";*/
	echo "</tr>";}
	?>
</table>
</body>
</html>