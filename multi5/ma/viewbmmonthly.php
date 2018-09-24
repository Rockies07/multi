<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
?>
<html>
<head><title>Main Announcement</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="css/BreadCrumb.css" type="text/css">
<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/easydrag.js"></script>
<script type="text/javascript">$(function(){$("#FloaintBox").easydrag();
$("#FloaintBox").ondrop(function(e, element){ });});</script> 
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
	  <td align="center"><span class="maintitle">View BM Monthly</span></td>
	</tr>
   </table>
   <div id="breadCrumb" class="breadCrumb module">
                    <ul>
                        <li>
                            <a href="viewbmyear.php" style="text-decoration:none; color:#FFFFFF;"><b>Home</b></a>
                        </li>
                     	 <li>
                            <b>View BM Monthly</b>
                        </li>
                    </ul>
</div><br><br><br>
   <div align="center">
   <form action='<?php echo $PHP_SELF;?>' method='POST' name='listing' >
  <!-- From:<input class="inputDate" id="inputDate" name="datetime_from" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate"> to 
   <input class="inputDate" id="inputDate2" name="datetime_to" value="<?php echo date("m/d/Y"); ?>" readonly="true" />&nbsp;<img src="images/pikpik.gif" width="20" height="20" class="inputDate">
  Select Year:
   <select name="datetime" class="searchformfiled" >
   <?php if ($_POST["datetime"]<>"") { ?>
  	 <option value="<?php echo $_POST["datetime"]; ?>" selected="selected"><?php echo $_POST["datetime"]; ?></option>
	 <option value="2010">2010</option>
	 <?php } else { ?>
          <option value="2010" selected="selected">2010</option>
	<?php } ?>	  
		 <option value="2009" >2009</option>
		  <option value="2008" >2008</option>
		  <option value="2007" >2007</option>
		  <option value="2006" >2006</option>
		  <option value="2005" >2005</option>
   </select>
   <input type="submit" name="View" value="View">
   </form>
   </div><br>-->
<table border="1" cellpadding="0" cellspacing="0" width="90%" align="center" class="stats">
<tr>
	<td class="hed"  ><span class="bn13text">&nbsp;<b>Code</b>&nbsp;</span></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Web</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
</tr>
<?php
$code=$_GET["code"];
$month=$_GET["month"];
$year=$_GET["year"];
//-=-=-= link1
if ($_SESSION["link1"]=="")
$_SESSION["link1"] = "viewbmmonthly.php?code=$code&month=$month&year=$year";
//echo $_SESSION["link1"];
//-=-=-= link1
if (strlen($month)==1)
$month = "0" . $month;
	$enum_from = $year . "-" . $month . "-" . "01";
	$enum_to = $year . "-" . $month . "-" . "31";
	
	
	if($code=="FIX")
	{
		$bmsql=mysql_query("select subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like 'F%' group by subbmcode order by ref asc");
	}
	else if(strtoupper($code)=="DOMIN")
	{
		$bmsql=mysql_query("select subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like '%A001%'  group by subbmcode order by ref asc");
	}
	else if(strtoupper($code)=="GROSS")
	{
		$bmsql=mysql_query("select subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like '%A003%'  group by subbmcode order by ref asc");
	}
	else if(strtoupper($code)=="LEVY")
	{
		$bmsql=mysql_query("select subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like '%A002%'  group by subbmcode order by ref asc");
	}
	else
	{
		$bmsql=mysql_query("SELECT subbmcode FROM bmcode where bmcode = '$code'");
	}
//	echo "SELECT subbmcode FROM bmcode where bmcode = '$code'" . "<br>";
	$bmrow=mysql_num_rows($bmsql);
