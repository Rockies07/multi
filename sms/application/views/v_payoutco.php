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
                                <td><span><i class="icon-table"></i><b> Calculate Payout</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								Date: 
								<?php echo form_dropdown('draw', $drawdate); ?>
								&nbsp;&nbsp;
                                <input type="submit" class="btn" name="Payout" value="Payout" onClick='javascript:return confirm(\"Are you sure want to payout?\")'></input>
                                </span></td>
                                <td>
							  </td>
                            </tr>
							<?PHP echo form_close(); ?>
                        </table>
                  </div><br >
            	</div>

<?PHP
	if($this->input->post('draw'))
	{
?>
				
				<div class="mws-panel grid_5">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>Calculation Status</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table align = "center">
                            <thead>
                                <tr>
                                    <th><div align="center">Logs</div></th>
                                </tr>
                            </thead>
                            <tbody>

							<tr>
                                <td><iframe id="w1" height="170" border=0 width="640" src="<?php echo site_url('c_payoutco/getstatus/'.$today);?>"></iframe></div></td>
							</tr>

							<tr>
                                <td></div></td>
							</tr>
							<tr>
                                <td></div></td>
							</tr>
							<tr>
                                <td></div></td>
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
