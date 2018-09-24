<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$memlist = $_POST["memberlist"];
?>
<?php
$action=$_POST[main];
if($action=='exec') {
$maintenance=$_POST[maintenance];
//echo $action . "<br>";
//echo $maintenance . "<br>";

mysql_query("update adminid set maintenance='$maintenance' where adminid='$weblogin'"); 
if ($maintenance=='1')
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Turned ON System Maintenance!');</SCRIPT>";
if ($maintenance=='0')
echo "<SCRIPT language=\"JavaScript\">alert('Successfully Turned OFF System Maintenance!');</SCRIPT>";
}
?>
<html>
<head><title>System Maintenance</title><link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr>
	  <td align="center" colspan="3"><span class="maintitle">System Maintenance</span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
</table>
<div align="center">
<form action="<?php echo $PHP_SELF;?>" method="POST" name="form1" >
<input type="hidden" name="main" value="exec">
<select name="maintenance" onChange="document.form1.submit()">
           
              <?php	
			  	if ($_POST["maintenance"]=='1') {
				echo "<option value='1' selected='select'>ON</option>";
				echo "<option value='0'>OFF</option>"; }
				if ($_POST["maintenance"]=='0') {
				echo "<option value='0' selected='select'>OFF</option>";
				echo "<option value='1'>ON</option>";
				}
				
				if ($_POST["maintenance"]=='') {
					$maintain=mysql_query("SELECT maintenance FROM adminid where adminid='$weblogin'");
					$mode = mysql_fetch_array($maintain);
					if ($mode[0]=='0') {
					echo "<option value='0'>OFF</option>";
					echo "<option value='1'>ON</option>";
					}
					else {
					echo "<option value='1' >ON</option>";
					echo "<option value='0'>OFF</option>";
					}
				}
			  ?>
      </select>
</form>
</div>

</body>
</html>