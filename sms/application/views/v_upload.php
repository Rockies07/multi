
        
        <!-- Main Container Start -->
		
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
               
            	<div class="mws-panel grid_7">
                	<div class="mws-panel-header">
                    	<span><i class="icon-official"></i> <b>Pending ARA</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <td align="center"><b>Delete</b></td>
                                    <td align="center"><b>Upload by</b></td>
                                    <td align="center"><b>File Name</b></td>
                                    <td align="center"><b>File Size</b></td>
                                    <td align="center"><b>Upload Time</b></td>
                                    <td align="center"><b>Load</b></td>
                                </tr>

                            </thead>
                            <tbody>
<?PHP
	if(!empty($upload_records))
	{
		foreach($upload_records as $records)
		{
?>
                                <tr>
                                    <td align="center"><?PHP echo anchor('c_upload/delete_ara/'.$records['fileref'].'/'.$uid, 'Delete'); ?></td>
                                    <td align="center"><?PHP echo $records['uploaded_by']; ?></td>
                                    <td align="center"><?PHP echo $records['ara_filename']; ?></td>
                                    <td align="center"><?PHP echo $records['ara_filesize']; ?> KB</td>
                                    <td align="center"><?PHP echo $records['datetime']; ?></td>
                                    <td align="center"><?PHP echo anchor('c_upload/load_ara/'.$records['fileref'].'/'.$uid, 'Load File'); ?></td>
                                </tr>
<?PHP
		}
	}
?>
								<tr>
									<td  colspan="6" align="center">--</td>
								</tr>

								<tr>
									<td  colspan="6" align="center">*All ARA files will be Loaded to the <b>Current Draw Only</b>.</td>
								</tr>
								<tr>
									<td colspan="6" align="center">Please check your ARA records at P.O Report by Page when Loaded.</td>
								</tr>


							</tbody>
                        </table>
                    </div>
                </div>
                <div class="mws-panel grid_4">
                    <div class="mws-panel-header">
                        <span><i class="icon-key"></i> <b>Upload File</b></span>
                    </div>
					<div style='color:red'><?PHP echo validation_errors(); ?></div>
                    <div class="mws-panel-body no-padding">
			<?PHP
			echo form_open_multipart('c_upload/do_upload');
			//echo form_open('c_showpost');
?>
                            <fieldset class="mws-form-inline">
                                
                                <div class="mws-form-row bordered">
									<input name="myFile" size="40" type="file">
									<input type="submit" value="Upload">
                                </div>
                                
                            </fieldset>
                         </form>
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
