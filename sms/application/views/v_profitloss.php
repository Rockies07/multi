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
                                <td><span><i class="icon-table"></i><b> P/L Report</b></span></td>
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
                    	<span><i class="icon-table"></i><b>Draw : <?PHP echo $this->input->post('fromdate'); ?>&nbsp;&nbsp;To&nbsp;&nbsp;<?PHP echo $this->input->post('todate'); ?></b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th><div align="center">My</div></th>
									<th><div align="center">Ticket</div></th>
									<th><div align="center">Strike</div></th>
									<th><div align="center">Win/Lose</div></th>
                                    <th><div align="center">Share</div></th>
                                    <th><div align="center">Tax</div></th>
                                    <th><div align="center">Nett</div></th>
                                </tr>
                            </thead>
                            <tbody>
								<tr>
									<td><div align="center">To Upline</div></td>
									<td><div align="center">1</div></td>
									<td><div align="center">1</div></td>
									<td rowspan="2"><div align="center">1</div></td>
									<td rowspan="2"><div align="center">1</div></td>
									<td rowspan="2"><div align="center">1</div></td>
									<td rowspan="2"><div align="center">1</div></td>
								</tr>
								<tr>
									<td><div align="center">From Downline</div></td>
									<td><div align="center">1</div></td>
									<td><div align="center">1</div></td>
									</tr>
								<tr>

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
