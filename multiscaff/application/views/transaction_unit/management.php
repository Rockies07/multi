<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Daily Transaction List</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Daily Employee List</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="filter-bar">
				<?php echo form_open($action)?>
					<div class="lbl glyphicons cogwheel"><i></i>Filter</div>
					<div>
						<label>From:</label>
						<div>
							<input type="text" name="date_from" id="date_from" class="input-mini datetimepicker" value="<?php if($filter_date_from=="") echo date("m/d/Y"); else echo $filter_date_from;?>" style="width: 70px;" />
						</div>
					</div>
					<div>
						<label>To:</label>
						<div>
							<input type="text" name="date_to" id="date_to" class="input-mini datetimepicker" value="<?php if($filter_date_to=="") echo date("m/d/Y"); else echo $filter_date_to;?>" style="width: 70px;" />
						</div>
					</div>
					<div>
						<label>Project:</label>
						<div>
							<select name="project" id="project">
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
									if($filter_site!="")
									{
										
								?>
										<option value="<?php echo $filter_site;?>"><?php echo $filter_site_name;?></option>
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
				<?php echo form_open($action)?>
					<div class="widget-body">
						<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle" width="20px">S/N</th>
									<!--<th width="100px">Project</th>-->
									<th style="vertical-align:middle; width:120px">Date</th>
									<th style="vertical-align:middle">Site</th>
									<th style="vertical-align:middle; width:100px">NTS No.</th>
									<th style="vertical-align:middle; width:250px">Name</th>
									<th style="vertical-align:middle">Position</th>
									<!--
										<th style="vertical-align:middle">HR.Rate</th>
										<th style="vertical-align:middle">OT.Rate</th>
									-->
									<th style="vertical-align:middle">Hours</th>
									<th style="vertical-align:middle">OT.Hours</th>
									<th style="vertical-align:middle">N.Salary</th>
									<th style="vertical-align:middle">OT.Salary</th>
									<th style="vertical-align:middle">Meal</th>
									<th style="vertical-align:middle">NS.Fee</th>
									<th style="vertical-align:middle">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i=0;
									foreach($transaction_employee as $transaction_employee_item)
									{
										$i++;
								?>
										<tr class="gradeX">
											<td class="center" style="vertical-align:middle">
												<?php
													if($edit_id!=$transaction_employee_item["id"])
													{ 
														echo $i;
													}
													else
													{
													?>
													<?php
														echo "-".anchor('transaction_employee/management', '<i></i>',array('class' => 'btn-action glyphicons repeat btn-danger'));
													}
												?>
											</td>
											<!--
											<td>
												<?php echo $transaction_employee_item["project_name"];?>
											</td>
											-->
											<td>
												<?php echo date("d-M-Y",strtotime($transaction_employee_item["date"]));?>
											</td>
											<td>
												<?php echo $transaction_employee_item["site_name"];?>
											</td>
											<td>
												<?php echo $transaction_employee_item["nts"];?>
												<?php
													if($edit_id==$transaction_employee_item["id"])
													{
												?>
														<input type="hidden" name="edit_id" id="edit_id" value="<?php echo $transaction_employee_item['id'];?>"/>
												<?php
													}
												?>
											</td>
											<td style="vertical-align:middle">
												<?php echo $transaction_employee_item["employee_name"];?>
											</td>
											<td style="vertical-align:middle" class="center">
												<?php echo $transaction_employee_item["position"];?>
											</td>
											<!--
												<td style="vertical-align:middle" class="right">
													$<?php echo (float)$transaction_employee_item["hourly_rate"];?>
												</td>
												<td style="vertical-align:middle" class="right">
													$<?php echo (float)$transaction_employee_item["ot_rate"];?>
												</td>
											-->
											<td style="vertical-align:middle" class="center">
												<?php
													if($edit_id!=$transaction_employee_item["id"])
													{ 
														echo $transaction_employee_item["work_hour"];
													}
													else
													{
												?>
														<input type="text" name="work_hour" id="work_hour" class="right" placeholder="Hour" style="width:50px" maxlength="6"  value="<?php echo $transaction_employee_item['work_hour'];?>" onkeypress="return isNumberKey(event)"/>
												<?php
													}
												?>
											</td>
											<td style="vertical-align:middle" class="center">
												<?php
													if($edit_id!=$transaction_employee_item["id"])
													{ 
														echo $transaction_employee_item["ot_hour"];
													}
													else
													{
												?>
														<input type="text" name="ot_hour" id="ot_hour" class="right" placeholder="OT Hour" style="width:50px" maxlength="6" value="<?php echo $transaction_employee_item['ot_hour'];?>" onkeypress="return isNumberKey(event)"/>
												<?php
													}
												?>
											</td>
											<td style="vertical-align:middle" class="right">
												$<?php echo number_format($transaction_employee_item["normal_salary"],2);?>
											</td>
											<td style="vertical-align:middle" class="right">
												$<?php echo number_format($transaction_employee_item["ot_salary"],2);?>
											</td>
											<td style="vertical-align:middle" class="right">
												$<?php echo number_format($transaction_employee_item["meal_fee"],2);?>
											</td>
											<td style="vertical-align:middle" class="right">
												<?php
													if($edit_id!=$transaction_employee_item["id"])
													{ 
														echo "$".number_format($transaction_employee_item["ns_fee"],2);
													}
													else
													{
														if($transaction_employee_item["ns_fee"]>0)
														{
															$ns_checked="checked";
														}
														else
														{
															$ns_checked="";
														}
												?>
														NS &nbsp;<input type="checkbox" name="ns" id="ns" value="1" <?php echo $ns_checked;?>>
												<?php
													}
												?>
												
											</td>
											<td class="center actions" style="vertical-align:middle" >
												<?php
													if($edit_id!=$transaction_employee_item["id"])
													{ 
														echo anchor('transaction_employee/management/'.$transaction_employee_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));
														echo anchor('transaction_employee/delete/'.$transaction_employee_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this employee data?')"));
													}
													else
													{
														if($transaction_employee_item["ns_fee"]>0)
														{
															$ns_checked="checked";
														}
														else
														{
															$ns_checked="";
														}
												?>
														<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
												<?php
													}
												?>
												
											</td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</form>
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
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
