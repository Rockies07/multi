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

	$cpyaccount=$_GET["code"];
	$date=$_GET["date"];
	$date_str=date('d M Y', strtotime($date));
if ($_SESSION["link2"]=="")
$_SESSION["link2"] = "viewbmpaymentdaily.php?code=$cpyaccount&week=$week&month=$month&year=$year";

/*$fulldet1 = $year . "-" . $month . "-" . "01";
$fulldet2 = $year . "-" . $month . "-" . $vilang;*/
if ($action=="save")
{
	$update_amount = "update bmdatabase_payment set  amount='$eamount' where memberid = '$memberid' and ref = '$getref'";
	mysql_query($update_amount);
	echo "<script>alert('Successfully Updated Amount.')</script>";
}
?>
<html>
<head><title>Main Announcement</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="css/BreadCrumb.css" type="text/css">
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
<style type="text/css">#FloaintBox{ border:1px solid red; background-color:#eef4d3;}#FloaintBox{width:150px; padding:10px;}</style>
</head>
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" >
<table border="0" cellpadding="0" cellspacing="0" width="50%" align="center">
	<tr>
	  <td align="center"><span class="maintitle"> View BM Payment Daily (<?php echo $date_str;?>) </span></td>
	</tr>
</table>
	<br>
   <table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
	<tr >
		<td class="hed"  ><span class="bn13text">&nbsp;<b>Member</b></span></td>
		<td class="hed"  ><span class="bn13text">&nbsp;<b>Currency</b></span></td>
	    <td class="hed"  ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
		<td class="hed" ><span class="bn13text">&nbsp;<b>Remarks</b>&nbsp;</span></td>
	</tr><tr>
	    <?php

		$week_array = getStartAndEndDate($week,$year);
		$week_start=date("Y-m-d", strtotime($week_array[0]));
		$week_end=date("Y-m-d", strtotime($week_array[1]));

		$sql_get_detail=mysql_query("select * from bmdatabase_payment where bmdate='$date' and cpyaccount='$cpyaccount' order by ref");
	$super_total=0;
	while($data=mysql_fetch_array($sql_get_detail)) 
	{
		$date=date('d M Y', strtotime($data['bmdate']));
		$results = $data['amount'];
		$memberid = $data['memberid'];
		$remark = $data['remark'];
		$curcode = $data['currencycode'];

		if ($results<>0 && $results<>"0" && $results<>" ") {
		echo "<tr>";
		echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$memberid</b></span></td>";
		echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$curcode</b></span></td>";
			if ($results<0) { $negtopos_total = number_format(abs($results),2);
			echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><font color='blue'>$negtopos_total</font></b></span></td>";
			} else { $postoneg_total = number_format((0-$results),2);
			echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><font color='red'>$postoneg_total</font></b></span></td>";
			}
		echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$remark</b></span></td>";
		echo "</tr>"; }

		$super_total = $super_total + $results;
	}

		?>
		<tr>
		    <td class="hed"  colspan="2"><span class="bn13text">&nbsp;<b>Grand Total</b>&nbsp;</span></td>
			<?php if ($super_total<=0) { $negtopos_total = number_format(abs($super_total),2); ?>
		    <td class="hed" ><span class="bn13text">&nbsp;<b><font color='blue'><?php echo $negtopos_total; ?></font></b>&nbsp;</span></td>
		    <?php } else { $postoneg_total = number_format((0-$super_total),2); ?>
			<td class="hed" ><span class="bn13text">&nbsp;<b><font color='red'><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
		<?php } ?>
			<td class="hed">&nbsp;</td>
		</tr>
	</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>