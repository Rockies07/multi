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
                                <td><span><i class="icon-table"></i><b> Download ARA</b></span></td>
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
	if($this->input->post('draw'))
	{
?>
				
				<div class="mws-panel grid_7">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>Bookie Info</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th><div align="center">Bookie ID</div></th>
                                    <th><div align="center">Big</div></th>
                                    <th><div align="center">Small</div></th>
                                    <th><div align="center">Nett</div></th>
                                    <th><div align="center">Download</div></th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP
						foreach($bookie_array as $bookie_data)
						{
?>

                                <tr>
                                    <td><div align="center"><?PHP echo $bookie_data['bok_id'];?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($bookie_data['amt_big'] * $bigvalue), 2, '.',',');?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($bookie_data['amt_small'] * $smallvalue),2,'.',',');?></div></td>
                                    <td><div align="center"><?PHP echo number_format((($bookie_data['amt_big'] * $bigvalue) + ($bookie_data['amt_small'] * $smallvalue)),2,'.',',');?></div></td>
                                    <td><div align="center"><a href="<?php echo site_url('c_downloadara/downloadara/'.$today.'/'.$bookie_data['bok_id']);?>"><B>download</b></a></td>
                                </tr>
<?PHP

						}
?>
							<tr>
                                <td><div colspan="5"></div></td>
							</tr>
							<tr>
                                <td><div colspan="5"></div></td>
							</tr>
							<tr>
                                <td><div colspan="5"></div></td>
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
