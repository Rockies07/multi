<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<?php
$code=$_GET["code"];
$type=$_GET["web"];
$month=$_GET["month"];
$year=$_GET["year"];
if ($_SESSION["link2"]=="")
$_SESSION["link2"] = "viewbmdaily_b.php?web=$type&month=$month&year=$year";
if ($month=="01" || $month=="03" || $month=="05" || $month=="07" || $month=="08" || $month=="10" || $month=="12")
	$vilang = 31;
if ($month=="04" || $month=="06" || $month=="09" || $month=="11")
	$vilang = 30;
if ($month=="02")
	$vilang = 29;
//	echo $vilang;
$year=$_GET["year"];
$action=$_GET["action"];
$getref=$_GET["ref"];
$eamount = $_GET["eamount"];
$memberid = $_GET["memberid"];
/*$fulldet1 = $year . "-" . $month . "-" . "01";
$fulldet2 = $year . "-" . $month . "-" . $vilang;*/
if ($action=="save")
{
	$update_amount = "update bmdatabase_wlplaceout set  amount='$eamount' where memberid = '$memberid' and ref = '$getref'";
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
<script type="text/javascript">$(function(){$("#FloaintBox").easydrag();
$("#FloaintBox").ondrop(function(e, element){ });});</script> 
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

for($x=1;$x<=$vilang;$x++) {
	if ($x<10) 
		$enum = $year . "-" . $month . "-" . "0" . $x;
	else
		$enum = $year . "-" . $month . "-" .$x;
//$getvalues=mysql_query("select ifnull(sum(amount),0) from bmdatabase_wlplaceout where bmdate='$enum' and subbmcode='$type' order by entriesdate asc");
$getvalues=mysql_query("select ifnull(sum(amount),0)+(select IFNULL(sum(amount),0) from backup_plan where bmdate='$enum' and subbmcode='$type') from bmdatabase_wlplaceout where bmdate='$enum' and subbmcode='$type' order by entriesdate asc");

//echo "select amount from bmdatabase_wlplaceout where bmdate='$enum' and subbmcode='$type' and entriesby='$weblogin' order by entriesdate asc";
$results = mysql_fetch_array($getvalues);
//echo $results[0] . "<br>";


//if ($results[0]<>0 && $results[0]<>"0" && $results[0]<>" ") {
//echo $results[0]; 
//if ($results[0]<>"" || $results[0]=="0.00") {
//if ($results[0]<>"" || $results[0]<>"0.00") {
if ($results[0]<>0 && $results[0]<>"0" && $results[0]<>" ") {
echo "<tr>";
echo "<td align='center'  ><span class='bn13text'>&nbsp;<b>$enum</b></span></td>";
	if ($results[0]<0) { $negtopos_total = number_format(abs($results[0]),2);
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a href='viewbmdaily.php?web=$type&month=$month&year=$year&deyt=$enum'><font color='blue'>$negtopos_total</font></a></b></span></td>";
	} else { $postoneg_total = number_format((0-$results[0]),2);
	echo "<td align='center'  ><span class='bn13text'>&nbsp;<b><a href='viewbmdaily.php?web=$type&month=$month&year=$year&deyt=$enum'><font color='red'>$postoneg_total</font></a></b></span></td>";
	}
echo "</tr>"; }
}

	?>
	</table>
	<div id="FloaintBox"> 
<table align="center">
<tr><td colspan="2"><span class='bn13text'><b>Hidden Funds</b></span></td></tr>
<?php

$enum_from = $year . "-" . $month . "-" . "01";
$enum_to = $year . "-" . $month . "-" . "31";
$clearreport=mysql_query("select bmdate,IFNULL(sum(amount),0) from backup_plan where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$type' group by bmdate");
//echo "select bmdate,sum(amount) from backup_plan where bmdate='$enum' and subbmcode='$type'";
	while ($row_report = mysql_fetch_array($clearreport)) 
	{
		
		echo "<tr><td><span class='bn13text'> " . $row_report[0] . "</span></td>";
	
		if ($row_report[1]<0) {
		echo "<td><span class='bn13text'><font color='red'>" . $row_report[1] . "</font></span></td></td>";
	//	echo "asdf";
		}
		else if ($row_report[1]==NULL) {
		echo "<td><span class='bn13text'><font color='blue'>0.00</font></span></td></td>";
		//echo "asdf2";
		}
		else {
		echo "<td><span class='bn13text'><font color='blue'>" . $row_report[1] . "</font></span></td></td>";
		//echo "asdf3";
		}
	}
	
?>
</div> 
</table>
<!--* montly report will base from the last 12 months starting from the current month-->
</body>
</html>