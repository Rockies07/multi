        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
                
               
            	<div class="mws-panel grid_8">
                
                	<div class="mws-panel-header">
                        <table cellpadding="0" cellspacing="0" width="100%">
                        	<tr>
								<?PHP echo form_open(''); ?>
                                <td><span><i class="icon-table"></i><b> PlaceOut Summary</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								From:
								<?php echo form_dropdown('fromdate', $drawdate); ?>
								&nbsp;&nbsp;
								To:
                                <?php echo form_dropdown('todate', $drawdate); ?>
									
                                <input type="submit" class="btn" name="view" value="VIEW">
								<input type="hidden" name="uid" value="<?PHP echo $uid;?>">

                                </span></td>
                                <td>
							  </td>
                            </tr>
							<?PHP echo form_close(); ?>
                        </table>
                    </div>

<?PHP

		if(strlen($uid) < 6) // agent have no downline intake
		{
			$downline_intake_tax = $downline_indata['tax_amount'];
			$downline_intake_amount = ($downline_indata['intake_amount'] - $downline_indata['intake_disc_amount']);
		}
		else
		{
			$downline_indata = 0;
			$downintakeamount = 0;
			$downintakenett = 0;
			$totalinnett = 0;
		}
		
		$my_intake_nett = ($myintake_data['intake_amount'] - $myintake_data['intake_disc_amount']) - $myintake_data['tax_amount'];
		$downline_intake_nett = ($downline_indata['intake_amount'] - $downline_indata['intake_disc_amount']) - $downline_indata['tax_amount'];

		$to_system_po_amount = $placeout_data['po_total_amount'] - $placeout_data['com_amount'];
		$to_system_intake_amount = ($myintake_data['all_intake_amount'] - $myintake_data['all_intake_disc_amount']); // deduct intake comm
		$to_system_nett = $to_system_po_amount - ($myintake_data['all_intake_amount'] - $myintake_data['all_intake_disc_amount']) + $myintake_data['all_tax_amount'];
		
		$downline_po_amount = $downline_podata['totalamount'] - $downline_podata['totaldisc'];
		$downline_nett = $downline_po_amount - ($downline_indata['intake_amount'] - $downline_indata['intake_disc_amount']) + $downline_indata['tax_amount'];
		
		$total_win_loss = $downline_nett - $to_system_nett;


