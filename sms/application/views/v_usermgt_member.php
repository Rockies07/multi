
        <!-- Main Container Start -->
		<script src="assets/js/libs/jquery-1.8.3.min.js"></script>
		
<SCRIPT>
	$(document).ready(function()
	{      
        $('#addagg').click(function() 
		{     
			window.open('<?PHP echo site_url("c_usermgt/add/agentgroup"); ?>', '_blank', 'width=885,height=680,scrollbars=no,status=no,resizable=no,screenx=0,screeny=0');
		});
        $('#addagt').click(function() 
		{     
			window.open('<?PHP echo site_url("c_usermgt/add/agent"); ?>', '_blank', 'width=885,height=680,scrollbars=no,status=no,resizable=no,screenx=0,screeny=0');
		});
        $('#addmeb').click(function() 
		{     
			window.open('<?PHP echo site_url("c_usermgt/add/member"); ?>', '_blank', 'width=885,height=680,scrollbars=no,status=no,resizable=no,screenx=0,screeny=0');
		});
	});
</SCRIPT>
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
           	<div class="mws-stat-container">

<?PHP
	if(strlen($uid) == 2)
	{
?>
                    <!-- Statistic Item -->
                	<a class="mws-stat" href="<?PHP echo site_url('c_usermgt/view/agentgroup/'.$uid); ?>">
                    	<!-- Statistic Icon (edit to change icon) -->
                    	<span class="mws-stat-icon icol32-building"></span>
                        
                        <!-- Statistic Content -->
                        <span class="mws-stat-content">
                        	<span class="mws-stat-title">Group</span>
                            <span class="mws-stat-value"><?PHP echo $count_users['agg']; ?></span>
                        </span>
						<button type="button" class="btn" id="addagg">Add</button>
                    </a>
<?PHP
	}
	if(strlen($uid) <= 4)
	{
?>

                	<a class="mws-stat"  href="<?PHP echo site_url('c_usermgt/view/agent/'.$uid); ?>">
                    	<!-- Statistic Icon (edit to change icon) -->
                    	<span class="mws-stat-icon icol32-building"></span>
                        
                        <!-- Statistic Content -->
                        <span class="mws-stat-content">
                        	<span class="mws-stat-title">Agent</span>
                            <span class="mws-stat-value"><?PHP echo $count_users['agt']; ?></span>
                        </span>
						<button type="button" class="btn" id="addagt">Add</button>
                    </a>
<?PHP
	}
?>
                	<a class="mws-stat" style="border:3px solid red" href="<?PHP echo site_url('c_usermgt/view/member/'.$uid); ?>">
                    	<!-- Statistic Icon (edit to change icon) -->
                    	<span class="mws-stat-icon icol32-building"></span>
                        
                        <!-- Statistic Content -->
                        <span class="mws-stat-content">
                        	<span class="mws-stat-title">Member</span>
                            <span class="mws-stat-value"><?PHP echo $count_users['meb']; ?></span>
                        </span>
						<button type="button" class="btn" id="addmeb">Add</button>
                    </a>

			</div>
			<br>

                <!-- Panels Start -->
               
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-official"></i> <b>Users Management </b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table mws-datatable" style="FONT-SIZE: 13px;">
                            <thead>
								<td align="center"><b>Member ID</b></td>
								<td align="center"><b>Name</b></td>
								<td align="center"><b>Password</b></td>
								<td align="center"><b>Comm</b></td>
								<td align="center"><b>Credit</b></td>
								<td align="center"><b>Balance</b></td>
								<td align="center"><b>HP 1</b></td>
								<td align="center"><b>HP 2</b></td>
								<td align="center"><b>Status</b></td>
								<td align="center"><b>Edit</b></td>
                            </thead>
                            <tbody>
<?PHP
	foreach($member_array as $member_data)
	{
?>
                                <tr>
								<td align="center"><?PHP echo $member_data['meb_id']; ?></td>
								<td align="center"><?PHP echo $member_data['name']; ?></td>
								<td align="center">******</td>
								<td align="center"><?PHP echo $member_data['placeout_com']; ?>%</td>
								<td align="center"><?PHP echo number_format($member_data['credit'],2,'.',','); ?></td>
								<td align="center"><?PHP echo number_format($member_data['balance'],2,'.',','); ?></td>
								<td align="center"><?PHP echo $member_data['handphone1']; ?></td>
								<td align="center"><?PHP echo $member_data['handphone2']; ?></td>
								<td align="center"><?PHP echo $member_data['status']; ?></td>
								<td align="center"><?PHP echo anchor_popup('c_usermgt/edit/member/'.$member_data['meb_id'], 'Edit', $attributes); ?></td>
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
