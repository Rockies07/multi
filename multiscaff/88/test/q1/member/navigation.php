<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
//	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Accordion Menu Using jQuery</title>
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".menu_body").hide();
	//toggle the componenet with class msg_body
	$(".menu_head").click(function(){
		$(this).next(".menu_body").slideToggle(300);
	});
});
</script>
<style type="text/css">
body {
	margin: 10px auto;

	font: 75%/120% Verdana,Arial, Helvetica, sans-serif;
}
p {
	padding: 0 0 1em;
}
.menu_list {
	margin: 0px;
	padding: 0px;
	width: 150px;
}
.menu_head {
	padding: 10px 10px;
	cursor: pointer;
	position: relative;
	margin:1px;
    font-weight:bold;
    background: #eef4d3 url(left.png) center right no-repeat;
}
.menu_body {
	display:none;
}
.menu_body a{
  display:block;
  color:#006699;
  background-color:#EFEFEF;
  padding-top:2.5px;
  padding-bottom:2.5px;
  padding-left:10px;
  font-weight:bold;
  text-decoration:none;
}
.menu_body a:hover{
  color: #000000;
  text-decoration:underline;
  }
</style>
</head>
<body bgcolor="#000000">
<div style="float:left" > <!--This is the first division of left-->
  <div id="firstpane" class="menu_list"> <!--Code for menu starts here-->
  		<p class="menu_head"><a href="member.php" target='main' style="text-decoration:none;">Home</a></p>
		<p class="menu_head"><a href="viewmemberdetails.php?memberid=<?php echo $weblogin;?>" target='main' style="text-decoration:none;">Report</a></p>
		<p class="menu_head"><a href="changepassword.php" target='main' style="text-decoration:none;">Change Password</a></p>
	   <p class="menu_head"><a href="logout.php" target='_top' style="text-decoration:none;">Logout</a></p>
  </div>  <!--Code for menu ends here-->
</div>

</body>
</html>
