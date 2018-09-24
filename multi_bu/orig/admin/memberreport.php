<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Member Report</title>
<script type="text/javascript" src="calendarDateInput.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body bottomMargin="0" bgColor="#FFFFFF" leftMargin="0" topMargin="0" rightMargin="0">
<p align="center" class="text12RedBold">Member Report </p>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFA800">
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFEDC7" align="center">
          <tr bgcolor="#FFEDC7" class="text12Bold"> 
            <td>Member</td>
			<?php	
				$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				echo "<td>$data</td>";}
                ?>
            <td>Total</td>
          </tr>
		  <tr bgcolor="#FFA800"> 
			  <?php	
			//	$members=mysql_query("SELECT distinct memberid,set_type,amount FROM member_submission");
				$members=mysql_query("SELECT distinct memberid FROM member_submission");
				while ($row_members = mysql_fetch_array($members)) 
				{
				echo "<td>$row_members[0]</td>";
				echo "<td>0.00</td>";
				echo "<td>0.00</td>";
				echo "<td>0.00</td>";								
				/*if ($row_members[0] == "
				echo "<td>$data</td>";
				echo "<td>$data</td>";
				echo "<td>$data</td>";*/
				}
                ?>
				<td> 0.00 </td>
		   </tr>
		   <tr bgcolor="#FFEDC7" class="text12Bold"> 
            <td>Total</td>
			<?php	
				$bmcodesql=mysql_query("SELECT subbmcode FROM bmcode");
				$bmcodesqlrow=mysql_num_rows($bmcodesql);
				for($count=0; $count<$bmcodesqlrow; $count++)
				{$data=mysql_result($bmcodesql,$count,"subbmcode");
				//echo "<td>$data</td>";
				echo "<td>0.00</td>";}
                ?>
            <td>0.00</td>
          </tr>
        </table>
	</td>
  </tr>
</table>
</body>
</html>
