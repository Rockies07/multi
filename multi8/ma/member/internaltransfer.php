<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	//$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

$webdate=date("Y-m-d");
function randomPagenum($length) {
	$chars = "1234567890";
	$i = 0;
	$number = "";
	while ($i <= $length) {
		$number .= $chars{mt_rand(0,strlen($chars))};
		$i++;
	}
	return $number;
}
?>
<?php
if ($_POST[submit]) {
	$amount=$_POST[amt];
	$toaccount=$_POST[toaccount];
	$fromaccount=$_POST[fromaccount];
	$currency=$_POST[currency];
	$submit=$_POST[submit];
	$remarks=$_POST[remarks];
	$datetime=$_POST[datetime];
	$sabog =(explode("/",$datetime));
	$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
	//$manageridfrom=$_POST[manageridfrom];
	$manageridto=$_POST[manageridto];
	
	$datetime2=date("Y-m-d H:i:s");
	
	if ($amount<>"" || $amount<>0) {
	switch($submit){
		case "Submit":
		if ($toaccount==$fromaccount)
		echo "<SCRIPT language=\"JavaScript\">alert('Cannot transfer from the same account!');</SCRIPT>";
		else {
		//deduct
	//	mysql_query("insert into bmdatabase_payment values('','$datetime','-','$fromaccount','INT','$currency','-$amount',UCASE('$weblogin'),'$datetime','','')") or die(mysql_error());
//	echo "insert into bmdatabase_payment values('','$datetime','-','$fromaccount','INT','$currency','-$amount',UCASE('$weblogin'),'$datetime','$remarks','','')" . "<br>";
$trans_ref=randomPagenum(5);

mysql_query("insert into bmdatabase_payment values('','$converted_datetime','-','$fromaccount','INT','$currency','-$amount',UCASE('$weblogin'),'$datetime2','$remarks','','','$trans_ref')") or die(mysql_error());
		//add
	//	mysql_query("insert into bmdatabase_payment values('','$datetime','-','$toaccount','INT','$currency','$amount',UCASE('$manageridto'),'$datetime','','')") or die(mysql_error());
	//echo "insert into bmdatabase_payment values('','$datetime','-','$toaccount','INT','$currency','$amount',UCASE('$weblogin'),'$datetime','$remarks','','')"  . "<br>";
mysql_query("insert into bmdatabase_payment values('','$converted_datetime','-','$toaccount','INT','$currency','$amount',UCASE('$weblogin'),'$datetime2','$remarks','','','$trans_ref')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('Internal Transfer Successful!');</SCRIPT>";}}
	}
	else {
	echo "<SCRIPT language=\"JavaScript\">alert('Amount is required!');</SCRIPT>";
	}
}

if ($_GET["action"]=='update') {
$reff = $_GET["ref"];
$trans_ref = $_GET["trans_ref"];
$amt = $_GET["amt"];

mysql_query("update bmdatabase_payment set amount='$amt' where ref='$reff' and trans_ref='$trans_ref'") or die(mysql_error());
mysql_query("update bmdatabase_payment set amount='-$amt' where trans_ref='$trans_ref' and amount<0") or die(mysql_error());
echo "<SCRIPT language=\"JavaScript\">alert('Amount got updated!');</SCRIPT>";
}

if ($_GET["action"]=='delete') {

$trans_ref = $_GET["trans_ref"];

mysql_query("delete from bmdatabase_payment where trans_ref='$trans_ref'") or die(mysql_error());
echo "<SCRIPT language=\"JavaScript\">alert('Transaction got deleted!');</SCRIPT>";
}

?>
<html>
<head><title>Internal Transfer</title>
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
	else if (o.value<=0) {
		alert("Please Enter Non-negative/Zero Value");
		o.focus();
		return false;
	}
	if (o.value.charAt(0)=="0") {
		alert("Please Insert Correct Amount Format");
		o.focus();
		return false;
	}
}
</script>
<link rel="stylesheet" href="style.css" type="text/css" /></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
	  <td align="center" colspan="7"><span class="bn13text">Internal Transfer </span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
	<tr>
	<td width="35%">
	</td>
	</tr>
</table>
	<form action='<?php echo $PHP_SELF;?>' method='POST' name='internal' >
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='95%' align='center'>
	<tr>
	<td align="left" nowrap class="text11">
		  <div class="demo">Date: <input type="text" id="inputDate" name="datetime" value="<?php echo date("m/d/Y"); ?>" readonly="true" style="width:80px">
