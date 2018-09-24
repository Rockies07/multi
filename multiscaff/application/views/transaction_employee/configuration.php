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
		<li>Update Detail</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Update Detail</h3>
	<?php echo form_open($action)?>
		<div class="innerLR">
			<div class="widget widget-4 widget-body-white span5">
				<div class="widget-head">
					<h4 class="heading">Update Salary</h4>
				</div>
				<div class="row-fluid well">
					<div class="span12">
						<div class="separator"></div>
						<div class="span12">
							<div class="span3">NTS No.</div>
							<div class="span6">
								<input type="text" name="nts_salary" id="nts_salary" placeholder="NTS No." class="span12" maxlength="32" value="" onblur="complete_nts_conf();"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Daily Rate</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="daily_rate" type="text" placeholder="Daily Rate" onkeypress="return isNumberKey(event)" maxlength="10" value=""/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Effective Date</div>
							<div class="span6">
								<input type="text" name="date_salary" id="date_salary" class="input-mini datepicker" value="<?php echo date("m/d/Y");?>" style="width: 70px;" />
							</div>
						</div>
					</div>
					<div class="span10">	
						<hr class="separator" />
					</div>
					<div class="span12">
						<div class="span10 center">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
				</div>
			</div>
			<div class="span1">
				&nbsp;
			</div>
			<div class="widget widget-4 widget-body-white span6">
				<div class="widget-head">
					<h4 class="heading">Adjust Date</h4>
				</div>
				<div class="row-fluid well">
					<div class="span12">
						<div class="separator"></div>
						<div class="span12">
							<div class="span3">Site</div>
							<div class="span6">
								<select class="selectpicker span10" name="site" id="site" data-live-search="true">
									<option value="">-Select-</option>
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
						<div class="span12">
							<div class="span3">Current Date</div>
							<div class="span6">
								<input type="text" name="date_site_from" id="date_site_from" class="input-mini datepicker" value="<?php echo date("m/d/Y");?>" style="width: 70px;" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Adjust Date</div>
							<div class="span6">
								<input type="text" name="date_site_to" id="date_site_to" class="input-mini datepicker" value="<?php echo date("m/d/Y");?>" style="width: 70px;" />
							</div>
						</div>
					</div>
					<div class="span10">	
						<hr class="separator" />
					</div>
					<div class="span12">
						<div class="span10 center">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
				</div>
				<div class="separator"></div>
			</div>
			<div class="widget widget-4 widget-body-white span5">
				<div class="widget-head">
					<h4 class="heading">Adjust Site</h4>
				</div>
				<div class="row-fluid well">
					<div class="span12">
						<div class="separator"></div>
						<div class="span12">
							<div class="span3">Current Site</div>
							<div class="span7">
								<select class="selectpicker span10" name="current_site" id="current_site" data-live-search="true">
									<option value="">-Select-</option>
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
						<div class="span12">
							<div class="span3">Target Site</div>
							<div class="span7">
								<select class="selectpicker span10" name="target_site" id="target_site" data-live-search="true">
									<option value="">-Select-</option>
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
						<div class="span12">
							<div class="span3">Date</div>
							<div class="span7">
								<input type="text" name="date_site" id="date_site" class="input-mini datepicker" value="<?php echo date("m/d/Y");?>" style="width: 70px;" />
							</div>
						</div>
					</div>
					<div class="span10">	
						<hr class="separator" />
					</div>
					<div class="span12">
						<div class="span10 center">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
				</div>
				<div class="separator"></div>
			</div>
		</div>
	</form>
	
<script type="text/javascript">
	$(function() {
		$(".datepicker").datepicker({
		showOn: 'both', 
		buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
		buttonImageOnly: true,
		changeMonth: true,
      	changeYear: true
		});
	});

	function reload(){
		window.location.href = '<?PHP echo site_url("transaction_employee/configuration"); ?>';
	}
	
	(function($){
		$(function(){
			$("#nts_salary").autocomplete({
				source: "<?php echo site_url('transaction_employee/get_employee_by_nts'); ?>"
				// path to the get_birds method
		  	});
		});
	})(jQuery);

	function complete_nts_conf()
	{
		var value=$("#nts_salary").val();
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
				
				$("#nts_salary").val(value);
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
