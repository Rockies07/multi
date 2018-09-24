        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
                
            	
               
            	<div class="mws-panel grid_8">
                
            <div class="mws-panel-header">
            <div class="clearfix"></div>
                        <table cellpadding="0" cellspacing="0" width="100%">
                        	<tr>
								<?PHP echo form_open(''); ?>
                                <td><span><i class="icon-table"></i><b> Report by page</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								From:
								<?php echo form_dropdown('fromdate', $drawdate); ?>
								&nbsp;&nbsp;
								To:
                                <?php echo form_dropdown('todate', $drawdate); ?>
                                <input type="submit" class="btn" name="view" value="VIEW"></input>

                                </span></td>
                                <td>
							  </td>
                            </tr>
							<?PHP echo form_close(); ?>
                        </table>
                  </div><br >
            	</div>

<?PHP
	if($this->input->post('view'))
	{
?>
				
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>Draw : <?PHP echo $this->input->post('fromdate'); ?> To <?PHP echo $this->input->post('todate'); ?></b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table" style="FONT-SIZE: 12px; padding:0;" border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
<?PHP
	if(strlen($uid) <= 4)
		{
?>
                                    <th><div align="center">Upline</div></th>
<?PHP
		}
	else
		{
?>

									<th><div align="center">-</div></th>
<?PHP
		}
?>
                                    <th><div align="center">Member</div></th>
                                    <th><div align="center">Page</div></th>
                                    <th><div align="center">Big</div></th>
                                    <th><div align="center">Small</div></th>
                                    <th><div align="center">i Big</div></th>
                                    <th><div align="center">i Small</div></th>
                                    <th><div align="center">Amount</div></th>
                                    <th><div align="center">Strike</div></th>
                                    <th><div align="center">Draw date</div></th>
                                    <th><div align="center">Entry Time</div></th>
                                    <th><div align="center">-</div></th>
                                   <th><div align="center">SMS</div></th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP

						foreach($downline_array as $downline_data)
						{
							if(strlen($uid) < 8) // open foreach for agent and above
							{
								$report_array = $this->m_accounts->getbetrecords($fromdate,$todate,$downline_data[$downline_type]);
							}
							else
							{
								$report_array = $this->m_accounts->getbetrecords($fromdate,$todate,$uid);
							}
							if(!empty($report_array))
							{
								if(strlen($uid) <= 4)
									{
?>
								<tr>
									<td><div align="center"><?PHP echo $downline_data[$downline_type]; ?></div></td>
									<td colspan="13"><div align="center"></div></td>
								</tr>
<?PHP
									}
								$totalbig = 0;
								$totalibig = 0;
								$totalsmall = 0;
								$totalismall = 0;
								$totalstrike = 0;
								$totaldisc = 0;
								$totalsmscharge = 0;
								
								switch(strlen($uid))
								{
									case '2':	$po_com	= "mas_com";
												break;
									case '4':	$po_com	= "agg_com";
												break;
									case '6':	$po_com	= "agt_com";
												break;
									case '8':	$po_com	= "meb_com";
												break;

								}
								foreach($report_array as $report_data)
								{
									$amount = (($report_data['amt_big'] + $report_data['amt_ibig']) * $bigvalue) + (($report_data['amt_small'] + $report_data['amt_ismall']) * $smallvalue);

									$amountdisc = $amount * ($report_data[$po_com] / 100);
?>									

									<tr>
										<td><div align="center">-</div></td>
										<td><div align="center"><?PHP echo $report_data['meb_id']; ?></div></td>
										<td style="white-space: nowrap"><div align="center"><?PHP echo $report_data['pageref']; ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['amt_big'],2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['amt_small'],2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['amt_ibig'],2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['amt_ismall'],2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo number_format(($amount - $amountdisc),2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['strike'],2,'.',','); ?></div></td>
										<td style="white-space: nowrap"><div align="center"><?PHP echo $report_data['drawdate']; ?></div></td>
										<td style="white-space: nowrap"><div align="center"><?PHP echo $report_data['entrytime']; ?></div></td>
										<td><div align="center"><?PHP echo anchor_popup('c_pagedetails/view/'.$report_data['ref'].'/'.$report_data['drawdate'], 'View', $attributes); ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['sms_charges'],2,'.',','); ?></div></td>
									</tr>
<?PHP
									$totalbig = $totalbig + $report_data['amt_big'];
									$totalibig = $totalibig + $report_data['amt_ibig'];
									$totalsmall = $totalsmall + $report_data['amt_small'];
									$totalismall = $totalismall + $report_data['amt_ismall'];
									$totalstrike = $totalstrike + $report_data['strike'];
									$totaldisc = $totaldisc + $amountdisc;
									$totalsmscharge = $totalsmscharge + $report_data['sms_charges'];
								}

								$totalamount = (($totalbig + $totalibig) * $bigvalue) + (($totalsmall + $totalismall) * $smallvalue) - $totaldisc;
?>
								<tr>
									<th colspan="3"><div align="right">Total : </div></th>
									<th><div align="center"><?PHP echo number_format($totalbig,2,'.',','); ?></div></th>
									<th><div align="center"><?PHP echo number_format($totalsmall,2,'.',','); ?></div></th>
									<th><div align="center"><?PHP echo number_format($totalibig,2,'.',','); ?></div></th>
									<th><div align="center"><?PHP echo number_format($totalismall,2,'.',','); ?></div></th>
									<th><div align="center"><?PHP echo number_format($totalamount,2,'.',','); ?></div></th>
									<th><div align="center"><?PHP echo number_format($totalstrike,2,'.',','); ?></div></th>
									<th colspan="3"><div align="center"></div></th>
									<th><div align="center"><?PHP echo number_format($totalsmscharge,2,'.',','); ?></div></th>
								</tr>

<?PHP
							}
						} // close for each if agent and above
?>

							<tr>
                                <td><div colspan="12"></div></td>
							</tr>
							<tr>
                                <td><div colspan="12"></div></td>
							</tr>
							<tr>
                                <td><div colspan="12"></div></td>
							</tr>

                            </tbody>
                        </table>
                    </div>
                </div>

<?PHP

	}
?>
                
            	
            <!-- Inner Container End -->
                       
            <!-- Footer -->
        </div>
        <!-- Main Container End -->
        
    </div>

    <!-- JavaScript Plugins -->
    <script src="assets/js/libs/jquery-1.8.3.min.js"></script>
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
