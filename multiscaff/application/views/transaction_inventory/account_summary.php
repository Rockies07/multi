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
		<li>Account Summary</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Account Summary</h3>
	
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
						<table class="table table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle" width="20px">S/N</th>
									<!--<th width="100px">Project</th>-->
									<th style="vertical-align:middle;">Account</th>
									<th class="center" style="vertical-align:middle" width="60px">Type</th>
									<th class="center" style="vertical-align:middle" width="150px">Deposit</th>
									<th class="center" style="vertical-align:middle" width="150px">Expenses</th>
									<th class="center" style="vertical-align:middle" width="180px">Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(($account_summary))
									{
										$i=0;
										foreach($account_summary as $account_summary_item)
										{
											$i++;
								?>
											<tr class="gradeX">
												<td class="center" style="vertical-align:middle">
													<?php
														echo $i;
													?>
												</td>
												<td>
													<?php 
														$account_no=$account_summary_item["account_no"];
														if($account_no!="")
														{
															$set_account_no_str="-".$account_no;
														}
														else
														{
															$set_account_no_str="";
														}
														echo $account_summary_item["account_name"].$set_account_no_str;?>
												</td>
												<td class="center" style="vertical-align:middle">
													<?php echo $account_summary_item["type"];?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format($account_summary_item["amount_deposit"],2);?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format($account_summary_item["amount_expenses"],2);?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo number_format(($account_summary_item["amount_expenses"]+$account_summary_item["amount_deposit"]),2);?>
												</td>
											</tr>
								<?php
										}
									}
									else
									{
								?>
										<tr class="gradeX">
											<td colspan='11' style="vertical-align:middle">
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
		window.location.href = '<?PHP echo site_url("transaction_journal/account_summary"); ?>';
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
