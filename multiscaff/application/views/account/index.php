
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Account</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Account</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Account</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span8">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Name</div>
							<div class="span8">
								<input type="text" name="name" placeholder="Name" class="span8" maxlength="50" value="<?php echo (isset($edit_account->name))?$edit_account->name:set_value('name');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_account->id))?$edit_account->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">No.</div>
							<div class="span8">
								<input type="text" name="account_no" placeholder="Account No." class="span8" maxlength="50" value="<?php echo (isset($edit_account->account_no))?$edit_account->account_no:set_value('account_no');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Account</div>
							<div class="span6">
								<select class="selectpicker" name="type">
									<?php 
										if(isset($edit_account->type))
										{
											switch($edit_account->type)
											{
												case "CIH": $type="Cash in Hand"; break;
												case "CIB": $type="Cash in Bank"; break;
												default: $type="Cash in Hand"; break;
											}
									?>
											<option value="<?php echo $edit_account->type;?>"><?php echo $type;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">-Select-</option>
									<?php
										}
									?>
									<option value="CIH" <?php echo set_select('type', 'CIH'); ?>>Cash in Hand</option>
									<option value="CIB" <?php echo set_select('type', 'CIB'); ?>>Cash in Bank</option>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Description</div>
							<div class="span10">
								<input type="text" name="description" placeholder="Description" class="span12" value="<?php echo (isset($edit_account->description))?$edit_account->description:set_value('description');?>"/>
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
			<div class="widget-head"><h4 class="heading">Account List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th>Name</th>
							<th>Account No.</th>
							<th>Type</th>
							<th>Description</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($account as $account_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td><?php echo $account_item['name']; ?></td>
									<td><?php echo $account_item['account_no']; ?></td>
									<td>
										<?php 
											switch($account_item['type'])
											{
												case "CIH": $type_str="Cash in Hand"; break;
												case "CIB": $type_str="Cash in Bank"; break;
												default: $type_str="Cash in Hand"; break;
											}
											echo $type_str; 
										?>
									</td>
									<td><?php echo $account_item['description']; ?></td>
									<td class="center actions">
										<?php echo anchor('account/management/'.$account_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('account/delete/'.$account_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this account data?')"));?>
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
		window.location.href = '<?PHP echo site_url("account/management"); ?>';
	}
</script>

<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
