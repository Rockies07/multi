<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Report</li>
		<li class="divider"></li>
		<li>Project</li>
		<li class="divider"></li>
		<li>Site</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Site Report (<?php echo date('d M Y',strtotime($filter_date_from));?> to <?php echo date('d M Y',strtotime($filter_date_to));?>)</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="span12">
				<div class="widget-body">
					<table class="table table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Site</th>
								<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Normal Salary</th>
								<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">OT Salary</th>
								<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Allowance</th>
								<th class="center" style="vertical-align:middle">Total Salary</th>
								<th class="center" style="vertical-align:middle">Levy</th>
								<th class="center" style="vertical-align:middle">Dorm</th>
								<th class="center" style="vertical-align:middle">Transport</th>
								<th class="center" style="vertical-align:middle">Adm</th>
								<th class="center" style="vertical-align:middle">Operation</th>
								<th class="center" style="vertical-align:middle">Total Cost</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$grand_total_normal_salary=0;
								$grand_total_ot_salary=0;
								$grand_total_allowance=0;
								$grand_total_total_salary=0;
								$grand_total_levy=0;
								$grand_total_dormitory=0;
								$grand_total_transportation=0;
								$grand_total_administration=0;
								$grand_total_operation=0;
								$grand_total_net_PL_unit=0;
								$grand_total_no_of_men=0;
								$grand_total_cost=0;
								foreach($site_report as $site_report_item)
								{
									$grand_total_levy=$grand_total_levy+$site_report_item['levy'];
									$grand_total_dormitory=$grand_total_dormitory+$site_report_item['dormitory'];
									$grand_total_transportation=$grand_total_transportation+$site_report_item['transportation'];
									$grand_total_administration=$grand_total_administration+$site_report_item['administration'];
									$grand_total_operation=$grand_total_operation+$site_report_item['operation'];
									
									$normal_salary=$site_report_item['normal_salary'];
									$grand_total_normal_salary=$grand_total_normal_salary+$normal_salary;

									$ot_salary=$site_report_item['ot_salary'];
									$grand_total_ot_salary=$grand_total_ot_salary+$ot_salary;

									$allowance_fee=$site_report_item['allowance_fee'];
									$grand_total_allowance=$grand_total_allowance+$allowance_fee;

									$total_salary=$normal_salary+$ot_salary+$allowance_fee;
									$grand_total_total_salary=$grand_total_total_salary+$total_salary;
									
									$total_cost=$site_report_item['levy']+$site_report_item['dormitory']+$site_report_item['transportation']+$site_report_item['administration']+$site_report_item['operation']+$total_salary;
									$grand_total_cost=$grand_total_cost+$total_cost;
							?>
									<tr>
										<td>
											<span style="text-decoration:underline; font-weight:bold;">
												<?php 
													echo anchor('report/site_detail/'.$site_report_item['site_id'].'/'.$filter_date_from.'/'.$filter_date_to, $site_report_item['site_name']);
												?>
											</span>
										</td>
										<td class="right">
											$<?php echo number_format($normal_salary,2);?>
										</td>
										<td class="right">
											$<?php echo number_format($ot_salary,2);?>
										</td>
										<td class="right">
											$<?php echo number_format($allowance_fee,2);?>
										</td>
										<td class="right">
											$<?php echo number_format($total_salary,2);?>
										</td>
										<td class="right">
											<?php 
												echo "$".number_format($site_report_item['levy'],2);
											?>
										</td>
										<td class="right">
											<?php 
												echo "$".number_format($site_report_item['dormitory'],2);
											?>
										</td>
										<td class="right">
											<?php 
												echo "$".number_format($site_report_item['transportation'],2);
											?>
										</td>
										<td class="right">
											<?php 
												echo "$".number_format($site_report_item['administration'],2);
											?>
										</td>
										<td class="right">
											<?php 
												echo "$".number_format($site_report_item['operation'],2);
											?>
										</td>
										<td class="right">
											<?php 
												echo "$".number_format($total_cost,2);
											?>
										</td>
									</tr>
							<?php
								}
							?>		
							
							<tr>
								<td>
									<b>Total</b>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_normal_salary,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_ot_salary,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_allowance,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_total_salary,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_levy,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_dormitory,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_transportation,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_administration,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_operation,2);?>
								</td>
								<td class="right">
									$<?php echo number_format($grand_total_cost,2);?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
	
<script type="text/javascript">
	$(function() {
		$(".datetimepicker").datepicker({
		showOn: 'both', 
		buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
		buttonImageOnly: true,
		changeMonth: true,
      	changeYear: true
		});
	});

	function prev_page(){
		window.location.href = '<?PHP echo site_url("report/project"); ?>';
	}
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
