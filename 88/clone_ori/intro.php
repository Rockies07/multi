<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM clone_user WHERE username='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

	$notes=htmlspecialchars($_POST['notes']);
	if(isset($_POST['submit']))
	{
		mysql_query("Update notes set notes='$notes'");
	}

	$sql_get_notes=mysql_query("Select * from notes");
	$get_notes=mysql_result($sql_get_notes,0, "notes")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jqueryscroll.js"></script>
<script type="text/javascript">
function openScript(url, width, height){
 var Win = window.open(url,"_blank",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}

</script>

<style>
.buttonYellow {
	-moz-box-shadow: inset 0px 0px 0px 0px #fff6af;
	-webkit-box-shadow: inset 0px 0px 0px 0px #fff6af;
	box-shadow: inset 0px 0px 0px 0px #fff6af;
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ffec64
		), color-stop(1, #ffab23));
	background: -moz-linear-gradient(center top, #ffec64 5%, #ffab23 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffec64',
		endColorstr='#ffab23');
	background-color: #ffec64;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	border-radius: 6px;
	border: 1px solid #ffaa22;
	display: inline-block;
	color: #333333;
	font-weight: bold;
	padding: 4px 22px;
	text-decoration: none;
	text-shadow: 1px 1px 0px #ffee66;
}

.buttonYellow:hover {
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ffab23
		), color-stop(1, #ffec64));
	background: -moz-linear-gradient(center top, #ffab23 5%, #ffec64 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffab23',
		endColorstr='#ffec64');
	background-color: #ffab23;
	cursor: pointer;
}

.buttonYellow:active {
	position: relative;
	top: 1px;
}

.buttonYellow a{
	color: #333333;
	text-decoration: none;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Member Page</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="css/li-scroller.css" rel="stylesheet" type="text/css">
</head>
<body>
<br />

<div align="center">
<form action="intro.php" method="POST">
	<textarea name="notes" style="width:100%; height: 700px"><?php echo $get_notes;?></textarea>

	<input type="submit" name="submit" value="Save" class="buttonYellow">

</form>
</div>

</body>
</html>
