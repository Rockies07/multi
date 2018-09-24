<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Main Menu</title>
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
		<p class="menu_head">Member Report</a></p>
		<div class="menu_body">
		<a href="viewallmember.php?reset=1" target='main'>Member Report</a>
		<a href="viewallmemberb.php?reset=1" target='main'>Member Report (Beta Version)</a>
        <!-- <a href="payment.php" target='main'>Payment</a>
         <a href="internaltransfer.php" target='main'>Internal Transfer</a>
		 <a href="expenses.php" target='main'>Expenses</a>-->
		 	
		</div>
		<p class="menu_head">User Management</p>
		<div class="menu_body">
			<a href="viewmanager.php" target='main'>View Manager</a>
         <a href="viewmember.php" target='main'>View Member</a>
         <a href="viewsubmember.php" target='main'> View Member Sub ID</a>	
		</div>
		<p class="menu_head">Administration</p>
		<div class="menu_body">
          <a href="viewaccount.php" target='main'>View Account</a>
         <a href="viewbookmakertype.php" target='main'>View BM Code</a>
		  <a href="viewinvestmenttype.php" target='main'>View IM Code</a>
         <a href="viewranking.php" target='main'>View Ranking</a>
		 <a href="viewcurrency.php" target='main'">View Currency</a>			
       </div>
	   <p class="menu_head">Reports</p>
		<div class="menu_body">
          <a href="viewbmyear.php" target='main'>View BM Yearly</a>
		  <a href="viewexpyear.php" target='main'>Yearly Expenses</a>
		  <a href="member_summary.php" target='main'>Member Summary</a>
		   <a href="member_history.php" target='main'>Member History</a>
        </div>
		<p class="menu_head">Settings</p>
		<div class="menu_body">
		<a href="revertrecords.php" target='main'>Revert Records</a>
		
	 	<a href="clear_records.php" target='main'>Clear Records</a>
         <a href="changepassword.php" target='main'>Change Password</a>
         <a href="announcement.php" target='main'>Announcement</a>
		 <a href="addlinks.php" target='main'>Link Management</a>
		 <a href="member_reset_manual.php" target='main'>Reset Report<br>(Beta Version)</a>
         <a href="maintenance.php" target='main'>System<br>Maintenance</a>
       </div>
	   <p class="menu_head"><a href="logout.php" target='_top' style="text-decoration:none;">Logout</a></p>
  </div>  <!--Code for menu ends here-->
</div>

</body>
</html>