?>

                    <div  class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th>-</th>
                                    <th>Big</th>
                                    <th>i Big</th>
                                    <th>Small</th>
                                    <th>i Small</th>
                                    <th>Amount</th>
                                    <th>Intake Amount</th>
                                    <th>Payable</th>
                                    <th>Tax</th>
                                    <th>Nett</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">To System</td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($placeout_data['amt_big'],2,'.',','); ?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($placeout_data['amt_ibig'],2,'.',','); ?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($placeout_data['amt_small'],2,'.',','); ?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($placeout_data['amt_ismall'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($to_system_po_amount,2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($to_system_intake_amount,2,'.',','); ?></td>
                                    <td align="center">-<?PHP echo number_format(($to_system_po_amount - $to_system_intake_amount),2,'.',','); ?></td>
                                    <td align="center">-<?PHP echo number_format($myintake_data['all_tax_amount'],2,'.',','); ?></td>
                                    <td align="center">-<b><?PHP echo number_format($to_system_nett,2,'.',','); ?></b></td>
                                </tr>
								<tr>
                                    <td align="center">Downline</td>
                                    <td align="center"><?PHP echo number_format($downline_po_amount,2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($downline_intake_amount,2,'.',','); ?></td>
                                    <td align="center">-<?PHP echo number_format(($downline_po_amount - $downline_intake_amount),2,'.',','); ?></td>
                                    <td align="center">-<?PHP echo number_format($downline_intake_tax,2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($downline_nett,2,'.',','); ?></td>
                               </tr>								
                               <tr>
									<td colspan="9" align="right"><b>Win/Loss</b></td>
                                    <td align="center"><b><?PHP echo number_format($total_win_loss,2,'.',','); ?></font></b></td>
							   </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                
<?PHP

				$intake_total_big = $myintake_data['intake_big'] + $downline_indata['intake_big'];
				$intake_total_small = $myintake_data['intake_small'] + $downline_indata['intake_small'];
				$intake_total_amount = ($myintake_data['intake_amount'] - $myintake_data['intake_disc_amount']) + ($downline_indata['intake_amount'] - $downline_indata['intake_disc_amount']);
				$intake_total_strike = 0;
				$intake_total_tax = $myintake_data['tax_amount'] + $downline_indata['tax_amount'];
				$intake_total_nett = $my_intake_nett + $downline_intake_nett;

?>
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Intake</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th>-</th>
                                    <th>Big</th>
                                    <th>Small</th>
                                    <th>Amount</th>
                                    <th>Tax</th>
                                    <th>Nett</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">My own</td>
                                    <td align="center"><?PHP echo number_format($myintake_data['intake_big'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($myintake_data['intake_small'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format(($myintake_data['intake_amount'] - $myintake_data['intake_disc_amount']),2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($myintake_data['tax_amount'],2,'.',','); ?></td>

                                    <td align="center"><b><?PHP echo number_format($my_intake_nett,2,'.',','); ?></b></td> 
									<td align="center">--</td>
                                </tr>
								<tr>
                                    <td align="center">Downline</td>
                                    <td align="center"><?PHP echo number_format($downline_indata['intake_big'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($downline_indata['intake_small'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format(($downline_indata['intake_amount'] - $downline_indata['intake_disc_amount']),2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($downline_indata['tax_amount'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($downline_intake_nett,2,'.',','); ?></td>
									<td align="center">--</td>
                               </tr>		
								<tr>
                                    <td align="center"><b>Total</b></td>
                                    <td align="center"><b><?PHP echo number_format($intake_total_big,2,'.',','); ?></b></td>
                                    <td align="center"><b><?PHP echo number_format($intake_total_small,2,'.',','); ?></b></td>
                                    <td align="center"><b><?PHP echo number_format($intake_total_amount,2,'.',','); ?></b></td>
                                    <td align="center"><b><?PHP echo number_format($intake_total_tax,2,'.',','); ?></b></td>
                                    <td align="center"><b><?PHP echo number_format($intake_total_nett,2,'.',','); ?></b></td>
									<td align="center"></td>
                               </tr>		

                            </tbody>
                        </table>
                    </div>
                </div>
				
				
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-install"></i><b> Downline Summary</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>B/E</th>
									<th>Big</th>
									<th>i Big</th>
                                    <th>Small</th>
                                    <th>i Small</th>
									<th>Amount</th>
									<th>Payable</th>
                                    <th>SMS Charges</th>
									<th>Tax</th>
                                    <th>Nett</th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP
						$total_big = 0; 
						$total_ibig = 0; 
						$total_small = 0;
						$total_ismall = 0;

						$total_intake_big = 0; 
						$total_intake_small = 0;

						$total_po_amount = 0;
						$total_intake_amount = 0;
						$total_intake_tax = 0;

						$totalstrike = 0;
						$totalsmscharge = 0;
						
						$total_payable = 0;
						$total_nett = 0;

								
						foreach($downline_array as $downline_data)
						{
							if(strlen($downline_data[$downline_type]) <= 4) // open foreach for group and above
							{
								$report_array = $this->m_accounts->getmyplaceouttotal($fromdate,$todate,$downline_data[$downline_type]);
								$intake_array = $this->m_accounts->getmyintaketotal($fromdate,$todate,$downline_data[$downline_type]);
								$intake_big = $intake_array['all_intake_big'];
								$intake_small = $intake_array['all_intake_small'];
								$intake_nett = ($intake_array['all_intake_amount'] - $intake_array['all_intake_disc_amount']);
								$amount = $report_array['po_total_amount'] - $report_array['com_amount'];
								$downline_tax = $intake_array['all_tax_amount'];

								$downline_payable = ($amount - $intake_nett);
								$downline_nett = $amount - $intake_nett -  - $report_array['sms_charges'] + $intake_array['all_tax_amount'];

							}
							else if(strlen($downline_data[$downline_type]) == 6) // Agent po/intake values here
							{
								$report_array = $this->m_accounts->getmyplaceouttotal($fromdate,$todate,$downline_data[$downline_type]);
								$intake_array = $this->m_accounts->getmyintaketotal($fromdate,$todate,$downline_data[$downline_type]);
								$intake_big = $intake_array['intake_big'];
								$intake_small = $intake_array['intake_small'];
								$intake_nett = ($intake_array['intake_amount'] - $intake_array['intake_disc_amount']);
								$amount = $report_array['po_total_amount'] - $report_array['com_amount'];

								$downline_tax = $intake_array['tax_amount'];
								$downline_payable = ($amount - $intake_nett) + $intake_array['tax_amount'];
								$downline_nett = $amount - $intake_nett - $report_array['sms_charges'] + $intake_array['tax_amount'];
							}
							else // member only po value
							{

							}
							if(!empty($report_array))
							{
								if(strlen($downline_data[$downline_type]) <= 6) // Agent hide eat for member
								{
?>
                                <tr>
									<td align="center" rowspan="2"><?PHP echo anchor_popup("c_posummary/view/".$downline_data[$downline_type]."/".$fromdate."/".$todate, $downline_data[$downline_type]." (".$downline_data['name'].")",$attributes);?></td>
                                    <td align="center">Bet</td>
                                    <td align="center"><?PHP echo number_format($report_array['amt_big'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($report_array['amt_ibig'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($report_array['amt_small'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($report_array['amt_ismall'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($amount,2,'.',',');?></td>
                                    <td align="center" rowspan="2">-<?PHP echo number_format($downline_payable,2,'.',',');?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($report_array['sms_charges'],2,'.',',');?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($downline_tax,2,'.',',');?></td>
                                    <td align="center" rowspan="2">-<?PHP echo number_format($downline_nett,2,'.',',');?></td>
                                </tr>

                                <tr>
                                    <td align="center">Eat</td>
                                    <td align="center" colspan="2"><?PHP echo number_format($intake_big,2,'.',',');?></td>
                                    <td align="center" colspan="2"><?PHP echo number_format($intake_small,2,'.',',');?></td>
                                </tr>

<?PHP
									$total_big = $total_big + $report_array['amt_big']; 
									$total_ibig = $total_ibig + $report_array['amt_ibig']; 
									$total_small = $total_small + $report_array['amt_small'];
									$total_ismall = $total_ismall + $report_array['amt_ismall'];

									$total_intake_big = $total_intake_big + $intake_big; 
									$total_intake_small = $total_intake_small + $intake_small;

									$total_po_amount = $total_po_amount + ($report_array['po_total_amount'] - $report_array['com_amount']);
									$total_intake_amount = $total_intake_amount + $intake_nett;

									$total_intake_tax = $total_intake_tax + $downline_tax;

									$totalsmscharge = $totalsmscharge + $report_array['sms_charges'];
									
									$total_payable = $total_payable + $downline_payable;
									$total_nett = $total_nett + $downline_nett;

								}
							}
						}
?>
								<tr>
									<td align="right" rowspan="2"><b>Total:</b></td>
                                    <td align="center"><b>Bet</b></td>
                                    <td align="center"><b><?PHP echo number_format($total_big,2,'.',',');?></b></td>
                                    <td align="center"><b><?PHP echo number_format($total_ibig,2,'.',',');?></b></td>
									<td align="center"><b><?PHP echo number_format($total_small,2,'.',',');?></b></td>
                                    <td align="center"><b><?PHP echo number_format($total_ismall,2,'.',',');?></b></td>
                                    <td align="center"><b><?PHP echo number_format($total_po_amount,2,'.',',');?></b></td>
                                    <td align="center" rowspan="2"><b><?PHP echo number_format($total_payable,2,'.',',');?></b></td>
                                    <td align="center" rowspan="2"><b><?PHP echo number_format($totalsmscharge,2,'.',',');?></b></td>
                                    <td align="center" rowspan="2"><b><?PHP echo number_format($total_intake_tax,2,'.',',');?></b></td>									
                                    <td align="center" rowspan="2"><b><?PHP echo number_format($total_nett,2,'.',',');?></b></td>
                                </tr>
                                <tr>
                                    <td align="center"><b>Eat</b></td>
                                    <td align="center" colspan="2"><b><?PHP echo number_format($total_intake_big,2,'.',',');?></b></td>
                                    <td align="center" colspan="2"><b><?PHP echo number_format($total_intake_small,2,'.',',');?></b></td>
                                    <td align="center"><b><?PHP echo number_format($total_intake_amount,2,'.',',');?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
				
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