while ($row_bmsql = mysql_fetch_array($bmsql)) 
	{
$count++;
if ($count%2)
	{echo"<tr>";}
	else
{echo"<tr bgcolor='#CCCCCC'>";}
if ($count==1)
echo "<td align='center' rowspan='$bmrow'><span class='bn13text'><b>$code</b></span></td>";

echo "<td align='center'><span class='bn13text'><b>$row_bmsql[0]</b></span></td>";


//	$getvalues=mysql_query("select IFNULL(sum(amount),0),subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' and entriesby='$weblogin'");
//	$getvalues=mysql_query("select IFNULL(sum(amount),0)+(select ifnull(sum(amount),0) from bmcode_cleared where month_covered>='$enum_from' and month_covered<='$enum_to' and subbmcode='$row_bmsql[0]') from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' order by ref asc");
	if($code=="FIX")
	{
		$getvalues=mysql_query("select IFNULL(sum(amount),0)+(Select IFNULL(sum(amount),0) from backup_plan where subbmcode ='$row_bmsql[0]' and bmdate>='$enum_from' and bmdate<='$enum_to') from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like 'F%' and subbmcode = '$row_bmsql[0]' order by ref asc");
	}
	else if(strtoupper($code)=="DOMIN")
	{
		$getvalues=mysql_query("select IFNULL(sum(amount),0)+(Select IFNULL(sum(amount),0) from backup_plan where subbmcode ='$row_bmsql[0]' and bmdate>='$enum_from' and bmdate<='$enum_to') from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like '%A001%' and subbmcode = '$row_bmsql[0]' order by ref asc");
	}
	else if(strtoupper($code)=="GROSS")
	{
		$getvalues=mysql_query("select IFNULL(sum(amount),0)+(Select IFNULL(sum(amount),0) from backup_plan where subbmcode ='$row_bmsql[0]' and bmdate>='$enum_from' and bmdate<='$enum_to') from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like '%A003%' and subbmcode = '$row_bmsql[0]' order by ref asc");
	}
	else if(strtoupper($code)=="LEVY")
	{
		$getvalues=mysql_query("select IFNULL(sum(amount),0)+(Select IFNULL(sum(amount),0) from backup_plan where subbmcode ='$row_bmsql[0]' and bmdate>='$enum_from' and bmdate<='$enum_to') from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and memberid like '%A002%' and subbmcode = '$row_bmsql[0]' order by ref asc");
	}
	else
	{
		$member_short=$code[0]."0";

		$getvalues=mysql_query("select IFNULL(sum(amount),0)+(Select IFNULL(sum(amount),0) from backup_plan where subbmcode ='$row_bmsql[0]' and bmdate>='$enum_from' and bmdate<='$enum_to') from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to'  and memberid like '%$member_short%' order by ref asc");
	}
	
//	echo "select IFNULL(sum(amount),0) from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' and entriesby='$weblogin'  order by ref asc" . "<br>";
//	echo "select IFNULL(sum(amount),0),subbmcode from bmdatabase_wlplaceout where bmdate>='$enum_from' and bmdate<='$enum_to' and subbmcode='$row_bmsql[0]' and entriesby='$weblogin'";
while ($row_getvalues = mysql_fetch_array($getvalues)) 
	{
		
	if ($row_getvalues[0]=="")
		echo "<td align='center'><span class='bn13text'><b>0.00</b></span></td>";
	else {
		if ($row_getvalues[0]<=0) { $negtopos_total = number_format(abs($row_getvalues[0]),2);
		echo "<td align='center'><a href='viewbmdaily_b.php?web=$row_bmsql[0]&code=$code&month=$month&year=$year'><span class='bn13text'><b><font color='blue'>$negtopos_total</</b></span></td>";
		} else { $postoneg_total = number_format((0-$row_getvalues[0]),2);
		echo "<td align='center'><a href='viewbmdaily_b.php?web=$row_bmsql[0]&code=$code&month=$month&year=$year'><span class='bn13text'><b><font color='red'>$postoneg_total</font></b></span></td>";
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

<div id="FloaintBox"> 
<table align="center">
<tr><td colspan="2"><span class='bn13text'><b>Hidden Funds</b></span></td></tr>
<?php
//$clearreport=mysql_query("Select code,sum(amount) from bmcode_cleared group by code");

$clearreport=mysql_query("SELECT subbmcode FROM bmcode where bmcode = '$code'");
//$clearreport=mysql_query("Select subbmcode from bmcode group by subbmcode asc");
	while ($row_report = mysql_fetch_array($clearreport)) 
	{
		echo "<tr><td><span class='bn13text'> " . $row_report[0] . "</span></td>";
	
		//$clearreporter=mysql_fetch_array(mysql_query("Select sum(amount) from bmcode_cleared where subbmcode ='".$row_report[0]."' and substr(month_covered,1,7)='".$year."-".$month."'"));
		$clearreporter=mysql_fetch_array(mysql_query("Select IFNULL(sum(amount),0) from backup_plan where subbmcode ='".$row_report[0]."' and bmdate>='$enum_from' and bmdate<='$enum_to'"));
	//	echo "Select sum(amount) from backup_plan where subbmcode ='".$row_report[0]."' and bmdate>='$enum_from' and bmdate<='$enum_to'" . "<BR><BR>";
		//echo "Select sum(amount) from bmcode_cleared where subbmcode ='".$row_report[0]."' and substr(month_covered,1,7)='".$year."-".$month."'" . "<br>";
		if ($clearreporter[0]<0) {
		echo "<td><span class='bn13text'><font color='red'>" . $clearreporter[0] . "</font></span></td></td>";
	//	echo "asdf";
		}
		else if ($clearreporter[0]==NULL) {
		echo "<td><span class='bn13text'><font color='blue'>0.00</font></span></td></td>";
		//echo "asdf2";
		}
		else {
		echo "<td><span class='bn13text'><font color='blue'>" . $clearreporter[0] . "</font></span></td></td>";
		//echo "asdf3";
		}
	}
	
?>
</div> 
</table>
</body>
</html>