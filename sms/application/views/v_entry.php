<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><!--<![endif]-->
<META http-equiv="Content-Type" content="text/html; charset=windows-1252"> 
        <META http-equiv="pragma" content="no-cache"> 
        <META http-equiv="cache-control" content="no-cache"> 
		<base href="<?PHP echo base_url(); ?>">
		<LINK href="assets/admin.css"  rel="stylesheet" type="text/css">
        <SCRIPT src="assets/event.js"></SCRIPT>
		<script src="assets/js/libs/jquery-1.8.3.min.js"></script>



        <SCRIPT language="javascript">

// <![CDATA[
    $(document).ready(function()
	{      
        $('#downline_id').change(function()
		{     
            $("#meb_id > option").remove();
            var downline_id = $('#downline_id').val();
            $.ajax(
			{
                type: "POST",
                url: "<?PHP echo site_url('/c_entry/getmemberdata/"+downline_id+"'); ?>", 
                dataType : "json",
                success: function(meb_id)
                {
					var opt = $('<option >');
					opt.val('-');
					opt.text('--- Select Member ---');
					$('#meb_id').append(opt);

                    $.each(meb_id,function(id,m_id) 
                    {
                        var opt = $('<option >');
                        opt.val(id);
                        opt.text(m_id);
                        $('#meb_id').append(opt);
                    });
                }
                 
            });
             
        });

        $('#meb_id').change(function() 
		{     
            var meb_id = $('#meb_id').val();
            $.ajax(
			{
                type: "POST",
                url: "<?PHP echo site_url('/c_entry/getmemberbal/"+meb_id+"'); ?>",
                dataType : "json",
                success: function(meb_bal)
                {
					document.PlaceBetForm.Balance.value=meb_bal
					document.PlaceBetForm.WhoseBet.value=meb_id
                }
                 
            });
             
        });

    });
    // ]]>

            function dM(rowstyle, n, d) {
                var htmlday;
				
				switch(d)
				{
					case 1: 
						htmlday = '<OPTION value="3" class="3day">3</OPTION><OPTION class="2day" value="2">2</OPTION><OPTION class="6day" value="6">6</OPTION><OPTION class="7day" value="7">7</OPTION><OPTION class="1day" value="1" SELECTED>1</OPTION>';
						break;
					case 2: 
						htmlday = '<OPTION value="3" class="day3">3</OPTION><OPTION class="day2" value="2" SELECTED>2</OPTION><OPTION class="day6" value="6">6</OPTION><OPTION class="day7" value="7">7</OPTION><OPTION class="day1" value="1">1</OPTION>';
						break;
					case 3: 
						htmlday = '<OPTION value="3" class="day3" SELECTED>3</OPTION><OPTION class="day2" value="2">2</OPTION><OPTION class="day6" value="6">6</OPTION><OPTION class="day7" value="7">7</OPTION><OPTION class="day1" value="1">1</OPTION>';
						break;
					case 6: 
						htmlday = '<OPTION value="3" class="day3">3</OPTION><OPTION class="day2" value="2">2</OPTION><OPTION class="day6" value="6" SELECTED>6</OPTION><OPTION class="day7" value="7">7</OPTION><OPTION class="day1" value="1">1</OPTION>';
						break;
					case 7: 
						htmlday = '<OPTION value="3" class="day3">3</OPTION><OPTION class="day2" value="2">2</OPTION><OPTION class="day6" value="6">6</OPTION><OPTION class="day7" value="7" SELECTED>7</OPTION><OPTION class="day1" value="1">1</OPTION>';
						break;
				}

                document.writeln('<tr class=' + rowstyle + '>');
                document.writeln('  <td>' + n + '</td>');
                document.writeln('  <td><select tabindex="-1" size="1" name="Day' + n + '" id="Day' + n + '" class="day' + d + '" onchange="javascript: ChangeValue('+ n +');">' + htmlday + '</select></td>');
                document.writeln('  <td><input maxLength="4" style="width: 41px; FONT-WEIGHT: bold; FONT-SIZE: 13px; color: white;" name="NumberToBuy' + n + '" id="NTB' + n + '" onFocus="javascript: FocusInNum('+ n +');" value="" onkeyup="javascript: KeyUpInNum(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="3" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px; color: white;" name="BigNum' + n + '" id="BN' + n + '" value="" onkeyup="javascript: KeyUpInBig(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="3" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px; color: white;" name="SmlNum' + n + '" id="SN' + n + '" value="" onkeyup="javascript: KeyUpInSml(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="1" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px; " name="Cmd' + n + '" id="CMD' + n + '" value="" disabled></td>');
                document.writeln('</tr>');
                document.writeln('  <input type="hidden" value="0" name="pDay' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pNumberToBuy' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pBigNum' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pSmlNum' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pCmd' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pAmt' + n + '">');
            }
        </SCRIPT>

<?PHP

?>
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                <!-- Panels Start -->
                
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Mass Entry</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <!-- Entry -->
					
            
        <table cellSpacing="0" cellPadding="0" border="1" width="100%" >
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="0" cellPadding="0" border="0" align="left">
<?PHP

	$attributes = array('name' => 'SelAgentForm',
						);
	echo form_open('', $attributes); 
	$meb_id['#'] = '-';
	if(strlen($uid) < 6)// show different dropdown for agent and member
	{
?>
                        <tr>
                            <td align="center" style="color:orange;font-size:14px;">Select Downline&nbsp;<?php echo form_dropdown('downline_id', $downlinedata , '#' ,'id="downline_id" class="wcolor"'); ?>&nbsp;&nbsp;&nbsp;
							Select Member : <?php echo form_dropdown('WhoseBet', $meb_id, '#' ,'id="meb_id" class="wcolor"'); ?>
							</form>
<?PHP
		$attributes = array('name' => 'PlaceBetForm',
							);
		echo form_open('c_checkout', $attributes); 
?>
							<INPUT name="WhoseBet" type="hidden" value="-"> 
							<INPUT name="setday" type="hidden" value="N"> 
							<INPUT type="hidden" value="80" name="MaxCellId">



<?PHP
	}
	if(strlen($uid) == 6)// show different dropdown for agent and member
	{
?>
                        <tr>
                            <td align="center" style="color:orange;font-size:14px;">
							Select Member : <?php echo form_dropdown('WhoseBet', $downlinedata, '#' ,'id="meb_id" class="wcolor"'); ?>
							</form>
<?PHP
		$attributes = array('name' => 'PlaceBetForm',
							);
		echo form_open('c_checkout', $attributes); 
?>
							<INPUT name="WhoseBet" type="hidden" value="-"> 
							<INPUT name="setday" type="hidden" value="N"> 
							<INPUT type="hidden" value="80" name="MaxCellId">


<?PHP
	}
	if(strlen($uid) == 8)// show different dropdown for agent and member
	{
?>
                        <tr>
                            <td align="center">
							Member : <?php echo $uid; ?>
							</form>

<?PHP
		$attributes = array('name' => 'PlaceBetForm',
							);
		echo form_open('c_checkout', $attributes); 
?>
							<INPUT name="WhoseBet" type="hidden" value="<?php echo $uid; ?>"> 
							<INPUT name="setday" type="hidden" value="N"> 
							<INPUT type="hidden" value="80" name="MaxCellId">
							
<?PHP
	}
	?>
                            </td>
                        </tr>
						<tr>
							<th><br>
								Available Draw Dates:
								<?PHP

									for ($i = 1; $i <= 3; $i++) 
									{
										$td = $drawdate[$i];
										$arr = explode ("-", $td);
										$stamp = mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
										$t = date('D',$stamp);
										if (strcmp($t, 'Wed') == 0 ){ echo '&nbsp;&nbsp;<font color="#33CCFF"><u>Wed '.$td.'</u></font>'; }
										if (strcmp($t, 'Sat') == 0 ){ echo '&nbsp;&nbsp;<font color="#CC00CC"><u>Sat '.$td.'</u></font>'; }
										if (strcmp($t, 'Sun') == 0 ){ echo '&nbsp;&nbsp;<font color="#33CC00"><u>Sun '.$td.'</u></font>'; }
									}
								?>
                            </th>
						</tr>
						<tr>
							<th><br>
								Day:
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(1);"><font color="#CC0000"><u>1 = Wed,Sat,Sun</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(2);"><font color="#F7FE2E"><u>2 = Sat,Sun</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(3);"><font color="#33CCFF"><u>3 = Wed</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(6);"><font color="#CC00CC"><u>6 = Sat</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(7);"><font color="#33CC00"><u>7 = Sun</u></font></a>
                            </th>
						</tr>
						<tr>
							<th>							
							


                          </th>
						</tr>

						<tr>
							<td>
							</td>
						</tr>
                    </table>
                </td></tr>
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="1" cellPadding="0" border="1" align="left">
                        <tr>
                            <th>							
							
								Page :&nbsp;<input maxLength="9" size="9" class="mws-form-item wcolor" name="txtPage"> &nbsp;&nbsp;&nbsp;&nbsp
                                Big : <input maxLength="6" style="width: 50px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" name="TotalBig" value="0" class="wcolor" readonly>
                                Sml : <input maxLength="6" style="width: 50px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" name="TotalSml" value="0" class="wcolor" readonly>
                                Amt : <input maxLength="6" style="width: 60px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" name="TotalAmt" id="TotalAmt" value="0" class="wcolor" readonly>
<?PHP
	if(strlen($uid) == 8)// show different dropdown for agent and member
	{

?>
       Balance : <input maxLength="10" style="width: 60px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" class="wcolor" name="Balance" id="Balance" value="<?php echo $userdata['balance']; ?>" readonly>
<?PHP
	}
	else
	{
?>
       Balance : <input maxLength="10" style="width: 60px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" class="wcolor" name="Balance" id="Balance" value="0" readonly>

<?PHP
	}
?>
							</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
                        <SCRIPT>
                            for (i = 1; i<21; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, <?PHP echo $defaultday; ?>);
                        </SCRIPT>
                        <th colspan="6">
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane1Big" value="0" readonly>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane1Sml" value="0" readonly>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane1Amt" value="0" readonly>                                                                
                        </th>
                    </table></td>

                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
                        <SCRIPT>
                            for (i = 21; i<41; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, <?PHP echo $defaultday; ?>);
                        </SCRIPT>
                        <th colspan="6">
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane2Big" value="0" readonly>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane2Sml" value="0" readonly>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane2Amt" value="0" readonly>                                                                
                        </th>
                    </table></td>

                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
                        <SCRIPT>
                            for (i = 41; i<61; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, <?PHP echo $defaultday; ?>);
                        </SCRIPT>
                        <th colspan="6">
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane3Big" value="0" readonly>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane3Sml" value="0" readonly>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane3Amt" value="0" readonly>                                                                
                        </th>
                    </table>
                </td>

                <td>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
                        <SCRIPT>
                            for (i = 61; i<81; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, <?PHP echo $defaultday; ?>);
                        </SCRIPT>
                        <th colspan="6">
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane4Big" value="0" readonly>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane4Sml" value="0" readonly>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" class="wcolor" name="Pane4Amt" value="0" readonly>                                                                
                        </th>
                    </table>
                </td>
            </tr>
          
			<tr>	
				<td colspan="4" style="align:center;">
                    
                      <table align="center">
                        
                        <tr>
                          <td align="left"><button type="button" class="btn " onclick="javascript : ResetForm();" value="Reset">Clear</button></td>
						  <td>&nbsp;&nbsp;</td>
                          <td><button type="button" class="btn btn-danger" onclick="javascript : ValidateForm();" value="Submit">Submit</button></td>
                          </tr>
                        
                        </table>
                </td>
            </tr>
        </table>
    </FORM>
						
						<!-- Entry End -->
						
						
						
                    </div>
                </div>
				
				
				
				
				
				
				
				
            	
                
              <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
        </div>
        <!-- Main Container End -->
        
    </div>

    <!-- JavaScript Plugins -->
    <script src="assets/js/libs/jquery.mousewheel.min.js"></script>
    <script src="assets/js/libs/jquery.placeholder.min.js"></script>
    <script src="assets/custom-plugins/fileinput.js"></script>
    
    <!-- jQuery-UI Dependent Scripts -->
    <script src="assets/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="assets/jui/jquery-ui.custom.min.js"></script>
    <script src="assets/jui/js/jquery.ui.touch-punch.js"></script>

    <!-- Plugin Scripts -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/colorpicker/colorpicker-min.js"></script>

    <!-- Core Script -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script src="assets/js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script src="assets/js/demo/demo.table.js"></script>

</body>
</html>
