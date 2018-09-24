<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<style>
	.ui-autocomplete { max-height: 300px; overflow-y: auto; overflow-x: hidden;}
</style>	
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Transaction</li>
		<li class="divider"></li>
		<li>Daily</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Daily Transaction</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<?php echo form_open($action)?>
				<div class="span4">
					<div class="row-fluid well">
						<div class="span12">
							<div class="separator"></div>
							<div class="span12">
								<div class="span2">Date</div>
								<div class="span6">
									<input type="text" name="date" id="transaction_date" class="input-mini" value="<?php echo date("m/d/Y");?>" style="width: 70px;" />
								</div>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_transaction_employee->id))?$edit_transaction_employee->id:'0';?>"/>
							</div>
							<div class="span12">
								<div class="span2">Site</div>
								<div class="span8">
									<select class="s span10" name="site" id="site" data-live-search="true">
										<?php 
											if(isset($edit_transaction_employee->site_id))
											{
												
										?>
												<option value="<?php echo $edit_transaction_employee->site_id;?>"><?php echo $edit_transaction_employee->name;?></option>
										<?php 
											}
											else
											{
										?>	
												<option value="">-Select-</option>
										<?php
											}
										?>
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
							<div class="span12 separator">
								<div class="span12 center">
									<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" onclick="return validate();"><i></i>Save</button>
									<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="span12">
					<div class="span5">
						<div class="widget-body">
							<table class="table table-bordered table-primary table-condensed">
								<thead>
									<tr>
										<th class="center" width="20px">S/N</th>
										<th>NTS No.</th>
										<th>Hours</th>
										<th>OT Hours</th>
										<th>NS</th>
										<th>2S</th>
									</tr>
								</thead>
								<tbody>
									<?php
										for($i=1;$i<=30;$i++)
										{
									?>
											<tr>
												<td class="center" style="vertical-align:middle">
													<?php echo $i;?>
												</td>
												<td class="center">
													<input type="text" name="nts_<?php echo $i;?>" id="nts_<?php echo $i;?>" class="nts_no" placeholder="NTS No." style="width:100px" value="<?php echo (isset($edit_transaction_employee->nts))?$edit_transaction_employee->nts:set_value('nts');?>" onkeyup="up(this)" onblur="complete_nts('<?php echo $i;?>');get_employee_detail('<?php echo $i;?>');get_employee_check_hours('<?php echo $i;?>');"/>
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="work_hour_<?php echo $i;?>" id="work_hour_<?php echo $i;?>" class="right" placeholder="Hour" style="width:70px" onkeypress="return isNumberKey(event)"/>
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="ot_hour_<?php echo $i;?>" id="ot_hour_<?php echo $i;?>" class="right" placeholder="OT Hour" style="width:70px" onkeypress="return isNumberKey(event)"/>
												</td>
												<td class="center">
													<input type="checkbox" name="ns_<?php echo $i;?>" id="ns_<?php echo $i;?>" value="1">
												</td>
												<td class="center">
													<input type="checkbox" name="add_shift_<?php echo $i;?>" id="add_shift_<?php echo $i;?>" value="1">
												</td>
											</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="span5">
						<div class="widget-body">
							<table class="table table-bordered table-primary table-condensed">
								<thead>
									<tr>
										<th class="center" width="20px">S/N</th>
										<th>NTS No.</th>
										<th>Hours</th>
										<th>OT Hours</th>
										<th>NS</th>
										<th>2S</th>
									</tr>
								</thead>
								<tbody>
									<?php
										for($i=31;$i<=60;$i++)
										{
									?>
											<tr>
												<td class="center" style="vertical-align:middle">
													<?php echo $i;?>
												</td>
												<td class="center">
													<input type="text" name="nts_<?php echo $i;?>" id="nts_<?php echo $i;?>" class="nts_no" placeholder="NTS No." style="width:100px" value="<?php echo (isset($edit_transaction_employee->nts))?$edit_transaction_employee->nts:set_value('nts');?>" onkeyup="up(this)" onblur="complete_nts('<?php echo $i;?>');get_employee_detail('<?php echo $i;?>');get_employee_check_hours('<?php echo $i;?>');"/>
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="work_hour_<?php echo $i;?>" id="work_hour_<?php echo $i;?>" class="right" placeholder="Hour" style="width:70px" onkeypress="return isNumberKey(event)"/>
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="ot_hour_<?php echo $i;?>" id="ot_hour_<?php echo $i;?>" class="right" placeholder="OT Hour" style="width:70px" onkeypress="return isNumberKey(event)"/>
												</td>
												<td class="center">
													<input type="checkbox" name="ns_<?php echo $i;?>" id="ns_<?php echo $i;?>" value="1">
												</td>
												<td class="center">
													<input type="checkbox" name="add_shift_<?php echo $i;?>" id="add_shift_<?php echo $i;?>" value="1">
												</td>
											</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="span12">
						<div class="span10 center">
							<div class="separator"></div>
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" onclick="return validate();"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
				</div>
			
			</form>
		</div>
	</div>
	
<script type="text/javascript">
	$(function() {
		$("#transaction_date").datepicker({
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
	
	(function($){
		$(function(){
			$(".nts_no").autocomplete({
				source: "<?php echo site_url('transaction_employee/get_employee_by_nts'); ?>" // path to the get_birds method
		  	});
		});
	})(jQuery);
	
	function get_employee_detail(counter)
	{
		var value=$("#nts_"+counter).val();
		
		var transaction_date=$("#transaction_date").val();
		var date_arr=transaction_date.split("/");
		
		transaction_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];
		
		if(value!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('utility/get_employee_detail/"+value+"/"+transaction_date+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					if(data.error)
					{
						alert("Employee NTS No. Not Found");
						$("#nts_"+counter).val('');
						$("#nts_"+counter).focus();
					}
				},
				error:function(data){
					alert("Employee NTS No. Not Found");
				}
			});
		}
	}

	function get_employee_check_hours(counter)
	{
		var value=$("#nts_"+counter).val();
		
		var transaction_date=$("#transaction_date").val();
		var date_arr=transaction_date.split("/");
		
		transaction_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];
		
		if(value!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('utility/get_employee_check_hours/"+value+"/"+transaction_date+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					if(data.error)
					{
						alert("Employee has work more than 8 hours");
					}
				},
				error:function(data){
					alert("Your data got error, please ask administrator to check");
				}
			});
		}
	}
	
	function validate()
	{
		var site=$("#site").val();
		var have_data=0;
		var get_nts="";
		for(var i=0;i<=30;i++)
		{
			get_nts=$("#nts_"+i).val();
			
			if(get_nts!="")
			{
				have_data++;
			}
		}
		
		if(have_data>=1)
		{
			return true;
		}
		else
		{
			alert("No Employee Data Inserted..");
			return false;
		}
	}

	function complete_nts(counter)
	{
		var value=$("#nts_"+counter).val();
		var str_len=value.length;


		if(parseFloat(value)>0)
		{
			if((value!="")&&(str_len<=3))
			{
				switch(str_len)
				{
					case 3 : value = "NTS-"+value; break;
					case 2 : value = "NTS-0"+value; break;
					case 1 : value = "NTS-00"+value; break;
					default : value = value; break;
				}
				
				$("#nts_"+counter).val(value);
			}
		}
	}
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
