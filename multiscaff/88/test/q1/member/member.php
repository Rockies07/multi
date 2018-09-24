<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM memberid WHERE memberid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
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
$(function(){
	$("ul#ticker01").liScroll();
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Member Page</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="css/li-scroller.css" rel="stylesheet" type="text/css">
</head>
<body>
<br />
<div align="center">
<ul id="ticker01">
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/cte/1705.popup.html',1000,600)">CTE AMK Ave.5</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/cte/1702.popup.html',1000,600)">CTE Bradell Flyover</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/cte/1703.popup.html',1000,600)">CTE St.George Road</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/cte/1701.popup.html
',1000,600)">CTE Moulmein Flyover</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/pie/5795.popup.html',1000,600)">PIE Eunos</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/pie/6706.popup.html',1000,600)">PIE BKE</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/pie/6708.popup.html',1000,600)">PIE JURONG</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/ecp/3795.popup.html',1000,600)">ECP East Coast</a></li>
	<li><span>Traffic Updates</span><a href="javascript: openScript('http://www.onemotoring.com.sg/publish/onemotoring/en/on_the_roads/traffic_cameras0/ecp/3798.popup.html',1000,600)">ECP B.Sheares Bridge</a></li>
</ul>
</div>
<br />

<table width="600" border="1" align="center" class="lister"><tr>
<?php
$linklist=mysql_query("SELECT * FROM linklist order by ref asc");
$linknum=mysql_num_rows($linklist);
	while ($row_linklist = mysql_fetch_array($linklist)) 
	{
		if ($colcount<3) {
		?>
		 <td><div align="center"><h3><div align="center"><font face="Arial, Helvetica, sans-serif"><?php echo $row_linklist[1]; ?></font></div></h3>
	<div align="center">
			<?php if ($row_linklist[6]<>"") { ?>
			<img border="0" src="../member/logo/<?php echo $row_linklist[6]; ?>" />
			<?php } else { ?>
			<img border="0" src="../member/logo/no-photo.jpg" />
			<?php } ?>
			</div>
			<div align="center"><font face="Arial, Helvetica, sans-serif"><a href="javascript: openScript('http://<?php echo $row_linklist[3]; ?>',1000,600)"><?php  echo $row_linklist[2]; ?></font></a></div>
			<div align="center"><font face="Arial, Helvetica, sans-serif"><a href="javascript: openScript('http://<?php echo $row_linklist[5]; ?>',1000,600)"><?php  echo $row_linklist[4]; ?></font></a></div>
			
	</div>
		</td>
		<?php
		$colcount++;
		}
		else { ?>
		<td><div align="center"><h3><div align="center"><font face="Arial, Helvetica, sans-serif"><?php echo $row_linklist[1]; ?></font></div></h3>
	<div align="center">
			<?php if ($row_linklist[6]<>"") { ?>
			<img border="0" src="../member/logo/<?php echo $row_linklist[6]; ?>" />
			<?php } else { ?>
			<img border="0" src="../member/logo/no-photo.jpg" />
			<?php } ?>
			</div>
			<div align="center"><font face="Arial, Helvetica, sans-serif"><a href="javascript: openScript('http://<?php echo $row_linklist[3]; ?>',1000,600)"><?php  echo $row_linklist[2]; ?></font></a></div>
			<div align="center"><font face="Arial, Helvetica, sans-serif"><a href="javascript: openScript('http://<?php echo $row_linklist[5]; ?>',1000,600)"><?php  echo $row_linklist[4]; ?></font></a></div>
		
		<?php
		echo "</tr><tr>";
		$colcount=0;
		}
		}
		?>
		
   </tr>
</table>
</body>
</html>
