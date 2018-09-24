<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" /></head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="45%" align="center">
	<tr><td align="center"><span class="bn13text">View Currency</span></td></tr>
    <?php
	$action=$_GET[action];
	$row=$_GET[row];
	$currencyname=$_POST[currencyname];
	$currencycode=$_POST[currencycode];
	$currencyrate=$_POST[currencyrate];
	if($action!='Add'){echo"<tr><td align='left'><a href='viewcurrency.php?action=Add' target='_self'><img src='images/new.jpg' border='0'></a></td></tr>";}
	switch($action){
		case "Delete":
			mysql_query("DELETE FROM currency WHERE no = '$row'");
			echo "<SCRIPT language=\"JavaScript\">alert('Currency Deleted!');</SCRIPT>";
		break;
		case "Added":
			if(($currencyname)&&($currencycode)&&(is_numeric($currencyrate)))
				{
				$currencysql=mysql_query("SELECT currencycode FROM currency WHERE currencycode='$currencycode'");
				$currencyrow=mysql_num_rows($currencysql);
					if($currencyrow){echo "<SCRIPT language=\"JavaScript\">alert('Currency Code Exists!');</SCRIPT>";$action='Add';}
					else{mysql_query("INSERT INTO currency (no, currencycode, rate, currencyname) VALUES('','$currencycode','$currencyrate','$currencyname')")or die(mysql_error());
				echo "<SCRIPT language=\"JavaScript\">alert('Currency Code Accepted!');</SCRIPT>";}}
			else{echo "<SCRIPT language=\"JavaScript\">alert('Make Sure All Fields Are Entered!');</SCRIPT>";
			$action='Add';}
		break;
		case "Edited":
			mysql_query("UPDATE currency SET currencycode='$currencycode', rate='$currencyrate', currencyname='$currencyname' WHERE no = '$row'");
			echo "<SCRIPT language=\"JavaScript\">alert('Currency Updated!');</SCRIPT>";
		break;
		}
	?>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="45%" align="center">
<tr >
    <td align="center" style="border:solid 1px #000000" width="5%"><span class="bn13text">&nbsp;<b>#</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Currency Name</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Currency Code</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Currency Rate</b>&nbsp;</span></td>
    <td align="center" style="border:solid 1px #000000"><span class="bn13text">&nbsp;<b>Action</b>&nbsp;</span></td>
</tr>
<?php
	if($action=='Add'){echo"<tr>";
	echo"<td align='center'><span class='bn13text'>#</span></td>";
	echo"<form action='viewcurrency.php?action=Added'  method='post' style='margin-bottom:0;'>";
	echo"<td align='center'><input type='text' maxlength='20' size='15' name='currencyname' value='$currencyname'></td>";
	echo"<td align='center'><input type='text' maxlength='3' size='10' name='currencycode' value='$currencycode'></td>";
	echo"<td align='center'><input type='text' maxlength='5' size='10' name='currencyrate' value='$currencyrate'></td>";
	echo"<td align='center'><a href='viewcurrency.php'><img src='images/cancel.gif' border='0' alt='Cancel'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' alt='Save'></td>";
	echo"</form>";
	echo"</tr>";}
	$currencysql=mysql_query("SELECT * FROM currency");
	$currencyrow=mysql_num_rows($currencysql);
	for($count=0; $count<$currencyrow; $count++)
	{$serial++;
	if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
	else
		{echo"<tr>";}
	$rowdata=mysql_result($currencysql,$count,"no");	
	echo"<td align='center'><span class='bn13text'>$serial</span></td>";
	$data=mysql_result($currencysql,$count,"currencyname");
	if(($action=='Edit')&&($row==$rowdata)){echo"<form action='viewcurrency.php?action=Edited&row=$rowdata'  method='post' style='margin-bottom:0;'>";
	echo "<td align='center'><input type='text' maxlength='20' size='15' name='currencyname' value='$data'></td>";}
	else{echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	$data=mysql_result($currencysql,$count,"currencycode");
	if(($action=='Edit')&&($row==$rowdata)){echo "<td align='center'><input type='text' maxlength='3' size='10' name='currencycode' value='$data'></td>";}
	else{echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	$data=mysql_result($currencysql,$count,"rate");
	if(($action=='Edit')&&($row==$rowdata)){echo "<td align='center'><input type='text' maxlength='5' size='10' name='currencyrate' value='$data'></td>";}
	else{echo "<td align='center'><span class='bn13text'>$data</span></td>";}
	if(($action=='Edit')&&($row==$rowdata)){echo "<td align='center'><span class='bn13text'><a href='viewcurrency.php'><img src='images/cancel.gif' border='0' alt='Cancel'></a>&nbsp;&nbsp;<input type='image' src='images/save.gif' alt='Save'></td>";
	echo "</form>";}
	else{echo "<td align='center'><span class='bn13text'><a href='viewcurrency.php?action=Edit&row=$rowdata'><img src='images/edit.gif' border='0'></a>&nbsp;&nbsp;<a href='viewcurrency.php?action=Delete&row=$rowdata'><img src='images/trash.gif' border='0'></a></span></td>";}
	echo"</tr>";
	}
?>
</table>
</body>
</html>