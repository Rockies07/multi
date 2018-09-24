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
                                <td><span><i class="icon-table"></i><b> Company P/L Report</b></span></td>
                                <td><span><i class="icon-calendar-month"></i> 
								From:
								<?php echo form_dropdown('fromdate', $drawdate); ?>
								&nbsp;&nbsp;
								To:
                                <?php echo form_dropdown('todate', $drawdate); ?>
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
	if($_POST)
	{

?>
				
                
				
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Company P/L</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th><div align="center">ID</div></th>
                                    <th><div align="center">Ticket</div></th>
                                    <th><div align="center">Strike</div></th>
                                    <th><div align="center">Amount</div></th>
									<th><div align="center">Ticket %</div></th>
                                    <th><div align="center">P/L Share</div></th>
                                    <th><div align="center">P.O Share</div></th>
                                    <th><div align="center">Intake Tax</div></th>
                                    <th><div align="center">Nett</div></th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP
						$ticket_amount_nett = 0;
						
						foreach($coy_pl_array as $coy_pl_data)
						{
							$ticket_amount = $coy_pl_data['total_ticket'] - $coy_pl_data['total_strike'];
							$ticket_amount_nett = $ticket_amount_nett + $ticket_amount;

								$pl_share = $coy_pl_data['share_co_amt'] + $coy_pl_data['share_po_amt'];
								$master_nett = ($coy_pl_data['total_ticket'] - $coy_pl_data['total_strike'] + $coy_pl_data['intake_tax']) - $pl_share;
?>
								<tr>
									<td><div align="center"><?PHP echo $coy_pl_data['mas_id'];?></div></td>
									<td><div align="right"><?PHP echo number_format($coy_pl_data['total_ticket'],2,'.',',');?></div></td>
									<td><div align="right"><?PHP echo number_format((0 - $coy_pl_data['total_strike']),2,'.',',');?></div></td>
									<td><div align="right"><?PHP echo number_format($ticket_amount,2,'.',',');?></div></td>
									<td><div align="right"><?PHP echo number_format(($coy_pl_data['ticket_perc'] / $drawcount ),4,'.',',');?> %</div></td>
									<td><div align='right'><?PHP echo number_format($coy_pl_data['share_co_amt'],2,'.',','); ?></div></td>
									<td><div align='right'><?PHP echo number_format($coy_pl_data['share_po_amt'],2,'.',','); ?></div></td>
									<td><div align="right" ><?PHP echo number_format($coy_pl_data['intake_tax'],2,'.',',');?></div></td>

<?PHP
								if($master_nett >= 0) // if lose = red
								{
									echo "<td><div align='right'>";
								}
								else
								{
									echo "<td><div align='right' style='color:red'>";

								}
?>
									<strong><?PHP echo number_format($master_nett,2,'.',',');?></strong></div></td>
								</tr>
<?PHP
						}
?>


								<tr>
                                    <td colspan="1"><div align="center"><strong>Total:</strong></div>
									<div align="center"></div></td>
                                    <td><div align="right"><strong><?PHP echo number_format($coy_pl_sum['total_ticket'],2,'.',',');?></strong></div></td>
                                    <td><div align="right"><strong><?PHP echo number_format((0 - $coy_pl_sum['total_strike']),2,'.',',');?></strong></div></td>
                                    <td><div align="right"><strong><?PHP echo number_format($ticket_amount_nett,2,'.',',');?></strong></div></td>
									<td><div align="right"><strong><?PHP echo number_format($coy_pl_sum['total_perc'] / $drawcount);?> %</strong></div></td>
                                    <td><div align="center"></div></td>
									<td><div align="center"></div></td>
                                    <td><div align="center"></div></td>
									<td><div align="center"></div></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>



				<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Company Placeout</b></span>
                  </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-datatable mws-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ticket</th>
                                    <th>Strike</th>
                                    <th>Nett</th>
									<th>P.O Return</th>
                                </tr>
                            </thead>
                            <tbody>
<?PHP
						foreach($bok_pl_array as $bok_pl_data)
						{
								$bookie_nett = ($bok_pl_data['total_strike'] - $bok_pl_data['total_ticket']);

?>
							<tr>
								<td><div align="left"><?PHP echo $bok_pl_data['bok_id']." ~ ".$bok_pl_data['name'];?></div></td>
								<td><div align="right"><?PHP echo number_format($bok_pl_data['total_ticket'],2,'.',',');?></div></td>
								<td><div align="right"><?PHP echo number_format($bok_pl_data['total_strike'],2,'.',',');?></div></td>
								<td><div align="right"><?PHP echo number_format($bookie_nett,2,'.',',');?></div></td>

<?PHP
								echo "<td><div align='right'>".number_format($bok_pl_data['po_return'],2,'.',',')."</div></td>";
?>
							</tr>

<?PHP
						}
								
?>
                                <tr>
                                    <td><div align="right"><strong>Total:</strong></div></td>
                                    <td><div align="right"><strong>-<?PHP echo number_format($bok_pl_sum['total_ticket'],2,'.',',');?></strong></div></td>
                                    <td><div align="right"><strong><?PHP echo number_format($bok_pl_sum['total_strike'],2,'.',',');?></strong></div></td>
<?PHP
									$bookie_total_nett = ($bok_pl_sum['total_strike'] - $bok_pl_sum['total_ticket']);
?>
                                    <td><div align="right"><strong><?PHP echo number_format($bookie_total_nett,2,'.',',');?></strong></div></td>
									<td><div rowspan="2" align="right">&nbsp;</div></td>

                                </tr>
								<tr>
									<td colspan="3">
									<div align="right"><strong>Expenses:</strong></div></td>
									<td><div align="right"><strong>-<?PHP echo number_format(($exp * $drawcount),2,'.',',');?></strong></div></td>
									<td><div rowspan="2" align="right">&nbsp;</div></td>
                                </tr>
<?PHP
									$coy_wl = ($coy_pl_sum['total_ticket'] - $coy_pl_sum['total_strike'] - $bok_pl_sum['total_ticket'] - ($exp * $drawcount)) + $bok_pl_sum['total_strike'];
?>
								<tr>

								<td colspan="3">
								<div align='right'><strong>Company W/L:</strong></div></td>
<?PHP
								if($coy_wl >= 0) // if lose = red
								{
									echo "<td><div align='right'>";
								}
								else
								{
									echo "<td><div align='right' style='color:red'>"; 
								}
?>
									<strong><?PHP echo number_format($coy_wl,2,'.',',');?></strong></div></td>

									<td>
										<div rowspan="2" align="right"><strong><?PHP echo number_format($bok_pl_sum['total_po_return'],2,'.',',');?></strong></div>
									</td>
                                </tr>

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
