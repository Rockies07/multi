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
	<head><title>Master Account</title>
    <link rel="stylesheet" href="style.css" type="text/css" /></head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
	<?php
	$dataentry=$_GET['dataentry'];
	$usermanagement=$_GET['usermanagement'];
	$administration=$_GET['administration'];
	$reports=$_GET['reports'];
	$approval=$_GET['approval'];
	$settings=$_GET['settings'];
	echo "<tr height='10'><td colspan='2'></td></tr>";
	if($dataentry){echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&reports=$reports&administration=$administration&usermanagement=$usermanagement' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Data Entry</b></span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='wlplaceout.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;W/L Placeout</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='payment.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Payment</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='internaltransfer.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Internal Transfer</span></a></td></tr>";	
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='expenses.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Expenses</span></a></td></tr>";	
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='investmententry.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Investment Entry</span></a></td></tr>";
/*	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenu.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='memberreport.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Member Report</span></a></td></tr>";*/
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenu.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewallmember.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Member Report</span></a></td></tr>";
	}
	else{echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&reports=$reports&administration=$administration&usermanagement=$usermanagement&dataentry=1' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Data Entry</b></span></a></td></tr>";}
	echo "<tr height='5'><td colspan='2'></td></tr>";
	if($usermanagement){echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&reports=$reports&administration=$administration&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>User Management</b></span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewmanager.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View Manager</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewmember.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View Member</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenu.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewsubmember.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View Member Sub ID</span></a></td></tr>";
	}
	else{echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&reports=$reports&administration=$administration&usermanagement=1&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>User Management</b></span></a></td></tr>";}
	echo "<tr height='5'><td colspan='2'></td></tr>";
	if($administration){echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&reports=$reports&usermanagement=$usermanagement&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Administration</b></span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewaccount.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View Account</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewbookmakertype.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View BM Type</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewinvestmenttype.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View IM Type</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenu.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewcurrency.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View Currency</span></a></td></tr>";
	}
	else{echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&reports=$reports&administration=1&usermanagement=$usermanagement&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Administration</b></span></a></td></tr>";}
	echo "<tr height='5'><td colspan='2'></td></tr>";
	if($reports){echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&administration=$administration&usermanagement=$usermanagement&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Reports</b></span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewbmweekly.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View BM Weekly</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewbmmonthly.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View BM Monthly</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenu.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='viewimmonthly.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;View IM Monthly</span></a></td></tr>";
	}
	else{echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=$approval&reports=1&administration=$administration&usermanagement=$usermanagement&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Reports</b></span></a></td></tr>";}
	echo "<tr height='5'><td colspan='2'></td></tr>";
	if($approval){echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&reports=$reports&administration=$administration&usermanagement=$usermanagement&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Approval</b></span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='expenses.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Expenses</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenu.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='investment.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Investment</span></a></td></tr>";
	}
	else{echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?settings=$settings&approval=1&reports=$reports&administration=$administration&usermanagement=$usermanagement&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Approval</b></span></a></td></tr>";}
	echo "<tr height='5'><td colspan='2'></td></tr>";
	if($settings){echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?approval=$approval&reports=$reports&administration=$administration&usermanagement=$usermanagement&dataentry=$dataentry' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Settings</b></span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='changepassword.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Change Password</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenujoin.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='announcement.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Announcement</span></a></td></tr>";
	echo "<tr><td bgcolor='#aaaaaa' align='right'><img src='images/submenu.jpg' border='0'></td><td bgcolor='#aaaaaa' align='left'><a href='backup.php' target='main' STYLE='text-decoration: none'><span class='bn12text'>&nbsp;&nbsp;Backup</span></a></td></tr>";
	}
	else{echo "<tr><td width='15' background='images/menubg.jpg'></td><td background='images/menubg.jpg' align='left'><a href='navigation.php?approval=$approval&reports=$reports&administration=$administration&usermanagement=$usermanagement&dataentry=$dataentry&settings=1' target='_self' STYLE='text-decoration: none'><span class='bn13text'><b>Settings</b></span></a></td></tr>";}
	echo "<tr height='5'><td colspan='2'></td></tr>";
	echo "<tr><td width='20' background='images/menubg.jpg'><img src='images/leftmenu.jpg' border='0'></td><td background='images/menubg.jpg' align='left'><a href='logout.php' target='_top' STYLE='text-decoration: none'><span class='bn13text'><b>Logout</b></span></a></td></tr>";
	?>
    </table>
    </body>
</html>