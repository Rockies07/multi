<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />
				
<style>
.passport,.work_permit,.airport_pass,.employee_detail,.compulsory_course,.basic_course,.low_levy_course{
	display: none;
}

#table_container{
	overflow:scroll;
}
</style>

<div id="content">
	<div class="se-pre-con"></div>
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>HRM</li>
		<li class="divider"></li>
		<li>NTS Worker</li>
		<li class="divider"></li>
		<li>Add NTS Worker</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add NTS Worker</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="widget widget-tabs-icons-only">
					<div class="separator"></div>
					<!-- Widget Heading -->
					<div class="widget-head">
						<!-- Tabs -->
						<ul class="pull-left">
							<li class="glyphicons user_add active"><span data-toggle="tab" data-target="#tab1-5"><i></i></span></li>
							<li class="glyphicons certificate"><span data-toggle="tab" data-target="#tab2-5"><i></i></span></li>
						</ul>
						<div class="clearfix"></div>
						<!-- // Tabs END -->
						
					</div>
					<!-- Widget Heading END -->
					
					<div class="widget-body">
						<div class="tab-content">
						
							<!-- Tab content -->
							<div id="tab1-5" class="tab-pane active box-generic" style="background:#fafafa;">
								<div class="row-fluid">
									<div class="span6" style="height:505px;">
										<div class="separator"></div>
										<div class="span12">
											<div class="span3">NTS No.</div>
											<div class="span3">
												<input type="text" name="nts" placeholder="NTS No." class="span12" maxlength="32" value="<?php echo (isset($edit_employee->nts))?$edit_employee->nts:set_value('nts');?>"/>
												<input type="hidden" name="edit_id" value="<?php echo (isset($edit_employee->id))?$edit_employee->id:'0';?>"/>
											</div>
										</div>
										<div class="span12">
											<div class="span3">Name</div>
											<div class="span8"><input type="text" name="name" placeholder="Name" class="span12"  value="<?php echo (isset($edit_employee->name))?$edit_employee->name:set_value('name');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Nationality</div>
											<div class="span8">
												<select class="selectpicker span8" name="nationality" id="nationality">
													<?php 
														if(isset($edit_employee->nationality))
														{
															
													?>
															<option value="<?php echo $edit_employee->nationality;?>"><?php echo $edit_employee->nationality;?></option>
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
														foreach ($country as $country_item){
													?>
															<option value="<?php echo $country_item['nationality'];?>" <?php echo set_select('nationality', $country_item['nationality']); ?>><?php echo $country_item['nationality'];?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
										<div class="span12">
											<div class="span3">Date of Birth</div>
											<div class="span8"><input type="text" name="date_of_birth" id="dob"placeholder="Date of Birth" class="span4"  value="<?php echo (isset($edit_employee->date_of_birth))?date("m/d/Y",strtotime($edit_employee->date_of_birth)):date("m/d/Y");?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Contact No.</div>
											<div class="span4"><input type="text" name="local_contact" placeholder="Local Contact No." class="span12" maxlength="20" value="<?php echo (isset($edit_employee->local_contact))?$edit_employee->local_contact:set_value('local_contact');?>"/></div>
											<div class="span4"><input type="text" name="hm_contact" placeholder="Hm Contact No." class="span12" maxlength="20" value="<?php echo (isset($edit_employee->hm_contact))?$edit_employee->hm_contact:set_value('hm_contact');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Local Address</div>
											<div class="span8"><input type="text" name="local_address" placeholder="Local Address" class="span12" maxlength="100" value="<?php echo (isset($edit_employee->local_address))?$edit_employee->local_address:set_value('local_address');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Email Address</div>
											<div class="span8"><input type="text" name="email" placeholder="Email Address" class="span8" maxlength="50" value="<?php echo (isset($edit_employee->email))?$edit_employee->email:set_value('email');?>"/></div>
										</div>
										<div class="separator"></div>
										<div class="span12">
											<div class="span3">Position</div>
											<div class="span4">
												<select class="selectpicker span8" name="position">
													<?php 
														if(isset($edit_employee->position))
														{
															
													?>
															<option value="<?php echo $edit_employee->position;?>"><?php echo $edit_employee->position;?></option>
													<?php 
														}
														else
														{
													?>	
															<option value="">-Select-</option>
													<?php
														}
													?>
													<option value="Driver" <?php echo set_select('position', 'Driver'); ?>>Driver</option>
													<option value="Erector" <?php echo set_select('position', 'Erector'); ?>>Erector</option>
													<option value="Safety" <?php echo set_select('position', 'Safety'); ?>>Safety</option>
													<option value="Storeman" <?php echo set_select('position', 'Storeman'); ?>>Storeman</option>
													<option value="Supervisor" <?php echo set_select('position', 'Supervisor'); ?>>Supervisor</option>
													<option value="Sr. Supervisor" <?php echo set_select('position', 'Sr. Supervisor'); ?>>Sr. Supervisor</option>
												</select>
											</div>
										</div>
										<div class="span12">
											<div class="span3">Daily Rate</div>
											<div class="span3 input-prepend">
												<span class="add-on">$</span>
												<input id="prependedInput" class="span8" name="daily_rate" type="text" placeholder="Daily Rate" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_employee->daily_rate))?$edit_employee->daily_rate:set_value('daily_rate');?>"/>
											</div>
											<div class="span1">Levy</div>
											<div class="span3 input-prepend">
												<span class="add-on">$</span>
												<input id="prependedInput" class="span6" name="levy" type="text" placeholder="Levy" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_employee->levy))?$edit_employee->levy:set_value('levy');?>"/>
											</div>
										</div>
										<div class="span12">
											<div class="span3">Date Joined</div>
											<div class="span8">
												<input type="text" name="start_work_date" placeholder="Date Joined" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->start_work_date))?date("m/d/Y",strtotime($edit_employee->start_work_date)):date("m/d/Y");?>"/>
												&nbsp;
												<input type="text" name="referral" placeholder="Referral" class="span7" maxlength="30" value="<?php echo (isset($edit_employee->referral))?$edit_employee->referral:set_value('referral');?>"/>
											</div>
										</div>
										<div class="span12">
											<div class="span3">Prev. Work Exp</div>
											<div class="span8">
												<input type="text" name="prev_work_exp_year" placeholder="Year" class="span2" maxlength="2" value="<?php echo (isset($edit_employee->prev_work_exp_year))?$edit_employee->prev_work_exp_year:set_value('prev_work_exp_year');?>"/>
												&nbsp;
												<input type="text" name="prev_work_exp_month" placeholder="Month" class="span2" maxlength="4" value="<?php echo (isset($edit_employee->prev_work_exp_month))?$edit_employee->prev_work_exp_month:set_value('prev_work_exp_month');?>"/>
												&nbsp;
												<input type="text" name="prev_work_exp_day" placeholder="Day" class="span2" maxlength="4" value="<?php echo (isset($edit_employee->prev_work_exp_day))?$edit_employee->prev_work_exp_day:set_value('prev_work_exp_day');?>"/>
											</div>
										</div>
										<div class="span12">
											<div class="span3">Status</div>
											<div class="span4">
												<select class="selectpicker span8" name="status" id="status" onchange="show_hl_date();">
													<?php 
														if(isset($edit_employee->status))
														{
															
													?>
															<option value="<?php echo $edit_employee->status;?>"><?php echo $edit_employee->status;?></option>
													<?php 
														}
													?>
													<option value="Active" <?php echo set_select('status', 'Active'); ?>>Active</option>
													<option value="Cancel Permit" <?php echo set_select('status', 'Cancel Permit'); ?>>Cancel Permit</option>
													<option value="Resign" <?php echo set_select('status', 'Resign'); ?>>Resign</option>
													<option value="Terminated" <?php echo set_select('status', 'Terminated'); ?>>Terminated</option>
													<option value="Transfer" <?php echo set_select('status', 'Transfer'); ?>>Transfer</option>
												</select>
											</div>
											<div class="span5 end_date">
												<input type="text" name="end_work_date" placeholder="End Work Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->end_work_date))?date("m/d/Y",strtotime($edit_employee->end_work_date)):date("m/d/Y");?>"/>
											</div>
										</div>
									</div>
									<div class="span6">
										<div class="separator"></div>
										<div class="span12">
											<div class="span12"><b><u>Work Permit Detail</u></b></div>
										</div>
										<div class="span12">
											<div class="span3">Fin No.</div>
											<div class="span8"><input type="text" name="fin_no" placeholder="Fin No." class="span12" maxlength="12" value="<?php echo (isset($edit_employee->fin_no))?$edit_employee->fin_no:set_value('fin_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">WP No.</div>
											<div class="span8"><input type="text" name="wp_no" placeholder="WP No." class="span12" maxlength="12" value="<?php echo (isset($edit_employee->wp_no))?$edit_employee->wp_no:set_value('wp_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Date of Application</div>
											<div class="span8"><input type="text" name="wp_application_date" placeholder="Date of Application" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->wp_application_date))?date("m/d/Y",strtotime($edit_employee->wp_application_date)):date("m/d/Y");?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">WP Issuance Date</div>
											<div class="span8"><input type="text" name="wp_issued_date" placeholder="WP Issuance Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->wp_issued_date))?date("m/d/Y",strtotime($edit_employee->wp_issued_date)):date("m/d/Y");?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">WP Exp Date</div>
											<div class="span8"><input type="text" name="wp_exp_date" placeholder="WP Exp Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->wp_exp_date))?date("m/d/Y",strtotime($edit_employee->wp_exp_date)):date("m/d/Y");?>"/></div>
										</div>
										<div class="separator"></div>
										<div class="span12">
											<div class="span12"><b><u>Airport Pass Detail</u></b></div>
										</div>
										<div class="span12">
											<div class="span3">Date of Application</div>
											<div class="span8"><input type="text" name="ap_application_date" placeholder="Date of Application" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->ap_application_date))?date("m/d/Y",strtotime($edit_employee->ap_application_date)):date("m/d/Y");?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">AP Exp Date</div>
											<div class="span8"><input type="text" name="ap_exp_date" placeholder="AP Exp Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->ap_exp_date))?date("m/d/Y",strtotime($edit_employee->ap_exp_date)):date("m/d/Y");?>"/></div>
										</div>
										<div class="span12">
											<div class="span12"><b><u>Passport Detail</u></b></div>
										</div>
										<div class="span12">
											<div class="span3">Passport No.</div>
											<div class="span8"><input type="text" name="passport" placeholder="Passport No." class="span4" maxlength="12" value="<?php echo (isset($edit_employee->passport))?$edit_employee->passport:set_value('passport');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Passport Exp. Date</div>
											<div class="span8"><input type="text" name="passport_exp_date" placeholder="Passport Exp Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->passport_exp_date))?date("m/d/Y",strtotime($edit_employee->passport_exp_date)):date("m/d/Y");?>"/></div>
										</div>
									</div>
									<div class="span10">	
										<hr class="separator" />
									</div>
									<div class="span12">
										<div class="span10 center">
											<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
											<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Back to NTS Worker List</button>
										</div>
									</div>
								</div>
							</div>
							<!-- // Tab content END -->
							
							<!-- Tab content -->
							<div id="tab2-5" class="tab-pane box-generic" style="background:#fafafa;">
								<div class="row-fluid">
									<div class="span6" style="height:505px;">
										<div class="separator"></div>
										<div class="span12">
											<div class="span12"><b><u>Basic Course</u></b></div>
										</div>
										<div class="span12">
											<div class="span3">MSES No.</div>
											<div class="span8"><input type="text" name="mses_no" placeholder="MSES No." class="span12"  value="<?php echo (isset($edit_employee->mses_no))?$edit_employee->mses_no:set_value('mses_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">MSEC No.</div>
											<div class="span8"><input type="text" name="msec_no" placeholder="MSEC No." class="span12"  value="<?php echo (isset($edit_employee->msec_no))?$edit_employee->msec_no:set_value('msec_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">WAHS No.</div>
											<div class="span8"><input type="text" name="wahs_no" placeholder="WAHS No." class="span12"  value="<?php echo (isset($edit_employee->wahs_no))?$edit_employee->wahs_no:set_value('wahs_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">WAHW No.</div>
											<div class="span8"><input type="text" name="wahw_no" placeholder="WAHW No." class="span12"  value="<?php echo (isset($edit_employee->wahw_no))?$edit_employee->wahw_no:set_value('wahw_no');?>"/></div>
										</div>
										<div class="separator"></div>
										<div class="span12">
											<div class="span12"><b><u>Compulsory Course</u></b></div>
										</div>
										<div class="span12">
											<div class="span3">BCSS No.</div>
											<div class="span8"><input type="text" name="bcss_no" placeholder="BCSS No." class="span12"  value="<?php echo (isset($edit_employee->bcss_no))?$edit_employee->bcss_no:set_value('bcss_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">CSOC No.</div>
											<div class="span8"><input type="text" name="csoc_no" placeholder="CSOC No." class="span12"  value="<?php echo (isset($edit_employee->csoc_no))?$edit_employee->csoc_no:set_value('csoc_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">CSOC Exp. Date</div>
											<div class="span8"><input type="text" name="csoc_exp_date" placeholder="CSOC Exp. Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->csoc_exp_date))?date("m/d/Y",strtotime($edit_employee->csoc_exp_date)):date("m/d/Y");?>"/></div>
										</div>
									</div>
									<div class="span6">
										<div class="separator"></div>
										<div class="span12">
											<div class="span12"><b><u>Low Levy Course - Core Trade</u></b></div>
										</div>
										<div class="span12">
											<div class="span3">Core Trade Type</div>
											<div class="span8">
												<select class="selectpicker span8" name="core_trade_type" id="core_trade_type">
													<?php 
														if(isset($edit_employee->core_trade_type))
														{
															
													?>
															<option value="<?php echo $edit_employee->core_trade_type;?>"><?php echo $edit_employee->core_trade_type;?></option>
													<?php 
														}
														else
														{
													?>	
															<option value="">-Select-</option>
													<?php
														}
													?>
													<option value="Foreman" <?php echo set_select('core_trade_type', 'Foreman'); ?>>Foreman</option>
													<option value="Tradesman" <?php echo set_select('core_trade_type', 'Tradesman'); ?>>Tradesman</option>
												</select>
											</div>
										</div>
										<div class="span12">
											<div class="span3">Course Title</div>
											<div class="span8"><input type="text" name="core_trade_course" placeholder="Course Title" class="span12"  value="<?php echo (isset($edit_employee->core_trade_course))?$edit_employee->core_trade_course:set_value('core_trade_course');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Registration No.</div>
											<div class="span8"><input type="text" name="core_register_no" placeholder="Registration No." class="span12"  value="<?php echo (isset($edit_employee->core_register_no))?$edit_employee->core_register_no:set_value('core_register_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Expiry Date</div>
											<div class="span8"><input type="text" name="core_exp_date" placeholder="Exp. Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->core_exp_date))?date("m/d/Y",strtotime($edit_employee->core_exp_date)):date("m/d/Y");?>"/></div>
										</div>
										<div class="separator"></div>
										<div class="span12">
											<div class="span12"><b><u>Low Levy Course - Multi Skill</u></b></div>
										</div>
										<div class="span12">
											<div class="span3">1st SEC</div>
											<div class="span8"><input type="text" name="multi_skill_1" placeholder="1st SEC" class="span12"  value="<?php echo (isset($edit_employee->multi_skill_1))?$edit_employee->multi_skill_1:set_value('multi_skill_1');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">2nd SEC</div>
											<div class="span8"><input type="text" name="multi_skill_2" placeholder="2nd SEC" class="span12"  value="<?php echo (isset($edit_employee->multi_skill_2))?$edit_employee->multi_skill_2:set_value('multi_skill_2');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Registration No.</div>
											<div class="span8"><input type="text" name="multi_skill_register_no" placeholder="Registration No." class="span12"  value="<?php echo (isset($edit_employee->multi_skill_register_no))?$edit_employee->multi_skill_register_no:set_value('multi_skill_register_no');?>"/></div>
										</div>
										<div class="span12">
											<div class="span3">Expiry Date</div>
											<div class="span8"><input type="text" name="multi_skill_exp_date" placeholder="Exp. Date" class="span4 datetimepicker"  value="<?php echo (isset($edit_employee->multi_skill_exp_date))?date("m/d/Y",strtotime($edit_employee->multi_skill_exp_date)):date("m/d/Y");?>"/></div>
										</div>
									</div>
									<div class="span11">	
										<hr class="separator" />
									</div>
									<div class="span12">
										<div class="span10 center">
											<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
											<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Back to NTS Worker List</button>
										</div>
									</div>
								</div>
							</div>
							<!-- // Tab content END -->
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("employee/management"); ?>';
	}

	$(function() {
		$(".datetimepicker").datepicker({
		showOn: 'both', 
		buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
		buttonImageOnly: true,
		changeMonth: true,
      	changeYear: true
		});
	});

	$(function() {
		$("#dob").datepicker({
			showOn: 'both', 
			buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
			buttonImageOnly: true,
			changeMonth: true,
	      	changeYear: true,
	      	yearRange: '-50:+1'
		});
	});

	function show_hl_date()
	{
		var status=$("#status").val();
		if(status=="Cancel Permit" || status=="Resign" || status=="Terminated" || status=="Transfer")
		{
			$(".end_date").show();
		}
		else
		{
			$(".end_date").hide();
		}
	}

	$(document).ready(function(){
		show_hl_date();
	});

	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});

	function show_detail(id, value, width)
	{
		var table_width=$('#table_container').width();

		if($('#' + id).is(":checked"))
		{
			$('.' + value).show();
			
			table_width=table_width+width;
			$('#table_container').width(table_width);
		}
		else
		{
			$('.' + value).hide();
			table_width=table_width-width;
			$('#table_container').width(table_width);
		}
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
