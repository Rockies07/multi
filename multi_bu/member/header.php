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
	<head><title>Manager Account</title>
    <link rel="stylesheet" href="../ma/style.css" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#SvrClock').html('--:--:--');
}, 300000); // refresh every xxx milliseconds
</script>
<body onLoad="show_clock();">

</body>
<!--<span id="SvrClock" style="width:100px;"></span>--></td>
      </tr>
    </table>
<script language="javascript">
var niH=<?php echo date('H'); ?>, niM=<?php echo date('i') ?>, niS=<?php echo date('s') ?>;
var sClock;
function show_clock(){
  if(niS==59){
    niS=0;
    if(niM==59){
      niM=0;
      if(niH==23){
        niH=0;
      }else{
        niH=niH+1;
      }
    }else{
      niM=niM+1;
    }
  }else{
    niS=niS+1;
  }
  if(niH<=9){sClock='0'+niH+':';}else{sClock=niH+':';}
  if(niM<=9){sClock=sClock+'0'+niM+':';}else{sClock=sClock+niM+':';}
  if(niS<=9){sClock=sClock+'0'+niS;}else{sClock=sClock+niS;}
  document.getElementById("SvrClock").innerHTML = sClock;
  setTimeout("show_clock()",1000);
//  alert(sClock);
  var d=new Date();
	var weekday=new Array(7);
	weekday[0]="Sunday";
	weekday[1]="Monday";
	weekday[2]="Tuesday";
	weekday[3]="Wednesday";
	weekday[4]="Thursday";
	weekday[5]="Friday";
	weekday[6]="Saturday";

}
</script></head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload=show_clock()>
    <?php $datetime=date("D j F Y");?>
    <table border="0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" width="100%">
    <tr><td width="10%"><span class="bn13textwhite">Welcome <b><?php echo $weblogin; ?></b></span></td><td align="center"><?php echo "<span class='bn13textwhite'>Date : $datetime </span>";?><SPAN class="bn13textwhite"><div id="SvrClock" style="width:100px;"></div></SPAN></td><td width="10%"></td></tr>
    <tr><td colspan="3"><img src="../ma/images/line.jpg" width="100%" border="0"></td></tr>
    </table>
	</body>

</html>