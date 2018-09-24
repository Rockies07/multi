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
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Project Report</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="filter-bar">
				<?php echo form_open($action)?>
					<div class="lbl glyphicons cogwheel"><i></i>Filter</div>
					<div>
						<label>From:</label>
						<div>
							<input type="text" name="date_filter_from" id="date_filter_from" class="input-mini datetimepicker" value="<?php if($filter_date_from=="") echo date("m/d/Y"); else echo $filter_date_from;?>" style="width: 90px; vertical-align:top;" />
						</div>
						<label>To:</label>
						<div>
							<input type="text" name="date_filter_to" id="date_filter_to" class="input-mini datetimepicker" value="<?php if($filter_date_to=="") echo date("m/d/Y"); else echo $filter_date_to;?>" style="width: 90px; vertical-align:top;" />
						</div>
					</div>
					<div>
						<button type="submit" class="btn btn-icon btn-primary glyphicons search"><i></i>Search</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
			<div class="span12">
				<div class="widget-body">
					<table class="table table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Project</th>
								<th style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Client</th>
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
								foreach($project_report as $project_report_item)
								{
									$grand_total_levy=$grand_total_levy+$project_report_item['levy'];
									$grand_total_dormitory=$grand_total_dormitory+$project_report_item['dormitory'];
									$grand_total_transportation=$grand_total_transportation+$project_report_item['transportation'];
									$grand_total_administration=$grand_total_administration+$project_report_item['administration'];
									$grand_total_operation=$grand_total_operation+$project_report_item['operation'];
									
									$normal_salary=$project_report_item['normal_salary'];
									$grand_total_normal_salary=$grand_total_normal_salary+$normal_salary;

									$ot_salary=$project_report_item['ot_salary'];
									$grand_total_ot_salary=$grand_total_ot_salary+$ot_salary;

									$allowance_fee=$project_report_item['allowance_fee'];
									$grand_total_allowance=$grand_total_allowance+$allowance_fee;

									$total_salary=$normal_salary+$ot_salary+$allowance_fee;
									$grand_total_total_salary=$grand_total_total_salary+$total_salary;
									
									$total_cost=$project_report_item['levy']+$project_report_item['dormitory']+$project_report_item['transportation']+$project_report_item['administration']+$project_report_item['operation']+$total_salary;
									$grand_total_cost=$grand_total_cost+$total_cost;
							?>
									<tr>
										<td>
											<span style="text-decoration:underline; font-weight:bold;">
												<?php 
													if($filter_date_from=="")
													{
														$date_filter_from=date("Y-m-d");
													}
													else
													{
														$date_arr=explode("/",$filter_date_from);
														$date_filter_from=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
													}

													if($filter_date_to=="")
													{
														$date_filter_to=date("Y-m-d");
													}
													else
													{
														$date_arr=explode("/",$filter_date_to);
														$date_filter_to=$date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
													}
													echo anchor('report/site/'.$project_report_item['project_id'].'/'.$date_filter_from.'/'.$date_filter_to, $project_report_item['project_name']);
												?>
											</span>
										</td>
										<td>
											<?php echo $project_report_item['client_name'];?>
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
								<td colspan="2">
									<b>Total</b>
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

	function reload(){
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
