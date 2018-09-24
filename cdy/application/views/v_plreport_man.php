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
								<?PHP echo form_open('c_profitloss/view/'); ?>
                                <td><span><i class="icon-table"></i><b> PlaceOut Summary</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								From:
								<?php echo form_dropdown('fromdate', $drawdate); ?>
								&nbsp;&nbsp;
								To:
                                <?php echo form_dropdown('todate', $drawdate); ?>
								&nbsp;&nbsp;&nbsp;&nbsp;
								Select Master:									
								<?php echo form_dropdown('uid', $downline_data); ?>	
                                <input type="submit" class="btn" name="view" value="VIEW">
                                </span></td>
                                <td>
							  </td>
                            </tr>
							<?PHP echo form_close(); ?>
                        </table>
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
