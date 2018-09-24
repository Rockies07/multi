        <!-- Main Container Start -->
		<div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
                
            	
               
				<span style="font-size:18px;"><b> Agent -> <?PHP echo $uid;?></b></span>
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
                                    <td align="center"><?PHP echo number_format(($report_data['total_meb_strike']),2,'.',',');?></td>
									<td align="center" rowspan="2"><?PHP echo number_format($master_payable_nett,2,'.',','); ?></td>
									<td align="center" rowspan="2" style="padding:0">
										<table class="mws-table">
											<thead>
												<tr align="center">
													<?PHP if($report_data['share_co_perc'] > 0) {?>
													<th>CO</th>
													<?PHP }
													if($report_data['share_mas_perc'] > 0) {?>
													<th>MA IT</th>
													<?PHP }
													if($report_data['share_agg_perc'] > 0) {?>
													<th>GP IT</th>
													<?PHP } ?>
												</tr>
											</thead>
											<tbody>
												<tr align="center" style="border:1px solid #D8D8D8;">
													<?PHP if($report_data['share_co_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_data['share_co_amt'],2,'.',','); ?></td>
													<?PHP }
													if($report_data['share_mas_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_data['share_mas_amt'],2,'.',','); ?></td>
													<?PHP }
													if($report_data['share_agg_perc'] > 0) {?>
													<td style="padding:0"><?PHP echo number_format($report_data['share_agg_amt'],2,'.',','); ?></td>
													<?PHP } ?>
												</tr>
											</tbody>
										</table>
									</td>
                                    <td align="center" rowspan="2"><?PHP echo number_format((0 -$report_data['total_own_intake_tax']),2,'.',',');?></td>
                                    <td align="center" rowspan="2"><?PHP echo number_format($master_nett,2,'.',','); ?></td>
                                </tr>
								<tr>
                                    <td align="center">Intake</td>
                                    <td align="center"><?PHP echo number_format($report_data['total_own_intake_ticket'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($report_data['total_own_strike'],2,'.',',');?></td>
                               </tr>
                            </tbody>

                            <thead>
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
                                    <td align="center"><?PHP echo number_format($report_data['total_meb_strike'],2,'.',',');?></td>
                                    <td align="center"><?PHP echo number_format($downline_payable_nett,2,'.',',');?></td>
                                    <td align="center">--</td>
                                    <td align="center">--</td>
                                    <td align="center"><?PHP echo number_format($downline_payable_nett,2,'.',',');?></td>
                                </tr>
							 </tbody>

                               <tr style="border:1px solid #D8D8D8;">
									<td colspan="6" align="right"><b>My P/L Nett</b></td>
                                    <td align="center"><b><?PHP echo number_format($po_wl,2,'.',',');?></b></td>
							   </tr>

                        </table>
                    </div>
                </div>

				<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Intake</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th>Intake Total</th>
                                    <th>Intake Strike</th>
                                    <th>Nett</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td align="center"><?PHP echo number_format($report_data['total_own_intake_ticket'],2,'.',','); ?></td>
                                    <td align="center"><?PHP echo number_format($report_data['total_own_strike'],2,'.',','); ?></td>
                                    <td align="center">
									<?PHP echo number_format(($report_data['total_own_intake_ticket'] - $report_data['total_own_strike']),2,'.',','); ?></td>
                                </tr>
                               <tr>
									<td colspan="2" align="right"><b>Intake Tax</b></td>
                                    <td align="center"><b><?PHP echo number_format($report_data['total_own_intake_tax'],2,'.',','); ?></b></td>
							   </tr>
                               <tr>
									<td colspan="2" align="right"><b>Intake Win/Lose Nett</b></td>
                                    <td align="center"><b>
									<?PHP echo number_format(($report_data['total_own_intake_ticket'] - $report_data['total_own_strike'] - $report_data['total_own_intake_tax']),2,'.',','); ?></b></td>
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
									<th>Big</th>
									<th>Small</th>
									<th>Amount</th>
                                    <th>Strike</th>
                                    <th>Ticket Nett</th>
                                    <th></th>
                                </tr>
                            </thead>
<?PHP
						$total_po_big = 0;
						$total_po_small = 0;
						$total_po_ticket = 0;
						$total_po_strike = 0;
						$total_report_nett = 0;

						foreach($downline_report_array as $downline_report_data)
						{
							if ($downline_report_data['total_ticket'] > 0)
							{
								$downline_report_ticket_nett = $downline_report_data['total_strike'] - $downline_report_data['total_ticket'];

								$total_po_big = $total_po_big + $downline_report_data['total_po_big'];
								$total_po_small = $total_po_small + $downline_report_data['total_po_small'];
								$total_po_ticket = $total_po_ticket + $downline_report_data['total_ticket'];
								$total_po_strike = $total_po_strike + $downline_report_data['total_strike'];
								$total_report_nett = $total_report_nett + $downline_report_ticket_nett;


?>
                            <tbody>

                                <tr style="border:1px solid #D8D8D8;">
									<td align="center" rowspan="2" style="padding:0"><?PHP echo $downline_report_data['meb_id']." (".$downline_report_data['name'].")";?></td>
                                    <td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_po_big'],2,'.',','); ?></td>
                                    <td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_po_small'],2,'.',','); ?></td>
                                    <td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_ticket'],2,'.',','); ?></td>
									<td align="center" style="padding:0"><?PHP echo number_format($downline_report_data['total_strike'],2,'.',','); ?></td>
                                    <td align="center" rowspan="2" style="padding:0"><?PHP echo number_format($downline_report_ticket_nett,2,'.',','); ?></td>
                                </tr>
                            </tbody>

<?PHP
							}
						}
?>
                            <tbody>
								<tr style="border:1px solid #D8D8D8;">
									<td align="right" style="padding:0"><b>Total:</b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_po_big,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_po_small,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_po_ticket,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_po_strike,2,'.',','); ?></b></td>
                                    <td align="center" style="padding:0"><b><?PHP echo number_format($total_report_nett,2,'.',','); ?></b></td>
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
