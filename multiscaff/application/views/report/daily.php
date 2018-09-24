<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Report</li>
		<li class="divider"></li>
		<li>Daily Deployment</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Daily Report</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="filter-bar">
				<?php echo form_open($action)?>
					<div class="lbl glyphicons cogwheel"><i></i>Filter</div>
					<div>
						<label>Date:</label>
						<div>
							<input type="text" name="date_filter" id="date_filter" class="input-mini datetimepicker" value="<?php if($filter_date=="") echo date("m/d/Y"); else echo $filter_date;?>" style="width: 70px; vertical-align:top;" />
						</div>
					</div>
					<div>
						<label>Project:</label>
						<div>
							<select name="project" id="project" onchange="init_filter_site();">
								<?php 
									if($filter_project!="")
									{
										
								?>
										<option value="<?php echo $filter_project;?>"><?php echo $filter_project_name;?></option>
								<?php 
									}
									else
									{
								?>	
										<option value="">-Select All-</option>
								<?php
									}
								?>	
									<option value="">-Select All-</option>
								<?php
									foreach ($project as $project_item){
								?>
										<option value="<?php echo $project_item['id'];?>" <?php echo set_select('site', $project_item['id']); ?>><?php echo $project_item['name'];?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					<div>
						<label>Site:</label>
						<div>
							<select name="site" id="site">
								<?php 
									if($filter_site!="0")
									{
										
								?>
										<option value="<?php echo $filter_site;?>"><?php echo $filter_site_name;?></option>
								<?php 
									}
									else
									{
								?>	
										<option value="0">-Select All-</option>
								<?php
									}
								?>
									<option value="0">-Select All-</option>
								<?php
									foreach ($site as $site_item){
								?>
										<option value="<?php echo $site_item['id'];?>" <?php echo set_select('site', $site_item['id']); ?>><?php echo $site_item['name'];?></option>
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
				<div class="span12">
					<div class="separator bottom"></div>
					<?php
						$daily_levy=$monthly_expenses->daily_levy;
						$daily_dormitory=$monthly_expenses->daily_dormitory;
						$daily_transportation=$monthly_expenses->daily_transportation;
						$daily_administration=$monthly_expenses->daily_administration;
						$daily_operation=$monthly_expenses->daily_operation;

						$total_no_of_men_supply=$report_daily_total_supply->total_no_of_men;
						$total_no_of_men_unit=$report_daily_total_unit->total_no_of_men;
						$total_normal_salary_supply=$report_daily_total_supply->total_normal_salary;
						$total_normal_salary_unit=$report_daily_total_unit->total_normal_salary;
						$total_ot_salary_supply=$report_daily_total_supply->total_ot_salary;
						$total_ot_salary_unit=$report_daily_total_unit->total_ot_salary;
						$total_allowance_fee_supply=$report_daily_total_supply->total_allowance_fee;
						$total_allowance_fee_unit=$report_daily_total_unit->total_allowance_fee;

						$total_no_of_men_filter=0; //$total_no_of_men_supply+$total_no_of_men_unit;
						$total_normal_salary=$total_normal_salary_supply+$total_normal_salary_unit;
						$total_ot_salary=$total_ot_salary_supply+$total_ot_salary_unit;
						$total_allowance_fee=$total_allowance_fee_supply+$total_allowance_fee_unit;
						$grand_total_salary=$total_normal_salary+$total_ot_salary+$total_allowance_fee;
						
						if($total_no_of_men<=0)
						{
							$total_no_of_men=1;
						}
						$total_man_count=0;
						$levy_per_man=$daily_levy/$total_no_of_men;
						$dormitory_per_man=$daily_dormitory/$total_no_of_men;
						$transportation_per_man=$daily_transportation/$total_no_of_men;
						$administration_per_man=$daily_administration/$total_no_of_men;
						$operation_per_man=$daily_operation/$total_no_of_men;
						
						$grand_total_cost=$grand_total_salary+$daily_levy+$daily_dormitory+$daily_transportation+$daily_administration+$daily_operation;
					?>
					<table>
						<tr>
							<td>&nbsp;</td>
							<td width="120px" class="right">Levy</td>
							<td width="120px" class="right">Dormitory</td>
							<td width="120px" class="right">Transportation</td>
							<td width="120px" class="right">Administration</td>
							<td width="120px" class="right">Operation</td>
						</tr>
						<tr>
							<td>Per Man Cost</td>
							<td class="right">
								$<?php echo number_format($levy_per_man,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($dormitory_per_man,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($transportation_per_man,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($administration_per_man,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($operation_per_man,2);?>
							</td>
						</tr>
						<tr>
							<td>Daily Cost</td>
							<td class="right">
								$<?php echo number_format($daily_levy,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($daily_dormitory,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($daily_transportation,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($daily_administration,2);?>
							</td>
							<td class="right">
								$<?php echo number_format($daily_operation,2);?>
							</td>
						</tr>
					</table>
					<div class="separator bottom"></div>
					<table class="table table-bordered table-primary table-condensed" style="border-top:solid 1px #d7d8da">
						<tbody>
							<tr>
								<th rowspan="2" width="50px" class="center" style="vertical-align:middle">Man Count</th>
								<th width="50px" class="center">Driver</th>
								<th width="50px" class="center">Erector</th>
								<th width="50px" class="center">Storeman</th>
								<th width="50px" class="center">Supervisor</th>
								<th width="50px" class="center">Supervisor w/ Income</th>
								<th width="50px" class="center">Working</th>
								<th width="50px" class="center">Ratio</th>
							</tr>
							<tr>
								<td class="center"><?php echo $driver_number;?></td>
								<?php
									foreach($report_position as $report_position_item)
									{
										if($report_position_item['position']!="Supervisor on Supply")
										{
											$total_spv_w_income=0;
										}
										else
										{
											$total_spv_w_income=$report_position_item['no_of_men_supply'];
										}
									}
									$total_no_of_men_filter=$total_no_of_men_filter+$erector_number+$total_spv_w_income;
								?>	
								<td class="center"><?php echo $erector_number;?></td>
								<td class="center"><?php echo $storeman_number;?></td>
								<td class="center"><?php echo ($supervisor_number-$total_spv_w_income);?></td>
								<td class="center"><?php echo $total_spv_w_income;?></td>
								<td class="center"><?php echo $total_no_of_men_filter;?></td>
								<td class="center">
									<?php 
										$no_of_men_absent=$total_absent->no_of_men;
										$total_man_count=$total_no_of_men+$driver_number+$storeman_number+$supervisor_number-$total_spv_w_income+$no_of_men_absent;
										echo $total_no_of_men_filter."/".$total_man_count;
										$total_man_count=0; //will used on double check below
									?>
								</td>
							</tr>
						</tbody>
					</table>
				<div class="separator bottom"></div>
			</div>
			<div class="span12">
				<div class="widget-body">
					<table class="table table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Project/Site</th>
								<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Client</th>
								<th class="center" rowspan="2" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">No. of Men</th>
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
								<th class="center" rowspan="2" style="vertical-align:middle">E/D/VO</th>
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
								foreach($report_daily_supply as $report_daily_item)
								{
									$no_of_men=$report_daily_item['no_of_men'];
									//$levy=$levy_per_man*$no_of_men;
									//$dormitory=$dormitory_per_man*$no_of_men;
									//$transportation=$transportation_per_man*$no_of_men;
									//$administration=$administration_per_man*$no_of_men;
									//$operation=$operation_per_man*$no_of_men;
									$levy=$report_daily_item['levy'];
									$dormitory=$report_daily_item['dormitory'];
									$transportation=$report_daily_item['transportation'];
									$administration=$report_daily_item['administration'];
									$operation=$report_daily_item['operation'];
									
									$normal_salary=$report_daily_item['normal_salary'];
									$ot_salary=$report_daily_item['ot_salary'];
									$allowance_fee=$report_daily_item['allowance_fee'];
									$total_salary=$normal_salary+$ot_salary+$allowance_fee;
									
									$total_cost=$levy+$dormitory+$transportation+$administration+$operation+$total_salary;
									
									$site_type=$report_daily_item['site_type'];
									$site_rate=$report_daily_item['site_rate'];
									
									$job_done=$report_daily_item['job_done'];
									
									$net_PL=$job_done-$total_cost;
							?>
									<tr>
										<td>
											<?php echo $report_daily_item['project_name']."-".$report_daily_item['site_name'];?>
										</td>
										<td>
											<?php echo $report_daily_item['client_name'];?>
										</td>
										<td class="center">
											<?php echo $no_of_men;?>
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
										<td>&nbsp;</td>
									</tr>
									
							<?php
								}
								foreach($report_daily_unit as $report_daily_item)
								{
									$no_of_men=$report_daily_item['no_of_men'];
									//$levy=$levy_per_man*$no_of_men;
									//$dormitory=$dormitory_per_man*$no_of_men;
									//$transportation=$transportation_per_man*$no_of_men;
									//$administration=$administration_per_man*$no_of_men;
									//$operation=$operation_per_man*$no_of_men;
									$levy=$report_daily_item['levy'];
									$dormitory=$report_daily_item['dormitory'];
									$transportation=$report_daily_item['transportation'];
									$administration=$report_daily_item['administration'];
									$operation=$report_daily_item['operation'];
									
									$normal_salary=$report_daily_item['normal_salary'];
									$ot_salary=$report_daily_item['ot_salary'];
									$allowance_fee=$report_daily_item['allowance_fee'];
									$total_salary=$normal_salary+$ot_salary+$allowance_fee;
									
									$total_cost=$levy+$dormitory+$transportation+$administration+$operation+$total_salary;
									
									$site_type=$report_daily_item['site_type'];
									$site_rate=$report_daily_item['site_rate'];
									
									$job_done=$report_daily_item['job_done'];
									
									$net_PL=$job_done-$total_cost;
							?>
									<tr>
										<td>
											<?php echo $report_daily_item['project_name']."-".$report_daily_item['site_name'];?>
										</td>
										<td>
											<?php echo $report_daily_item['client_name'];?>
										</td>
										<td class="center">
											<?php echo $no_of_men;?>
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
										<td><?php echo $report_daily_item['e_percentage']."%/".$report_daily_item['d_percentage']."%/VO";?></td>
									</tr>
									
							<?php
								}
							?>
							
							<tr>
								<td colspan="2">
									<b>Total Count</b>
								</td>
								<td class="center">
									<?php echo $total_no_of_men_filter;?>
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
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<div class="separator bottom"></div>
					<table class="table table-bordered table-primary table-condensed" style="border-top:solid 1px #d7d8da">
						<thead>
							<tr>
								<th class="center" colspan="4" style="vertical-align:middle">Losses per day</th>
								<th class="center">Company Losses</th>
								<th class="center">Worker Deduction</th>
							</tr>
						</thead>
						<tbody>
							<td
							<?php
								$i=0;
								$hl_fee=$get_setting->hl_cut_fee;
								$standby_fee=$get_setting->standby_fee;
								$mc_fee=$get_setting->mc_fee;
								$course_fee=$get_setting->course_fee;
								$absent_fee=$get_setting->absent_fee;
								$total_company_losses=0;
								foreach($report_absent as $report_absent_item)
								{
							?>
							<?php
									$i++;
									$no_of_men=$report_absent_item['nummen'];
									$total_man_count=$total_man_count+$no_of_men;
							?>
										<td><?php echo $report_absent_item['name'];?></td>
										<td class="center"><?php echo $no_of_men;?></td>
								<?php

										switch($i)
										{
											case 1: echo "<td class='center'>$".$hl_fee."/pax</td>"; 
													echo "<td>Dorm (Air Ticket $300 not included)</td>"; 
													$company_losses=$no_of_men*$hl_fee;
													break;
											case 2: echo "<td class='center'>$".$standby_fee."/pax</td>"; 
													echo "<td>Levy, Dorm</td>"; 
													$company_losses=$no_of_men*$standby_fee;
													break;
											case 3: echo "<td class='center'>$".$mc_fee."/pax</td>"; 
													echo "<td>Levy, Dorm, Medical, Basic Salary</td>"; 
													$company_losses=$no_of_men*$mc_fee;
													break;
											case 4: echo "<td class='center'>$".$course_fee."/pax</td>"; 
													echo "<td>Levy, Dorm (Course fee not included)</td>"; 
													$company_losses=$no_of_men*$course_fee;
													break;
											case 5: echo "<td class='center'>$".$absent_fee."/pax</td>"; 
													echo "<td>Levy, Dorm</td>"; 
													$company_losses=$no_of_men*$absent_fee;
													break;
											default: echo "<td class='center'>$0.00/pax</td>"; 
													 echo "<td>Levy, Dorm</td>"; 
													 $company_losses=0;
													 break;
										}
										$total_company_losses=$total_company_losses+$company_losses;
								?>	
										<td class="right"><?php echo "<font color='red'>$ -".number_format($company_losses,2)."</font>";?></td>
										<td class="right"><?php echo "$0.00";?></td>
									</tr>
							<?php
								}
							?>
								<td colspan="4" class="right">Estimated Losses not recorded</td>
								<td colspan="2" class="right"><?php echo "<font color='red'>$ -".number_format($total_company_losses,2)."</font>";?></td>
						</tbody>
					</table>
					<div class="separator bottom"></div>
					<table class="table table-bordered table-primary table-condensed" style="border-top:solid 1px #d7d8da; width:300px">
						<thead>
							<tr>
								<th class="center">Position</th>
								<th class="center">Man Count</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Driver</td>
								<td class="center"><?php echo $driver_number;?></td>
							</tr>
							<tr>
								<td>Storeman</td>
								<td class="center"><?php echo $storeman_number;?></td>
							</tr>
							<tr>
								<td>Supervisor</td>
								<td class="center"><?php echo ($supervisor_number-$total_spv_w_income);?></td>
							</tr>
							<tr>
								<td>Total Man Count</td>
								<td class="center">
									<?php 
										$total_man_count=$total_man_count+$total_no_of_men+$driver_number+$storeman_number+$supervisor_number-$total_spv_w_income;
										echo $total_man_count;
									?>
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
