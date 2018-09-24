<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Report</li>
		<li class="divider"></li>
		<li>Daily Deployment</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Daily Collection</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">

			<table cellpadding="0" cellspacing="0" align="center" width="99%" border="0" >
				<tr><td height="6"></td></tr>
				<tr><td background="<?php echo base_url();?>public/images/header.jpg" width="250" bgcolor="#DDDDDD"><span class="wb13text">&nbsp;Daily Collection</span></td><td bgcolor="#DDDDDD" width="70%"></td><td bgcolor="#DDDDDD" align="right"></td></tr></table>
			<?php
				$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
				if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
				if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
				
				$cMonth = $_REQUEST["month"];
				$cYear  = $_REQUEST["year"];

				$prev_year = $cYear;
				$next_year = $cYear;

				$prev_month = $cMonth-1;
				$next_month = $cMonth+1;

				if ($prev_month == 0 ) {
				$prev_month = 12;
				$prev_year = $cYear - 1;}
				if ($next_month == 13 ) {
				$next_month = 1;
				$next_year = $cYear + 1;}?>
				<table width="99%" align="center" cellpadding="0" cellspacing="0" border="1">
					<tr align="center">
					<td style="color:#FFFFFF">
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td background="<?php echo base_url();?>public/images/navbg.jpg" width="10%" align="left" link="#ffffff">&nbsp;&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" STYLE="TEXT-DECORATION: NONE"><img src="<?php echo base_url();?>public/images/icon/arrowleft.gif" border="0" ></a></td>
					<td background="<?php echo base_url();?>public/images/navbg.jpg" width="80%" align="center"><span class="wb13text"><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></span></td>
					<td background="<?php echo base_url();?>public/images/navbg.jpg" width="10%" align="right" link="#ffffff"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" STYLE="TEXT-DECORATION: NONE"><img src="<?php echo base_url();?>public/images/icon/arrowright.gif" border="0" ></a>&nbsp;&nbsp;</td>
					</tr>
				</table>
					</td></tr>
				<tr>
				<td align="center">
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr style="background: #37A6CD">
						<td align="center" width="14%"><span class="wb13text">Sunday</span></td>
						<td align="center" width="14%"><span class="wb13text">Monday</span></td>
						<td align="center" width="14%"><span class="wb13text">Tuesday</span></td>
						<td align="center" width="14%"><span class="wb13text">Wednesday</span></td>
						<td align="center" width="14%"><span class="wb13text">Thursday</span></td>
						<td align="center" width="14%"><span class="wb13text">Friday</span></td>
						<td align="center" width="14%"><span class="wb13text">Saturday</span></td>
					</tr>

			<?php
				$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
				$maxday    = date("t",$timestamp);
				$thismonth = getdate ($timestamp);
				$startday  = $thismonth['wday'];
				$tday	   = $_GET[tday];
				if($tday==NULL){$tday=date("j");}//change from d to j

				for ($i=0; $i<($maxday+$startday); $i++) {
					if(($i % 7) == 0 ) echo "<tr>\n";
					if($i < $startday) echo "<td align='top' valign='top' height='45' style='border:solid 1px #DDDDDD'></td>";
					 else{
						$day=$i - $startday + 1;
						$today=date("Y-n-j");
						$now="$cYear-$cMonth-$day";
			if($today==$now){echo"<td bgcolor='#DDDDDD' align='top' valign='top' height='40' style='border:solid 1px #DDDDDD'><span class='bn12text'>";}
			else{echo"<td align='top' valign='top' height='40' style='border:solid 1px #DDDDDD'>";}
				
				echo "&nbsp;<a href='collection?month=$cMonth&year=$cYear&tday=$day' STYLE='text-decoration:none'><span class='bn12text'><b>$day</b></span></a>";
			if($repaymentrow>0){echo "<br><a href='collection?month=$cMonth&year=$cYear&tday=$day' STYLE='text-decoration:none'><span class='rb13text'>&nbsp;$repaymentrow Collections</span></a>";}
			echo "<br><a href='collection?month=$cMonth&year=$cYear&tday=$day' STYLE='text-decoration:none'><span class='rb13text'>&nbsp;Net P/L: $132,320</span></a></td>";}
			if(($i % 7) == 6 ) echo "</tr>";}?>
			</table></td></tr></table>
			<table cellpadding="0" cellspacing="0" align="center" width="99%" border="0" >
			<tr><td height="5"></td></tr>
			<tr><td background="<?php echo base_url();?>public/images/header.jpg" width="250" bgcolor="#DDDDDD">&nbsp;<span class="wb13text"> Collection for <?php
				$monthname=$monthNames[$cMonth-1];
				 echo"$tday $monthname $cYear"; ?></span></td><td bgcolor="#DDDDDD" width="30" valign="baseline" align="center"><a href="printpreview.php?<?php echo "day=$tday&month=$cMonth&year=$cYear";?>" target="_blank" STYLE='text-decoration: none' title="Print Preview"><img src="<?php echo base_url();?>public/images/preview.gif" border="0"></a></td><td bgcolor="#DDDDDD" width="30" valign="baseline" align="center"><img src="<?php echo base_url();?>public/images/space.gif" border="0" width="10"><a href="overduepreview.php?<?php echo "day=$tday&month=$cMonth&year=$cYear";?>" target="_blank" STYLE='text-decoration: none' title="Print OverDue"><img src="<?php echo base_url();?>public/images/overduepreview.gif" border="0"></a></td><td bgcolor="#DDDDDD"><img src="<?php echo base_url();?>public/images/space.gif" border="0" width="10"><?php 
				 if($_GET[overdue]=='yes')
				 	{echo"<a href='collection?month=$cMonth&year=$cYear&tday=$tday' title='Overdue'><img src='<?php echo base_url();?>public/images/overdue.gif' border='0'></a>";}
				else
					{echo"<a href='collection?overdue=yes&month=$cMonth&year=$cYear&tday=$tday' title='Overdue'><img src='<?php echo base_url();?>public/images/overdue.gif' border='0'></a>";}?></td></tr>
			</table>
			
				<table align='center' cellpadding='0' cellspacing='0' border='1' width='99%'>
				<tr bordercolor='#000000'>
					<td align='center' background='<?php echo base_url();?>public/images/navbg.jpg'><span class='wb13text'>&nbsp;#&nbsp;</span></td><td align='center' background='<?php echo base_url();?>public/images/navbg.jpg'><span class='wb13text'>Loan No.</span></td><td align='center' background='<?php echo base_url();?>public/images/navbg.jpg'><span class='wb13text'>Name</span></td><td align='center' background='<?php echo base_url();?>public/images/navbg.jpg'><span class='wb13text'>&nbsp;Amount&nbsp;</span></td><td align='center' background='<?php echo base_url();?>public/images/navbg.jpg'><span class='wb13text'>&nbsp;Due Date&nbsp;</span></td>";
				
					<td align='center' background='<?php echo base_url();?>public/images/navbg.jpg' colspan='2'><span class='wb13text'>Address (1)</span></td><td align='center' background='<?php echo base_url();?>public/images/navbg.jpg'><span class='wb13text'>Repayment Remarks</span></td></tr>;

			<?php

			$sqldata=mysql_query("SELECT code FROM company WHERE company='$webcompany'");
			$sqlrow=mysql_num_rows($sqldata);
			if($sqlrow=='1'){$code=mysql_result($sqldata,0,"code");}

			$repaymentdata=mysql_query("SELECT * FROM loan, repayment, clients WHERE loan.hidden='0' AND clients.hidden='0' AND repayment.hidden='0' AND loan.loanid=repayment.loanid AND loan.loanid=clients.loanid AND clients.status='BORROWER' AND loan.company='$webcompany' AND DAY(repayment.repaydate)='$tday' AND MONTH(repayment.repaydate)= '$cMonth' AND YEAR(repayment.repaydate)= '$cYear' AND repayment.actualrepaydate='0000-00-00' and loan.is_baddebt='0' $filterTeam ORDER BY loan.loanno");
			$repaymentrow=mysql_num_rows($repaymentdata);
			if($repaymentrow=='0'){$displaymonth=$monthNames[$cMonth-1];
			echo"<tr><td align='center' colspan='9'><span class='bb12text'>-- No Borrower For $tday $displaymonth --</span></td></tr>";}
			else{
				for($count=0; $count<$repaymentrow; $count++)
				{$serial++;
				$dataid=mysql_result($repaymentdata,$count,"repayment.loanid");
					if($count%2)
						{echo"<tr onMouseOver=\"this.bgColor = '#AAAAAA'\" onMouseOut =\"this.bgColor = '#DDDDDD'\" bgcolor=\"#DDDDDD\">";}
					else
						{echo"<tr onMouseOver=\"this.bgColor = '#AAAAAA'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">";}
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$serial'><span class='bn12text'>$serial</span></a></td>";
				$data=mysql_result($repaymentdata,$count,"loan.loanno");
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$code$data'><span class='bn12text'>&nbsp;$code$data&nbsp;</span></a></td>";
				$datafull=mysql_result($repaymentdata,$count,"clients.name");
					if($datafull==NULL){$data='-';}
					$lenght=strlen($datafull);
					if($lenght>27){$data=substr($datafull, 0, 27);
					$data=$data.'...';}
					else{$data=$datafull;}
				echo"<td align='left'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$datafull'><span class='bn12text'>&nbsp;$data&nbsp;</span></a></td>";
				$data=mysql_result($repaymentdata,$count,"repayment.repayamount");
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$$data'><span class='bn12text'>&nbsp;$$data&nbsp;</span></a></td>";
				$data=mysql_result($repaymentdata,$count,"repayment.repaydate");
				$data=strtotime("$data");
				$data=date("d-M-Y", $data);
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$data'><span class='bn12text'>&nbsp;$data&nbsp;</span></a></td>";
				if(!$hide_contact){
					$data=mysql_result($repaymentdata,$count,"clients.mobile");
					echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$data'><span class='bn12text'>&nbsp;$data&nbsp;</span></a></td>";
				}
				$datafull=mysql_result($repaymentdata,$count,"clients.address1");
					if($datafull==NULL){$data='-';}
					$lenght=strlen($datafull);
					if($lenght>50){$data=substr($datafull, 0,50);
					$data=$data.'...';}
					else{$data=$datafull;}
				echo"<td align='left' style='border-width:1px 0px 1px 1px'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$datafull'><span class='bn12text'>&nbsp;$data&nbsp;</span></a></td>";
				$data=mysql_result($repaymentdata,$count,"clients.address2");
				if($data!=NULL){echo"<td align='right' style='border-width:1px 1px 1px 0px'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$data'><span class='bn10text'>&nbsp;more>>&nbsp;</span></a></td>";}
				else{echo"<td align='right' style='border-width:1px 1px 1px 0px'>&nbsp;</td>";}
				$datafull=mysql_result($repaymentdata,$count,"repayment.remarks");
					if($datafull==NULL){$data='-';}
					$lenght=strlen($datafull);
					if($lenght>25){$data=substr($datafull, 0,25);
					$data=$data.'...';}
					else{$data=$datafull;}
				echo"<td align='left'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$datafull'><span class='bn12text'>&nbsp;$data&nbsp;</span></a></td>";
				echo"</tr>";}}
			$overdue=$_GET[overdue];
			if($overdue=='yes'){
			if ($webcompany=='EurohubCredit')
			$repaymentdata=mysql_query("SELECT * FROM repayment, loan, clients WHERE loan.hidden='0' AND clients.hidden='0' AND repayment.hidden='0' AND loan.loanid=repayment.loanid AND loan.loanid=clients.loanid AND clients.status='BORROWER' AND loan.company='$webcompany' AND repaydate <'$today' AND repayment.actualrepaydate='0000-00-00' and loan.loanno not in (select loanno from bad_debts) $filterTeam ORDER BY repayment.repaydate");
			else
			$repaymentdata=mysql_query("SELECT * FROM repayment, loan, clients WHERE loan.hidden='0' AND clients.hidden='0' AND repayment.hidden='0' AND loan.loanid=repayment.loanid AND loan.loanid=clients.loanid AND clients.status='BORROWER' AND loan.company='$webcompany' AND repaydate <'$today' AND repayment.actualrepaydate='0000-00-00' and loan.is_baddebt='0' $filterTeam ORDER BY repayment.repaydate");

			$repaymentrow=mysql_num_rows($repaymentdata);
			if($repaymentrow=='0'){
				$data=strtotime("$today");
				$data=date("d F", $data);
			echo"<tr><td align='center' colspan='8'><span class='rb12text'>-- No Outstanding Payment From $data --</span></td></tr>";}
			else{
				for($count=0; $count<$repaymentrow; $count++)
				{$serial++;
				$dataid=mysql_result($repaymentdata,$count,"repayment.loanid");
					if($count%2)
						{echo"<tr onMouseOver=\"this.bgColor = '#AAAAAA'\" onMouseOut =\"this.bgColor = '#DDDDDD'\" bgcolor=\"#DDDDDD\">";}
					else
						{echo"<tr onMouseOver=\"this.bgColor = '#AAAAAA'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">";}
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$serial'><span class='rb12text'> $serial </span></a></td>";
				$data=mysql_result($repaymentdata,$count,"loan.loanno");
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$code$data'><span class='rb12text'>&nbsp;$code$data&nbsp;</span></a></td>";
				$datafull=mysql_result($repaymentdata,$count,"clients.name");
					if($datafull==NULL){$data='-';}
					$lenght=strlen($datafull);
					if($lenght>27){$data=substr($datafull, 0, 27);
					$data=$data.'...';}
					else{$data=$datafull;}
				echo"<td align='left'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$datafull'><span class='rb12text'>&nbsp;$data&nbsp;</span></a></td>";
				$data=mysql_result($repaymentdata,$count,"repayment.repayamount");
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$$data'><span class='rb12text'>&nbsp;$$data&nbsp;</span></a></td>";
				$data=mysql_result($repaymentdata,$count,"repayment.repaydate");
				$data=strtotime("$data");
				$data=date("d-M-Y", $data);
				echo"<td align='center'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$data'><span class='rb12text'> &nbsp;$data&nbsp;</span></a></td>";
				if(!$hide_contact){
					$data=mysql_result($repaymentdata,$count,"clients.mobile");
					echo"<td align='center' colspan='2'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$data'><span class='rb12text'>&nbsp;$data&nbsp;</span></a></td>";
				}
				$datafull=mysql_result($repaymentdata,$count,"clients.address1");
					if($datafull==NULL){$data='-';}
					$lenght=strlen($datafull);
					if($lenght>50){$data=substr($datafull, 0,50);
					$data=$data.'...';}
					else{$data=$datafull;}
				echo"<td align='left' style='border-width:1px 0px 1px 1px'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$datafull'><span class='rb12text'>&nbsp;$data&nbsp;</span></a></td>";
				$data=mysql_result($repaymentdata,$count,"clients.address2");
				if($data!=NULL){echo"<td align='right' style='border-width:1px 1px 1px 0px'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$data'><span class='rb10text'>&nbsp;more>>&nbsp;</span></a></td>";}
				else{echo"<td align='right' style='border-width:1px 1px 1px 0px'>&nbsp;</td>";}
				$datafull=mysql_result($repaymentdata,$count,"repayment.remarks");
					if($datafull==NULL){$data='-';}
					$lenght=strlen($datafull);
					if($lenght>25){$data=substr($datafull, 0,25);
					$data=$data.'...';}
					else{$data=$datafull;}
				echo"<td align='left'><a href='repayment.php?id=$dataid' STYLE='text-decoration:none' title='$datafull'><span class='rb12text'>&nbsp;$data&nbsp;</span></a></td>";
				echo"</tr>";}}
			}
				?>
			</table>
		</div>
	</div>
</div>