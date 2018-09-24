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
                                <td><span><i class="icon-table"></i><b> Company Strike Details</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								Draw: 
								<?php echo form_dropdown('fromdate', $drawdate); ?>
								&nbsp;&nbsp;
                                <input type="submit" class="btn" value="VIEW"></input>
                                </span></td>
                                <td>
							  </td>
                            </tr>
							<?PHP echo form_close(); ?>
                        </table>
                  </div><br >
            	</div>

 <?PHP
	if($this->input->post())
	{
 ?>
				
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Details for <?PHP echo $selectdate; ?></b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table" style="padding:0">
                            <thead>
                                <tr>
                                    <th rowspan="2"><div align="center" style="padding:0">Prize</div></th>
                                    <th rowspan="2"><div align="center" style="padding:0">Number</div></th>
                                    <th colspan="3"><div align="center">Member Bets</div></th>
                                    <th colspan="3"><div align="center">System Intake</div></th>
									<th colspan="3"><div align="center">Bookie Intake</div></th>
                                    <th colspan="3"><div align="center">Downline Intake</div></th>
                                </tr>
                                <tr>
                                    <th><div align="center">Big</div></th>
                                    <th><div align="center">Small</div></th>
                                    <th><div align="center">Strike</div></th>
                                    <th><div align="center">Big</div></th>
                                    <th><div align="center">Small</div></th>
                                    <th><div align="center">Strike</div></th>
                                    <th><div align="center">Big</div></th>
                                    <th><div align="center">Small</div></th>
                                    <th><div align="center">Strike</div></th>
                                    <th><div align="center">Big</div></th>
                                    <th><div align="center">Small</div></th>
                                    <th><div align="center">Strike</div></th>
                                </tr>

                            </thead>
                            <tbody>
<?PHP
							foreach($results_array as $results_data)
							{
?>
                                <tr>
                                    <td><div align="center" style="padding:0"><?PHP echo $results_data['prizetype'];?></div></td>
                                    <td><div align="center" style="padding:0"><?PHP echo $results_data['number'];?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['member_big'],2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['member_small'],2,'.',','); ?></div></td>
									<td><div align="center"><?PHP echo number_format($results_data['member_strike'],2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['company_big'],2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['company_small'],2,'.',','); ?></div></td>
									<td><div align="center"><?PHP echo number_format($results_data['company_strike'],2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['bookie_big'],2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['bookie_small'],2,'.',','); ?></div></td>
									<td><div align="center"><?PHP echo number_format($results_data['bookie_strike'],2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['other_big'],2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format($results_data['other_small'],2,'.',','); ?></div></td>
									<td><div align="center"><?PHP echo number_format($results_data['other_strike'],2,'.',','); ?></div></td>
                                </tr>
<?PHP
							}
?>
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
