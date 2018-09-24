<?php
	session_start();
	$weblogin=$_SESSION["weblogin"];
	$webpassword=$_SESSION["webpassword"];
	
	include "include/include.php";
	
	$login=mysql_query("SELECT * FROM managerid WHERE managerid='$weblogin' and password='$webpassword'");
	$rights=mysql_num_rows($login);
	if(!$rights){header("location:index.php");}
	$weblogin=strtoupper($weblogin);
	$i=0;
	$once=0;
	$newcol="";
	$memcount=0;
	
	//-=-=-= clear session
	if ($_GET["renew"]==1) {
	$_SESSION["payge"] = "";
	$_SESSION["pagenum"] = "";
	$_SESSION["delimit"] = "";
	$_SESSION["SortBy"] = "";
	$_SESSION["searchID"] = "";
	$_SESSION["filter"] = "";
	$_SESSION["mayneger"] = "";
	$_SESSION["hiddenf"] = "";
	$_SESSION["SortOrder"] = "";
	}
	//-=-=- pass back
	if ($_GET["payge"]<>"" && $_GET["renew"]==1)
	$_SESSION["payge"] = $_GET["payge"];
	if ($_GET["pagenum"]<>"" && $_GET["renew"]==1)
	$_SESSION["pagenum"]= $_GET["pagenum"];
	if ($_GET["delimit"]<>"" && $_GET["renew"]==1)
	$_SESSION["delimit"] = $_GET["delimit"];
//	else
//	$_SESSION["delimit"]=1;
	if ($_GET["SortBy"]<>"" && $_GET["renew"]==1)
	$_SESSION["SortBy"] = $_GET["SortBy"];
	if ($_GET["searchID"]<>"" && $_GET["renew"]==1)
	$_SESSION["searchID"] = $_GET["searchID"];
	if ($_GET["filter"]<>"" && $_GET["renew"]==1)
	$_SESSION["filter"] = $_GET["filter"];
	if ($_GET["mayneger"]<>"" && $_GET["renew"]==1)
	$_SESSION["mayneger"] = $_GET["mayneger"];
	if ($_GET["hiddenf"]<>"" && $_GET["renew"]==1)
	$_SESSION["hiddenf"] = $_GET["hiddenf"];
	if ($_GET["SortOrder"]<>"" && $_GET["renew"]==1)
	$_SESSION["SortOrder"] = $_GET["SortOrder"];
	
/*	echo $_SESSION["payge"] . "<br>";
	echo $_SESSION["pagenum"] . "<br>";
	echo $_SESSION["delimit"] . "<br>";
	echo $_SESSION["SortBy"] . "<br>";
	echo $_SESSION["searchID"] . "<br>";
	echo $_SESSION["filter"] . "<br>";
	echo $_SESSION["mayneger"] . "<br>";
	echo $_SESSION["hiddenf"] . "<br>";
	echo $_SESSION["SortOrder"] . "<br>";*/

	if ($_GET[memberid]<>"") {
	$_SESSION["memberid"]=$_GET[memberid];
	$_SESSION["managerid"]=$_GET[managerid];
	}
	$memberid=$_SESSION["memberid"];
	$managerid=$_SESSION["memberid"];
	$action=$_GET["action"];
	$hiddenf = $_POST["hiddenf"];
	$counts = $_POST["counts"];
	$reference = $_GET["ref"];
	$methody=$_GET["methody"];
	$even_once = "";
	
	//-=-=- get ids
		// get from submembers
		$memberlist2=mysql_query("SELECT subid FROM submembers where memberid = '$memberid'");
		//$memrows=mysql_num_rows($memberlist2);
		//if ($memrow<>0) {
	//	echo "SELECT subid FROM submembers where memberid = '$memberid'";
	$include_only1 = " where memberid = '$memberid'";
	$include_only2 = " and memberid = '$memberid'";
	$ipunin = "'$memberid'";
		while ($row_memberlist2 = mysql_fetch_array($memberlist2)) 
		{
			$include_only1 = $include_only1 . " or memberid = '".$row_memberlist2[0]."'";
			$include_only2 = $include_only2 . " or memberid = '".$row_memberlist2[0]."'";
				/*if ($ipunin=="")
				$ipunin = "'" . $row_memberlist2[0] . "'"; 
				else*/
				$ipunin = $ipunin . "," . "'" . $row_memberlist2[0] . "'"; 
				
			if ($memlist=="") {
				$memlist = $row_memberlist2[0];
			}
			else
			{		
				$memlist = $memlist . "," . $row_memberlist2[0];
			}
		}
		
		//echo $ipunin;
		//echo "include_only1: " . $include_only1 . "<br>";
		//echo "include_only2: " . $include_only2 . "<br>";
//	echo $hiddenf;

