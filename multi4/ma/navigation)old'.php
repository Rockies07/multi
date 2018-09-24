<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
//	$login=mysql_query("SELECT * FROM adminid WHERE adminid='$weblogin' and password='$webpassword'");
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
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
<!--//---------------------------------+
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// --------------------------------->
$(document).ready(function()
{
	//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
	$("#firstpane p.menu_head").click(function()
    {
		$(this).css({backgroundImage:"url(down.png)"}).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
       	$(this).siblings().css({backgroundImage:"url(left.png)"});
	});
	//slides the element with class "menu_body" when mouse is over the paragraph
	$("#secondpane p.menu_head").mouseover(function()
    {
	     $(this).css({backgroundImage:"url(down.png)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
         $(this).siblings().css({backgroundImage:"url(left.png)"});
	});
});
</script>
<style type="text/css">
body {
	margin: 10px auto;
	font: 75%/200% Verdana,Arial, Helvetica, sans-serif;
}
.menu_list {	
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
<body>
<div style="float:left" > <!--This is the first division of left-->
  <div id="firstpane" class="menu_list"> <!--Code for menu starts here-->
		<p class="menu_head">Data Entry</p>
		<div class="menu_body">
		<a href="wlplaceout.php" target='main'>W/L Placeout</a>
         <a href="payment.php" target='main'>Payment</a>
         <a href="internaltransfer.php" target='main'>Internal Transfer</a>	
		 <a href="expenses.php" target='main'>Expenses</a>	
		 <a href="viewallmember.php" target='main'>Member Report</a>	
		</div>
		<p class="menu_head">User Management</p>
		<div class="menu_body">
			<!--<a href="viewmanager.php" target='main'>View Manager</a>-->
         <a href="viewmember.php" target='main'>View Member</a>
         <a href="viewsubmember.php" target='main'> View Member Sub ID</a>	
		</div>
		<p class="menu_head">Accounts</p>
		<div class="menu_body">
          <a href="viewaccount.php" target='main'>View Account</a>
       </div>
	<!--	<p class="menu_head">Administration</p>
		<div class="menu_body">
          <a href="viewaccount.php" target='main'>View Account</a>
         <a href="viewbookmakertype.php" target='main'>View BM Code</a>
         <a href="viewranking.php" target='main'>View Ranking</a>
		 <a href="viewcurrency.php target='main'">View Currency</a>			
       </div>-->
	   <p class="menu_head">Reports</p>
		<div class="menu_body">
          <a href="viewbmyear.php" target='main'>View BM Yearly</a>
        </div>
		<p class="menu_head">Settings</p>
		<div class="menu_body">
         <a href="changepassword.php" target='main'>Change Password</a>
         <a href="announcement.php" target='main'>Announcement</a>
       </div>
	   <p class="menu_head"><a href="logout.php" target='_top' style="text-decoration:none;">Logout</a></p>
  </div>  <!--Code for menu ends here-->
</div>

</body>
</html>
