
        <!-- Main Container Start -->

<script src="assets/js/libs/jquery-1.8.3.min.js"></script>
		
<SCRIPT>
	$(document).ready(function()
	{      
        $('#addman').click(function() 
		{     
			window.open('<?PHP echo site_url("c_usermgt/add/manager"); ?>', '_blank', 'width=885,height=680,scrollbars=yes,status=no,resizable=no,screenx=0,screeny=0');
		});
        $('#addbok').click(function() 
		{     
			window.open('<?PHP echo site_url("c_usermgt/add/bookie"); ?>', '_blank', 'width=885,height=680,scrollbars=yes,status=no,resizable=no,screenx=0,screeny=0');
		});
        $('#addsub').click(function() 
		{     
			window.open('<?PHP echo site_url("c_usermgt/add/subadmin"); ?>', '_blank', 'width=885,height=680,scrollbars=yes,status=no,resizable=no,screenx=0,screeny=0');
		});
	});
</SCRIPT>
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->

            	<!-- Statistics Button Container -->

			<div class="mws-stat-container">
                    <!-- Statistic Item -->
                	<a class="mws-stat" href="<?PHP echo site_url('c_usermgt/view/manager/'); ?>">
                    	<!-- Statistic Icon (edit to change icon) -->
                    	<span class="mws-stat-icon icol32-building"></span>
                        
                        <!-- Statistic Content -->
                        <span class="mws-stat-content">
                        	<span class="mws-stat-title">Manager</span>
                            <span class="mws-stat-value"><?PHP echo $count_users['man']; ?></span>
                        </span>
						<button type="button" class="btn" id="addman">Add</button>
                    </a>

                	<a class="mws-stat" href="<?PHP echo site_url('c_usermgt/view/bookie/'); ?>">
                    	<!-- Statistic Icon (edit to change icon) -->
                    	<span class="mws-stat-icon icol32-building"></span>
                        
                        <!-- Statistic Content -->
                        <span class="mws-stat-content">
                        	<span class="mws-stat-title">Bookie</span>
                            <span class="mws-stat-value"><?PHP echo $count_users['bok']; ?></span>
                        </span>
						<button type="button" class="btn" id="addbok">Add</button>
                    </a>

                	<a class="mws-stat" style="border:3px solid red" href="<?PHP echo site_url('c_usermgt/view/subadmin/'); ?>">
                    	<!-- Statistic Icon (edit to change icon) -->
                    	<span class="mws-stat-icon icol32-building"></span>
                        
                        <!-- Statistic Content -->
                        <span class="mws-stat-content">
                        	<span class="mws-stat-title">Sub Admin</span>
                            <span class="mws-stat-value"><?PHP echo $count_users['sub']; ?></span>
                        </span>
						<button type="button" class="btn" id="addsub">Add</button>
                    </a>

			</div>
			<br>

                <!-- Panels Start -->




            	<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-official"></i> <b>Users Management </b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table mws-datatable"  style="FONT-SIZE: 13px;">
                            <thead>
								<td align="center"><b>Sub Admin ID</b></td>
								<td align="center"><b>Password</b></td>
								<td align="center"><b>Edit</b></td>
                            </thead>
                            <tbody>
<?PHP
	foreach($member_array as $member_data)
	{
?>
                                <tr>
								<td align="center"><?PHP echo $member_data['adm_id']; ?></td>
								<td align="center"><?PHP echo $member_data['password']; ?></td>
								<td align="center"><?PHP echo anchor_popup('c_usermgt/edit/subadmin/'.$member_data['adm_id'], 'Edit', $attributes); ?></td>
								</tr>
<?PHP
	}
?>
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