//-=-=-=- update
	if($_POST["action"]=='Update'){
		$datetime = $_POST['datetime'];
		$sabog =(explode("/",$datetime));
		$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
		$remark=$_POST["remarks"];
		$amount=$_POST["amount"];
		$type=$_POST["type"];
		$accounts=$_POST["accounts"];
		$currency=$_POST["currency"];
		$webdatetime=date("Y-m-d H:i:s");
		$refy=$_POST["refy"];
		
	if ($_POST['type']=="PLACEOUT") {
	
	//-=-=- get info from database
	$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_wlplaceout where ref='$refy'");
	$memaydi=mysql_result($getinfo,0,"memberid");
	$amawnt=mysql_result($getinfo,0,"amount");
	$phim=mysql_result($getinfo,0,"pm");
	//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		if ($phim=='0') {
			if ($amount>$amawnt) {
				$totadd = $amount - $amawnt;
				$updatetotal = "update member_total set total=total+'$totadd', outstanding=outstanding+'$totadd' where memberid='$maimmem'"; }
			if ($amount<$amawnt) {
				$totded = $amawnt - $amount;
				$updatetotal = "update member_total set total=total-'$totded', outstanding=outstanding-'$totded' where memberid='$maimmem'"; }
			mysql_query($updatetotal);
			/*echo $updatetotal . "1<br>";
			break;*/
		}	
		else {
			if ($amount>$amawnt) {
				$totadd = $amount - $amawnt;
				$updatetotal = "update member_total set total=total+'$totadd', amountdue=amountdue+'$totadd' where memberid='$maimmem'"; }
			if ($amount<$amawnt) {
				$totded = $amawnt - $amount;
				$updatetotal = "update member_total set total=total-'$totded', amountdue=amountdue-'$totded' where memberid='$maimmem'"; }
			mysql_query($updatetotal);
			/*echo $updatetotal . "2<br>";
			break;*/
		}
	
mysql_query("update bmdatabase_wlplaceout set bmdate='$converted_datetime',subbmcode='$accounts',currencycode='$currency',amount='$amount',entriesby='$weblogin',remark='$remark',entriesdate='$webdatetime' where ref ='$refy'") or die(mysql_error());

	}
	else
	{

	//-=-=- get info from database
	$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_payment where ref='$refy'");
	$memaydi=mysql_result($getinfo,0,"memberid");
	$amawnt=mysql_result($getinfo,0,"amount");
	$phim=mysql_result($getinfo,0,"pm");
	//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		if ($phim=='0') {
			if ($amount>$amawnt) {
				$totadd = $amount - $amawnt;
				$updatetotal = "update member_total set total=total+'$totadd', outstanding=outstanding+'$totadd' where memberid='$maimmem'"; }
			if ($amount<$amawnt) {
				$totded = $amawnt - $amount;
				$updatetotal = "update member_total set total=total-'$totded', outstanding=outstanding-'$totded' where memberid='$maimmem'"; }
			mysql_query($updatetotal);
			/*echo $updatetotal . "1a<br>";
			break;*/
		}	
		else {
			if ($amount>$amawnt) {
				$totadd = $amount - $amawnt;
				$updatetotal = "update member_total set total=total+'$totadd', amountdue=amountdue+'$totadd' where memberid='$maimmem'"; }
			if ($amount<$amawnt) {
				$totded = $amawnt - $amount;
				$updatetotal = "update member_total set total=total-'$totded', amountdue=amountdue-'$totded' where memberid='$maimmem'"; }
			mysql_query($updatetotal);
			/*echo $updatetotal . "2a<br>";
			break;*/
		}

	mysql_query("update bmdatabase_payment set bmdate='$converted_datetime',cpyaccount='$accounts',currencycode='$currency',amount='$amount',entriesby='$weblogin',remark='$remark',entriesdate='$webdatetime' where ref = '$refy'") or die(mysql_error());
	}
	
		echo "<SCRIPT language=\"JavaScript\">alert('Details Updated!');</SCRIPT>";
		//$action='add';
		// 	break;
	}
	
	
	//-=-=-=- save check p
	if ($_POST["Save"]) {
	$refcol=$_POST["refcol"];
	$refcolw=$_POST["refcolw"];
	$refcolp=$_POST["refcolp"];
	
	//echo $refcol;
	$counts = isset($_POST['check_listp']) ? count($_POST['check_listp']) : 0;
	//echo "counts: " . $counts ."<br>";
	if ($counts<>0) {
	for ($i=0; $i<$counts;$i++) {
	$datum = $_POST['check_listp'][$i];
	$sabog =explode("%",$datum);
	$ref = $sabog[0];
	$method = $sabog[1];
	//echo $datum . "<BR>";
	
		if ($hiddenf==0 || $hiddenf==""){
			if ($method=='placeout') {
								
				//-=-=- get info from database
				$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_wlplaceout where ref='$ref'");
				$memaydi=mysql_result($getinfo,0,"memberid");
				$amawnt=mysql_result($getinfo,0,"amount");
				$fiem=mysql_result($getinfo,0,"pm");
				//-=-=-= get main memberid
				$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
				//	$getmainmember
				$maimmem=mysql_result($getmainmember,0,"mainmember");
				//=-=-=-= update the total
				if ($fiem==0)
				$updatetotal = "update member_total set outstanding=outstanding-'$amawnt', amountdue=amountdue+'$amawnt' where memberid='$maimmem'";
				//echo $updatetotal . "1<br>";
				mysql_query($updatetotal);
				$updatetotal="";
				
				mysql_query("update bmdatabase_wlplaceout set pm='1' WHERE ref = '$ref'");
				
				if ($not_to_uncheck_w=="")
					$not_to_uncheck_w = $ref;
				else
					$not_to_uncheck_w = $not_to_uncheck_w . "," . $ref;
			}
			if ($method=='payment') {
						
			//-=-=- get info from database
				$getinfo = mysql_query("select memberid, amount, pm from bmdatabase_payment where ref='$ref'");
				//echo "select memberid, amount from bmdatabase_payment where ref='$ref'" . "<br>";
				$memaydi=mysql_result($getinfo,0,"memberid");
				$amawnt=mysql_result($getinfo,0,"amount");
				$fiem=mysql_result($getinfo,0,"pm");
				//-=-=-= get main memberid
				$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
				//	$getmainmember
				$maimmem=mysql_result($getmainmember,0,"mainmember");
				//=-=-=-= update the total
				if ($fiem==0)
				$updatetotal = "update member_total set outstanding=outstanding-'$amawnt', amountdue=amountdue+'$amawnt' where memberid='$maimmem'";
				mysql_query($updatetotal);
				//echo $updatetotal . "2<br>";
				$updatetotal="";
				
				mysql_query("update bmdatabase_payment set pm='1' WHERE ref = '$ref'");								
				
				if ($not_to_uncheck_p=="")
					$not_to_uncheck_p = $ref;
				else
					$not_to_uncheck_p = $not_to_uncheck_p . "," . $ref;
			
			}
		} else { // if hidden
			if ($method=='placeout') {
								
				//-=-=- get info from database
				$getinfo = mysql_query("select memberid, amount, pm from bmdatabase_wlplaceout where ref='$ref'");
				$memaydi=mysql_result($getinfo,0,"memberid");
				$amawnt=mysql_result($getinfo,0,"amount");
				$fiem=mysql_result($getinfo,0,"pm");
				//-=-=-= get main memberid
				$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
				//	$getmainmember
				$maimmem=mysql_result($getmainmember,0,"mainmember");
				//=-=-=-= update the total
				if ($fiem==0)
				$updatetotal = "update member_total set outstanding=outstanding-'$amawnt', amountdue=amountdue+'$amawnt' where memberid='$maimmem'";
				//echo $updatetotal . "3<br>";
				mysql_query($updatetotal);
				$updatetotal="";
				
				mysql_query("update bmdatabase_wlplaceout set pm='1' WHERE ref = '$ref'");
				
				if ($not_to_uncheck_w=="")
					$not_to_uncheck_w = $ref;
				else
					$not_to_uncheck_w = $not_to_uncheck_w . "," . $ref;
			}
			if ($method=='payment') {
						
				//-=-=- get info from database
				$getinfo = mysql_query("select memberid, amount, pm from bmdatabase_payment where ref='$ref'");
				$memaydi=mysql_result($getinfo,0,"memberid");
				$amawnt=mysql_result($getinfo,0,"amount");
				$fiem=mysql_result($getinfo,0,"pm");
				//-=-=-= get main memberid
				$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
				//	$getmainmember
				$maimmem=mysql_result($getmainmember,0,"mainmember");
				//=-=-=-= update the total
				if ($fiem==0)
				$updatetotal = "update member_total set outstanding=outstanding-'$amawnt', amountdue=amountdue+'$amawnt' where memberid='$maimmem'";
				//echo $updatetotal . "4<br>";
				mysql_query($updatetotal);
				$updatetotal="";
			
				mysql_query("update bmdatabase_payment set pm='1' WHERE ref = '$ref'");
			
				if ($not_to_uncheck_p=="")
					$not_to_uncheck_p = $ref;
				else
					$not_to_uncheck_p = $not_to_uncheck_p . "," . $ref;
			
			}
		
		}
		
	
		} // for loop
	
		if ($not_to_uncheck_w<>"") {
		
			$loopall = mysql_query("select ref from bmdatabase_wlplaceout WHERE ref in ($refcolw) and not ref in ($not_to_uncheck_w)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_wlplaceout where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "5<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
			
			mysql_query("update bmdatabase_wlplaceout set pm='0' WHERE ref in ($refcolw) and not ref in ($not_to_uncheck_w)");
				
		}
		else {
	
			$loopall = mysql_query("select ref from bmdatabase_wlplaceout WHERE ref in ($refcolw)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_wlplaceout where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "6<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
			
			mysql_query("update bmdatabase_wlplaceout set pm='0' WHERE ref in ($refcolw)");
		
		}
		
		if ($not_to_uncheck_p<>"") {
	
			$loopall = mysql_query("select ref from bmdatabase_payment WHERE ref in ($refcolp) and not ref in ($not_to_uncheck_p)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_payment where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//echo $fiem . "<br>";
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "7<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
			
			mysql_query("update bmdatabase_payment set pm='0' WHERE ref in ($refcolp) and not ref in ($not_to_uncheck_p)"); 

		}
		else {

			$loopall = mysql_query("select ref from bmdatabase_payment WHERE ref in ($refcolp)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_payment where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "8<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
			
					mysql_query("update bmdatabase_payment set pm='0' WHERE ref in ($refcolp)");
		}
		
	//	echo "update bmdatabase_wlplaceout set pm='0' WHERE ref in ($refcol) and not ref in ($not_to_uncheck_w)" . "<br>";
	//	echo "update bmdatabase_payment set pm='0' WHERE ref in ($refcol) and not ref in ($not_to_uncheck_p)" . "<br>";
			//echo $refcol;
	} // if ($counts<>0)
	
		else // if none is seen
		{
			if ($hiddenf==0 || $hiddenf==""){
			/*	mysql_query("update bmdatabase_wlplaceout set pm='0' WHERE ref in ($refcol)");
				mysql_query("update bmdatabase_payment set pm='0' WHERE ref in ($refcol)");*/
					
			$loopall = mysql_query("select ref from bmdatabase_wlplaceout WHERE ref in ($refcolw)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_wlplaceout where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "9<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
								
			$loopall = mysql_query("select ref from bmdatabase_payment WHERE ref in ($refcolp)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_payment where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//echo $fiem . "<br>";
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "10<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
			
			mysql_query("update bmdatabase_wlplaceout set pm='0' WHERE ref in ($refcolw)");
			mysql_query("update bmdatabase_payment set pm='0' WHERE ref in ($refcolp)");
			
			}
			else
			{
							
			$loopall = mysql_query("select ref from bmdatabase_wlplaceout WHERE ref in ($refcolw)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_wlplaceout where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "11<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
								
			$loopall = mysql_query("select ref from bmdatabase_payment WHERE ref in ($refcolp)");
			while ($row_loopall = mysql_fetch_array($loopall)) 
			{
					//-=-=- get info from database
					$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_payment where ref='$row_loopall[0]'");
					$memaydi=mysql_result($getinfo,0,"memberid");
					$amawnt=mysql_result($getinfo,0,"amount");
					$fiem=mysql_result($getinfo,0,"pm");
					//-=-=-= get main memberid
					$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
					//	$getmainmember
					$maimmem=mysql_result($getmainmember,0,"mainmember");
					//=-=-=-= update the total
					if ($fiem==1)
					$updatetotal = "update member_total set outstanding=outstanding+'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
					//echo $updatetotal . "12<br>";
					mysql_query($updatetotal);
					$updatetotal="";
			}
			
			mysql_query("update bmdatabase_wlplaceout set pm='0' WHERE ref in ($refcolw)");
			mysql_query("update bmdatabase_payment set pm='0' WHERE ref in ($refcolp)");
			
			}
		
		} // else non is seen
	} // if ($_POST["Save"])
	
	//-=-=-=- save check h
	if ($_POST["Save"]) {
	$refcol=$_POST["refcol"];
	$refcolw=$_POST["refcolw"];
	$refcolp=$_POST["refcolp"];
	//echo $refcol;
	$counts = isset($_POST['check_listh']) ? count($_POST['check_listh']) : 0;
	//echo "counts: " . $counts ."<br>";
	if ($counts<>0) {
	for ($i=0; $i<$counts;$i++) {
	$datum = $_POST['check_listh'][$i];
	$sabog =explode("%",$datum);
	$ref = $sabog[0];
	$method = $sabog[1];
	//echo $datum . "<BR>";
	
		if ($hiddenf==0 || $hiddenf==""){
			if ($method=='placeout') {
				mysql_query("update bmdatabase_wlplaceout set clr='1' WHERE ref = '$ref'");
				if ($not_to_uncheck_w2=="")
					$not_to_uncheck_w2 = $ref;
				else
					$not_to_uncheck_w2 = $not_to_uncheck_w2 . "," . $ref;
				//	echo "update bmdatabase_wlplaceout set clr='1' WHERE ref = '$ref'" . "<br>";
					//echo $not_to_uncheck_w2 . "<br>";
			}
			if ($method=='payment') {
			mysql_query("update bmdatabase_payment set clr='1' WHERE ref = '$ref'");
				if ($not_to_uncheck_p2=="")
					$not_to_uncheck_p2 = $ref;
				else
					$not_to_uncheck_p2 = $not_to_uncheck_p2 . "," . $ref;
					//echo "update bmdatabase_payment set clr='1' WHERE ref = '$ref'" . "<br>";
					//echo $not_to_uncheck_p2 . "<br>";
			}
		} else { // if hidden
			if ($method=='placeout') {
				mysql_query("update bmdatabase_wlplaceout set clr='1' WHERE ref = '$ref'");
				if ($not_to_uncheck_w2=="")
					$not_to_uncheck_w2 = $ref;
				else
					$not_to_uncheck_w2 = $not_to_uncheck_w2 . "," . $ref;
					//echo "update bmdatabase_wlplaceout set clr='1' WHERE ref = '$ref'" . "<br>";
					//echo $not_to_uncheck_w2 . "<br>";
			}
			if ($method=='payment') {
			mysql_query("update bmdatabase_payment set clr='1' WHERE ref = '$ref'");
				if ($not_to_uncheck_p2=="")
					$not_to_uncheck_p2 = $ref;
				else
					$not_to_uncheck_p2 = $not_to_uncheck_p2 . "," . $ref;
					//echo "update bmdatabase_payment set clr='1' WHERE ref = '$ref'" . "<br>";
					//echo $not_to_uncheck_p2 . "<br>";
			
			}
		
		}
		
	
		} // for loop
		
		if ($not_to_uncheck_w2<>"") {
		//mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcol) and not ref in ($not_to_uncheck_w2)"); 
		mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcolw) and not ref in ($not_to_uncheck_w2)"); 
	//	echo "update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcolw) and not ref in ($not_to_uncheck_w2)" . "<br>";
		}
		else {
		//mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcol)");
		mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcolw)");
	//	echo "update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcolw)" . "<br>";
		}
		
		if ($not_to_uncheck_p2<>"") {
	//	mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcol) and not ref in ($not_to_uncheck_p2)");
		mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcolp) and not ref in ($not_to_uncheck_p2)");
	//	echo "update bmdatabase_payment set clr='0' WHERE ref in ($refcolp) and not ref in ($not_to_uncheck_p2)" . "<br>";
		}
		else {
	//	mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcol)"); 
		mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcolp)"); 
	//	echo "update bmdatabase_payment set clr='0' WHERE ref in ($refcolp)" . "<br>";
		}
		

	} // if ($counts<>0)
	
		else // if none is seen
		{
			if ($hiddenf==0 || $hiddenf==""){
				/*mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcol)");
				mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcol)");*/
				mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcolw)");
				mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcolp)");
			}
			else
			{
				/*mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcol)");
				mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcol)");*/
				mysql_query("update bmdatabase_wlplaceout set clr='0' WHERE ref in ($refcolw)");
				mysql_query("update bmdatabase_payment set clr='0' WHERE ref in ($refcolp)");
			}
		
		} // else non is seen
	} // if ($_POST["Save"])



//-=-=-= delete
if ($action=='delete')
{
	$webdatetime=date("Y-m-d H:i:s");
	if ($methody=="payment") {
	
	//-=-=- get info from database
	$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_payment where ref='$reference'");
	$memaydi=mysql_result($getinfo,0,"memberid");
	$amawnt=mysql_result($getinfo,0,"amount");
	$phim=mysql_result($getinfo,0,"pm");
	//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		if ($phim=='0')
		$updatetotal = "update member_total set total=total-'$amawnt', outstanding=outstanding-'$amawnt' where memberid='$maimmem'";
		else
		$updatetotal = "update member_total set total=total-'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
		mysql_query($updatetotal);
		/*echo $updatetotal . "1<br>";
		break;*/
	
	mysql_query("insert into cleared_history select *,'$weblogin','$webdatetime' from bmdatabase_payment where ref='$reference'") or die(mysql_error());
	mysql_query("delete from bmdatabase_payment where ref = '$reference'") or die(mysql_error());
			echo "<SCRIPT language=\"JavaScript\">alert('Detail Deleted!');</SCRIPT>";
	}
	else
	{
	
	//-=-=- get info from database
	$getinfo = mysql_query("select memberid, amount,pm from bmdatabase_wlplaceout where ref='$reference'");
	$memaydi=mysql_result($getinfo,0,"memberid");
	$amawnt=mysql_result($getinfo,0,"amount");
	$phim=mysql_result($getinfo,0,"pm");
	//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$memaydi'),(select memberid from memberid where memberid='$memaydi'),(select memberid from submembers where subid='$memaydi')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		if ($phim=='0')
		$updatetotal = "update member_total set total=total-'$amawnt', outstanding=outstanding-'$amawnt' where memberid='$maimmem'";
		else
		$updatetotal = "update member_total set total=total-'$amawnt', amountdue=amountdue-'$amawnt' where memberid='$maimmem'";
		mysql_query($updatetotal);
/*		echo $updatetotal . "2<br>";
		break;*/

	
	mysql_query("insert into cleared_history select *,'','$weblogin','$webdatetime' from bmdatabase_wlplaceout where ref='$reference'") or die(mysql_error());
	mysql_query("delete from bmdatabase_wlplaceout where ref = '$reference'") or die(mysql_error());
			echo "<SCRIPT language=\"JavaScript\">alert('Detail Deleted!');</SCRIPT>";
	}
}

	
	if ($hiddenf==0 || $hiddenf=="")
		$hide_me = " and clr = '0'";
	
//	echo $hide_me;
//	echo $_POST["counts"] . "<br><br>";
	
	//-=-=-= reports
$bmreport=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
+ (select ifnull(SUM(amount),0) from bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid') and pm='0')
) as outstanding FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'");
//echo "SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid'))) as outstanding FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'";
/*$bmsql=mysql_query("(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid'))");
*/

//echo "SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0') + (select ifnull(SUM(amount),0) from bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid')) as outstanding FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'";

$bmreport_pm=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')
+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid')
 and pm='1')+(SELECT ifnull(SUM(amount),0) FROM bmdatabase_payment where memberid in 
 (select subid from submembers where memberid='$memberid') and pm='1')
) as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1'");


