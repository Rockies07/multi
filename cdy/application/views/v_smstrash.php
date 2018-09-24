        <!-- Main Container Start -->
<style type="text/css">
<style type="text/css">
.content_link a:link{
color:black;
}
.content_link a:visited{
color:black;
}
.content_link a:hover{
color:black;
}
.content_link a:active{
color:black;
}
select
{
	padding: 5px;
}
</style>

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
								<a href="<?php echo site_url('c_smsinbox');?>"><u>Inbox</u></a> / 
								<a href="<?php echo site_url('c_smssent');?>"><u>Sent</u></a> / 
								<strong>Trash</strong>
								</td>
                                <td>
							  </td>
                            </tr>
                        </table>
                  </div><br >
            	</div>

			
                
				
				<div class="mws-panel grid_8">
					<?PHP echo form_open(''); ?>						
						<div class="mws-panel-header">
							<table cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td><span><i class="icon-table"></i><b> Trash</b></span></td>
									<td style="font-size:15px" align="right">
										ID: 
										<input type="text" name="filter_id" value="<?php echo isset($filter_id)?$filter_id:'';?>">
										&nbsp;&nbsp;&nbsp;&nbsp;
										From: 
										<select name="filter_date">
										<?php
											if($filter_date!="")
											{
												echo "<option value='$filter_date'>".date('d M Y (D)',strtotime($filter_date))."</option>";
											}
										?>
											<option value="">All</option>
										<?php 
											foreach($sms_date as $sms_data)
											{	
												echo "<option value='".date('Y-m-d',strtotime($sms_data['datetime']))."'>".date('d M Y (D)',strtotime($sms_data['datetime']))."</option>";
											}
										?>
										</select>
										<input type="submit" class="btn" name="view" value="View Record"></input>
									</td>
								</tr>
							</table>				
						</div>
					<?PHP echo form_close(); ?>	
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table" style="width: 100%;">
                            <thead>
                                <tr>
                                   <th><div align="center">Msg ID.</div></th>
                                    <th><div align="center">Mobile</div></th>
                                    <th><div align="center">Date Time</div></th>
                                    <th><div align="center">Member</div></th>
                                    <th><div align="center">Enter By</div></th>
                                    <th><div align="center" style="word-wrap:break-word">Message</div></th>
                                    <th><div align="center">Check</div></th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP
					foreach($sms_array as $sms_data)
					{
						echo form_open('');
?>
                                <tr style="font-size:15px">
                                    <td><div align="center"><?PHP echo $sms_data['id']?></div></td>
                                    <td><div align="center"><?PHP echo $sms_data['mobile']?></div></td>
                                    <td style="white-space: nowrap"><div align="center"><?PHP echo $sms_data['datetime']?></div></td>
									<td><div align="center"><?PHP echo $sms_data['meb_id']?></div></td>
									<td><div align="center"><?PHP echo $sms_data['assign']?></div></td>
									<td width="450" style="word-break: break-all;"><div align="center"><?PHP echo $sms_data['msg']?></div></td>	
                                    <td><div align="center"><input type='checkbox' name='check_list[]' value="<?PHP echo $sms_data['id']; ?>"></div></td>
                                </tr>
<?PHP					 
					}
?>
								<tr>
									<td colspan="6" align="right"><input type='submit' name='Undelete' value='Undelete'></td>
								</tr>

							</tbody>
<?PHP
								echo form_close();
?>
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
