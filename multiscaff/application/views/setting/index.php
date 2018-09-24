
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
		
<style>
input.hidden_text{
	border:none;
}
input[readonly]{
	background: transparent;
	cursor: auto;
}
</style>

<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Setting</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Setting</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Update Setting</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span3">Site Name</div>
							<div class="span7">
								<input type="text" name="site_name" placeholder="Site Name" class="span12" maxlength="100" value="<?php echo (isset($edit_setting->site_name))?$edit_setting->site_name:set_value('site_name');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_setting->id))?$edit_setting->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">System Name</div>
							<div class="span7">
								<input type="text" name="sys_name" placeholder="System Name" class="span12" maxlength="100" value="<?php echo (isset($edit_setting->sys_name))?$edit_setting->sys_name:set_value('sys_name');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">System Quote</div>
							<div class="span7">
								<input type="text" name="sys_motto" placeholder="System Motto" class="span12" maxlength="100" value="<?php echo (isset($edit_setting->sys_motto))?$edit_setting->sys_motto:set_value('sys_motto');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">OT Weekday</div>
							<div class="span6 input-prepend">
								<span class="add-on">x</span>
								<input id="prependedInput" class="span6" name="ot_weekday" type="text" placeholder="OT Weekday" onkeypress="return isNumberKey(event)" maxlength="4" value="<?php echo (isset($edit_setting->ot_weekday))?$edit_setting->ot_weekday:set_value('ot_weekday');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">OT Sunday</div>
							<div class="span6 input-prepend">
								<span class="add-on">x</span>
								<input id="prependedInput" class="span6" name="ot_sunday" type="text" placeholder="OT Sunday" onkeypress="return isNumberKey(event)" maxlength="4" value="<?php echo (isset($edit_setting->ot_sunday))?$edit_setting->ot_sunday:set_value('ot_sunday');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Meal min. Hour</div>
							<div class="span6 input-append">
								<input id="prependedInput" class="span5" name="meal_min_hour" type="text" placeholder="Meal min. Hour" onkeypress="return isNumberKey(event)" maxlength="6" value="<?php echo (isset($edit_setting->meal_min_hour))?$edit_setting->meal_min_hour:set_value('meal_min_hour');?>"/>
								<span class="add-on">hour(s)</span>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Meal Fee</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="meal_fee" type="text" placeholder="Meal Fee" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->meal_fee))?$edit_setting->meal_fee:set_value('meal_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Night Shift Fee</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="ns_fee" type="text" placeholder="Night Shift Fee" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->ns_fee))?$edit_setting->ns_fee:set_value('ns_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Night Shift Fee(Spv)</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="ns_spv_fee" type="text" placeholder="Night Shift Fee(Spv)" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->ns_spv_fee))?$edit_setting->ns_spv_fee:set_value('ns_spv_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Home Leave Fee</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="hl_cut_fee" type="text" placeholder="Home Leave Fee" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->hl_cut_fee))?$edit_setting->hl_cut_fee:set_value('hl_cut_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Standby Fee</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="standby_fee" type="text" placeholder="Standby Fee" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->standby_fee))?$edit_setting->standby_fee:set_value('standby_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">MC Fee</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="mc_fee" type="text" placeholder="MC Fee" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->mc_fee))?$edit_setting->mc_fee:set_value('mc_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Course Fee</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="course_fee" type="text" placeholder="Course Fee" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->course_fee))?$edit_setting->course_fee:set_value('course_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Absent Fee</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="absent_fee" type="text" placeholder="Absent Fee" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_setting->absent_fee))?$edit_setting->absent_fee:set_value('absent_fee');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Exp. Limit</div>
							<div class="span6 input-append">
								<input id="prependedInput" class="span3" name="expiry_limit" type="text" placeholder="Exp. Limit" onkeypress="return isNumberKey(event)" maxlength="5" value="<?php echo (isset($edit_setting->expiry_limit))?$edit_setting->expiry_limit:set_value('expiry_limit');?>"/>
								<span class="add-on">days</span>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Prefix Code</div>
							<div class="span6">
								<input class="span6" name="prefix_code" id="prefix_code" type="text" placeholder="Prefix Code" maxlength="32" value="<?php echo (isset($edit_setting->prefix_code))?$edit_setting->prefix_code:set_value('prefix_code');?>" onkeyup="set_code()"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Format Code</div>
							<div class="span6">
								<select name="middle_code" id="middle_code" onchange="set_code()">
									<?php 
										if(isset($edit_setting->middle_code))
										{
											
									?>
											<option value="<?php echo $edit_setting->middle_code;?>"><?php echo date("$edit_setting->middle_code");?></option>
									<?php 
										}
										else
										{
									?>	
											<option>-Select-</option>
									<?php
										}
									?>
									<option value="Y"><?php echo date('Y');?></option>
									<option value="Y/m"><?php echo date('Y/m');?></option>
									<option value="Y-m"><?php echo date('Y-m');?></option>
									<option value="Y/m/d"><?php echo date('Y/m/d');?></option>
									<option value="Y-m-d"><?php echo date('Y-m-d');?></option>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Suffix Code</div>
							<div class="span9">
								<input class="span4" name="suffix_code" id="suffix_code" type="text" placeholder="Suffix Code" maxlength="32" value="<?php echo (isset($edit_setting->suffix_code))?$edit_setting->suffix_code:set_value('suffix_code');?>" onkeyup="set_code()"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Decimal Digit</div>
							<div class="span9">
								<input class="span2" name="decimal_digit" id="decimal_digit" type="text" placeholder="Decimal Digit" maxlength="2" value="<?php echo (isset($edit_setting->decimal_digit))?$edit_setting->decimal_digit:set_value('decimal_digit');?>" onkeyup="set_code()"/>
								<input class="span6 hidden_text" readonly name="result_code" id="result_code" type="text"/>
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
					<div class="span5">
						<div class="separator"></div>
						<table class="table table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th width="150px" class="center">Setting</th>
									<th class="center">Value</th>
								</tr>
							</thead>
							<tbody>
								<tr class="gradeX">
									<td>Site Name</td>
									<td><?php echo $setting->site_name; ?></td>
								</tr>
								<tr class="gradeX">
									<td>System Name</td>
									<td><?php echo $setting->sys_name; ?></td>
								</tr>
								<tr class="gradeX">
									<td>System Quote</td>
									<td><?php echo $setting->sys_motto; ?></td>
								</tr>
								<tr class="gradeX">
									<td>OT Weekday</td>
									<td class="right"><?php echo $setting->ot_weekday; ?></td>
								</tr>
								<tr class="gradeX">
									<td>OT Sunday</td>
									<td class="right"><?php echo $setting->ot_sunday; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Meal min Hour</td>
									<td class="right"><?php echo $setting->meal_min_hour; ?> hour(s)</td>
								</tr>
								<tr class="gradeX">
									<td>Meal Fee</td>
									<td class="right">$<?php echo $setting->meal_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Night Shift Fee</td>
									<td class="right">$<?php echo $setting->ns_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Night Shift Fee(Spv)</td>
									<td class="right">$<?php echo $setting->ns_spv_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Home Leave Fee</td>
									<td class="right">$<?php echo $setting->hl_cut_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Standby Fee</td>
									<td class="right">$<?php echo $setting->standby_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>MC Fee</td>
									<td class="right">$<?php echo $setting->mc_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Course Fee</td>
									<td class="right">$<?php echo $setting->course_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Absent Fee</td>
									<td class="right">$<?php echo $setting->absent_fee; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Exp. Limit</td>
									<td class="right"><?php echo $setting->expiry_limit; ?> days</td>
								</tr>
								<tr class="gradeX">
									<td>Prefix Code</td>
									<td class="right"><?php echo $setting->prefix_code; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Middle Code</td>
									<td class="right"><?php echo date("$setting->middle_code"); ?></td>
								</tr>
								<tr class="gradeX">
									<td>Suffix Code</td>
									<td class="right"><?php echo $setting->suffix_code; ?></td>
								</tr>
								<tr class="gradeX">
									<td>Decimal Digit</td>
									<td class="right"><?php echo $setting->decimal_digit; ?></td>
								</tr>
							</tbody>
						</table>
						<div class="span12">
							<div class="separator"></div>
							<div class="span10 center">
								<?php echo anchor('setting/management/'.$setting->id, '<i></i>Edit',array('class' => 'btn btn-icon btn-primary glyphicons circle_ok'));?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("setting/management"); ?>';
	}

	$(document).ready(function(){
		set_code();
	});

	function pad (str, max) {
	  	str = str.toString();
	  	return str.length < max ? pad("0" + str, max) : str;
	}

	function set_code()
	{
		var prefix_code=$("#prefix_code").val();
		var suffix_code=$("#suffix_code").val();
		var middle_code=$("#middle_code option:selected" ).text();
		if(middle_code=="-Select-")
		{
			middle_code="";
		}

		var decimal_digit=$("#decimal_digit").val();
		var last_number= pad("1",decimal_digit);

		var result_code=prefix_code+""+middle_code+""+suffix_code+last_number;

		if((prefix_code!="")||(suffix_code!="")||(middle_code!=""))
		{
			$("#result_code").val(result_code);
		}
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