//echo "SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')) as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1'";
$outstanding=mysql_result($bmreport,0,"outstanding");
$pmdue=mysql_result($bmreport_pm,0,"pmdue");
$total = $outstanding + $pmdue;
/*echo "Outstanding: " . number_format($outstanding,2) . "<br>";
echo "Payment Due: " . number_format($pmdue,2) . "<br>";
echo "Total: " . number_format($total,2) . "<br><br>";*/


$paydue = number_format($pmdue,2);
//$outstanding = number_format($outstanding-$pmdue,2);
$outstanding = number_format($outstanding,2);
$total = number_format($total,2);

//-=-=-=wl placeout
/*$fullreport=mysql_query("select distinct bmcode from bmcode order by bmcode asc");
while ($row_fullreport = mysql_fetch_array($fullreport)) 
	{
		echo "Code: " . $row_fullreport[0] . ": ";
		$fullsubbmcode=mysql_query("select subbmcode from bmcode where bmcode='$row_fullreport[0]' order by subbmcode asc");
		while ($row_fullsubbmcode = mysql_fetch_array($fullsubbmcode)) 
		{
			$fullamount=mysql_query("select sum(amount) as tutal from bmdatabase_wlplaceout where subbmcode='$row_fullsubbmcode[0]' and memberid='$memberid'");
			//echo "select sum(amount) as tutal from bmdatabase_wlplaceout where subbmcode='$row_fullsubbmcode[0]'" . "<br>";
			$amount=mysql_result($fullamount,0,"tutal");
			$full_amount_bm = $full_amount_bm + $amount;
		//	echo $full_amount_bm . "<br>";
			//while ($row_fullsubbmcode = mysql_fetch_array($fullamount)) 
		}
		echo number_format($full_amount_bm,2) . "<br>";
		$super_2tal = $super_2tal + $full_amount_bm;
		$full_amount_bm = 0;
	}*/
	
