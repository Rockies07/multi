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
    <link rel="stylesheet" href="style.css" type="text/css" />
		<SCRIPT language=javascript>
		var niH=14, niM=56, niS=45;
		var sClock;
		function show_clock(){
		  if(niS==59){niS=0;
    	  if(niM==59){niM=0;
      	  if(niH==23){niH=0;}
		  	else{niH=niH+1;}}
		  	else{niM=niM+1;}}
		  	else{niS=niS+1;}
  		  if(niH<=9){sClock='0'+niH+':';}else{sClock=niH+':';}
  		  if(niM<=9){sClock=sClock+'0'+niM+':';}else{sClock=sClock+niM+':';}
  		  if(niS<=9){sClock=sClock+'0'+niS;}else{sClock=sClock+niS;}
		  	document.getElementById("SvrClock").innerHTML = sClock;
  			setTimeout("show_clock()",1000)}
		</SCRIPT></head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload=show_clock()>
    <?php $datetime=date("D j F Y");?>
    <table bgcolor="#FFFFFF" border="0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" width="100%">
    <tr><td width="10%"><span class="bn13text">Welcome Admin</span></td><td align="center"><?php echo "<span class='bn13text'>Date : $datetime </span>";?><SPAN class="bn13text" id=SvrClock></SPAN></td><td width="10%"></td></tr>
    <tr><td colspan="3"><img src="images/line.jpg" width="100%" border="0"></td></tr>
    </table>
	</body>
</html>