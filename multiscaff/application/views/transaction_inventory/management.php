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
</style>

<div id="content">
	<div class="se-pre-con"></div>
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
									foreach($transaction_journal as $transaction_journal_item)
									{
										$i++;
								?>
										<tr class="gradeX">
											<td class="center" style="vertical-align:middle">
												<?php
													if($edit_id!=$transaction_journal_item["id"])
													{ 
														echo $i;
													}
													else
													{
													?>
													<?php
														echo "-".anchor('transaction_journal/management', '<i></i>',array('class' => 'btn-action glyphicons repeat btn-danger'));
													}
												?>
											</td>
											<!--
											<td>
												<?php echo $transaction_journal_item["project_name"];?>
											</td>
											-->
											<td>
												<?php echo date("d-M-Y",strtotime($transaction_journal_item["date"]));?>
											</td>
											<td>
												<?php echo $transaction_journal_item["site_name"];?>
											</td>
											<td>
												<?php echo $transaction_journal_item["nts"];?>
												<?php
													if($edit_id==$transaction_journal_item["id"])
													{
												?>
														<input type="hidden" name="edit_id" id="edit_id" value="<?php echo $transaction_journal_item['id'];?>"/>
												<?php
													}
												?>
											</td>
											<td style="vertical-align:middle">
												<?php echo $transaction_journal_item["employee_name"];?>
											</td>
											<td style="vertical-align:middle" class="center">
												<?php echo $transaction_journal_item["position"];?>
											</td>
											<!--
												<td style="vertical-align:middle" class="right">
													$<?php echo (float)$transaction_journal_item["hourly_rate"];?>
												</td>
												<td style="vertical-align:middle" class="right">
													$<?php echo (float)$transaction_journal_item["ot_rate"];?>
												</td>
											-->
											<td style="vertical-align:middle" class="center">
												<input type="text" id="work_hour_<?php echo $transaction_journal_item["id"];?>" class="right edit_text" style="width:50px" maxlength="6" value="<?php echo $transaction_journal_item['work_hour'];?>" onkeypress="return isNumberKey(event)" readonly/>
												<div class="hidden_element"><?php echo $transaction_journal_item['work_hour'];?></div>
											</td>
											<td style="vertical-align:middle" class="center">
												<input type="text" id="ot_hour_<?php echo $transaction_journal_item["id"];?>" class="right edit_text" style="width:50px" maxlength="6" value="<?php echo $transaction_journal_item['ot_hour'];?>" onkeypress="return isNumberKey(event)" readonly/>
												<div class="hidden_element"><?php echo $transaction_journal_item['ot_hour'];?></div>
											</td>
											<td style="vertical-align:middle" class="right">
												<input id="normal_salary_<?php echo $transaction_journal_item["id"];?>" value="$<?php echo number_format($transaction_journal_item["normal_salary"],2);?>" class="right hidden_text" style="width:80px" readonly>
												<div class="hidden_element"><?php echo $transaction_journal_item['normal_salary'];?></div>
											</td>
											<td style="vertical-align:middle" class="right">
												<input id="ot_salary_<?php echo $transaction_journal_item["id"];?>" value="$<?php echo number_format($transaction_journal_item["ot_salary"],2);?>" class="right hidden_text" style="width:80px" readonly>
												<div class="hidden_element"><?php echo $transaction_journal_item['ot_salary'];?></div>
											</td>
											<td style="vertical-align:middle" class="right">
												<input id="meal_fee_<?php echo $transaction_journal_item["id"];?>" value="$<?php echo number_format($transaction_journal_item["meal_fee"],2);?>" class="right hidden_text" style="width:50px" readonly>
												<div class="hidden_element"><?php echo $transaction_journal_item['meal_fee'];?></div>
											</td>
											<td style="vertical-align:middle" class="right">
												<div class="normal_session">
													<input id="ns_fee_<?php echo $transaction_journal_item["id"];?>" value="$<?php echo number_format($transaction_journal_item["ns_fee"],2);?>" class="right hidden_text" style="width:50px" readonly>
													<div class="hidden_element"><?php echo $transaction_journal_item['ns_fee'];?></div>
												</div>
												<div class="edit_session">
													<?php
														if($transaction_journal_item["ns_fee"]>0)
														{
															$ns_checked="checked";
														}
														else
														{
															$ns_checked="";
														}
													?>
													<input type="checkbox" name="ns" id="ns_<?php echo $transaction_journal_item["id"];?>" value="1" <?php echo $ns_checked;?>>
												</div>
											</td>
											<td class="center actions" style="vertical-align:middle" >
												<a class="btn-action glyphicons pencil btn-success normal_session" onclick="edit_show_text('<?php echo $transaction_journal_item["id"];?>')"><i></i></a>
												<?php
														echo anchor('transaction_journal/delete/'.$transaction_journal_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger normal_session','onclick'=>"return confirm('Are you sure to remove this employee data?')"));
												?>
												<a class="btn-action glyphicons ok_2 btn-primary edit_session" onclick="save_text('<?php echo $transaction_journal_item["id"];?>')"><i></i></a>
												<a class="btn-action glyphicons repeat btn-danger edit_session" onclick="save_hide_text('<?php echo $transaction_journal_item["id"];?>')"><i></i></a>
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
		$(".edit_session").hide();
		init_filter_site();
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
		window.location.href = '<?PHP echo site_url("transaction_journal/management"); ?>';
	}

	function edit_show_text(id)
	{
		$("#work_hour_"+id).removeClass("edit_text");
		$("#ot_hour_"+id).removeClass("edit_text");
		$("#work_hour_"+id).attr("readonly", false);
		$("#ot_hour_"+id).attr("readonly", false);
		$(".normal_session").hide();
		$(".edit_session").show();
	}

	function save_hide_text(id)
	{
		$("#work_hour_"+id).addClass("edit_text");
		$("#ot_hour_"+id).addClass("edit_text");
		$("#work_hour_"+id).attr("readonly", true);
		$("#ot_hour_"+id).attr("readonly", true);
		$(".edit_session").hide();
		$(".normal_session").show();
	}

	function save_text(id)
	{
		var work_hour=$("#work_hour_"+id).val();
		var ot_hour=$("#ot_hour_"+id).val();
		var ns=0;
		if($('#ns_' + id).is(":checked"))
		{
			ns=1;
		}
		else
		{
			ns=0;
		}
		var id=id;
		
		$.ajax(
		{
			url: "<?php echo site_url('utility/update_supply_transaction/"+id+"/"+work_hour+"/"+ot_hour+"/"+ns+"'); ?>",
			type:'POST', //data type
			dataType : "json",
			success:function(data){
				$("#normal_salary_"+id).val(data.normal_salary);
				$("#ot_salary_"+id).val(data.ot_salary);
				$("#meal_fee_"+id).val(data.meal_fee);
				$("#ns_fee_"+id).val(data.ns_fee);
				save_hide_text(id);
				alert("Data Updated");
			},
			error:function(data){
				alert("Error when Saving");
			}
		});
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
 			url: "<?php echo site_url('transaction_journal/get_site_list_by_value/"+project+"'); ?>", //here we are calling our user controller and get_cities method with the country_id
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
<script src="<?php echo base_url();?>public/js/modernizr.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