//-=-= payment
/*$fullreport2=mysql_query("select distinct cpyaccount from cpyaccount order by cpyaccount asc");
while ($row_fullreport2 = mysql_fetch_array($fullreport2)) 
	{
		echo "Code: " . $row_fullreport2[0] . ": ";
			$fullamount2=mysql_query("select ifnull(sum(amount),0) as tutal from bmdatabase_payment where cpyaccount='$row_fullreport2[0]' and memberid='$memberid'");
		//	echo "select sum(amount) as tutal from bmdatabase_payment where cpyaccount='$row_fullreport2[0]' and memberid='$memberid'" . "<br>";
			$amount2=mysql_result($fullamount,0,"tutal");
			$full_amount2=  $full_amount2 + $amount2;
		//	echo $full_amount_bm . "<br>";
			//while ($row_fullsubbmcode = mysql_fetch_array($fullamount)) 
		echo number_format($full_amount2,2) . "<br>";
		//$super_2tal = $super_2tal + $full_amount_bm;
		$full_amount2 = 0;
	}
	echo "Total: " . number_format($super_2tal,2);*/
	//-=-=-=-=-=
	
	//-=-=-=-=-= insert info
	if ($_POST["Insert"]) {
	$datetime = $_POST['datetime'];
	$sabog =(explode("/",$datetime));
	$converted_datetime = $sabog[2] . "/" . $sabog[0] . "/" . $sabog[1];
	$remarks=$_POST["remarks"];
	$amount=$_POST["amount"];
	$type=$_POST["type"];
	$aydis=$_POST["aydis"];
	$accounts=$_POST["accounts"];
	$currency=$_POST["currency"];
	$webdatetime=date("Y-m-d H:i:s");
	
	if ($_POST['type']=="PLACEOUT") {
$insert2 = "insert into bmdatabase_wlplaceout values('','$converted_datetime','$aydis','$accounts','TKT','$currency','$amount','$weblogin','$webdatetime','$remarks','','')";
		//echo $insert2;
		mysql_query($insert2);
		
		//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$aydis'),(select memberid from memberid where memberid='$aydis'),(select memberid from submembers where subid='$aydis')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		$updatetotal = "update member_total set total=total+'$amount', outstanding=outstanding+'$amount' where memberid='$maimmem'";
		mysql_query($updatetotal);
		
		echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved W/L Placeout!'); window.location = 'viewmemberdetailsb.php';</SCRIPT>";
		 }
	if ($_POST['type']=="PAYMENT") {
$insert2 = "insert into bmdatabase_payment values('','$converted_datetime','$aydis','$accounts','TRS','$currency','$amount','$weblogin','$webdatetime','$remarks','','','')";
	//	echo $insert2;
		mysql_query($insert2);
		
		//-=-=-= get main memberid
		$getmainmember = mysql_query("select if (0<(select count(memberid) from memberid where memberid='$aydis'),(select memberid from memberid where memberid='$aydis'),(select memberid from submembers where subid='$aydis')) as mainmember");
		//	$getmainmember
		$maimmem=mysql_result($getmainmember,0,"mainmember");
		//=-=-=-= update the total
		$updatetotal = "update member_total set total=total+'$amount', outstanding=outstanding+'$amount' where memberid='$maimmem'";
		mysql_query($updatetotal);
		
		echo "<SCRIPT language=\"JavaScript\">alert('Successfully Saved Payment!'); window.location = 'viewmemberdetailsb.php';</SCRIPT>";
		 }
		
	} // if ($_POST["Insert"])
	//-=-=-=-=-=-


	
	//-=-=-=
	
	/* if(is_array($_POST['check_listp']))
	 foreach($_POST['check_listp'] as $requirementschecked)
  	 {
	 $requirementsprint .= "$requirementschecked";

	 }
	 	 echo $requirementsprint;*/
?>
<html>
<head><title>Main Announcement</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<link href="css/demos2.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
<!-- 
function win(){
window.opener.location.href="viewallmemberb.php?payge=<?php echo $_SESSION["payge"]; ?>&page=<?php echo $_SESSION["pagenum"]; ?>&delimit=<?php echo $_SESSION["delimit"]; ?>&SortBy=<?php echo $_SESSION["SortBy"]; ?>&searchID=<?php echo $_SESSION["searchID"]; ?>&filter=<?php echo $_SESSION["filter"]; ?>&mayneger=<?php echo $_SESSION["mayneger"]; ?>&hiddenf=<?php echo $_SESSION["hiddenf"]; ?>&SortOrder=<?php echo $_SESSION["SortOrder"]; ?>";
self.close();
//-->
}

