<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$filter_query="";

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
	$year=$_GET["year"];
	$filtered=0;

	if($week_start=="")
	{
		$week_start=$_POST["week_start"];
		$week_end=$_POST["week_end"];
		$filter_acc=$_POST["filter_acc"];
		$filter_rank=$_POST["filter_rank"];
		$filter_member=$_POST["filter_member"];
	}

	if($filter_member!="")
	{
		$filter_query=" and bp.memberid like '%$filter_member%' ";
		$filtered=1;
	}

	if($filter_rank!="")
	{
		$filter_query=$filter_query." and m.ranking ='$filter_rank' ";
		$filtered=1;
	}

	if($filter_acc!="")
	{
		$filter_query=$filter_query." and bp.cpyaccount ='$filter_acc' ";
		$filtered=1;
	}

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
	  <td align="center"><span class="maintitle"> View BM Payment Weekly (<?php echo date('d M Y',strtotime($week_start))." - ".date('d M Y',strtotime($week_end));?>) </span></td>
	</tr>
</table>
	<br>
	<form name="sorttools" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	   <table border="0" cellpadding="0" cellspacing="0" width="50%" align="center" style="background:#eef4d3; height: 35px;">
	   		<tr>
	   			<td align="center" width="100%">
	   				<select name="filter_acc">
	   					<?php
		   					$account_sql=mysql_query("SELECT cpyaccount from cpyaccount order by cpyaccount asc");
		   					if($filter_acc!="")
		   					{
		   						echo "<option value='$filter_acc' selected>$filter_acc</option>";
		   					}	
		   					echo "<option value=''>All</option>";
							while ($row_acc = mysql_fetch_array($account_sql)) 
							{
								echo "<option value='$row_acc[0]'>$row_acc[0]</option>";
							}
						?>
	   				</select>
	   				<select name="filter_rank">
	   					<?php
		   					$rankno=mysql_query("SELECT no,name FROM ranking order by no asc");
		   					if($filter_rank!="")
		   					{
		   						$sql_rank_text=mysql_query("SELECT no,name FROM ranking where no='$filter_rank'");
		   						$get_rank_text=mysql_result($sql_rank_text,0, 'name');
		   						echo "<option value='$filter_rank' selected>$get_rank_text-$filter_rank</option>";
		   					}	
		   					echo "<option value=''>All</option>";
							while ($row_rankno = mysql_fetch_array($rankno)) 
							{
								echo "<option value='$row_rankno[0]'>$row_rankno[1]-$row_rankno[0]</option>";
							}
						?>
	   				</select>
	   				<input type="text" name="filter_member" value="<?php echo $filter_member;?>" placeholder="Member ID">
	   				<input type="hidden" name="week_start" id="week_start" value="<?php echo $week_start;?>">
	   				<input type="hidden" name="week_end" value="<?php echo $week_end;?>">
	   				<input name="search" value="Search" type="submit">
	   			</td>
	   			<td align="right">
	   				<a href=# onclick="back_page()" class="bn13text" style="color:blue">Back</a>&nbsp;&nbsp;&nbsp;
	   			</td>
	   		</tr>
	   	</table>
   	</form>
   	<br>
   <table border="1" cellpadding="0" cellspacing="0" width="50%" align="center" class="stats">
	<tr >
		<td class="hed"  ><span class="bn13text">&nbsp;<b>Date</b></span></td>
		<td class="hed"  ><span class="bn13text">&nbsp;<b>Account</b></span></td>
		<td class="hed"  ><span class="bn13text">&nbsp;<b>Member</b></span></td>
		<td class="hed"  ><span class="bn13text">&nbsp;<b>Currency</b></span></td>
	    <td class="hed"  ><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
		<td class="hed" ><span class="bn13text">&nbsp;<b>Remarks</b>&nbsp;</span></td>
	</tr><tr>
	    <?php
	    
	    $sql_get_detail=mysql_query("select bp.ref,bp.bmdate,bp.cpyaccount,bp.amount,bp.memberid,bp.currencycode,bp.remark from bmdatabase_payment bp,memberid m where bp.bmdate between '$week_start' and '$week_end' and m.memberid=bp.memberid $filter_query UNION select bp.ref,bp.bmdate,bp.cpyaccount,bp.amount,bp.memberid,bp.currencycode,bp.remark from bmdatabase_payment bp,submembers m where bp.bmdate between '$week_start' and '$week_end' and m.subid=bp.memberid $filter_query order by ref desc");
	    echo "";
		
	$super_total=0;
	while($data=mysql_fetch_array($sql_get_detail)) 
	{
		$date=date('d M Y', strtotime($data['bmdate']));
		$results = $data['amount']*-1;
		$memberid = $data['memberid'];
		$cpyaccount = $data['cpyaccount'];
		$remark = $data['remark'];
		$curcode = $data['currencycode'];

		if ($results<>0 && $results<>"0" && $results<>" ") {
		echo "<tr>";
		echo "<td align='center'  ><span class='bn13text'>&nbsp;$date</span></td>";
		echo "<td align='center'  ><span class='bn13text'>&nbsp;$cpyaccount</span></td>";
		echo "<td align='center'  ><span class='bn13text'>&nbsp;$memberid</span></td>";
		echo "<td align='center'  ><span class='bn13text'>&nbsp;$curcode</span></td>";
			if ($results<0) { $negtopos_total = number_format(abs($results),2);
			echo "<td align='center'  ><span class='bn13text'>&nbsp;<font color='blue'>$negtopos_total</font></span></td>";
			} else { $postoneg_total = number_format((0-$results),2);
			echo "<td align='center'  ><span class='bn13text'>&nbsp;<font color='red'>$postoneg_total</font></span></td>";
			}
		echo "<td align='center'  ><span class='bn13text'>&nbsp;$remark</span></td>";
		echo "</tr>"; }

		$super_total = $super_total + $results;
	}

		?>
		<tr>
		    <td class="hed"  colspan="4"><span class="bn13text">&nbsp;<b>Grand Total</b>&nbsp;</span></td>
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
<script>
	function back_page(){
		var date=$("#week_start").val();
		var date_arr=date.split('-');
		var year=date_arr[0];

		window.location.href = "viewbmyear.php?year="+year;
	}
</script>