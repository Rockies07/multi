<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Holiday Preset</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Holiday Preset</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Holiday</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span8">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Date</div>
							<div class="span6">
								<input type="text" name="date" id="date" class="input-mini" value="<?php echo (isset($edit_day_preset->date))?date('m/d/Y',strtotime($edit_day_preset->date)):date("m/d/Y");?>" style="width: 70px;" />
							</div>
							<input type="hidden" name="edit_id" value="<?php echo (isset($edit_day_preset->id))?$edit_day_preset->id:'0';?>"/>
						</div>
						<div class="span12">
							<div class="span2">Description</div>
							<div class="span10">
								<input type="text" name="description" placeholder="Description" class="span12" value="<?php echo (isset($edit_day_preset->description))?$edit_day_preset->description:set_value('description');?>"/>
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
			<div class="widget-head"><h4 class="heading">Holiday List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th width="120px" class="center">Date</th>
							<th>Description</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($day_preset as $day_preset_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td class="center"><?php echo date('d-M-Y',strtotime($day_preset_item['date'])); ?></td>
									<td><?php echo $day_preset_item['description']; ?></td>
									<td class="center actions">
										<?php echo anchor('day_preset/management/'.$day_preset_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('day_preset/delete/'.$day_preset_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this day_preset data?')"));?>
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
	$(function() {
		$("#date").datepicker({
		showOn: 'both', 
		buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
		buttonImageOnly: true,
		changeMonth: true,
      	changeYear: true
		});
	});

	function reload(){
		window.location.href = '<?PHP echo site_url("day_preset/management"); ?>';
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