function validate_form(thisform)
{
	if (thisform.type.value==="" || thisform.type.value===null) {
		alert("Please select Type First");
		thisform.type.focus();
		return false;
	}
	if (thisform.accounts.value==="--Click--" || thisform.accounts.value===null || thisform.accounts.value==="") {
		alert("Please select account");
		thisform.accounts.focus();
		return false;
	}
	if (thisform.aydis.value==="" || thisform.aydis.value===null) {
		alert("ID Cannot be blank");
		thisform.aydis.focus();
		return false;
	}
	if (thisform.amount.value==="" || thisform.aydis.value===null) {
		alert("Amount Cannot be blank");
		thisform.amount.focus();
		return false;
	}
	if (isNaN(thisform.amount.value)) {
		alert("Amount should only be Numeric");
		thisform.amount.focus();
		return false;
	}
	window.opener.location.href="viewallmemberb.php?payge=<?php echo $_SESSION["payge"]; ?>&page=<?php echo $_SESSION["pagenum"]; ?>&delimit=<?php echo $_SESSION["delimit"]; ?>&SortBy=<?php echo $_SESSION["SortBy"]; ?>&searchID=<?php echo $_SESSION["searchID"]; ?>&filter=<?php echo $_SESSION["filter"]; ?>&mayneger=<?php echo $_SESSION["mayneger"]; ?>&hiddenf=<?php echo $_SESSION["hiddenf"]; ?>&SortOrder=<?php echo $_SESSION["SortOrder"]; ?>";
}
</SCRIPT>
<script type="text/javascript">
	$(function() {
		$("#inputDate").datepicker({showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true});
	});
	</script>
<script type="text/javascript">
function AjaxFunction(command)
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
//alert(httpxml.responseText);
//document.addinfo.sort.style='';
//typeko = document.getElementById("type");
//element = document.getElementById("sort");
//alert(typeko.value);
//if (typeko.value=='' || typeko.value==null)
//element.style.display = '';
//else
//element.style.display = 'table-row';
/*element = document.getElementById('sort');
element.style.display = 'inline';
*/
//alert(command);
var myarray=eval(httpxml.responseText);
var myarray=eval(httpxml.responseText);
// Before adding new we must remove previously loaded elements
for (j=document.addinfo.accounts.options.length-1;j>=0;j--)
{
document.addinfo.accounts.remove(j);
}


for (i=0;i<myarray.length;i++)
{
var optn = document.createElement("OPTION");
//var fafa = myarray[i].split("%");
//alert(myarray[i]);
optn.value = myarray[i];
optn.text = myarray[i];
//if (fafa[1]!=undefined) { optn.text = fafa[0] + " [" + fafa[1] + "]"; }
//else { optn.text = fafa[0]; }
document.addinfo.accounts.options.add(optn);
} 
      }
    }
var url="gg.php";
url=url+"?command="+command;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
  }
</script>
<SCRIPT LANGUAGE="JavaScript">


function checkAll(field,exby) {
for (i = 0; i < field.length; i++)
	field[i].checked = exby.checked? true:false
}
</script>

<script type="text/javascript">
function AjaxRefresh()
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
	 // alert("ok");
window.opener.location.href="viewallmemberb.php?payge=<?php echo $_SESSION["payge"]; ?>&page=<?php echo $_SESSION["pagenum"]; ?>&delimit=<?php echo $_SESSION["delimit"]; ?>&SortBy=<?php echo $_SESSION["SortBy"]; ?>&searchID=<?php echo $_SESSION["searchID"]; ?>&filter=<?php echo $_SESSION["filter"]; ?>&mayneger=<?php echo $_SESSION["mayneger"]; ?>&hiddenf=<?php echo $_SESSION["hiddenf"]; ?>&SortOrder=<?php echo $_SESSION["SortOrder"]; ?>";
      }
    }
var url="rr.php";
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
  }
</script>


<link href="style.css" rel="stylesheet" type="text/css">
<!--<link rel="stylesheet" href="css/datepicker.css" type="text/css" />-->

<!--<link rel="stylesheet" href="style.css" type="text/css" />
-->
</head>
<!--<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0" onLoad="CountCheck();">-->
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0">
<table border="0" cellpadding="0" cellspacing="0" width="80%" align="center">
	<tr>
	  <td align="center"><span class="bn13text"> <b><?php echo $memberid; ?></b> Details<br>
  </span></td>
	</tr>
  <td>
  <?php if($action=='aditional'){
  echo "<a href='viewmemberdetailsb.php' target='_self'><img border='0' src='images/cancel.gif' align=left></a>";}
  else{
  echo"<span class='bn13textwhite15'><a href='viewmemberdetailsb.php?action=aditional' target='_self'><img border='0' src='images/new.jpg' align=left></a>&nbsp;&nbsp;&nbsp;";
  
  if ($total<0)
			echo "Gross Total : <span class='bn13textred15'>$$total</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Gross Total : <span class='bn13textskyblue'>$$total</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			echo "Outstanding : <span class='bn13textred15'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
		else
			echo "Outstanding : <span class='bn13textskyblue'>$$outstanding</span>&nbsp;&nbsp;&nbsp;";
	
	if ($paydue<0)
			echo "Amt Due : <span class='bn13textred15'>$$paydue</span>";
		else
			echo "Amt Due : <span class='bn13textskyblue'>$$paydue</span>";
					
 // &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Outstanding : $$outstanding&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pending Due : $$paydue</span	>";
  
  }
  ?>
</td>
</table>
<?php
if($action=='aditional'){
if($action<>'edit'){
	$det = date('m/d/Y');
	echo "<form action='viewmemberdetailsb.php' method='post' name='addinfo' style='margin-bottom:0;' onsubmit='return validate_form(this);'>
<table bgcolor='#FFEFC6' border='1' cellpadding='0' cellspacing='0' width='80%' align='center' >
	  <tr>
    <td width='30%'><span class='bn13text'>&nbsp;Data Entry: &nbsp; 
	<select name='type' class='searchformfiled' onChange='AjaxFunction(this.value)' >
	<option value='' selected='selected'>--Click--</option>
          <option value='PLACEOUT' >W/L Placeout</option>
		  <option value='PAYMENT'>Payment</option>
        </select> </span></td>
    <td colspan='2' width='40%'><span class='bn13text'>&nbsp;Account:
	
	<select name='accounts' class='searchformfiled' >
			<option value=''>--Click--</option></select></span>
	</td>
    <td rowspan='5' >
	<table align='center' border='1' cellpadding='10' cellspacing='10' width='70%'>
        <tr>
          <td><span class='bn13text'>Total</span></td>
          <td align='right'><span class='bn13text'>$total</span></td>
        </tr>
		<tr>
          <td><span class='bn13text'>Outstanding</span></td>
          <td align='right'><span class='bn13text'>$outstanding</span></td>
        </tr>
        <tr>
          <td><span class='bn13text'>Amt Due </span></td>
          <td align='right'><span class='bn13text'>$paydue</span></td>
        </tr>
      </table>
	</td>
  </tr>";
	echo "<tr><td><span class='bn13text'>&nbsp;ID: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<select name='aydis' class='searchformfiled' >        <option value='$memberid' selected='selected'>$memberid</option>";
			//}
	/*else // assume it's subid
	{
		$memberlistsub=mysql_query("SELECT memberid FROM submembers where subid = '$memberid'");
		$mainmember=mysql_result($memberlistsub,0,"memberid");
		$memlist = $mainmember;
	
	while ($row_memberlistsub = mysql_fetch_array($memberlistsub)) 
		{
			if ($memlist=="") {
				$memlist = $row_memberlistsub[0];
			}
			else
			{		
				$memlist = $memlist . "," . $row_memberlistsub[0];
			}
		}
	
	}*/
	
	
		//-=-=-=-=		
				
				$pasabog = explode(",",$memlist);
				$bilanggo = count($pasabog);
				//echo "count: " . $bilanggo;
				//echo $pasabog[0] . "<br>";
				//echo $pasabog[1] . "<br>";
	 //	$aydis=mysql_query("SELECT subid FROM submembers where memberid='$submembers'");
		//	$aydisrow=mysql_num_rows($aydis);
			for($count=0; $count<$bilanggo; $count++)
			{
			//$data=mysql_result($aydis,$count,"subid");
			echo "<option value='$pasabog[$count]'>$pasabog[$count]</option>";
			}
	
	$hehey = date('m/d/Y');
	//echo "</td><td ><span class='bn13text'>Date:</span><input name='datetime' class='inputDate' id='inputDate' value='$det' readonly='true' /><img src='images/pikpik.gif' width='20' height='20' class='inputDate'></td>
	echo "</td><td align='left' nowrap class='text11'>
		  <div class='demo'>&nbsp;<span class='bn13text'>Date:</span> <input type='text' id='inputDate' name='datetime' value='$hehey' readonly='true' style='width:80px'></div></td></tr>";
 echo "<tr>
    <td colspan='3'><span class='bn13text'>&nbsp;Amount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='text' size='15' name='amount' maxlength='20' value='$amount'>
	<select name='currency' class='searchformfiled' >
                <option value='SGD' selected='selected'>SGD</option>";
	 	$currencysql=mysql_query("SELECT currencycode FROM currency");
			$currencysqlrow=mysql_num_rows($currencysql);
			for($count=0; $count<$currencysqlrow; $count++)
			{$data=mysql_result($currencysql,$count,"currencycode");
			echo "<option value='$data'>$data</option>";}
echo"	<span></td>
  </tr>
  <tr>
    <td colspan='3'><span class='bn13text'>&nbsp;Remarks: &nbsp;&nbsp;&nbsp; <input type='text' name='remarks' size='25' maxlength='50' value='$remarks'></span></td>
  </tr>
  <tr>
    <td colspan='3' align='center'><input type='submit' name='Insert' value='Insert' title='Add New Member'><!--&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewmemberdetailsb.php'\" title='Cancel'>--></td>
  </tr>";
	
	
	
	echo"</table>
	</td></tr>";
	echo "<tr></tr>";
	echo"</form>";
	}                 }
	
