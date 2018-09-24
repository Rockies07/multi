<link rel="stylesheet" href="<?php echo base_url();?>public/css/jqueryui.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />

<style>
#setting_unit{
	display:none;
}
</style>

<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Site</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Site</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Site</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Project</div>
							<div class="span4">
								<select class="selectpicker span10" name="project" data-live-search="true">
									<?php 
										if(isset($edit_site->project_id))
										{
											
									?>
											<option value="<?php echo $edit_site->project_id;?>"><?php echo $edit_site_project->name;?></option>
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
										foreach ($project as $project_item){
									?>
											<option value="<?php echo $project_item['id'];?>" <?php echo set_select('project', $project_item['id']); ?>><?php echo $project_item['name'];?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Name</div>
							<div class="span8">
								<input type="text" name="name" placeholder="Name" class="span12" maxlength="100" value="<?php echo (isset($edit_site->name))?$edit_site->name:set_value('name');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_site->id))?$edit_site->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Code</div>
							<div class="span8">
								<input type="text" name="code" placeholder="Code" class="span7" maxlength="32" value="<?php echo (isset($edit_site->code))?$edit_site->code:set_value('code');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Type</div>
							<div class="span4">
								<select class="selectpicker span8" name="type" id="type" onchange="site_setting()">
									<?php 
										if(isset($edit_site->type))
										{
											
									?>
											<option value="<?php echo $edit_site->type;?>"><?php echo $edit_site->type;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">-Select-</option>
									<?php
										}
									?>
									<option value="Supply" <?php echo set_select('type', 'Supply'); ?>>Supply</option>
									<option value="Unit" <?php echo set_select('type', 'Unit'); ?>>Unit</option>
									<option value="Lumpsum" <?php echo set_select('type', 'Lumpsum'); ?>>Lumpsum</option>
								</select>
							</div>
						</div><div class="span12">
							<div class="span2">Status</div>
							<div class="span4">
								<select class="selectpicker span8" name="status" id="status">
									<?php 
										if(isset($edit_site->status))
										{
											
									?>
											<option value="<?php echo $edit_site->status;?>"><?php echo $edit_site->status;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">-Select-</option>
									<?php
										}
									?>
									<option value="Active" <?php echo set_select('status', 'Active'); ?>>Active</option>
									<option value="Closed" <?php echo set_select('status', 'Closed'); ?>>Closed</option>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Description</div>
							<div class="span10">
								<input type="text" name="description" placeholder="Description" class="span12" value="<?php echo (isset($edit_site->description))?$edit_site->description:set_value('description');?>"/>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="separator"></div>
						<div class="span12" id="setting_supply">
							<div class="span12"><b><u>Site Setting</u></b></div>
							<div class="span12">
								<div class="span2">Hourly Rate</div>
								<div class="span3 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span8" name="hourly_rate" type="text" placeholder="Hourly Rate" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->hourly_rate))?$edit_site->hourly_rate:set_value('hourly_rate');?>"/>
								</div>
								<div class="span3">Hourly Rate(Spv)</div>
								<div class="span4 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span6" name="spv_hourly_rate" type="text" placeholder="Hourly Rate" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->spv_hourly_rate))?$edit_site->spv_hourly_rate:set_value('spv_hourly_rate');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">OT 1.5</div>
								<div class="span3 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span8" name="ot_normal_rate" type="text" placeholder="OT 1.5" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->ot_normal_rate))?$edit_site->ot_normal_rate:set_value('ot_normal_rate');?>"/>
								</div>
								<div class="span3">OT 1.5(Spv)</div>
								<div class="span4 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span6" name="spv_ot_normal_rate" type="text" placeholder="OT 1.5" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->spv_ot_normal_rate))?$edit_site->spv_ot_normal_rate:set_value('spv_ot_normal_rate');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">OT 2.0</div>
								<div class="span3 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span8" name="ot_sunday_rate" type="text" placeholder="OT 2.0" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->ot_sunday_rate))?$edit_site->ot_sunday_rate:set_value('ot_sunday_rate');?>"/>
								</div>
								<div class="span3">OT 2.0(Spv)</div>
								<div class="span4 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span6" name="spv_ot_sunday_rate" type="text" placeholder="OT 2.0" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->spv_ot_sunday_rate))?$edit_site->spv_ot_sunday_rate:set_value('spv_ot_sunday_rate');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Spv. Payment</div>
								<div class="span4">
									<select class="selectpicker span8" name="spv_payment">
										<?php 
											if(isset($edit_site->spv_payment))
											{
												
										?>
												<option value="<?php echo $edit_site->spv_payment;?>"><?php echo $edit_site->spv_payment;?></option>
										<?php 
											}
											else
											{
										?>	
												<option value="">-Select-</option>
										<?php
											}
										?>
										<option value="Client" <?php echo set_select('spv_payment', 'Client'); ?>>Client</option>
										<option value="Company" <?php echo set_select('spv_payment', 'Company'); ?>>Company</option>
									</select>
								</div>
							</div>
						</div>
						<div class="span12" id="setting_unit">
							<div class="span12"><b><u>Site Setting</u></b></div>
							<div class="span12">
								<div class="span2">Rate</div>
								<div class="span4 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span6" name="unit_rate" type="text" placeholder="Unit Rate" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->unit_rate))?$edit_site->unit_rate:set_value('unit_rate');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">E%</div>
								<div class="span4 input-append">
									<input id="appendedInput" class="span6" name="e_percentage" type="text" placeholder="E %" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->e_percentage))?$edit_site->e_percentage:set_value('e_percentage');?>"/>
									<span class="add-on">%</span>
								</div>
							</div>
							<div class="span12">
								<div class="span2">D%</div>
								<div class="span4 input-append">	
									<input id="appendedInput" class="span6" name="d_percentage" type="text" placeholder="D %" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->d_percentage))?$edit_site->d_percentage:set_value('d_percentage');?>"/>
									<span class="add-on">%</span>
								</div>
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
			</form>
			<div class="separator"></div>
			<div class="widget-head"><h4 class="heading">Site List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th>Project</th>
							<th>Name</th>
							<th>Code</th>
							<th>Type</th>
							<th>Hr. Rate(Spv)/OT 1.5(Spv)/OT 2.0(Spv)</th>
							<th>Rate/E%/D%</th>
							<th>Status</th>
							<th>Description</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($site as $site_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td><?php echo $site_item['project_name']; ?></td>
									<td><?php echo $site_item['name']; ?></td>
									<td><?php echo $site_item['code']; ?></td>
									<td class="center"><?php echo $site_item['type']; ?></td>
									<td class="center">
										<?php echo number_format($site_item['hourly_rate'],2)."(".number_format($site_item['spv_hourly_rate'],2).")/".number_format($site_item['ot_normal_rate'],2)."(".number_format($site_item['spv_ot_normal_rate'],2).")/".number_format($site_item['ot_sunday_rate'],2)."(".number_format($site_item['spv_ot_sunday_rate'],2).")"; ?>
									</td>
									<td class="center"><?php echo number_format($site_item['unit_rate'],2)."/".number_format($site_item['e_percentage'],2)."/".number_format($site_item['d_percentage'],2);?></td>
									<td class="center"><?php echo $site_item['status']; ?></td>
									<td><?php echo $site_item['description']; ?></td>
									<td class="center actions">
										<?php echo anchor('site/management/'.$site_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('site/delete/'.$site_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this site data?')"));?>
									</td>
								</tr>
						<?php 
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
<script>
	$(document).ready(function(){
		site_setting();
	});

	function reload(){
		window.location.href = '<?PHP echo site_url("site/management"); ?>';
	}

	function site_setting()
	{
		var type=$("#type").val();

		switch(type)
		{
			case "Supply":  $("#setting_unit").hide();
						  	$("#setting_supply").show();
						  	break;
			case "Unit": 	$("#setting_unit").show();
						  	$("#setting_supply").hide();
						  	break;	
			case "Lumpsum": $("#setting_unit").show();
						  	$("#setting_supply").hide();
						  	break;	
			default : 		$("#setting_unit").hide();
				     		$("#setting_supply").show();
				     		break;		
		}
	}
</script>

<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
