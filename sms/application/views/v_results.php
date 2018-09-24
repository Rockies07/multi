        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
                
            	
               
            	<div class="mws-panel grid_6">
                
            <div class="mws-panel-header">
            <div class="clearfix"></div>
                        <table cellpadding="0" cellspacing="0" width="100%">
                        	<tr>
								<?PHP echo form_open(''); ?>
                                <td><span><i class="icon-table"></i><b> Results</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								Draw: 
								<?php echo form_dropdown('fromdate', $drawdate); ?>
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
	if($this->input->post())
	{
 ?>
				
				<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Results for <?PHP echo $selectdate; ?></b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <tbody>
<?PHP
				foreach($first_array as $first_data)
				{
?>
							<tr>
								<td colspan="2"><div align="center">1st Prize</div></td>
								<td colspan="2"><div align="center"><?PHP echo $first_data['number'];?></div></td>
							</tr>
<?PHP
				}
				foreach($second_array as $second_data)
				{
?>
							<tr>
								<td colspan="2"><div align="center">2nd Prize</div></td>
								<td colspan="2"><div align="center"><?PHP echo $second_data['number'];?></div></td>
							</tr>
<?PHP
				}
				foreach($third_array as $third_data)
				{
?>

							<tr>
								<td colspan="2"><div align="center">3rd Prize</div></td>
								<td colspan="2"><div align="center"><?PHP echo $third_data['number'];?></div></td>
							</tr>
<?PHP
				}
?>

							<tr>
								<td colspan="4"><div align="center">&nbsp</div></td>
							</tr>
							<table class="mws-table">
								<tr>
									<th colspan="5" align="center">Starters</th>
								</tr>
								<tr>

<?PHP
				$x = 1;
				foreach($starts_array as $starts_data)
				{

					echo '<td><div align="center">'.$starts_data['number'].'</div></td>';
					if($x == 5)
					{
						echo '</tr><tr>';
					}
					$x = $x + 1;
				}
?>
								</tr>

							</table>
							<tr>
								<td colspan="5"><div align="center">&nbsp</div></td>
							</tr>

							<table class="mws-table">
								<tr>
									<th colspan="5" align="center">Consolations</th>
								</tr>
								<tr>
<?PHP
				$y = 1;
				foreach($cons_array as $cons_data)
				{

					echo '<td><div align="center">'.$cons_data['number'].'</div></td>';
					if($y == 5)
					{
						echo '</tr><tr>';
					}
					$y = $y + 1;
				}
?>								</tr>
							</table>


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