if($action=='edit'){
	$referee=$_GET["ref"];
//	echo $_GET["methodz"];
	if ($_GET["methodz"]=='payment') {
		$editbm=mysql_query("select * from bmdatabase_payment where ref='$referee'");
		//echo "select * from bmdatabase_payment where ref='$referee'"; 
		}
	else {
		$editbm=mysql_query("select * from bmdatabase_wlplaceout where ref='$referee'");
		//echo "select * from bmdatabase_wlplaceout where ref='$referee'";
		 }
	
	$bmdate=mysql_result($editbm,$count,"bmdate");
	$memberid_active=mysql_result($editbm,$count,"memberid");
	//echo $memberid;
	$remark=mysql_result($editbm,$count,"remark");
	$amount=mysql_result($editbm,$count,"amount");
	$cpyaccount=mysql_result($editbm,$count,"cpyaccount");
	$currencycode=mysql_result($editbm,$count,"currencycode");
	//$type=mysql_result($editbm,$count,"type");
	$subbmcode=mysql_result($editbm,$count,"subbmcode");
	$shabug=explode("-",$bmdate);
	$newdit =  $shabug[1] . "/" . substr($shabug[2],0,2) . "/" . $shabug[0];
	$det = $newdit; //date('m/d/Y');
	echo "<form action='viewmemberdetailsb.php' method='post' name='info' style='margin-bottom:0;' >";
	echo"<tr><td align='center'><table bgcolor='#FFEFC6' border='0' cellpadding='0' cellspacing='0' width='80%' align='center' class='outline'><tr><td height='10' colspan='7'></td></tr><tr><td align='right' ><span class='bn13text'>Date&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><input name='datetime' class='inputDate' id='inputDate' value='$det' readonly='true' />";
	

	  echo "</select></td><td align='right' ><span class='bn13text'>ID&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'>
	  <select name='currency' class='searchformfiled' >
                <option value='submembers' selected='selected'>$memberid_active</option>";
	 	$aydis=mysql_query("SELECT subid FROM submembers where memberid='submembers'");
			$aydisrow=mysql_num_rows($aydis);
			for($count=0; $count<$aydisrow; $count++)
			{$data=mysql_result($aydis,$count,"subid");
			echo "<option value='$data'>$data</option>";}

	echo "</select><td align='right' ></td><tr><td align='right' ><span class='bn13text'>Remarks&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><input type='text' name='remarks' size='25' maxlength='50' value='$remark'>
	<td align='right' ><span class='bn13text'>Amount&nbsp;</span></td></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><span class='bn12text'><input type='text' size='15' name='amount' maxlength='20' value='$amount'></span>
	<select name='currency' class='searchformfiled' >
                <option value='SGD' selected='selected'>SGD</option>";
	 	$currencysql=mysql_query("SELECT currencycode FROM currency");
			$currencysqlrow=mysql_num_rows($currencysql);
			for($count=0; $count<$currencysqlrow; $count++)
			{$data=mysql_result($currencysql,$count,"currencycode");
			echo "<option value='$data'>$data</option>";}
       
	echo "</select></td></tr><tr><td align='right' ><span class='bn13text'>Type&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'><select name='type' class='searchformfiled' onChange='AjaxFunction(this.value)' >";
	
	if ($_GET["methodz"]=='payment')
		echo "<option value='PAYMENT' selected='selected'>Payment</option>";
	else if ($_GET["methodz"]=='placeout')
		echo "<option value='PLACEOUT' selected='selected'>W/L Placeout</option>";
	else
	echo "<option value='' selected='selected'>--Click--</option>";

	echo "<option value='PLACEOUT' >W/L Placeout</option>
		  <option value='PAYMENT'>Payment</option>
        </select>&nbsp;";
	
	echo"</td><td align='right' ><span class='bn13text'>Account&nbsp;</span></td><td align='center' ><span class='bn13text'>:</span></td><td align='left'>
	<select name='accounts' class='searchformfiled' >";
	if ($subbmcode<>"")
		echo "<option value='$subbmcode'>$subbmcode</option></select></td></tr>";
	if ($cpyaccount<>"")
		echo "<option value='$cpyaccount'>$cpyaccount</option></select></td></tr>";
	//else
	//	echo "<option value=''>--Click--</option></select></td></tr>";
		echo"<tr><td colspan='6' align='center'><input type='submit' name='action' value='Update' title='Update Details'>&nbsp;<input type='button' value='Cancel' onClick=\"window.location.href='viewmemberdetailsb.php'\" title='Cancel'></td></tr><input type='hidden' name='refy' value='$referee'></form>";
  echo"<tr><td height='10' colspan='4'></td></tr>";
	echo"</table>
	</td></tr>";echo "<tr><td height='8'></td></tr>";
	echo"</form>";}
	?>
<br>

<strong>

    <?php
