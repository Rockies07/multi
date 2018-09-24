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
	$week=$_GET["week"];
	$month=$_GET["month"];
	$year=$_GET["year"];
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
	  <td align="center"><span class="maintitle"> View BM by Date </span></td>
	</tr>
</table>
<div id="breadCrumb" class="breadCrumb module">
                    <ul>
                        <li>
                            <a href="viewbmyear.php" style="text-decoration:none; color:#FFFFFF;"><b>Home</b></a>
                        </li>
                     	 <li>
                            <a href="<?php echo $_SESSION["link1"]; ?>" style="text-decoration:none; color:#FFFFFF;"><b>View BM Monthly</b></a>
                        </li>
							 <li>
                            <b>View BM By Date</b>
                        </li>
                    </ul>
</div><br><br><br>
   <table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
	<tr >
		<td class="hed"  ><span class="bn13text">&nbsp;<b>Date</b></span></td>
	    <td class="hed"  ><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
	</tr><tr>
	    <?php

		$week_array = getStartAndEndDate($week,$year);
		$week_start=date("Y-m-d", strtotime($week_array[0]));
		$week_end=date("Y-m-d", strtotime($week_array[1]));

		$sql_get_detail=mysql_query("select bmdate,sum(amount) as daily_amount from bmdatabase_payment where week(bmdate)='$week' and month(bmdate)='$month' and year(bmdate)='$year' and cpyaccount='$cpyaccount' group by bmdate");
	$super_total=0;
	while($data=mysql_fetch_array($sql_get_detail)) 
	{
		$date=date('d M Y', strtotime($data['bmdate']));
		$date_format=date('Y-m-d', strtotime($data['bmdate']));
		$results = $data['daily_amount'];

		if ($results<>0 && $results<>"0" && $results<>" ") {
		echo "<tr>";
		echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$date</b></span></td>";
			if ($results<0) { $negtopos_total = number_format(abs($results),2);
			echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a href='viewbmpaymentdaily_detail.php?code=$cpyaccount&date=$date_format'><font color='blue'>$negtopos_total</font></a></b></span></td>";
			} else { $postoneg_total = number_format((0-$results),2);
			echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a href='viewbmpaymentdaily_detail.php?code=$cpyaccount&date=$date_format'><font color='red'>$postoneg_total</font></a></b></span></td>";
			}
		echo "</tr>"; }

		$super_total = $super_total + $results;
	}

		?>
		<tr>
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