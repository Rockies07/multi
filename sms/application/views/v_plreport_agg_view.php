        <!-- Main Container Start -->
		<div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
                
            	
               
 				<span style="font-size:18px;"><b> Group -> <?PHP echo $uid;?></b></span>
				<br>
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                        <table cellpadding="0" cellspacing="0" width="100%">
                        	<tr>
								<?PHP echo form_open(''); ?>
                                <td><span><i class="icon-table"></i><b> P/L Report</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								From:
								<?php echo form_dropdown('fromdate', $drawdate); ?>
								&nbsp;&nbsp;
								To:
                                <?php echo form_dropdown('todate', $drawdate); ?>
								<input type="hidden" name="uid" value="<?PHP echo $uid; ?>"></input>
	
                                <input type="submit" class="btn" name="view" value="VIEW"></input>




                                </span></td>
                                <td>
							  </td>
                            </tr>
							<?PHP echo form_close(); ?>
                        </table>
                    </div>
				
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th>My</th>
                                    <th>Ticket</th>
                                    <th>Strike</th>
                                    <th>Payable</th>
                                    <th>Share</th>
                                    <th>Tax</th>
                                    <th>Nett</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">P.O Ticket</td>
                                    <td align="center"><?PHP echo number_format((0 - $report_data['total_po_ticket']),2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($report_data['total_meb_strike'],2,'.',',');?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($master_payable_nett,2,'.',',');?></td>
                                    <td align="center" rowspan="2" style="padding:0">
										<table class="mws-table" >
											<thead>
												<tr align="center">
													<?PHP if($report_data['share_co_perc'] > 0) {?>
													<th>CO</th>
													<?PHP }
													if($report_data['share_po_perc'] > 0) {?>
													<th>PO</th>
													<?PHP } 
													if($report_data['share_mas_perc'] > 0) {?>
													<th>MA IT</th>
													<?PHP } ?>
												</tr>
											</thead>
											<tbody>
												<tr align="center" style="border:1px solid #D8D8D8;">
													<?PHP if($report_data['share_co_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_data['share_co_amt'],2,'.',','); ?></td>
													<?PHP }
													if($report_data['share_po_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_data['share_po_amt'],2,'.',','); ?></td>
													<?PHP }
													if($report_data['share_mas_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_data['share_mas_amt'],2,'.',','); ?></td>
													<?PHP } ?>
												</tr>
											</tbody>
										</table>

                                    <td align="center" rowspan="2"><?PHP echo number_format((0 -$report_data['total_intake_tax']),2,'.',',');?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($master_nett,2,'.',',');?></td>
                                </tr>
								<tr>
                                    <td align="center">Intake</td>
                                    <td align="center"><?PHP echo number_format($report_data['total_intake_ticket'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format(($report_data['total_own_strike'] + $report_data['total_downline_strike']),2,'.',',');?></td>
                               </tr>
							 </tbody>
							 <thead style="border:1px solid #D8D8D8;">
                                <tr>
                                    <th>Downline</th>
                                    <th>Ticket</th>
                                    <th>Strike</th>
                                    <th>Payable</th>
									<th>Share</th>									
                                    <th>Tax</th>
                                    <th>Nett</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">P.O Ticket</td>
                                    <td align="center"><?PHP echo number_format((0 - $report_data['downline_total_po_ticket']),2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format(($report_data['total_meb_strike']),2,'.',',');?></td>
									<td align="center" rowspan="2"><?PHP echo number_format($downline_payable_nett,2,'.',','); ?></td>
									<td align="center" rowspan="2" style="padding:0">
										<table class="mws-table">
											<thead>
												<tr align="center">
													<?PHP if($report_data['share_co_perc'] > 0) {?>
													<th>CO</th>
													<?PHP }
													if($report_share_downline['share_mas'] != 0) {?>
													<th>MA IT</th>
													<?PHP }
													if($report_share_downline['share_agg'] != 0) {?>
													<th>GP IT</th>
													<?PHP } ?>
												</tr>
											</thead>
											<tbody>
												<tr align="center" style="border:1px solid #D8D8D8;">
													<?PHP if($report_data['share_co_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_share_downline['share_co'],2,'.',','); ?></td>
													<?PHP }
													if($report_share_downline['share_mas'] != 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_share_downline['share_mas'],2,'.',','); ?></td>
													<?PHP }
													if($report_share_downline['share_agg'] != 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_share_downline['share_agg'],2,'.',','); ?></td>
													<?PHP } ?>
												</tr>
											</tbody>
										</table>
									</td>
                                    <td align="center" rowspan="2"><?PHP echo number_format((0 -$report_data['total_downline_intake_tax']),2,'.',',');?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format((0 - $downline_nett),2,'.',','); ?></td>
                                </tr>
								<tr>
                                    <td align="center">Intake</td>
                                    <td align="center"><?PHP echo number_format($report_data['total_downline_intake_ticket'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($report_data['total_downline_strike'],2,'.',',');?></td>
                               </tr>
                               <tr style="border:1px solid #D8D8D8;">
									<td colspan="6" align="right"><b>My P/L Nett</b></td>
                                    <td align="center"><b><?PHP echo number_format($po_wl,2,'.',',');?></font></b></td>
							   </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

				<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> My Intake</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th>Total</th>
                                    <th>Strike</th>
                                    <th>Tax</th>
                                    <th>Nett</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td align="center"><?PHP echo number_format($report_data['total_own_intake_ticket'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($report_data['total_own_strike'],2,'.',','); ?></td>
									<td align="center"><?PHP echo number_format($report_data['total_own_intake_tax'],2,'.',','); ?></td>
									<td align="center"><?PHP echo number_format(($report_data['total_own_intake_ticket'] - $report_data['total_own_strike'] - $report_data['total_own_intake_tax']),2,'.',','); ?></td>
                                </tr>
                               <tr>
									<td colspan="3" align="right"><b>Downline Share</b></td>
                                    <td align="center"><b><?PHP echo number_format((0- ($report_share_downline['share_agg'])),2,'.',','); ?></b></td>
							   </tr>
                               <tr>
									<td colspan="3" align="right"><b>Win/Lose Nett</b></td>
                                    <td align="center"><b>
									<?PHP echo number_format(($report_data['total_own_intake_ticket'] - $report_data['total_own_strike'] - $report_data['total_own_intake_tax'] - $report_share_downline['share_agg']),2,'.',','); ?></b></td>
							   </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				
				
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-install"></i><b> Downline Report</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>-</th>
									<th>Ticket</th>
                                    <th>Strike</th>
                                    <th>Payable</th>
                                    <th>Ticket %</th>
                                    <th>Share</th>
                                    <th>Tax</th>
                                    <th>Nett</th>
                                    <th></th>
                                </tr>
                            </thead>
<?PHP
						$total_po_ticket = 0;
						$total_po_strike = 0;
						$total_in_ticket = 0;
						$total_in_strike = 0;

						$total_payable = 0;
						$total_ticket_perc = 0;
						$total_co_share = 0;
						$total_agg_share = 0;
						$total_mas_share = 0;
						$total_report_tax = 0;
						$total_report_nett = 0;

						foreach($downline_report_array as $downline_report_data)
						{
							if ($downline_report_data['total_po_ticket'] > 0)
							{
								$downline_report_payable =($downline_report_data['total_meb_strike'] - $downline_report_data['total_own_strike']) - ($downline_report_data['total_po_ticket'] - $downline_report_data['total_own_intake_ticket']);
								
								$downline_report_share = $downline_report_data['share_co_amt'] + $downline_report_data['share_agg_amt'] + $downline_report_data['share_mas_amt'];

								$downline_report_nett = $downline_report_payable + $downline_report_share - $downline_report_data['total_own_intake_tax'];



								$total_po_ticket = $total_po_ticket + $downline_report_data['total_po_ticket'];
								$total_in_ticket = $total_in_ticket + $downline_report_data['total_own_intake_ticket'];
								$total_po_strike = $total_po_strike + $downline_report_data['total_meb_strike'];
								$total_in_strike = $total_in_strike + $downline_report_data['total_own_strike'];

								$total_payable = $total_payable + $downline_report_payable;
								$total_ticket_perc = $total_ticket_perc + $downline_report_data['ticket_perc'];
								$total_co_share = $total_co_share + $downline_report_data['share_co_amt'];
								$total_agg_share = $total_agg_share + $downline_report_data['share_agg_amt'];
								$total_mas_share = $total_mas_share + $downline_report_data['share_mas_amt'];

								$total_report_tax = $total_report_tax + $downline_report_data['total_own_intake_tax'];
								$total_report_nett = $total_report_nett + $downline_report_nett;

?>
                            <tbody>

                                <tr style="border:1px solid #D8D8D8;">
									<td align="center" rowspan="2" style="padding:0"><?PHP echo anchor_popup("c_profitloss/view/".$downline_report_data['agt_id']."/".$fromdate."/".$todate, $downline_report_data['agt_id']." (".$downline_report_data['name'].")",$attributes);?></td>
									<td align="center" style="padding:0">Bet</td>
                                    <td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_po_ticket'],2,'.',','); ?></td>

									<td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_meb_strike'],2,'.',','); ?></td>
                                    <td align="center" rowspan="2" style="padding:0"><?PHP echo number_format($downline_report_payable,2,'.',','); ?></td>
                                    <td align="center" rowspan="2" style="padding:0"><?PHP echo number_format(($downline_report_data['ticket_perc'] / $drawcount),4,'.',','); ?> %</td>

									<td align="center" rowspan="2" style="padding:0">
										<table class="mws-table">
											<thead>
												<tr align="center">
													<?PHP if($downline_report_data['share_co_perc'] > 0) {?>
													<th>CO</th>
													<?PHP }
													if($downline_report_data['share_mas_perc'] > 0) {?>
													<th>MA IT</th>
													<?PHP }
													if($downline_report_data['share_agg_perc'] > 0) {?>
													<th>GP IT</th>
													<?PHP } ?>
												</tr>
											</thead>
											<tbody>
												<tr align="center" style="border:1px solid #D8D8D8;">
													<?PHP if($downline_report_data['share_co_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($downline_report_data['share_co_amt'],2,'.',',')." (".number_format(($downline_report_data['share_co_perc']),0)."%)"; ?></td>
													<?PHP }
													if($downline_report_data['share_mas_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($downline_report_data['share_mas_amt'],2,'.',',')." (".number_format(($downline_report_data['share_mas_perc']),0)."%)"; ?></td>
													<?PHP }
													if($downline_report_data['share_agg_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($downline_report_data['share_agg_amt'],2,'.',',')." (".number_format(($downline_report_data['share_agg_perc']),0)."%)"; ?></td>
													<?PHP } ?>
												</tr>
											</tbody>
										</table>
									</td>

                                    <td align="center" rowspan="2" style="padding:0"><?PHP echo number_format((0 -$downline_report_data['total_own_intake_tax']),2,'.',','); ?></td>
                                    <td align="center" rowspan="2" style="padding:0"><?PHP echo number_format($downline_report_nett,2,'.',','); ?></td>
                                </tr>
                                <tr style="border:1px solid #D8D8D8;">
									<td align="center" style="padding:0">Eat</td>
                                    <td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_own_intake_ticket'],2,'.',','); ?></td>
                                    <td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_own_strike'],2,'.',','); ?></td>
                                </tr>
                            </tbody>

<?PHP
							}
						}
?>
                            <tbody>
								<tr style="border:1px solid #D8D8D8;">
									<td align="right" style="padding:0" rowspan="2"><b>Total:</b></td>
                                    <td align="center" style="padding:0"><b>Bet</b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_po_ticket,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_po_strike,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0" rowspan="2"><b><?PHP echo number_format($total_payable,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0" rowspan="2"><b><?PHP echo number_format(($total_ticket_perc / $drawcount),2,'.',','); ?> %</b></td>

									<td align="center" rowspan="2" style="padding:0">
										<table class="mws-table">
											<thead>
												<tr align="center">
													<?PHP if($total_co_share != 0) {?>
													<th>CO</th>
													<?PHP }
													if($total_mas_share != 0) {?>
													<th>MA IT</th>
													<?PHP }
													if($total_agg_share != 0) {?>
													<th>GP IT</th>
													<?PHP } ?>
												</tr>
											</thead>
											<tbody>
												<tr align="center" style="border:1px solid #D8D8D8;">
													<?PHP if($total_co_share != 0) {?>
													<td style="padding:0"><b><?PHP echo number_format($total_co_share,2,'.',','); ?></b></td>
													<?PHP }
													if($total_mas_share != 0) {?>
													<td style="padding:0"><b><?PHP echo number_format($total_mas_share,2,'.',','); ?></b></td>
													<?PHP }
													if($total_agg_share != 0) {?>
													<td style="padding:0"><b><?PHP echo number_format($total_agg_share,2,'.',','); ?></b></td>
													<?PHP } ?>
												</tr>
											</tbody>
										</table>
									</td>

                                    <td align="center" style="padding:0" rowspan="2"><b><?PHP echo number_format($total_report_tax,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0" rowspan="2"><b><?PHP echo number_format($total_report_nett,2,'.',','); ?></b></td>
                                </tr>
                                <tr style="border:1px solid #D8D8D8;">
                                    <td align="center" style="padding:0"><b>Eat</b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_in_ticket,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_in_strike,2,'.',','); ?></b></td>
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