//	echo $memberid;
	$bmsql=mysql_query("(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid' $hide_me)) union
	(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid = '$memberid' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' $hide_me order by bmdate desc) and NOT type = 'INT' $hide_me) order by (case when memberid = '$memberid' then 0 else 1 end),memberid asc,bmdate desc, ref desc");

//echo "(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid' $hide_me)) union(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid = '$memberid' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' $hide_me order by bmdate desc) and NOT type = 'INT' $hide_me) order by (case when memberid = '$memberid' then 0 else 1 end),bmdate desc, ref desc" . "<br>";
	
//ORDER BY (case when number is null then 0 else 1 end), id
//echo "(SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,cpyaccount,pm,clr,remark FROM bmdatabase_payment where memberid in (select subid from submembers where memberid='$memberid' $hide_me)) union(SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid = '$memberid' $hide_me) union (SELECT ref,bmdate,entriesby,memberid,amount,type,subbmcode,pm,clr,remark FROM bmdatabase_wlplaceout where memberid in (select subid from submembers where memberid='$memberid' $hide_me order by bmdate desc) and NOT type = 'INT' $hide_me) order by memberid,bmdate desc, ref desc";
	 
	if($once==0) {
	$mum=mysql_result($bmsql,0,"memberid");
	?>
	<form name="member_details" action="viewmemberdetailsb.php" method="post" onSubmit="return validate()">
	<table border="1" cellpadding="0" cellspacing="0" width="90%" align="center" class="stats">
	<tr>
	<td colspan="10" align="right">
	  <span class="bn13text">
  Show Hidden <b>
<?php  if ($hiddenf==0) { ?>
    <input type="checkbox" name="hiddenf" onClick="document.member_details.submit();" value="1">
	<?php } else { ?>
	<input type="checkbox" name="hiddenf" onClick="document.member_details.submit();" value="1" checked="checked">
	<?php } ?>
  </b></span>
	</td>
	</tr>
<tr align="center">
<td><span class="bn13text"><?php echo $mum; ?></span>
  <td colspan="6" width="350px" align="left" class="hedacheblack"><span class="bn13text">
  <?php
$indivmem=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='0')) 
 as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberid' and pm='1')) 
 FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberid' and NOT type = 'INT' and pm='0'");

$outstanding2=mysql_result($indivmem,0,"outstanding");
$pmdue2=mysql_result($indivmem,0,"pmdue");
$total2 = $outstanding2 + $pmdue2;

if ($total2<0)
			echo "<b>Sub Total : <span class='bn13textred12'>$$total2</span></b>&nbsp;&nbsp;&nbsp;";
		else
			echo "<b>Sub Total : <span class='bn13textskybluer'>$$total2</span></b>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			echo "<b>Outstanding : <span class='bn13textred12'>$$outstanding2</span></b>&nbsp;&nbsp;&nbsp;";
		else
			echo "<b>Outstanding : <span class='bn13textskybluer'>$$outstanding2</span></b>&nbsp;&nbsp;&nbsp;";
	
	if ($pmdue2<0)
			echo "<b>Amt Due : <span class='bn13textred12'>$$pmdue2</span></b>";
		else
			echo "<b>Amt Due : <span class='bn13textskybluer'>$$pmdue2</span></b>";
?>
 </td>
  <td><span class="bn13text">D</span></td><td><span class="bn13text">H</span></td><td>
  <input name="hideme" type="hidden" value="">
  <input type="Submit" name="Save" value="Save" class="formButton" onClick="AjaxRefresh();"> 
  </td></tr>
<tr >
    
<td class="hed" width="20%"><span class="bn13text"><b>Date</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>ID</b></span></td>
<td class="hed" width="5%"><span class="bn13text"><b>@</b></span></td>
<td class="hed"  width="10%"><span class="bn13text"><b>Subbmcode</b></span></td>
<td class="hed"  width="10%"><span class="bn13text"><b>Accounts</b></span></td>
<td class="hed" width="10%"><span class="bn13text"><b>Amount</b></span></td>
<td class="hed" width="35%"><span class="bn13text"><b>Remarks</b></span></td>
<td class="hed"  width="5%"><span class="bn13text"><b><input type="checkbox" name="allp"  onClick="checkAll(document.member_details['check_listp[]'],this)"></b></span></td>
 <td class="hed"  width="5%"><span class="bn13text"><b><input type="checkbox" name="allh" onClick="checkAll(document.member_details['check_listh[]'],this)" ></b></span></td>
 <td class="hed"  width="10%"><span class="bn13text"><b>Action</b></span></td>
</tr>
	
	
	<?php
	//echo "3333";
	$once=1;
	//echo $once;
	}
	$bmrow=mysql_num_rows($bmsql);
	for($count=0; $count<$bmrow; $count++)
	{
	$mim=mysql_result($bmsql,$count,"memberid");
//	echo $mim . "<br>";
	//echo $temp_member . "<br>";;

	//$ref=mysql_result($bmsql,$count,"ref");
	//echo "<td align='center'><span class='bn13text'>$ref</span></td>";
	$bmdate=mysql_result($bmsql,$count,"bmdate");
	$bbb=strtotime(str_replace("-", "/",$bmdate));
	$bmdate=date("D, j M Y",$bbb);
	echo "<td align='center'><span class='bn13text'>$bmdate</span></td>";
	
	$memberid=mysql_result($bmsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";
	//echo "<td align='center'><span class='bn13text'>-</span></td>";
	//$type=mysql_result($bmsql,$count,"type");
/*	echo "<td align='center'><span class='bn13text'>$type</span></td>";
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");*/
	/*$type=mysql_result($bmsql,$count,"type");
	echo "<td align='center'><span class='bn13text'>$type</span></td>";*/
	$cpyaccount=mysql_result($bmsql,$count,"cpyaccount");
	$bmcode=mysql_query("SELECT bmcode FROM bmcode where subbmcode='$cpyaccount'");
	$atsign=mysql_result($bmcode,0,"bmcode");
	$bilangin = mysql_num_rows($bmcode);
//	echo $bilangin . "<br>";
//	echo $atsign . "<br>";
	if ($bilangin<>0)
	echo "<td align='center'><span class='bn13text'>$atsign</span></td>";
	else
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	
	
	if ($bilangin==0) {
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	}
	else {
	echo "<td align='center'><span class='bn13text'>$cpyaccount</span></td>";
	echo "<td align='center'><span class='bn13text'>-</span></td>";	
	}
/*	$memberid=mysql_result($bmsql,$count,"memberid");
	echo "<td align='center'><span class='bn13text'>$memberid</span></td>";*/
	$amount=mysql_result($bmsql,$count,"amount");
	$amount2 = number_format($amount,2);
	//echo "<td align='center'><span class='bn13text'>$amount2</span></td>";
		if ($amount2<0)
		echo "<td align='center'><span class='bn13text'><font color='red'>$amount2</font></span></td>";
		else
		echo "<td align='center'><span class='bn13text'><font color='blue'>$amount2</font></span></td>";
	$remark=mysql_result($bmsql,$count,"remark");
	if ($remark<>"")
	echo "<td align='center'><span class='bn13text'>$remark</span></td>";
	else
	echo "<td align='center'><span class='bn13text'>-</span></td>";
	//$clr=strtoupper(mysql_result($bmsql,$count,"clr"));
	$clr=mysql_result($bmsql,$count,"clr");
//	if ($clr==0) {
	$superamount=$superamount+$amount;
	$super_dummy = number_format($superamount,2);
	$final_amount = $final_amount + $amount;
//	}
//	echo $superamount . "<br>";
	/*$entriesby=strtoupper(mysql_result($bmsql,$count,"entriesby"));
	echo "<td align='center'><span class='bn13text'>$entriesby</span></td>";*/
		//pm and clr
	$ref=strtoupper(mysql_result($bmsql,$count,"ref"));
	
	if ($ref_collect=="")
	$ref_collect = $ref;
	else
	$ref_collect = $ref_collect . "," . $ref;
	
	if ($atsign=="") {
		if ($ref_collectp=="")
		$ref_collectp = $ref;
		else
		$ref_collectp = $ref_collectp . "," . $ref;
	}
	else
	{
		if ($ref_collectw=="")
		$ref_collectw = $ref;
		else
		$ref_collectw = $ref_collectw . "," . $ref;
	}
		
	$pm=strtoupper(mysql_result($bmsql,$count,"pm"));
	
	if ($pm==0) {
		if ($bilangin<>0)
		{echo "<td align='center'><input type='checkbox' name='check_listp[]' value='$ref%placeout'></td>";}
		else
		{echo "<td align='center'><input type='checkbox' name='check_listp[]' value='$ref%payment'></td>";
	//	echo "1-$ref%payment" . "<br>";
		}
	}
	else {
		if ($bilangin<>0)
		{echo "<td align='center'><input type='checkbox' name='check_listp[]'  value='$ref%placeout' checked='checked'></td>";}
		else
		{echo "<td align='center'><input type='checkbox' name='check_listp[]' value='$ref%payment' checked='checked'></td>";
	//	echo "2-$ref%payment" . "<br>";
		}
	}
	
	$clr=strtoupper(mysql_result($bmsql,$count,"clr"));
	if ($clr==0) {
		if ($bilangin<>0)
		{echo "<td align='center'><input type='checkbox' name='check_listh[]' value='$ref%placeout'></td>";
	//	echo "$ref%placeout" . "<br>";
		}
		else
		{echo "<td align='center'><input type='checkbox' name='check_listh[]' value='$ref%payment'></td>";
	//	echo "$ref%payment" . "<br>";
		}
	}
	else {
		if ($bilangin<>0)
		{echo "<td align='center'><input type='checkbox' name='check_listh[]' value='$ref%placeout' checked='checked'></td>";
	//	echo "$ref%placeout" . "<br>";
		}
		else
		{echo "<td align='center'><input type='checkbox' name='check_listh[]' value='$ref%payment' checked='checked'></td>";
	//	echo "$ref%payment" . "<br>";
		}
	}
	
	if ($bilangin<>0) {
	echo "<td align='center'><span class='bn12text'><a href='viewmemberdetailsb.php?action=edit&ref=$ref&methodz=placeout' target='_self'><img src='images/edit.gif' border='0' title='Edit'><a href='viewmemberdetailsb.php?action=delete&ref=$ref&methody=placeout' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></span>
	
	</td>";
	}
	else
	{
	echo "<td align='center'><span class='bn12text'><a href='viewmemberdetailsb.php?action=edit&ref=$ref&methodz=payment' target='_self'><img src='images/edit.gif' border='0' title='Edit'><a href='viewmemberdetailsb.php?action=delete&ref=$ref&methody=payment' target='_self' onclick=\"return confirm('You Are About To Delete!');\"><img src='images/trash.gif' border='0' title='Delete'></a></span>
	
	</td>";
	}
	echo "</td></tr>";
	$memberidadv=mysql_result($bmsql,$count+1,"memberid");
//	echo "tae1: " . $mim . "<>" . $memberid . "<br>";	
//	echo "tae2: " . $mim . "<>" . $memberidadv . "<br>";
	if ($mim<>$memberid || $mim<>$memberidadv && $memberidadv<>"") {
		if ($super_dummy<0) {
		//echo "<tr bgcolor='#888888'><td colspan='5' align='center' class='hed'><span class='bn13text'><b>Sub Total</b></span></td><td class='hed' ><span class='bn13text'><b><font color='red'>$super_dummy</font></b></span></td><td colspan='4' class='hed'></td></tr>";
		$indivmem=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='0')) 
 as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='1')) 
 FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='0'");

