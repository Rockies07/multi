
        
        <!-- Main Container Start -->
		
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
               
            	<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-official"></i> My Profile</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                              
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="boldr"></i>ID</td>
                                    <td><?PHP echo $uid;?></td>
                                </tr>             
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mws-panel grid_4">
                    <div class="mws-panel-header">
                        <span><i class="icon-key"></i> Change Password</span>
                    </div>
					<div style='color:red'><?PHP echo validation_errors(); ?></div>
                    <div class="mws-panel-body no-padding">
			<?PHP
			$attributes = array('class' => 'mws-form');
			echo form_open('c_changepass', $attributes); 
			?>
                            <fieldset class="mws-form-inline">
                                
                                <div class="mws-form-row bordered">
									<label class="mws-form-label">New Password</label>
                                    <div class="mws-form-item">
                                        <input type="password" class="small" name='new_pass1'>
                                    </div>
									<label class="mws-form-label">Confirm New Password</label>
                                    <div class="mws-form-item">
                                        <input type="password" class="small" name='new_pass2'>
                                    </div>
                                </div>
                                
                            </fieldset>
                           
                            <div class="mws-button-row">
                                <input type="submit" value="Submit" class="btn btn-danger">
                                <input type="reset" value="Reset" class="btn ">
                            </div>
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
