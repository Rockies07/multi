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
                                <td><span><i class="icon-table"></i><b> Select Date</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								Date: 
								<?php echo form_dropdown('draw', $drawdate); ?>
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
				
				<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Clear Table Details for Date => <?PHP echo $this->input->post('draw'); ?></b></span>
                    </div>
                    <div class="mws-panel-body no-padding">

					<?PHP 
						$hidden = array('draw' => $this->input->post('draw'),
							);
						$x = 1;
						echo form_open('c_clear/clear', '', $hidden); 
					?>
                        <table class="mws-table">
                            <tbody>
                                <tr>
                                    <td><div align="center">Clear Payout</div></td>
                                    <td><div align="center"><input type="submit" class="btn" name="clr" value="Clear Payout"></input></div></td></div></td>
                                </tr>
                                <tr>
                                    <td><div align="center">Clear Results</div></td>
                                    <td><div align="center"><input type="submit" class="btn" name="clr" value="Clear Results"></input></div></td></div></td>
                                </tr>
                                <tr>
                                    <td><div align="center">Clear Generate ARA</div></td>
                                    <td><div align="center"><input type="submit" class="btn" name="clr" value="Clear Gen ARA"></input></div></td></div></td>
                                </tr>
                                <tr>
                                    <td><div align="center">Clear Placeout Return</div></td>
                                    <td><div align="center"><input type="submit" class="btn" name="clr" value="Clear PO Return"></input></div></td></div></td>
                                </tr>
							<tr>
                                <td colspan="5" ><div align="center"> -- </div></td>
							</tr>
                            </tbody>
                        </table>
						<?PHP echo form_close(); ?>
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
