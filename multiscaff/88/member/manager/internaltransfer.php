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
	$amount=$_POST[amt];
	$toaccount=$_POST[toaccount];
	$fromaccount=$_POST[fromaccount];
	$currency=$_POST[currency];
	$submit=$_POST[submit];
	$datetime=date("Y-m-d H:i:s");
	switch($submit){
		case "Submit":
		//deduct
		mysql_query("insert into bmdatabase_payment values('','$datetime','-','$fromaccount','INT','$currency','-$amount',UCASE('$weblogin'),'$datetime','','')") or die(mysql_error());
		//add
		mysql_query("insert into bmdatabase_payment values('','$datetime','-','$toaccount','INT','$currency','$amount',UCASE('$weblogin'),'$datetime','','')") or die(mysql_error());
		echo "<SCRIPT language=\"JavaScript\">alert('Internal Transfer Successful!');</SCRIPT>";}
?>
<html>
<head><title>Internal Transfer</title><link rel="stylesheet" href="style.css" type="text/css" /></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
	  <td align="center" colspan="7"><span class="bn13text">Internal Transfer </span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
	<tr>
	<form action='<?php echo $PHP_SELF;?>' method='POST' name='change_pass' >
	<table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='50%' align='center' class='outline'>
	<tr><td height='10' colspan='7'></td></tr>
	<tr>
	  <td width='8%' align='right' valign='top'><span class='bn13text'>Date</span></td>
	  <td width='18%' align='center' valign='top'><input type='text'  size='15' name='date'  value='<?php echo $webdate; ?>' style="background-color:#66CCFF" disabled="disabled"></td>
	  <td width="2%" align='left'><span class="bn13text">&nbsp;&nbsp;&nbsp;ID</span></td>
	  <td width="30%" align='left'><input type='text'  size='15' name='userid'  value='<?php echo $weblogin; ?>' style="background-color:#66CCFF" disabled="disabled"></td>
	  <td width="20%" align='left'><span class="bn13text">From Account </span></td>
	  <td width="10%" align='left'><select name="fromaccount" class="searchformfiled" tabindex="2">
	    <option value="">--Click--</option>
	    <?php	$accountsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount where managerid='$weblogin'");
				$accountsqlrow=mysql_num_rows($accountsql);
				for($count=0; $count<$accountsqlrow; $count++)
				{$cpyaccount=mysql_result($accountsql,$count,"cpyaccount");
				$managerid=mysql_result($accountsql,$count,"managerid");
				echo "<option value='$cpyaccount'>$managerid - $cpyaccount</option>";}
                ?>
	    </select>	  </td>
	</tr>
	<tr>
	  <td width='8%' align='right' valign='top'><span class='bn13text'>Amt&nbsp;</span></td>
	  <td width='18%' align='center' valign='top'><input type='text'  size='15' name='amt'  value=''></td>
	  <td align='left'><span class="bn13text">&nbsp;&nbsp;&nbsp;Currency</span></td>
	  <td align='left'><select name="currency" class="searchformfiled" >
        <option value="SGD" selected="selected">SGD</option>
        <option value="">--Click--</option>
        <?php	$currencysql=mysql_query("SELECT currencycode FROM currency");
				$currencysqlrow=mysql_num_rows($currencysql);
				for($count=0; $count<$currencysqlrow; $count++)
				{$currencycode=mysql_result($currencysql,$count,"currencycode");
				echo "<option value='$currencycode'>$currencycode</option>";}
                ?>
      </select></td>
	  
	  <td align='left'><span class="bn13text">To Account </span></td>
	  <td align='left'><select name="toaccount" class="searchformfiled" tabindex="2">
        <option value="">--Click--</option>
	    <?php	$accountsql=mysql_query("SELECT cpyaccount,managerid FROM cpyaccount where not managerid='$weblogin'");
				$accountsqlrow=mysql_num_rows($accountsql);
				for($count=0; $count<$accountsqlrow; $count++)
				{$cpyaccount=mysql_result($accountsql,$count,"cpyaccount");
				$managerid=mysql_result($accountsql,$count,"managerid");
				echo "<option value='$cpyaccount'>$managerid - $cpyaccount</option>";}
                ?>
      </select></td></tr>
	<tr><td width='8%' align='right' valign='top'>&nbsp;</td>
	<td width='18%' align='center' valign='top'>&nbsp;</td>
	  <td align='left'>&nbsp;</td>
	  <td align='left'>&nbsp;</td>
	  
	  <td align='left'>&nbsp;</td>
	  <td align='left'>&nbsp;</td></tr>
	<tr><td colspan='7' align='center'><input type='submit' value='Submit' name='submit'>&nbsp;<input type='button' value='Reset' onClick=\"window.location.href='internaltransfer.php'\"></td></tr></form>
	<tr><td height='10' colspan='7'></td></tr>
	</table>
	</tr>
</table>

</body>
</html>