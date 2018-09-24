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
<script type="text/javascript">
function openScript(url, width, height){
 var Win = window.open(url,"_blank",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Member Page</title>
<style type="text/css">
   /* <![CDATA[ */
     .roundabout-holder { padding: 100; height: 500px; width:700px; text-decoration:none; left:200px; }
   .roundabout-moveable-item { 
      height: 20em; 
      width: 15em; 
      cursor: pointer;
      background-color: #EFEFEF;
     border: 1px solid #999;
	   list-style: none;
   }
   .roundabout-in-focus { cursor: auto; }
   /* ]]> */
   
   
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.roundabout.js"></script>
<script type="text/javascript">
   // <![CDATA[
   $(document).ready(function() {
      $('ul#myRoundabout').roundabout();
   });
   // ]]>
</script>
</head>

<body>

<ul id="myRoundabout">
<?php
$linklist=mysql_query("SELECT * FROM linklist");
$linknum=mysql_num_rows($linklist);
	while ($row_linklist = mysql_fetch_array($linklist)) 
	{
		?>
			<li style="list-style: none;"><h2><div align="center"><font face="Arial, Helvetica, sans-serif"><?php echo $row_linklist[1]; ?></font></div></h2>
			<div align="center">
			<?php if ($row_linklist[6]<>"") { ?>
			<img border="0" src="logo/<?php echo $row_linklist[6]; ?>" />
			<?php } else { ?>
			<img border="0" src="logo/no-photo.jpg" />
			<?php } ?>
			
			</div>
			<div align="center"><font face="Arial, Helvetica, sans-serif"><a href="javascript: openScript('http://<?php echo $row_linklist[3]; ?>',1000,600)"><?php  echo $row_linklist[2]; ?></font></a></div>
			<div align="center"><font face="Arial, Helvetica, sans-serif"><a href="javascript: openScript('http://<?php echo $row_linklist[5]; ?>',1000,600)"><?php  echo $row_linklist[4]; ?></font></a></div>
			</li>
		<?php
	}
	if ($linknum==2) { ?>
	<li style="list-style: none;"><b><?php echo "Welcome: " . $weblogin; ?></b></li>
	<?php } ?>
</ul>
</body>
</html>
