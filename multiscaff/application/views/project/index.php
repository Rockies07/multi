<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
			
<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
  	width: 98%;
}
</style>

<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Project</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Project</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Project</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span8">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Business</div>
							<div class="span6">
								<select class="selectpicker span10" name="business" data-live-search="true" data-size="10">
									<?php 
										if(isset($edit_project->business_id))
										{
											
									?>
											<option value="<?php echo $edit_project->business_id;?>"><?php echo $edit_project_business->name;?></option>
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
										foreach ($business as $business_item){
									?>
											<option value="<?php echo $business_item['id'];?>" <?php echo set_select('business', $business_item['id']); ?>><?php echo $business_item['name'];?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Client</div>
							<div class="span6">
								<select class="selectpicker span12" name="client" data-live-search="true" data-size="10">
									<?php 
										if(isset($edit_project->client_id))
										{
											
									?>
											<option value="<?php echo $edit_project->client_id;?>"><?php echo $edit_project_client->name;?></option>
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
										foreach ($client as $client_item){
									?>
											<option value="<?php echo $client_item['id'];?>" <?php echo set_select('client', $client_item['id']); ?>><?php echo $client_item['name'];?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Name</div>
							<div class="span8">
								<input type="text" name="name" placeholder="Name" class="span12" maxlength="100" value="<?php echo (isset($edit_project->name))?$edit_project->name:set_value('name');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_project->id))?$edit_project->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Deadline</div>
							<div class="span8">
								<input type="text" name="deadline" placeholder="Deadline" class="span4 datetimepicker" maxlength="100" value="<?php echo (isset($edit_project->deadline))?$edit_project->deadline:set_value('deadline');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Contract Value</div>
							<div class="span8">
								<div class="span6 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span6 right" name="contract_value" type="text" placeholder="Contract Value" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_project->contract_value))?$edit_project->contract_value:set_value('contract_value');?>"/>
								</div>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Description</div>
							<div class="span10">
								<input type="text" name="description" placeholder="Description" class="span12" value="<?php echo (isset($edit_project->description))?$edit_project->description:set_value('description');?>"/>
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
			<div class="widget-head"><h4 class="heading">Project List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th>Business</th>
							<th>Client</th>
							<th>Name</th>
							<th class="center" width="80px">Deadline</th>
							<th class="center" width="80px">Value</th>
							<th>Description</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($project as $project_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td><?php echo $project_item['business_name']; ?></td>
									<td><?php echo $project_item['client_name']; ?></td>
									<td><?php echo $project_item['name']; ?></td>
									<td class="center"><?php echo date('d-M-Y',strtotime($project_item['deadline'])); ?></td>
									<td class="right"><?php echo number_format($project_item['contract_value'],2); ?></td>
									<td><?php echo $project_item['description']; ?></td>
									<td class="center actions">
										<?php echo anchor('project/management/'.$project_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('project/delete/'.$project_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this project data?')"));?>
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
	function reload(){
		window.location.href = '<?PHP echo site_url("project/management"); ?>';
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
</script>

<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
