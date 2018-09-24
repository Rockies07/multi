<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Report</li>
		<li class="divider"></li>
		<li>Monthly Deployment</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Monthly Report</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="filter-bar">
				<?php echo form_open($action)?>
					<div class="lbl glyphicons cogwheel"><i></i>Filter</div>
					<div>
						<label>Month:</label>
						<div>
							<select name="date_filter_month">
								<?php 
									if($filter_date_month!="")
									{
										
								?>
										<option value="<?php echo $filter_date_month;?>"><?php echo date('F',mktime(0, 0, 0, $filter_date_month+1, 0, 0));?></option>
								<?php 
									}
									else
									{
								?>	
										<option value="<?php echo date('m');?>"><?php echo date('F');?></option>
								<?php
									}
								?>
								<?php
									for($x=1;$x<=12;$x++)
									{
										if(strlen($x)==1)
										{
											$x="0".$x;
										}
								?>
										<option value="<?php echo $x;?>" <?php echo set_select('date_filter_month', mktime(0, 0, 0, $x, 0, 0)); ?>><?php echo date('F',mktime(0, 0, 0, $x+1, 0, 0));?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					<div>
						<label>Year:</label>
						<div>
							<select name="date_filter_year">
								<?php 
									if($filter_date_year!="")
									{
										
								?>
										<option value="<?php echo $filter_date_year;?>"><?php echo $filter_date_year;?></option>
								<?php 
									}
									else
									{
								?>	
										<option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
								<?php
									}
								?>
								<?php
									for($x=0;$x<=4;$x++)
									{
										$year_now=date('Y');
										$year_now=$year_now-$x;
								?>
										<option value="<?php echo $year_now;?>" <?php echo set_select('date_filter_year', $year_now); ?>><?php echo $year_now;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					<div>
						<button type="submit" class="btn btn-icon btn-primary glyphicons search"><i></i>Search</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
			<div class="span12">
			<?php
				$monthly_levy=$monthly_expenses->monthly_levy;
				$monthly_dormitory=$monthly_expenses->monthly_dormitory;
				$monthly_transportation=$monthly_expenses->monthly_transportation;
				$monthly_administration=$monthly_expenses->monthly_administration;
				$monthly_operation=$monthly_expenses->monthly_operation;

				$total_no_of_men_supply=$report_monthly_total_supply->total_no_of_men;
				$total_no_of_men_unit=$report_monthly_total_unit->total_no_of_men;
				$total_normal_salary_supply=$report_monthly_total_supply->total_normal_salary;
				$total_normal_salary_unit=$report_monthly_total_unit->total_normal_salary;
				$total_ot_salary_supply=$report_monthly_total_supply->total_ot_salary;
				$total_ot_salary_unit=$report_monthly_total_unit->total_ot_salary;
				$total_allowance_fee_supply=$report_monthly_total_supply->total_allowance_fee;
				$total_allowance_fee_unit=$report_monthly_total_unit->total_allowance_fee;

				$total_no_of_men_filter=0; //$total_no_of_men_supply+$total_no_of_men_unit;

				$total_no_of_men_filter=$erector_number+$total_spv_w_income;
				$total_normal_salary=$total_normal_salary_supply+$total_normal_salary_unit;
				$total_ot_salary=$total_ot_salary_supply+$total_ot_salary_unit;
				$total_allowance_fee=$total_allowance_fee_supply+$total_allowance_fee_unit;
				$grand_total_salary=$total_normal_salary+$total_ot_salary+$total_allowance_fee;
				
				if($total_no_of_men<=0)
				{
					$total_no_of_men=1;
				}
				$total_man_count=0;
				$levy_per_man=$monthly_levy/$total_no_of_men;
				$dormitory_per_man=$monthly_dormitory/$total_no_of_men;
				$transportation_per_man=$monthly_transportation/$total_no_of_men;
				$administration_per_man=$monthly_administration/$total_no_of_men;
				$operation_per_man=$monthly_operation/$total_no_of_men;
				
				$grand_total_cost=$grand_total_salary+$monthly_levy+$monthly_dormitory+$monthly_transportation+$monthly_administration+$monthly_operation;
			?>
			<div class="widget-body">
				<table class="table table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Project/Site</th>
							<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Client</th>
							<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Normal Salary</th>
							<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">OT Salary</th>
							<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Allowance</th>
							<th class="center" rowspan="2" style="vertical-align:middle">Total Salary</th>
							<th class="center" rowspan="2" style="vertical-align:middle">Levy</th>
							<th class="center" rowspan="2" style="vertical-align:middle">Dorm</th>
							<th class="center" rowspan="2" style="vertical-align:middle">Transport</th>
							<th class="center" rowspan="2" style="vertical-align:middle">Adm</th>
							<th class="center" rowspan="2" style="vertical-align:middle">Operation</th>
							<th class="center" colspan="2" style="vertical-align:middle; background: rgb(39, 145, 22); border-color: rgb(39, 145, 22);">Total Cost</th>
							<th class="center" colspan="2" style="vertical-align:middle; background: rgb(195, 45, 159); border-color: rgb(195, 45, 159);">Job Done</th>
							<th class="center" colspan="2" style="vertical-align:middle; background: rgb(190, 138, 58); border-color: rgb(190, 138, 58);">Net P/L</th>
						</tr>
						<tr>
							<td class="center" style="vertical-align:middle; background: rgb(39, 145, 22); border-color: rgb(39, 145, 22);">Supply</td>
							<td class="center" style="vertical-align:middle; background: rgb(39, 145, 22); border-color: rgb(39, 145, 22);">Unit Rate</td>
							<td class="center" style="vertical-align:middle; background: rgb(195, 45, 159); border-color: rgb(195, 45, 159);">Supply</td>
							<td class="center" style="vertical-align:middle; background: rgb(195, 45, 159); border-color: rgb(195, 45, 159);">Unit Rate</td>
							<td class="center" style="vertical-align:middle; background: rgb(190, 138, 58); border-color: rgb(190, 138, 58);">Supply</td>
							<td class="center" style="vertical-align:middle; background: rgb(190, 138, 58); border-color: rgb(190, 138, 58);">Unit Rate</td>
						</tr>
					</thead>
					<tbody>
						<?php 
							$grand_total_cost_supply=0;
							$grand_total_cost_unit=0;
							$grand_total_job_done_supply=0;
							$grand_total_job_done_unit=0;
							$grand_total_net_PL_supply=0;
							$grand_total_net_PL_unit=0;
							$grand_total_levy=0;
							$grand_total_dormitory=0;
							$grand_total_transportation=0;
							$grand_total_administration=0;
							$grand_total_operation=0;
							foreach($report_monthly_supply as $report_monthly_item)
							{
								$no_of_men=$report_monthly_item['no_of_men'];
								//$levy=$levy_per_man*$no_of_men;
								//$dormitory=$dormitory_per_man*$no_of_men;
								//$transportation=$transportation_per_man*$no_of_men;
								//$administration=$administration_per_man*$no_of_men;
								//$operation=$operation_per_man*$no_of_men;
								$levy=$report_monthly_item['levy'];
								$dormitory=$report_monthly_item['dormitory'];
								$transportation=$report_monthly_item['transportation'];
								$administration=$report_monthly_item['administration'];
								$operation=$report_monthly_item['operation'];
								
								$normal_salary=$report_monthly_item['normal_salary'];
								$ot_salary=$report_monthly_item['ot_salary'];
								$allowance_fee=$report_monthly_item['allowance_fee'];
								$total_salary=$normal_salary+$ot_salary+$allowance_fee;
								
								$total_cost=$levy+$dormitory+$transportation+$administration+$operation+$total_salary;
								
								$site_type=$report_monthly_item['site_type'];
								$site_rate=$report_monthly_item['site_rate'];
								
								$job_done=$report_monthly_item['job_done'];
								
								$net_PL=$job_done-$total_cost;
						?>
								<tr>
									<td>
										<?php echo $report_monthly_item['project_name']."-".$report_monthly_item['site_name'];?>
									</td>
									<td>
										<?php echo $report_monthly_item['client_name'];?>
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
											echo "$".number_format($levy,2);
											$grand_total_levy=$grand_total_levy+$levy;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($dormitory,2);
											$grand_total_dormitory=$grand_total_dormitory+$dormitory;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($transportation,2);
											$grand_total_transportation=$grand_total_transportation+$transportation;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($administration,2);
											$grand_total_administration=$grand_total_administration+$administration;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($operation,2);
											$grand_total_operation=$grand_total_operation+$operation;
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type=="Supply")
											{
												echo "<font color='red'>$-".number_format($total_cost,2)."</font>";
												$grand_total_cost_supply=$grand_total_cost_supply+$total_cost;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type!="Supply")
											{
												echo "<font color='red'>$-".number_format($total_cost,2)."</font>";
												$grand_total_cost_unit=$grand_total_cost_unit+$total_cost;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type=="Supply")
											{
												echo "$".number_format($job_done,2);
												$grand_total_job_done_supply=$grand_total_job_done_supply+$job_done;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type!="Supply")
											{
												echo "$".number_format($job_done,2);
												$grand_total_job_done_unit=$grand_total_job_done_unit+$job_done;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type=="Supply")
											{
												if($net_PL>=0)
												{
													echo "$".number_format($net_PL,2);
												}
												else
												{
													echo "<font color='red'>$".number_format($net_PL,2)."</font>";
												}
												$grand_total_net_PL_supply=$grand_total_net_PL_supply+$net_PL;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type!="Supply")
											{
												if($net_PL>=0)
												{
													echo "$".number_format($net_PL,2);
												}
												else
												{
													echo "<font color='red'>$".number_format($net_PL,2)."</font>";
												}
												$grand_total_net_PL_unit=$grand_total_net_PL_unit+$net_PL;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
								</tr>
								
						<?php
							}
							foreach($report_monthly_unit as $report_monthly_item)
							{
								$no_of_men=$report_monthly_item['no_of_men'];
								//$levy=$levy_per_man*$no_of_men;
								//$dormitory=$dormitory_per_man*$no_of_men;
								//$transportation=$transportation_per_man*$no_of_men;
								//$administration=$administration_per_man*$no_of_men;
								//$operation=$operation_per_man*$no_of_men;
								$levy=$report_monthly_item['levy'];
								$dormitory=$report_monthly_item['dormitory'];
								$transportation=$report_monthly_item['transportation'];
								$administration=$report_monthly_item['administration'];
								$operation=$report_monthly_item['operation'];
								
								$normal_salary=$report_monthly_item['normal_salary'];
								$ot_salary=$report_monthly_item['ot_salary'];
								$allowance_fee=$report_monthly_item['allowance_fee'];
								$total_salary=$normal_salary+$ot_salary+$allowance_fee;
								
								$total_cost=$levy+$dormitory+$transportation+$administration+$operation+$total_salary;
								
								$site_type=$report_monthly_item['site_type'];
								$site_rate=$report_monthly_item['site_rate'];
								
								$job_done=$report_monthly_item['job_done'];
								
								$net_PL=$job_done-$total_cost;
						?>
								<tr>
									<td>
										<?php echo $report_monthly_item['project_name']."-".$report_monthly_item['site_name'];?>
									</td>
									<td>
										<?php echo $report_monthly_item['client_name'];?>
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
											echo "$".number_format($levy,2);
											$grand_total_levy=$grand_total_levy+$levy;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($dormitory,2);
											$grand_total_dormitory=$grand_total_dormitory+$dormitory;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($transportation,2);
											$grand_total_transportation=$grand_total_transportation+$transportation;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($administration,2);
											$grand_total_administration=$grand_total_administration+$administration;
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($operation,2);
											$grand_total_operation=$grand_total_operation+$operation;
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type=="Supply")
											{
												echo "<font color='red'>$-".number_format($total_cost,2)."</font>";
												$grand_total_cost_supply=$grand_total_cost_supply+$total_cost;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type!="Supply")
											{
												echo "<font color='red'>$-".number_format($total_cost,2)."</font>";
												$grand_total_cost_unit=$grand_total_cost_unit+$total_cost;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type=="Supply")
											{
												echo "$".number_format($job_done,2);
												$grand_total_job_done_supply=$grand_total_job_done_supply+$job_done;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type!="Supply")
											{
												echo "$".number_format($job_done,2);
												$grand_total_job_done_unit=$grand_total_job_done_unit+$job_done;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type=="Supply")
											{
												if($net_PL>=0)
												{
													echo "$".number_format($net_PL,2);
												}
												else
												{
													echo "<font color='red'>$".number_format($net_PL,2)."</font>";
												}
												$grand_total_net_PL_supply=$grand_total_net_PL_supply+$net_PL;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
									<td class="right">
										<?php 
											if($site_type!="Supply")
											{
												if($net_PL>=0)
												{
													echo "$".number_format($net_PL,2);
												}
												else
												{
													echo "<font color='red'>$".number_format($net_PL,2)."</font>";
												}
												$grand_total_net_PL_unit=$grand_total_net_PL_unit+$net_PL;
											}
											else
											{	
												echo "&nbsp;";
											}	
										?>
									</td>
								</tr>
								
						<?php
							}
						?>
						
						<tr>
							<td colspan="2">
								<b>Total Count</b>
							</td>
							<td class="right">
								$<?php echo number_format($total_normal_salary,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($total_ot_salary,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($total_allowance_fee,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($grand_total_salary,2);?>
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
							<td>
								<font color="red">$-<?php echo number_format($grand_total_cost_supply,2);?></font>
							</td>
							<td>
								<font color="red">$-<?php echo number_format($grand_total_cost_unit,2);?></font>
							</td>
							<td>
								$<?php echo number_format($grand_total_job_done_supply,2);?>
							</td>
							<td>
								$<?php echo number_format($grand_total_job_done_unit,2);?>
							</td>
							<td>
								<?php
									if($grand_total_net_PL_supply>=0)
									{
										echo "$".number_format($grand_total_net_PL_supply,2);
									}
									else
									{
										echo "<font color='red'>$".number_format($grand_total_net_PL_supply,2)."</font>";
									}
								?>
							</td>
							<td>
								<?php
									if($grand_total_net_PL_unit>=0)
									{
										echo "$".number_format($grand_total_net_PL_unit,2);
									}
									else
									{
										echo "<font color='red'>$".number_format($grand_total_net_PL_unit,2)."</font>";
									}
								?>
							</td>
						</tr>
					</tbody>
				</table>
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
		window.location.href = '<?PHP echo site_url("transaction_employee/management"); ?>';
	}

	function init_filter_site()
	{ //any select change on the dropdown with id country trigger this code
		var text_selected=$("#site option:selected").text();
		var value_selected=$("#site").val();
		$("#site > option").remove(); //first of all clear select items
 		var project = $('#project').val(); // here we are taking country id of the selected one.
		$.ajax({
 			type: "POST",
 			dataType : "json",
 			url: "<?php echo site_url('transaction_employee/get_site_list_by_value/"+project+"'); ?>", //here we are calling our user controller and get_cities method with the country_id
 			success: function(data) //we're calling the response json array 'cities'
 			{
 				var opt = $('<option />'); // here we're creating a new select option with for each city
				opt.val(value_selected);
				opt.text(text_selected);
				$('#site').append(opt);

 				$.each(data,function(id,text) //here we're doing a foeach loop round each city with id as the key and city as the value
 				{
 					var opt = $('<option />'); // here we're creating a new select option with for each city
					opt.val(id);
					opt.text(text);
 					$('#site').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
 				});
 			}
		});
 	};

	$(document).ready(function(){
		init_filter_site();
	})
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
