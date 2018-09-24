<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}

$get_member_sql=mysql_query("select a.memberid,a.membername,a.membercontact1,a.bankaccount,a.remarks,a.sms,a.membercontact2,a.ranking,a.status,a.managerid from memberid a ORDER BY a.memberid asc");


while($data=mysql_fetch_assoc($get_member_sql))
{
	$memberid=$data["memberid"];
	
	$bmreport=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
	+ (select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
	) as outstanding FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'");

	$bmreport_pm=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')
	+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid')
	 and pm='1')+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_payment where memberid in 
	 (select subid from submembers where memberid='$memberid') and pm='1')
	) as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1'");


	//echo "SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')) as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1'";
	$outstanding=mysql_result($bmreport,0,"outstanding");
	$pmdue=mysql_result($bmreport_pm,0,"pmdue");
	$total = $outstanding + $pmdue;

	mysql_query("Update member_total set total='$total', outstanding='$outstanding', amountdue='$pmdue' where memberid='$memberid'");


	echo "$memberid <br>";
}


?>