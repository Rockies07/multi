
        
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
                                <tr>
                                    <td class="boldr"> Name</span></td>
                                    <td><?PHP echo $userdata['name'];?></td>
                                </tr>
                                <tr>
                                    <td class="boldr" >Ticket Rate</td>
									<td> 
										<span style="width:100%;">
										<span style="width:50%;"><b>Big:</b> <?PHP echo $bigvalue;?></span>
										<span style="width:50%; padding-left:25%;"><b>Small:</b> <?PHP echo $smallvalue;?></span>
										</span>
									</td>
                                </tr>
                                <tr>
                                    <td class="boldr">Ticket Commission</td>
                                    <td><?PHP echo $userdata['placeout_com'];?> %</td>
                                    
                                </tr>
<?PHP
if (isset($userdata['intake_tax']))
{
?>
                                <tr>
                                    <td class="boldr">Intake Tax</td>
                                    <td><?PHP echo $userdata['intake_tax'];?> %</td> 
                                </tr>
                                <tr>
                                    <td class="boldr">Intake Big</td>
                                    <td><?PHP echo $userdata['intake_big'];?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr">Intake Small</td>
                                    <td><?PHP echo $userdata['intake_small'];?></td> 
                                </tr>
<?PHP
}
			switch(strlen($uid))
			{
				case 2: $msg_upline = 'Company';
						unset($shareupwl);
						break;
				case 4: $msg_upline = 'Upline Company';
						$shareupwl = $userdata['share_mas'];
						break;
				case 6: $msg_upline = 'Upline Company';
						$shareupwl = 0;
						$shareupwl = $userdata['share_agg'];
						break;
			}

if (isset($userdata['share_co']) && $userdata['share_co'] > 0)
{

?>
								<tr>
                                    <td class="boldr">Share <?PHP echo $msg_upline;?> P/L</td>
                                    <td><?PHP if($userdata['share_co'] > 0){ echo 'Yes ('.$userdata['share_co'].'%)';} else{echo 'No (0%)';}?></td>
                                </tr>
<?PHP
}
if (isset($userdata['share_po']) && $userdata['share_po'] > 0)
{
?>			
                                <tr>
                                    <td class="boldr">Share <?PHP echo $msg_upline;?> Place Out</td>
                                    <td><?PHP if($userdata['share_po'] > 0){ echo 'Yes ('.$userdata['share_po'].'%)';} else{echo 'No (0%)';}?></td>
                                </tr>
<?PHP
}
if (isset($userdata['share_mas']) && $userdata['share_mas'] > 0)
{
?>			
                                <tr>
                                    <td class="boldr">Share Master Intake Win/Loss</td>
                                    <td><?PHP if($userdata['share_mas'] > 0){ echo 'Yes ('.$userdata['share_mas'].'%)';} else{echo 'No (0%)';}?></td>
                                </tr>
<?PHP
}
if (isset($userdata['share_agg']) && $userdata['share_agg'] > 0)
{
?>			
                                <tr>
                                    <td class="boldr">Share Group Intake Win/Loss</td>
                                    <td><?PHP if($userdata['share_agg'] > 0){ echo 'Yes ('.$userdata['share_agg'].'%)';} else{echo 'No (0%)';}?></td>
                                </tr>
<?PHP
}
?>
								<tr>
                                    <td class="boldr">Status</td>
                                    <td><?PHP echo $userdata['status'];?></td>
                                    
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
