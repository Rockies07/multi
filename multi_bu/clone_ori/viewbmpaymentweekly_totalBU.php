<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

	function getStartAndEndDate($week, $year) {
	  	$time = strtotime("1 January $year", time());
	    $day = date('w', $time);
	    $time += ((7*$week)+1-$day)*24*3600;
	    $return[0] = date('Y-n-j', $time);
	    $time += 6*24*3600;
	    $return[1] = date('Y-n-j', $time);
	    return $return;
	}

	$week_start=$_GET["start"];
	$week_end=$_GET["end"];
	$week_count=$_GET["week"];
?>
<html>
<head><title>Main Announcement</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="css/BreadCrumb.css" type="text/css">
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/easydrag.js"></script>

<style type="text/css">#FloaintBox{ border:1px solid red; background-color:#eef4d3;}#FloaintBox{width:150px; padding:10px;}</style>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->
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
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle">View BM Payment Weekly (<?php echo date('d M Y',strtotime($week_start))." - ".date('d M Y',strtotime($week_end));?>)</span></td>
	</tr>
   </table>
   <div id="breadCrumb" class="breadCrumb module">
                    <ul>
                        <li>
                            <a href="viewbmyear.php" style="text-decoration:none; color:#FFFFFF;"><b>Home</b></a>
                        </li>
                     	 <li>
                            <b>View BM Payment Weekly</b>
                        </li>
                    </ul>
</div><br><br><br>
   <div align="center">
   <form action='<?php echo $PHP_SELF;?>' method='POST' name='listing' >
  
<table border="1" cellpadding="0" cellspacing="0" width="70%" align="center" class="stats">
<?php
	$bmsql=mysql_query("select cpyaccount from cpyaccount");
	$bmrow=mysql_num_rows($bmsql);
?>
<tr>
	<td class="hed" width="200px"><span class="bn13text">&nbsp;<b>&nbsp;</b>&nbsp;</span></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Account</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
</tr>
<?php
//-=-=-= link1
if ($_SESSION["link1"]=="")
$_SESSION["link1"] = "viewbmyear.php";
//echo $_SESSION["link1"];
//-=-=-= link1
if (strlen($month)==1)
$month = "0" . $month;
	$enum_from = $year . "-" . $month . "-" . "01";
	$enum_to = $year . "-" . $month . "-" . "31";
	
while ($row_bmsql = mysql_fetch_assoc($bmsql)) 
	{
$count++;
if ($count%2)
	{echo"<tr>";}
	else
{echo"<tr bgcolor='#CCCCCC'>";}
if ($count==1)
echo "<td align='center' rowspan='$bmrow'><span class='bn13text'><b>Week $week_count<br>(".date('d M Y',strtotime($week_start))." - ".date('d M Y',strtotime($week_end)).")</b></span></td>";

$cpyaccount=$row_bmsql['cpyaccount'];
echo "<td align='center'><span class='bn13text'><b>$cpyaccount</b></span></td>";

	$getvalues=mysql_query("select sum(amount) as month_amount from bmdatabase_payment where bmdate between '$week_start' and '$week_end' and cpyaccount='$cpyaccount'");

while ($row_getvalues = mysql_fetch_array($getvalues)) 
	{
		
	if ($row_getvalues[0]=="")
		echo "<td align='center'><span class='bn13text'><b>0.00</b></span></td>";
	else {
		if ($row_getvalues[0]<=0) { $negtopos_total = number_format(abs($row_getvalues[0]),2);
		echo "<td align='center'><a href='viewbmpaymentweekly_detail.php?code=$cpyaccount&start=$week_start&end=$week_end'><span class='bn13text'><b><font color='blue'>$negtopos_total</</b></span></td>";
		} else { $postoneg_total = number_format((0-$row_getvalues[0]),2);
		echo "<td align='center'><a href='viewbmpaymentweekly_detail.php?code=$cpyaccount&start=$week_start&end=$week_end'><span class='bn13text'><b><font color='red'>$postoneg_total</font></b></span></td>";
		}
		}
		$super_total = $super_total + $row_getvalues[0];
	}
}
	?>
	<tr>
	<td class="hed"  ></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
	<?php if ($super_total<=0) { $negtopos_total = number_format(abs($super_total),2); ?>
    <td class="hed" ><span class="bn13text">&nbsp;<b><font color='blue'><?php echo $negtopos_total; ?></font></b>&nbsp;</span></td>
    <?php } else { $postoneg_total = number_format((0-$super_total),2); ?>
	<td class="hed" ><span class="bn13text">&nbsp;<b><font color='red'><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
	<?php } ?>
</tr>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>