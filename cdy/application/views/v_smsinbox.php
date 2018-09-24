        <!-- Main Container Start -->

        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
                
            	
               
            	<div class="mws-panel grid_8">
                
            <div class="mws-panel-header content_link">
            <div class="clearfix"></div>
                        <table cellpadding="0" cellspacing="0" width="100%">
                        	<tr>
                                <td><span><i class="icon-table"></i><b> Incoming SMS</b></span></td>
								<td style="font-size:15px">
								<a href="<?php echo site_url('c_smsincoming');?>"><u>Incoming SMS</u></a> / 
								<strong>Inbox</strong> / 
								<a href="<?php echo site_url('c_smssent');?>"><u>Sent</u></a> / 
								<a href="<?php echo site_url('c_smstrash');?>"><u>Trash</u></a> 
								</td>
                                <td>
							  </td>
                            </tr>
                        </table>
                  </div><br >
            	</div>

			
                
				
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Inbox</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table" style="width: 100%;">
							<?PHP echo form_open(''); ?>
                            <thead>
                                <tr>
                                    <th><div align="center">ID</div></th>
                                    <th><div align="center">Message</div></th>
                                    <th><div align="center">Mobile</div></th>
                                    <th><div align="center">Date Time</div></th>
                                    <th><div align="center">Member</div></th>
									<th><div align="center">Action</div></th>
                                    <th><div align="center">Bet Entry</div></th>
                                   <th><div align="center"><input type="checkbox" onclick="check_all_inbox()" id="delete_all"></div></th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP
					foreach($sms_array as $sms_data)
					{
?>
                                <tr style="font-size:15px">
                                    <td><div align="center"><?PHP echo $sms_data['id']?></div></td>
                                    <td width="450" style="word-break: break-all;"><div align="center"><?PHP echo $sms_data['msg']?></div></td>
                                    <td><div align="center"><?PHP echo $sms_data['mobile']?></div></td>
                                    <td><div align="center"><?PHP echo $sms_data['datetime']?></div></td>
									<td><div align="center"><?PHP echo $sms_data['meb_id']?></div></td>
                                    <td style="white-space: nowrap"><div align="center">
									<?php echo anchor_popup("c_reply/reply_view/".urlencode($sms_data['id'])."/false", '<i class="icol32-comment"></i>', $attributes2);?>
									<?php echo anchor_popup("c_reply/reply_view/".urlencode($sms_data['id'])."/true", '<i class="icol32-email"></i>', $attributes2);?>
									</div></td>
                                    <td style="white-space:nowrap"><div align="center"><?php echo anchor_popup("c_entry/entry/".$sms_data['meb_id'], 'Bet Entry', $attributes);?></div></td>
                                    <td><div align="center"><input type='checkbox' name='check_list[]' class="delete_data" value='<?PHP echo $sms_data['id']?>'></input></div></td>
                                </tr>
<?PHP
					}
?>
								<tr>
									<td colspan="8" align="right"><input type='submit' name='Reply' value='Reply'><input type='submit' name='Delete' value='Delete'><input type='submit' name='Return' value='Return'></td>
								</tr>
							</tbody>
	  						<?PHP echo form_close(); ?>

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
	<script>
		function check_all_inbox()
		{
			if($("#delete_all").is(':checked'))
			{
				$(".delete_data").prop('checked', true);
			}
			else
			{
				$(".delete_data").prop('checked', false);
			}
		}
	</script>
</body>
</html>
