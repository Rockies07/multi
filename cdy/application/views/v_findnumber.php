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
                                <td><span><i class="icon-table"></i><b> Find Number</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								Select Date:&nbsp;
								<?php echo form_dropdown('fromdate', $drawdate); ?>
								&nbsp;&nbsp;
								Number: &nbsp;
								<input type="text" maxlength="4" style="width: 60px;" name="number" value=""></input>
                                <input type="submit" class="btn" name="view" value="view"></input>
                                </span></td>
                            </tr>
							<?PHP echo form_close(); ?>
                        </table>
                  </div><br >
            	</div>

<?PHP
	if($this->input->post('view'))
	{
?>
				
				<div class="mws-panel grid_6">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>Draw : <?PHP echo $this->input->post('fromdate'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number: <?PHP echo $this->input->post('number'); ?></b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
						
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th><div align="center">Member</div></th>
                                    <th><div align="center">Big</div></th>
                                    <th><div align="center">Small</div></th>
									<th><div align="center">Cmd</div></th>
                                    <th><div align="center">Downline Intake Big</div></th>
                                    <th><div align="center">Downline Intake Sml</div></th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP
								$report_array = $this->m_accounts->get_trans_records($this->input->post('fromdate'),$this->input->post('number'));

								foreach($report_array as $report_data)
								{

									
									$intake_big = $report_data['mas_intake_big'] + $report_data['agg_intake_big'] + $report_data['agt_intake_big'];
									$intake_small = $report_data['mas_intake_small'] + $report_data['agg_intake_small'] + $report_data['agt_intake_small'];
									
									$total_big = $total_big + $report_data['amt_big'];
									$total_small = $total_small + $report_data['amt_small'];
									$total_inbig = $total_inbig + $intake_big;
									$total_insmall = $total_insmall + $intake_small;
?>									
									<tr>
										<td><div align="center"><?PHP echo $report_data['meb_id']; ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['amt_big'],2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo number_format($report_data['amt_small'],2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo $report_data['cmd']; ?></div></td>
										<td><div align="center"><?PHP echo number_format($intake_big,2,'.',','); ?></div></td>
										<td><div align="center"><?PHP echo number_format($intake_small,2,'.',','); ?></div></td>

									</tr>
<?PHP
								}

?>
									<tr>
										<td><div align="center"><strong>Total</strong></div></td>
										<td><div align="center"><strong><?PHP echo number_format($total_big,2,'.',','); ?></strong></div></td>
										<td><div align="center"><strong><?PHP echo number_format($total_small,2,'.',','); ?></strong></div></td>
										<td><div align="center"><strong>--</strong></div></td>
										<td><div align="center"><strong><?PHP echo number_format($total_inbig,2,'.',','); ?></strong></div></td>
										<td><div align="center"><strong><?PHP echo number_format($total_insmall,2,'.',','); ?></strong></div></td>

									</tr>
									<tr>
										<td><div align="center"><strong>To System</strong></div></td>
										<td><div align="center"><strong><?PHP echo number_format(($total_big - $total_inbig),2,'.',','); ?></strong></div></td>
										<td><div align="center"><strong><?PHP echo number_format(($total_small - $total_insmall),2,'.',','); ?></strong></div></td>
										<td colspan="3"><div align="center"><strong>--</strong></div></td>

									</tr>							
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
