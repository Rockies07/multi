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
                                <td><span><i class="icon-table"></i><b> Generate ARA</b></span></td>
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
				
				<div class="mws-panel grid_5">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b>Pool Info</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th><div align="center">Type</div></th>
                                    <th><div align="center">Nett</div></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><div align="center">Total Big ticket: <?PHP echo number_format($reportsysdata['total_big'],2,'.',',');?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($reportsysdata['total_big'] * $bigvalue), 2, '.',',');?></div></td>
                                </tr>
                                <tr>
                                    <td><div align="center">Total Small ticket: <?PHP echo number_format($reportsysdata['total_small'],2,'.',',');?></div></td>
                                    <td><div align="center"><?PHP echo number_format(($reportsysdata['total_small'] * $smallvalue),2,'.',',');?></div></td>
                                </tr>
                                <tr>
                                    <td><div align="right"><B>Total:</b></td>
                                    <td><div align="center"> <?PHP $total =  ($reportsysdata['total_big'] * $bigvalue) + ($reportsysdata['total_small'] * $smallvalue); 
																	echo number_format($total,2,'.',',');
															?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

<?PHP
				/*echo form_open('');
				echo "Eat Big ".form_input('eatbig', '');
				echo "<br>";
				echo "Eat Sml ".form_input('eatsmall', '');
				echo "<br>";
				echo form_submit('submiteat', 'Gen ARA');
				echo form_close();*/

?>
                <div class="mws-panel grid_4">
                    <div class="mws-panel-header">
                        <span><i class="icon-key"></i><b> Generate Intake</b></span>
                    </div>
					<div style='color:red'></div>
                    <div class="mws-panel-body no-padding">
			<?PHP
			$hidden = array('draw' => $this->input->post('draw'),
							);
			$attributes = array('class' => 'mws-form');
			echo form_open('', $attributes, $hidden);
			?>
                            <fieldset class="mws-form-inline">
                                <div class="mws-form-row bordered">
									<label class="mws-form-label">Big Amt</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="small" name='eatbig'>
                                    </div>
									<label class="mws-form-label">Small Amt</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="small" name='eatsmall'>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="mws-button-row">
							<?PHP echo form_submit('submiteat', 'Generate ARA'); ?>
                            </div>
                        </form>
                    </div>      
                </div>

				<div class="mws-panel grid_5">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Company Intake</b></span>
                  </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-datatable mws-table">
                            <thead>
								<tr>
                                    <th colspan="3" >Intake</th>
                                    <th colspan="3" >Out</th>

								</tr>
                                <tr>
                                    <th>Ticket Type</th>
                                    <th>Total Ticket</th>
                                    <th>Ticket Nett</th>
                                    <th>Ticket Type</th>
                                    <th>Total Ticket</th>
                                    <th>Ticket Nett</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div align="center">Intake Big</div></td>
                                    <td><div align="center"><?PHP echo number_format($reportsysdata_temp['total_big'],2,'.',','); ?></div></td>
                                    <td><div align="right"><?PHP echo number_format(($reportsysdata_temp['total_big'] * $bigvalue),2,'.',','); ?></div></td>
                                    <td><div align="center">Out Big</div></td>
                                    <td><div align="center"><?PHP echo number_format($reportbookiedata_temp['total_big'],2,'.',','); ?></div></td>
                                    <td><div align="right"><?PHP echo number_format(($reportbookiedata_temp['total_big'] * $bigvalue),2,'.',','); ?></div></td>
                                </tr>
                                <tr>
                                    <td><div align="center">Intake Small</div></td>
                                    <td><div align="center"><?PHP echo number_format($reportsysdata_temp['total_small'],2,'.',','); ?></div></td>
                                    <td><div align="right"><?PHP echo number_format(($reportsysdata_temp['total_small']* $smallvalue),2,'.',','); ?></div></td>
                                    <td><div align="center">Out Small</div></td>
                                    <td><div align="center"><?PHP echo number_format($reportbookiedata_temp['total_small'],2,'.',','); ?></div></td>
                                    <td><div align="right"><?PHP echo number_format(($reportbookiedata_temp['total_small']* $smallvalue),2,'.',','); ?></div></td>
                                </tr>
                                <tr >
                                  <td colspan="6" >&nbsp;</td>
                                </tr>
                                <tr >
                                    <td colspan="2" ><div align="right"><strong>Total:</strong></div></td>
                                    <td><div align="right"><strong><?PHP $total =  ($reportsysdata_temp['total_big'] * $bigvalue) + ($reportsysdata_temp['total_small'] * $smallvalue); 
																	echo number_format($total,2,'.',',');
															?></strong></div></td>
                                    <td colspan="2"><div align="right"><strong>Total:</strong></div></td>
                                    <td><div align="right"><strong><?PHP $total =  ($reportbookiedata_temp['total_big'] * $bigvalue) + ($reportbookiedata_temp['total_small'] * $smallvalue); 
																	echo number_format($total,2,'.',',');
															?></strong></div></td>
                                </tr>
                            </tbody>
							<?PHP
							if($this->input->post('submiteat'))
							{
								$hidden = array('draw' => $this->input->post('draw'),
												'eatbig' => $this->input->post('eatbig'),
												'eatsmall' => $this->input->post('eatsmall'),
												);
								$attributes = array('class' => 'mws-form');
								echo form_open('', $attributes,$hidden); 
								//echo form_submit('saveintake', 'Save Intake'); 
								//echo form_close();
							}
							?>

                            <td colspan="6" class="mws-button-row" align="center">
							<?PHP echo form_submit('saveintake', 'Save Intake'); ?>
                            </td>
							<?PHP echo form_close(); ?>
                        </table>

						
                    </div>
			</div>

				

                <?PHP } ?>
            	
                
            	

                
            	
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
