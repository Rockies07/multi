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
<html>
<head><title>Member Summary</title><link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript">
function openScript(url, width, height){
 var Win = window.open(url,"_blank",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}
</script>
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
	<tr>
	  <td align="center" colspan="3"><span class="maintitle">Member <b><?php echo $memlist; ?></b> History Stamement</span></td>
	</tr>
    <style>table.outline { border: 1px outset #FFAA00; }</style>
</table>
<div align="center">
<form action="<?php echo $PHP_SELF;?>" method="POST" name="form1" >
<select name="memberlist" onChange="document.form1.submit()">
              <?php	
			  if ($memlist<>"") {
			  $myname=mysql_query("SELECT membername FROM memberid where memberid='$memlist'");
			  $namenya = mysql_fetch_array($myname);
			  	echo "<option value='$memlist'>$memlist - $namenya[0]</option>";
				}
			  $memberlist=mysql_query("SELECT memberid,membername FROM memberid order by memberid asc");
				while ($row_mem = mysql_fetch_array($memberlist)) 
				{ 
				echo "<option value='$row_mem[0]'>$row_mem[0] - $row_mem[1]</option>";
				}
			  ?>
      </select>
</form>
</div>

<table border="1" cellpadding="0" cellspacing="0" width="95%" align="center" class="stats">
<tr >
    <td class="hed" width="13%" ><span class="bn13text"><b>No</b></span></td>
	<td class="hed" width="13%" ><span class="bn13text"><b>Year</b></span></td>
	<td class="hed" width="13%" ><span class="bn13text"><b>Member ID</b></span></td>
	<td class="hed" width="13%" ><span class="bn13text"><b>Amount</b></span></td>
	<td class="hed" width="13%" ><span class="bn13text"><b>Action</b></span></td>
	</tr>
    <?php 
	//$yearlist=mysql_query("select ref,substr(bmdate,1,4),memberid,sum(amount) from member_history where memberid='$memlist' group by substr(bmdate,1,4),memberid");
	//$yearlist=mysql_query("select '1',substr(bmdate,1,4),memberid,sum(amount) from backup_plan where memberid='$memlist' group by substr(bmdate,1,4),memberid");
	$yearlist=mysql_query("select substr(bmdate,1,4),memberid,sum(amount) from backup_plan where memberid='$memlist' group by substr(bmdate,1,4),memberid");
	
//	echo "select ref,substr(bmdate,1,4),memberid,sum(amount) from member_history where memberid='$memlist' group by substr(bmdate,1,4),memberid" . "<br>";
	while ($row_year = mysql_fetch_array($yearlist)) 
	{ 
	$ctr++;
	?>
	<tr >
	<td align="center"><span class="bn13text"><b><?php echo $ctr;?></b></span></td>
	<td align="center"><span class="bn13text"><b><?php echo $row_year[0];?></b></span></td>
	
	<td align="center"><span class="bn13text"><b><a href="javascript: openScript('history_details.php?memberid=<?php echo $memlist; ?>&year=<?php echo $row_year[0]; ?>',1000,600)" target='_self'><?php echo $row_year[1];?></a></b></span></td>
	<td align="center"><span class="bn13text"><b><?php echo $row_year[2];?></b></span></td>
	<td align="center"><span class="bn13text"><b><a href="javascript: openScript('history_details.php?memberid=<?php echo $memlist; ?>&year=<?php echo $row_year[1]; ?>',1000,600)" target='_self'><?php echo "View";?></a>	</b></span></td>
	</tr>
	<?php
	$memtot = $memtot + $row_year[2];
	 }	?>	
<tr >
	<td align="center" colspan="3"><span class="bn13text"><b>Member History Total</b></span></td>
	<td align="center"><span class="bn13text"><b><?php echo number_format($memtot,2);?></b></span></td>
	<td align="center"><span class="bn13text"><b><?php //echo "-";?></b></span></td>
	</tr>
</table>
</body>
</html>