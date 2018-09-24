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
	  <td align="center"><span class="maintitle">View Cash Monthly</span></td>
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
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Account</b>&nbsp;</span></td>
    <td class="hed"  ><span class="bn13text">&nbsp;<b>Date</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Amount</b>&nbsp;</span></td>
    <td class="hed" ><span class="bn13text">&nbsp;<b>Remark</b>&nbsp;</span></td>
</tr>
<?php
$code=$_GET["code"];
$date=$_GET["date"];
//-=-=-= link1
if ($_SESSION["link1"]=="")
$_SESSION["link1"] = "viewbmmonthly_cash.php?code=$code&month=$month&year=$year";
//echo $_SESSION["link1"];
//-=-=-= link1
if (strlen($month)==1)
$month = "0" . $month;
	$enum_from = $year . "-" . $month . "-" . "01";
	$enum_to = $year . "-" . $month . "-" . "31";
	
	$bmsql=mysql_query("SELECT * FROM bmdatabase_payment where bmdate='$date'");
//	echo "SELECT subbmcode FROM bmcode where bmcode = '$code'" . "<br>";
	$bmrow=mysql_num_rows($bmsql);
while ($row_bmsql = mysql_fetch_assoc($bmsql)) 
	{
$count++;
if ($count%2)
	{echo"<tr>";}
	else
{echo"<tr bgcolor='#CCCCCC'>";}
echo "<td align='center'><span class='bn13text'><b>$row_bmsql[memberid]</b></span></td>";

echo "<td align='center'><span class='bn13text'><b>$row_bmsql[cpyaccount]</b></span></td>";

$date=date('d-M-Y',strtotime($row_bmsql['bmdate']));
$get_date=$row_bmsql['bmdate'];
echo "<td align='center'><span class='bn13text'><b>$date</b></span></td>";
if ($row_bmsql['amount']>=0) { $bmamount = number_format(abs($row_bmsql['amount']),2);
echo "<td align='center'><span class='bn13text'><b><font color='blue'>$bmamount</font></b></span></td>";
} else { $bmamount = number_format((0-$row_bmsql['amount']),2);
echo "<td align='center'><span class='bn13text'><b><font color='red'>$bmamount</font></b></span></td>";
}

echo "<td><span class='bn13text'><b>$row_bmsql[remark]</b></span></td>";

$super_total = $super_total + $row_bmsql['amount'];

}
	?>
	<tr>
	<td class="hed" colspan="3" style="text-align:right"><span class="bn13text">&nbsp;<b>Total</b>&nbsp;</span></td>
	<?php if ($super_total>=0) { $negtopos_total = number_format(abs($super_total),2); ?>
    <td class="hed" ><span class="bn13text">&nbsp;<b><font color='blue'><?php echo $negtopos_total; ?></font></b>&nbsp;</span></td>
    <?php } else { $postoneg_total = number_format((0-$super_total),2); ?>
	<td class="hed" ><span class="bn13text">&nbsp;<b><font color='red'><?php echo $postoneg_total; ?></font></b>&nbsp;</span></td>
	<?php } ?>
	<td class="hed" style="text-align:right"><span class="bn13text">&nbsp;&nbsp;</span></td>

</tr>
</table>
<!--* montly report will base from the last 12 months starting from the current month-->

</body>
</html>