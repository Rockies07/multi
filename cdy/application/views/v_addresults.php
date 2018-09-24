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
                                <td><span><i class="icon-table"></i><b> Add Results</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								Date: 
								<?php echo form_dropdown('draw', $drawdate); ?>
								&nbsp;&nbsp;
                                <input type="submit" class="btn" value="Select"></input>

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
				
				<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>Results Info</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">

			<?PHP
			$hidden = array('draw' => $this->input->post('draw'),
							);
			$attributes = array('class' => 'mws-form');
			echo form_open('', $attributes, $hidden);
			?>
                        <table class="mws-datatable-fn mws-table">
                            <tbody>
							<tr>
								<td><div align="center">Consolation 1</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons1"></div></td>
								<td><div align="center">Consolation 2</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons2"></div></td>
							</tr>
							<tr>
								<td><div align="center">Consolation 3</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons3"></div></td>
								<td><div align="center">Consolation 4</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons4"></div></td>
							</tr>
							<tr>
								<td><div align="center">Consolation 5</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons5"></div></td>
								<td><div align="center">Consolation 6</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons6"></div></td>
							</tr>
							<tr>
								<td><div align="center">Consolation 7</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons7"></div></td>
								<td><div align="center">Consolation 8</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons8"></div></td>
							</tr>
							<tr>
								<td><div align="center">Consolation 9</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons9"></div></td>
								<td><div align="center">Consolation 10</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="cons10"></div></td>
							</tr>
							<tr>
								<td><div align="center">Starters 1</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start1"></div></td>
								<td><div align="center">Starters 2</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start2"></div></td>

							</tr>
							<tr>
								<td><div align="center">Starters 3</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start3"></div></td>
								<td><div align="center">Starters 4</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start4"></div></td>
							</tr>
							<tr>
								<td><div align="center">Starters 5</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start5"></div></td>
								<td><div align="center">Starters 6</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start6"></div></td>
							</tr>
							<tr>
								<td><div align="center">Starters 7</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start7"></div></td>
								<td><div align="center">Starters 8</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start8"></div></td>
							</tr>
							<tr>
								<td><div align="center">Starters 9</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start9"></div></td>
								<td><div align="center">Starters 10</div></td>
								<td><div align="center"><input type="text" size="4" maxlength="4" name="start10"></div></td>
							</tr>
							<tr>
								<td colspan="2"><div align="center">3rd</div></td>
								<td colspan="2"><div align="center"><input type="text" maxlength="4" size="4" name="pos3"></div></td>
							</tr>
							<tr>
								<td colspan="2"><div align="center">2nd</div></td>
								<td colspan="2"><div align="center"><input type="text" maxlength="4" size="4" name="pos2"></div></td>
							</tr>

							<tr>
								<td colspan="2"><div align="center">1st</div></td>
								<td colspan="2"><div align="center"><input type="text" maxlength="4" size="4" name="pos1"></div></td>
							</tr>
							<tr>
                                <td colspan="4" ><div align="center"><input type="submit" class="btn" value="Save" name="Save"></input></div></td>
							</tr>

                            </tbody>

                        </table>
						<?PHP echo form_close(); ?>
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
