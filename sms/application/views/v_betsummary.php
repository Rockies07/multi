
        
        <!-- Main Container Start -->
		
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
               
            	<div class="mws-panel grid_5">
                	<div class="mws-panel-header">
                    	<span><i class="icon-official"></i><b> Bet Summary</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table" style="FONT-SIZE: 15px;">
                            <thead>
                              
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="boldr" align="right"></i>Member ID</td>
                                    <td><?PHP echo $this->session->flashdata('meb_id');?></td>
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Commission</td>
                                    <td><?PHP echo number_format($this->session->flashdata('placeout_com'),2,'.','.');?> %</td>
                                    
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Total Big</td>
                                    <td><?PHP echo $this->session->flashdata('totalbig');?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Total Small</td>
                                    <td><?PHP echo $this->session->flashdata('totalsmall');?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Amount</td>
                                    <td><?PHP echo number_format($this->session->flashdata('totalamt'),2,'.',',');?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Nett</td>
                                    <td><?PHP echo number_format($this->session->flashdata('totalmeb'),2,'.',',');?></td> 
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"><a href="<?php echo site_url('c_entry');?>">Continue Entry</a></td>
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
