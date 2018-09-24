        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
                
            	
               
            	<div class="mws-panel grid_6">
                
            <div class="mws-panel-header">
            <div class="clearfix"></div>
                        <table cellpadding="0" cellspacing="0" width="100%">
                        	<tr>
								<?PHP echo form_open(''); ?>
                                <td><span><i class="icon-table"></i><b> Company Stake</b></span></td>
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
				$attributes = array(
							  'width'      => '915',
							  'height'     => '570',
							  'scrollbars' => 'yes',
							  'status'     => 'no',
							  'resizable'  => 'no',
							  'screenx'    => '0',
							  'screeny'    => '0'
							);				
?>
				
				<div class="mws-panel grid_6">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>System Intake Summary</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th><div align="center">Level</div></th>
                                    <th><div align="center">Intake Big</div></th>
                                    <th><div align="center">Intake Small</div></th>
                                    <th><div align="center">Big Nett</div></th>
									<th><div align="center">Small Nett</div></th>
                                    <th><div align="center">Total Amt</div></th>
                                    <th><div align="center">Download</div></th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><div align="center">System Intake</div></td>
                                    <td><div align="center"><?PHP echo $system_intake_data['set_big']; ?></div></td>
                                    <td><div align="center"><?PHP echo $system_intake_data['set_small']; ?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($system_intake_data['amt_big'] * 1.6),2,'.',','); ?></div></td>
									<td><div align="center"><?PHP echo number_format(($system_intake_data['amt_small'] * 0.7),2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($system_intake_data['amt_big'] * 1.6) + ($system_intake_data['amt_small'] * 0.7),2,'.',','); ?></div></td>
                                    <td><div align="center"><?php echo anchor_popup('c_companystake/download/sys_in/'.$today,'download',$attributes);?></div></td>
                                </tr>

                                <tr>
                                    <td><div align="center">System Out</div></td>
                                    <td><div align="center">-</div></td>
                                    <td><div align="center">-</div></td>
                                    <td><div align="center"><?PHP echo number_format(($bookie_intake_data['amt_big'] * 1.6),2,'.',','); ?></div></td>
									<td><div align="center"><?PHP echo number_format(($bookie_intake_data['amt_small'] * 0.7),2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($bookie_intake_data['amt_big'] * 1.6) + ($bookie_intake_data['amt_small'] * 0.7),2,'.',','); ?></div></td>
									<td><div align="center"><?php echo anchor_popup('c_companystake/download/sys_out/'.$today,'download',$attributes);?></div></td>
                                </tr>

								<tr>
								  <td colspan="7">&nbsp;</td>
							  </tr>
								<tr>
								  <td colspan="7">&nbsp;</td>
							  </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

				<div class="mws-panel grid_6">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>Master Bet Summary</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th><div align="center">Level</div></th>
                                    <th><div align="center">Big Nett</div></th>
									<th><div align="center">Small Nett</div></th>
                                    <th><div align="center">Total Amt</div></th>
                                    <th><div align="center">Download</div></th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><div align="center">Master Bet</div></td>
                                    <td><div align="center"><?PHP echo number_format(($master_po_data['amt_big'] * 1.6),2,'.',','); ?></div></td>
									<td><div align="center"><?PHP echo number_format(($master_po_data['amt_small'] * 0.7),2,'.',','); ?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($master_po_data['amt_big'] * 1.6) + ($master_po_data['amt_small'] * 0.7),2,'.',','); ?></div></td>
                                    <td><div align="center"><?php echo anchor_popup('c_companystake/download/mas_out/'.$today,'download',$attributes);?></div></td>
                                </tr>

								<tr>
								  <td colspan="7">&nbsp;</td>
							  </tr>
								<tr>
								  <td colspan="7">&nbsp;</td>
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
