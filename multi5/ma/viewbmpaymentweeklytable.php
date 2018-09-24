<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$_SESSION["link1"]="";
	$_SESSION["link2"]="";
?>
<?php

if ($_GET["year"]=="")
$year = date("Y");
else
$year = $_GET["year"];

$cpyaccount = $_GET["code"];

$datetime=date("Y-m-d");
$current_month=date("M") . "-" . date("Y");
$prev11 = date("M", strtotime("-1 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev10 = date("M", strtotime("-2 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev9 = date("M", strtotime("-3 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev8 = date("M", strtotime("-4 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev7 = date("M", strtotime("-5 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev6 = date("M", strtotime("-6 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev5 = date("M", strtotime("-7 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev4 = date("M", strtotime("-8 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev3 = date("M", strtotime("-9 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev2 = date("M", strtotime("-10 month")) . "-" . date("Y", strtotime("-1 month")); 
$prev1 = date("M", strtotime("-11 month")) . "-" . date("Y", strtotime("-1 month")); 
?>
<html>
<head><title>Main Announcement</title><link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/easydrag.js"></script>
<script src="js/jquery.easing.1.3.js" type="text/javascript" language="JavaScript"></script>
<script src="js/jquery.jBreadCrumb.1.1.js" type="text/javascript" language="JavaScript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function()
        {
            jQuery("#breadCrumb").jBreadCrumb();
        })
    </script>
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<br>
<p align="center"><span class="maintitle">View BM Payment Weekly <?php echo $year;?></span></p>
<table border="1" cellpadding="0" cellspacing="0" width="100%" align="center" class="stats">
<tr >
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Account</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b><b>Jan-<?php echo $year;?></b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Feb-<?php echo $year;?></b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Mar-<?php echo $year;?></b>&nbsp;</span></td>
     <td class="hed" ><span class="bn13text">&nbsp;<b>Apr-<?php echo $year;?></b>&nbsp;</span></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>May-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Jun-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Jul-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Aug-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Sep-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Oct-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Nov-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Dec-<?php echo $year;?></b>&nbsp;</span></td>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
</tr>
<?php
	$bmdata=array();
//	$bmsql=mysql_query("SELECT bmcode,subbmcode FROM bmcode");
	$bmsql=mysql_query("select year(bmdate) as year,month(bmdate) as month,week(bmdate) as week,FROM_DAYS(TO_DAYS(bmdate) -MOD(TO_DAYS(bmdate) -1, 7)) AS week_start, FROM_DAYS(TO_DAYS(bmdate + INTERVAL 6 DAY) -MOD(TO_DAYS(bmdate) -1, 7)) AS week_end, bmdate from bmdatabase_payment where year(bmdate)='$year' and week(bmdate)!='0' group by year(bmdate),week(bmdate) order by bmdate");
	
	$i=0;
	$j=1;
	
	while($data = mysql_fetch_assoc($bmsql)) 
	{	
		$bm_year=$data['year'];
		$bm_month=$data['month'];
		$bm_week=$data['week'];
		$bm_week_start=$data['week_start'];
		$get_week_start_month=date("n",strtotime($bm_week_start));
		$bm_week_end=$data['week_end'];
		$bmdate=$data['bmdate'];
		if($i==$get_week_start_month)
		{
			$j++;
		}
		else
		{
			$i++;
			$j=1;
		}
		$bmdata[$i][$j]['week_start']=$bm_week_start;
		$bmdata[$i][$j]['week_end']=$bm_week_end;
	}

	for($i=1; $i<=5; $i++)
	{
		if($count%2)
		{echo"<tr bgcolor='#CCCCCC'>";}
		else
		{echo"<tr>";}

		echo "<td align='center'><span class='bn13text'><b>Week $i</b></span></td>";

		for($j=1; $j<=12; $j++)
		{
			$x=$j-1;
			$week_start=$bmdata[$j][$i]['week_start'];
			$week_end=$bmdata[$j][$i]['week_end'];

			$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_payment where bmdate>='$week_start' and bmdate<='$week_end' and cpyaccount = '$cpyaccount'");

			$results=mysql_result($getvalues,0,"month_amount");
			$negtopos=0;
			$postoneg=0;
			
			$coltotal_payment[$x] = ($coltotal_payment[$x] + $results);
			$total_result = ($total_result + $results);
			if ($results<>0) {
				if ($results<=0) {
					$negtopos = number_format(abs($results),2);
					echo "<td align='center'><span class='bn13text'><a href='viewbmpaymentweekly_detail.php?code=$cpyaccount&start=$week_start&end=$week_end'>$negtopos</a></span></td>"; }
				else {
					$postoneg = number_format((0-$results),2);
					echo "<td align='center'><span class='bn13text'><a href='viewbmpaymentweekly_detail.php?code=$cpyaccount&start=$week_start&end=$week_end'><font color='red'>$postoneg</font></a></span></td>";
					
					}
				}
			else
				echo "<td align='center'><a href='viewbmpaymentweekly_detail.php?code=$cpyaccount&start=$week_start&end=$week_end'><span class='bn13text'>0.00</a></span></td>";
		}

		if ($total_result<=0) {
		$negtopos_total_result = number_format(abs($total_result),2);
		echo "<td align='center'><span class='bn13text'><b><font color='blue'>$negtopos_total_result</font></b></span></td>";
		}
		else
		{
		$postoneg_total_result = number_format((0-$total_result),2);
		echo "<td align='center'><span class='bn13text'><b><font color='red'>$postoneg_total_result</font></b></span></td>";
		}
	echo "</tr>";
	$ultra_result = ($ultra_result + $total_result);
	$total_result=0;
	}

	$negtopos_total=0;
	$postoneg_total=0;
	?>
	<tr >
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
<?php for ($jjj=0;$jjj<=11;$jjj++)  { ?>	
<?php if ($coltotal_payment[$jjj]<=0) { $negtopos_total = number_format(abs($coltotal_payment[$jjj]),2); ?>
  	  <td class="hed" ><span class="bn13text">&nbsp;<b><font color='blue'><?php echo $negtopos_total; ?></font></b>&nbsp;</span></td>
	  <?php } else { $postoneg_total = number_format((0-$coltotal_payment[$jjj]),2); ?>
	  <td class="hed" ><span class="bn13text">&nbsp;<b><font color="red"><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
	  <?php } ?>
 <?php } ?>
 	<?php if ($ultra_result<=0) { $negtopos_total = number_format(abs($ultra_result),2); ?>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><font color='blue'><?php echo $negtopos_total; ?></font></b>&nbsp;</span></td>
	<?php } else { $postoneg_total = number_format((0-$ultra_result),2); ?>
	<td class="hed"  ><span class="bn13text">&nbsp;<b><font color="red"><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
	<?php } ?>
</tr>
</table>



</body>
</html>