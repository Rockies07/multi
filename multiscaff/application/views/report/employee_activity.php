<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />

<style>
input.edit_text{
	border:none;
}
input.hidden_text{
	border:none;
}
input[readonly]{
	background: transparent;
	cursor: auto;
}
.hidden_element{
	display:none;
}

a{
	color:#484c50;
}

.control-label{
	font-weight: bold;
}

.modal-title{
	padding-top: 5px;
	height: 35px;
}

.modal-header{
	background-color: #EEE;
}
</style>

<div id="content">
	<div class="se-pre-con"></div>
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>HRM</li>
		<li class="divider"></li>
		<li>NTS Worker Activity</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>NTS Worker Activity</h3>
	
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
						<label>NTS:</label>
						<div>
							<input type="text" name="nts" id="nts" class="input-mini" placeholder="NTS No." value="<?php if($filter_nts!="") echo $filter_nts; ?>" style="width: 70px; vertical-align:5px;" onBlur="complete_nts_by_field('nts');"/>
						</div>
					</div>
					<div>
						<button type="submit" class="btn btn-icon btn-primary glyphicons search"><i></i>Search</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
			<div>
				<?php echo form_open($action)?>
					<div class="widget-body">
						<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle" width="20px">S/N</th>
									<!--<th width="100px">Project</th>-->
									<th style="vertical-align:middle">Site</th>
									<th class="center" style="vertical-align:middle; width:120px">Date</th>
									<th class="center" style="vertical-align:middle; width:50px">Day</th>
									<th class="center" style="vertical-align:middle">Hours</th>
									<th class="center" style="vertical-align:middle">1.5 OT</th>
									<th class="center" style="vertical-align:middle">2 OT</th>
									<th class="center" style="vertical-align:middle">Rate</th>
									<th class="center" style="vertical-align:middle">OT Rate</th>
									<th class="center" style="vertical-align:middle">Amount</th>
									<th class="center" style="vertical-align:middle">Meal Fee</th>
									<th class="center" style="vertical-align:middle">NS Fee</th>
									<th class="center" style="vertical-align:middle">Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(($transaction_employee))
									{
										$i=0;
										foreach($transaction_employee as $transaction_employee_item)
										{
											$i++;
											$hourly_rate=$transaction_employee_item["hourly_rate"];
											$ot_rate=$transaction_employee_item["ot_rate"];
											$ot_hour=$transaction_employee_item["ot_hour"];
											$work_hour=$transaction_employee_item["work_hour"];
											$meal_fee=$transaction_employee_item["meal_fee"];
											$ns_fee=$transaction_employee_item["ns_fee"];
											$multiple=$ot_rate/$hourly_rate;
											$amount=($work_hour*$hourly_rate)+($ot_hour*$ot_rate);
											$total=$amount+$meal_fee+$ns_fee;
								?>
											<tr class="gradeX">
												<td class="center" style="vertical-align:middle">
													<?php
														 echo $i;
													?>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_employee_item["site_name"];?>
												</td>
												<td class="center" style="vertical-align:middle">
													<?php echo date("d-M-Y",strtotime($transaction_employee_item["date"]));?>
												</td>
												<td class="center" style="vertical-align:middle">
													<?php echo date("D",strtotime($transaction_employee_item["date"]));?>
												</td>
												<td class="center" style="vertical-align:middle">
													<?php echo $transaction_employee_item["work_hour"];?>
												</td>
												<td class="center" style="vertical-align:middle">
													<?php 
														if($multiple<2.0)
														{
															echo $ot_hour;
														}
													?>
												</td>
												<td class="center" style="vertical-align:middle">
													<?php 
														if($multiple>=2)
														{
															echo $ot_hour;
														}
													?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format($hourly_rate,2);?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format($ot_rate,2);?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php 
														echo number_format($amount,2);
													?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format($meal_fee,2);?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format($ns_fee,2);?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format($total,2);?>
												</td>
											</tr>
								<?php
										}
									}
									else
									{
								?>
										<tr class="gradeX">
											<td colspan='10' style="vertical-align:middle">
												No data available in table
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
	$(document).ready(function(){
		init_filter_site();

		$('.selectpicker').selectpicker({
	      	size: 10,
	  	});
	});

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
		window.location.href = '<?PHP echo site_url("report/employee_activity"); ?>';
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

 	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