$outstanding2=mysql_result($indivmem,0,"outstanding");
$pmdue2=mysql_result($indivmem,0,"pmdue");
$total2 = $outstanding2 + $pmdue2;

	if ($total2<0)
			$gtot = "Sub Total : <span class='bn13textred12'>$$total2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gtot = "Sub Total : <span class='bn13textskybluer'>$$total2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			$gout = "Outstanding : <span class='bn13textred12'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gout = "Outstanding : <span class='bn13textskybluer'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($pmdue2<0)
			$gdue = "Amt Due : <span class='bn13textred12'>$$pmdue2</span>";
		else
			$gdue = "Amt Due : <span class='bn13textskybluer'>$$pmdue2</span>";
	
	
	//if ($super_dummy<0)
	echo "
	<tr><td colspan='10' height='30px' class='mates'></td><tr>
	<tr bgcolor='#888888'><td ><span class='bn13text'>$memberidadv</span></td><td colspan='6' align='center' class='hedacheblack'><span class='bn13text'><b>$gtot $gout 	$gdue</b></span></td> <td><span class='bn13text'>D</span></td><td><span class='bn13text'>H</span></td><td>
  <input name='hideme' type='hidden' value=''>
  <input type='Submit' name='Save' value='Save' class='formButton' onClick='AjaxRefresh();'> 
  </td></tr><tr >   
<td class='hed' width='20%'><span class='bn13text'><b>Date</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>ID</b></span></td>
<td class='hed' width='5%'><span class='bn13text'><b>@</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Subbmcode</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Accounts</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>Amount</b></span></td>
<td class='hed' width='35%'><span class='bn13text'><b>Remarks</b></span></td>
<td class='hed'  width='5%'></td> <td class='hed'  width='5%'></td> <td class='hed'  width='10%'><span class='bn13text'><b>Action</b></span></td></tr>";
		}
		else { 
	//	echo "super dummy: " . $super_dummy;
	//	echo "<br>" . "jerbax" . "<br>";
		$indivmem=mysql_query("SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='0')) 
 as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='1')) 
 FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='0'");

// echo "SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='0'))  as outstanding, (SELECT (ifnull(SUM(amount),0) + (SELECT ifnull(SUM(amount),0) FROM bmdatabase_wlplaceout where memberid = '$memberidadv' and pm='1'))  FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='1') as pmdue FROM bmdatabase_payment where memberid = '$memberidadv' and NOT type = 'INT' and pm='0'" . "<br><br>";

$outstanding2=mysql_result($indivmem,0,"outstanding");
$pmdue2=mysql_result($indivmem,0,"pmdue");
$total2 = $outstanding2 + $pmdue2;

	if ($total2<0)
			$gtot = "Sub Total : <span class='bn13textred12'>$$total2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gtot = "Sub Total : <span class='bn13textskybluer'>$$total2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($outstanding<0)
			$gout = "Outstanding : <span class='bn13textred12'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
		else
			$gout = "Outstanding : <span class='bn13textskybluer'>$$outstanding2</span>&nbsp;&nbsp;&nbsp;";
	
	if ($pmdue2<0)
			$gdue = "Amt Due : <span class='bn13textred12'>$$pmdue2</span>";
		else
			$gdue = "Amt Due : <span class='bn13textskybluer'>$$pmdue2</span>";
	
	
	//if ($super_dummy<0)
	echo "
	<tr><td colspan='10' height='30px' class='mates'></td><tr>
	<tr bgcolor='#888888'><td ><span class='bn13text'>$memberidadv</span></td><td colspan='6' align='center' class='hedacheblack'><span class='bn13text'><b>$gtot $gout 	$gdue</b></span></td> <td><span class='bn13text'>D</span></td><td><span class='bn13text'>H</span></td><td>
  <input name='hideme' type='hidden' value=''>
  <input type='Submit' name='Save' value='Save' class='formButton' onClick='AjaxRefresh();'> 
  </td></tr><tr >   
<td class='hed' width='20%'><span class='bn13text'><b>Date</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>ID</b></span></td>
<td class='hed' width='5%'><span class='bn13text'><b>@</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Subbmcode</b></span></td>
<td class='hed'  width='10%'><span class='bn13text'><b>Accounts</b></span></td>
<td class='hed' width='10%'><span class='bn13text'><b>Amount</b></span></td>
<td class='hed' width='35%'><span class='bn13text'><b>Remarks</b></span></td>
<td class='hed'  width='5%'><span class='bn13text'><b><input type='checkbox' name='allp$mim'  onClick=\"checkAll(document.member_details['check_listp".$mim."[]'],this)\"></b></span></td> <td class='hed'  width='5%'><span class='bn13text'><b><input type='checkbox' name='allp$mim' onClick=\"checkAll(document.member_details['check_listh".$mim."[]'],this)\"></b></span></td> <td class='hed'  width='10%'><span class='bn13text'><b>Action</b></span></td></tr>";
		//echo "<tr bgcolor='#888888'><td colspan='5' align='center'  class='hed'><span class='bn13text'><b>Sub Total</b></span></td><td class='hed'><span class='bn13text'><b><font color='red'>$super_dummy</font></b></span></td><td colspan='4' class='hed'></td></tr>";
		$superamount=0;
		$once=0;
		}
		}
//		}
	}
	?>
	<input type='hidden' name='refcol' value='<?php echo $ref_collect; ?>'>
	<input type='hidden' name='refcolw' value='<?php echo $ref_collectw; ?>'>
	<input type='hidden' name='refcolp' value='<?php echo $ref_collectp; ?>'>
	</form>
<tr><td colspan="10" align="center" bgcolor="#888888" class="hedache"><span class="bn13text"><b>Gross Total: <?php 
	if ($final_amount<0)
	echo "<font color='red'>" . number_format($final_amount,2) . "</font>";
	else
	echo number_format($final_amount,2);

?></b></span></td></tr>
<table align="center">
<tr>
<td>
<input type=button onClick="win();" value="Close Window">
</td></tr></table>
</body>
</html>