</div></td>
	  <input type='hidden' name='userid'  value='<?php echo $weblogin; ?>'></td>
	  <td ><span class='bn13text'>Amount
	    <input type='text'  size='15' name='amt'  value='' onChange='numeric(this)'>
	    <select name="currency" class="searchformfiled" >
          <option value="SGD" selected="selected">SGD</option>
          <!--<option value="">--Click--</option>-->
          <?php	$currencysql=mysql_query("SELECT currencycode FROM currency");
				$currencysqlrow=mysql_num_rows($currencysql);
				for($count=0; $count<$currencysqlrow; $count++)
				{$currencycode=mysql_result($currencysql,$count,"currencycode");
				echo "<option value='$currencycode'>$currencycode</option>";}
                ?>
        </select>
	  </span></td>
	  <td align='left'><span class='bn13text'>&nbsp;&nbsp;&nbsp;Remarks</span></td>
	   <td align='left'><input type='text'  size='35' name='remarks'  value=''></td>
	  <td ><span class='bn13text'>From Account</span></td>
	  <td ><select name="fromaccount" class="searchformfiled" tabindex="2">
        <!-- <option value="">--Click--</option>-->
        <?php	//$accountsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount where managerid='$weblogin'");
				$accountsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount where managerid='$weblogin'");
				$accountsqlrow=mysql_num_rows($accountsql);
				for($count=0; $count<$accountsqlrow; $count++)
				{$cpyaccount=mysql_result($accountsql,$count,"cpyaccount");
				$managerid_from=mysql_result($accountsql,$count,"managerid");
				echo "<option value='$cpyaccount'>$cpyaccount</option>";}
				//echo "<option value='$cpyaccount'>$managerid_from - $cpyaccount</option>";}
                ?>
      </select>
	  <input type='hidden' name='manageridfrom' value='<?php echo $managerid_from; ?>'>
	  </td>
	  <td ><span class='bn13text'>To Account </span></td>
	  <td ><select name="toaccount" class="searchformfiled" tabindex="2">
        <!--<option value="">--Click--</option>-->
        <?php	//$accountsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount where not managerid='$weblogin'");
				$accountsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount where not managerid='$weblogin'");
				$accountsqlrow=mysql_num_rows($accountsql);
				for($count=0; $count<$accountsqlrow; $count++)
				{$cpyaccount=mysql_result($accountsql,$count,"cpyaccount");
				$managerid_to=mysql_result($accountsql,$count,"managerid");
				echo "<option value='$cpyaccount'>$cpyaccount</option>";}
				//echo "<option value='$cpyaccount'>$managerid_to - $cpyaccount</option>";}
                ?>
      </select>
	  <input type='hidden' name='manageridto' value='<?php echo $managerid_to; ?>'>
	  </td>
	  </tr>
	  <tr>
	  <td colspan="7" ><div align="center"><input type='submit' value='Submit' name='submit'>&nbsp;<input type='button' value='Reset' onClick=\"window.location.href='internaltransfer.php'\"></div></form></td>
	  </tr>

<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center">
	  <br>
	<tr >
		  <td align="center"><span class="bn13text">Date</span></td>
	  <td align="center"><span class="bn13text">Account</span></td>
	  <td align="center"><span class="bn13text">Amount</span></td>
	  <td align="center"><span class="bn13text">Currency</span></td>
	  <td align="center"><span class="bn13text">Remarks</span></td>	  
	<td align="center"><span class="bn13text">Date</span></td>
	<td align="center"><span class="bn13text">Action</span></td>
	</tr>
<?php
	//$action=$_POST[action];
	$expensesql=mysql_query("SELECT entriesby,cpyaccount,amount,currencycode,entriesdate,remark,bmdate,ref,trans_ref FROM bmdatabase_payment where type='INT' and entriesby = '$weblogin' ORDER BY entriesdate DESC");
//	echo "SELECT entriesby,cpyaccount,amount,currencycode,remark,entriesdate FROM bmexpenses ORDER BY entriesdate DESC";
	$expensesrow=mysql_num_rows($expensesql);
	for($count=0; $count<$expensesrow; $count++)
	{
	$amount=mysql_result($expensesql,$count,"amount");
	if ($amount<>'0.00' && $amount<>"") {
	echo "<tr>";
	$entriesby=mysql_result($expensesql,$count,"entriesby");
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";
	$cpyaccount=mysql_result($expensesql,$count,"cpyaccount");
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	
	$action=$_GET[action];
	$ref=mysql_result($expensesql,$count,"ref");
	$trans_ref=mysql_result($expensesql,$count,"trans_ref");
/*	echo $action . "<br>";
	echo $ref . "<br>";
	echo $trans_ref . "<br>";
	echo $_GET["ref"] . "<br>";*/
	if ($action=='edit' && $_GET["ref"]==$ref)
	{
		echo "<form action='internaltransfer.php' method='get' style='margin-bottom:0;'><td align='center'><span class='bn13text'><input type='text' size='15' name='amt'  value='$amount' onChange='numeric(this)'></span></td>
		<input type='hidden' name='ref' value='$ref'><input type='hidden' name='trans_ref' value='$trans_ref'><input type='hidden' name='action' value='update'>";
	}
	else
	{
		echo "<td align='center'><span class='bn13text'>$amount</span></td>";
	}
	$currencycode=mysql_result($expensesql,$count,"currencycode");
	echo "<td align='center'><span class='bn13text'>$currencycode</span></td>";
/*	$remark=mysql_result($expensesql,$count,"remark");
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";*/
	
/*	$entriesdate=mysql_result($expensesql,$count,"entriesdate");  ///new lah
	$bbb=strtotime(str_replace("-", "/",$entriesdate));
	$entriesdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$entriesdate</span></td>";*/
	
	$remark=mysql_result($expensesql,$count,"remark");
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	
	$bmdate=mysql_result($expensesql,$count,"bmdate");  ///new lah
	$bbb=strtotime(str_replace("-", "/",$bmdate));
	$bmdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	
	if ($amount>0 && $action<>'edit') {

	echo "<td align='center'><a href='internaltransfer.php?action=edit&ref=$ref&transref=$trans_ref' target='_self'><img src='images/edit.gif' border='0' title='Edit'></a>&nbsp;&nbsp;<a href='internaltransfer.php?action=delete&ref=$ref&trans_ref=$trans_ref' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></td>";
	}
	else
	{
//	echo "<td align='center'></td>";
		if ($amount>0) {
			echo "<td align='center'><a href='internaltransfer.php' target='_self'><img src='images/undo.gif' border='0' title='Undo'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' title='Save'></td>";
			}
			else
			{
				echo "<td align='center'></td>";
			}
	}
	
	/*echo "<td align='center'><span class='bn13text'><a href='viewsubmember.php?action=delete&memberid=$memberid&subid=$subid'>Delete</a></span></td>";
	echo "<td align='center'><input type='checkbox'></td>";*/
	echo "</tr></form>";}}
	?>
</table>
</body>
</html>