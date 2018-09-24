
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Ledger</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Ledger</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Ledger</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span8">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Header</div>
							<div class="span6">
								<select class="selectpicker" name="header" data-live-search="true">
									<?php 
										if(isset($edit_ledger->header))
										{
									?>
											<option value="<?php echo $edit_ledger->header;?>"><?php echo $edit_ledger->header;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">-Select-</option>
									<?php
										}
									?>
									<option value="Assets" <?php echo set_select('header', 'Assets'); ?>>Assets</option>
									<option value="Expenses" <?php echo set_select('header', 'Expenses'); ?>>Expenses</option>
									<option value="Other Income" <?php echo set_select('header', 'Other Income'); ?>>Other Income</option>
									<option value="Liability" <?php echo set_select('header', 'Liability'); ?>>Liability</option>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Code</div>
							<div class="span8">
								<input type="text" name="code" placeholder="Code" class="span8" maxlength="32" value="<?php echo (isset($edit_ledger->code))?$edit_ledger->code:set_value('code');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_ledger->id))?$edit_ledger->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Ledger</div>
							<div class="span8">
								<input type="text" name="ledger" placeholder="Ledger" class="span8" maxlength="100" value="<?php echo (isset($edit_ledger->ledger))?$edit_ledger->ledger:set_value('ledger');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Type</div>
							<div class="span8">
								<select class="selectpicker" name="type">
									<?php 
										if(isset($edit_ledger->type))
										{
									?>
											<option value="<?php echo $edit_ledger->type;?>"><?php echo $edit_ledger->type;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="Other">Other</option>
									<?php
										}
									?>
									<option value="Levy" <?php echo set_select('type', 'Levy'); ?>>Levy</option>
									<option value="Dormitory" <?php echo set_select('type', 'Dormitory'); ?>>Dormitory</option>
									<option value="Operation" <?php echo set_select('type', 'Operation'); ?>>Operation</option>
									<option value="Administration" <?php echo set_select('type', 'Administration'); ?>>Administration</option>
									<option value="Transportation" <?php echo set_select('type', 'Transportation'); ?>>Transportation</option>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Description</div>
							<div class="span10">
								<input type="text" name="description" placeholder="Description" class="span12" value="<?php echo (isset($edit_ledger->description))?$edit_ledger->description:set_value('description');?>"/>
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
			<div class="widget-head"><h4 class="heading">Ledger List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th>Code</th>
							<th>Header</th>
							<th>Ledger</th>
							<th>Type</th>
							<th>Description</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($ledger as $ledger_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td><?php echo $ledger_item['code']; ?></td>
									<td><?php echo $ledger_item['header']; ?></td>
									<td><?php echo $ledger_item['ledger']; ?></td>
									<td><?php echo $ledger_item['type']; ?></td>
									<td><?php echo $ledger_item['description']; ?></td>
									<td class="center actions" style="padding-left: 2px;">
										<?php echo anchor('ledger/management/'.$ledger_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('ledger/delete/'.$ledger_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this ledger data?')"));?>
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
		window.location.href = '<?PHP echo site_url("ledger/management"); ?>';
	}
</script>

<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
