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
	<h3 class="glyphicons table"><i></i>Monthly Report(Detail)</h3>
	
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
			<div class="widget-body">
				<table class="table table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Date</th>
							<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">No. of Men</th>
							<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Normal Salary</th>
							<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">OT Salary</th>
							<th class="center" style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);">Allowance</th>
							<th class="center" style="vertical-align:middle">Total Salary</th>
							<th class="center" style="vertical-align:middle">Levy</th>
							<th class="center" style="vertical-align:middle">Dorm</th>
							<th class="center" style="vertical-align:middle">Transport</th>
							<th class="center" style="vertical-align:middle">Adm</th>
							<th class="center" style="vertical-align:middle">Operation</th>
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
							foreach($monthly_detail as $monthly_detail_item)
							{
								$grand_total_no_of_men=$grand_total_no_of_men+$monthly_detail_item['no_of_men'];
								$grand_total_levy=$grand_total_levy+$monthly_detail_item['levy'];
								$grand_total_dormitory=$grand_total_dormitory+$monthly_detail_item['dormitory'];
								$grand_total_transportation=$grand_total_transportation+$monthly_detail_item['transportation'];
								$grand_total_administration=$grand_total_administration+$monthly_detail_item['administration'];
								$grand_total_operation=$grand_total_operation+$monthly_detail_item['operation'];
								
								$normal_salary=$monthly_detail_item['normal_salary'];
								$grand_total_normal_salary=$grand_total_normal_salary+$normal_salary;

								$ot_salary=$monthly_detail_item['ot_salary'];
								$grand_total_ot_salary=$grand_total_ot_salary+$ot_salary;

								$allowance_fee=$monthly_detail_item['allowance_fee'];
								$grand_total_allowance=$grand_total_allowance+$allowance_fee;

								$total_salary=$normal_salary+$ot_salary+$allowance_fee;
								$grand_total_total_salary=$grand_total_total_salary+$total_salary;
								
								$total_cost=$project_report_item['levy']+$project_report_item['dormitory']+$project_report_item['transportation']+$project_report_item['administration']+$project_report_item['operation']+$total_salary;
						?>
								<tr>
									<td>
										<?php echo date('D, d-M-Y',strtotime($monthly_detail_item['date']));?>
									</td>
									<td class="center">
										<?php echo $monthly_detail_item['no_of_men'];?>
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
											echo "$".number_format($monthly_detail_item['levy'],2);
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($monthly_detail_item['dormitory'],2);
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($monthly_detail_item['transportation'],2);
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($monthly_detail_item['administration'],2);
										?>
									</td>
									<td class="right">
										<?php 
											echo "$".number_format($monthly_detail_item['operation'],2);
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
		window.location.href = '<?PHP echo site_url("report/monthly_by_date"); ?>';
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
