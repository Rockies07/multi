<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

$webdate=date("Y-m-d");
?>
<?php
if ($_POST[submit]) {
	$amount=abs($_POST[amount]);
	$remarks=$_POST[remarks];
	$account=$_POST[account];
	$datetime=$_POST[datetime];
	$sabog =(explode("/",$datetime));
	$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
	$currency=$_POST[currency];
	$userid=$_POST[userid];
	$submit=$_POST[submit];
	$datetime2=date("Y-m-d H:i:s");
	//$sabog =(explode("-",$datetime));
	//$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
	$deyt=date("Y-m-d");
	if ($amount<>"" || $amount<>0) {
	switch($submit){
		case "Submit":
		//echo "INSERT INTO bmexpenses (ref, bmdate, type, cpyaccount, currencycode, amount, remark, entriesby, entriesdate) VALUES('', '$converted_datetime', 'EXP','$account','$currency','-$amount','$remarks','$weblogin','$datetime2')";
		mysql_query("INSERT INTO bmexpenses (ref, bmdate, type, cpyaccount, currencycode, amount, remark, entriesby, entriesdate) VALUES('', '$converted_datetime', 'EXP','$account','$currency','-$amount','$remarks',UCASE('$weblogin'),'$datetime2')") or die(mysql_error());
		//echo "INSERT INTO bmexpenses (ref, bmdate, type, cpyaccount, currencycode, amount, remark, entriesby, entriesdate) VALUES('', '$deyt', 'EXP','$account','$currency','$amount','$remarks','$weblogin','$datetime')";
		echo "<SCRIPT language=\"JavaScript\">alert('New Expenses has been Added!');</SCRIPT>";}
		//break;
		}
		else {
	echo "<SCRIPT language=\"JavaScript\">alert('Amount is required!');</SCRIPT>";
	}
}
	?>
<html>
<head><title>Expenses</title>
<script type="text/javascript">
function numeric(o){	
	if (isNaN(o.value)) {
		alert("Amount should only be Numeric");
		o.focus();
		return false;
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
<script type="text/javascript">
	$(function() {
		$("#inputDate").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	</script>
<link href="style.css" rel="stylesheet" type="text/css">
<!--<link rel="stylesheet" href="css/datepicker.css" type="text/css" />-->
<link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
<script type="text/javascript">
function numeric(o){
	if (isNaN(o.value)) {
		alert("Amount should only be Numeric");
		o.focus();
		return false;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
	  <td align="center" colspan="9"><span class="bn13text">Expenses</span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
	<tr>
	<form action='<?php echo $PHP_SELF;?>' method='POST' name='change_pass' >
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='80%' align='center' class='outline'>
	<tr><td height='10' colspan='9'></td></tr>
	<tr>
	  <td align='right' ><span class='bn13text'>&nbsp;&nbsp;&nbsp;Amt&nbsp;&nbsp;</span></td>
	  <td  align='left' ><input type='text' size='15' name='amount'  value='0' onBlur='numeric(this)'><input type='hidden' name='userid'  value='<?php echo $weblogin; ?>'></td>
	  <td  align='left'><span class="bn13text">&nbsp;&nbsp;&nbsp;Account&nbsp;&nbsp;</span></td>
	  <td  align='left'><select name="account" class="searchformfiled" tabindex="2">
        <!--   <option value="">--Click--</option>-->
        <?php	$bmcodesql=mysql_query("SELECT cpyaccount FROM cpyaccount");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"cpyaccount");
				echo "<option value='$data'>$data</option>";}
                ?>
      </select>
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
	  <td align='left'><span class='bn13text'>&nbsp;&nbsp;&nbsp;Remarks</span></td>
	  <td align='left'><input type='text'  size='35' name='remarks'  value=''></td>
	  <td align="left" nowrap class="text11">
		  <div class="demo">Date: <input type="text" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" style="width:80px">
</div></td>
	 <!-- <td align='left'><span class="bn13text">Date </span></td>
	  <td  align='left' nowrap class='text11'><input name="datetime" class="inputDate" id="inputDate" value="<?php echo date("m/d/Y"); ?>" readonly="true" /><img src="images/pikpik.gif" width="20" height="20" class="inputDate"></td>-->
	</tr>
	<tr><td colspan='9' align='center'><input type='submit' value='Submit' name='submit'>&nbsp;<input type='button' value='Reset' onClick=\"window.location.href='internaltransfer.php'\"></td></tr></form>
	<tr><td height='10' colspan='9'></td></tr>
	</table>
<br><br>
<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr bordercolor="#000000" bgcolor="#888888">
	  <td align="center"><span class="bn13text">Date</span></td>
	  <td align="center"><span class="bn13text">Account</span></td>
	  <td align="center"><span class="bn13text">Amount</span></td>
	  <td align="center"><span class="bn13text">Currency</span></td>
	  <td align="center"><span class="bn13text">Remarks</span></td>
	  <td align="center"><span class="bn13text">MD</span></td>
	</tr>
<?php
	//$action=$_POST[action];
	$expensesql=mysql_query("SELECT entriesby,cpyaccount,amount,currencycode,remark,bmdate FROM bmexpenses ORDER BY entriesdate DESC");
//	echo "SELECT entriesby,cpyaccount,amount,currencycode,remark,entriesdate FROM bmexpenses ORDER BY entriesdate DESC";
	$expensesrow=mysql_num_rows($expensesql);
	for($count=0; $count<$expensesrow; $count++)
	{
	$amount=mysql_result($expensesql,$count,"amount");
	//echo $amount;
	if ($amount<>'0.00' && $amount<>"") {
	echo "<tr>";
	$bmdate=mysql_result($expensesql,$count,"bmdate");  ///new lah
	$bbb=strtotime(str_replace("-", "/",$bmdate));
	$bmdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	$cpyaccount=mysql_result($expensesql,$count,"cpyaccount");
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	
	echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	$currencycode=mysql_result($expensesql,$count,"currencycode");
	echo "<td align='center'><span class='bn13text'>$currencycode</span></td>";
	$remark=mysql_result($expensesql,$count,"remark");
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	$bmdate=mysql_result($expensesql,$count,"bmdate");
//	$hahaha = "2010-01-07 00:30:28";
///	$hahaha = "01-01-2010 00:30:28";
//	echo date("m-d-Y",$hahaha);
//	$entriesdate=mysql_result($expensesql,$count,"entriesdate");

	$entriesby=mysql_result($expensesql,$count,"entriesby");
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
	/*echo "<td align='center'><span class='bn13text'><a href='viewsubmember.php?action=delete&memberid=$memberid&subid=$subid'>Delete</a></span></td>";
	echo "<td align='center'><input type='checkbox'></td>";*/
	echo "</tr>";}}
	?>
</table>
</body>
</html>