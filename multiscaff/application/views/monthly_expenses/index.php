
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Transaction</li>
		<li class="divider"></li>
		<li>Monthly Expenses</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Monthly Expenses</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Monthly Expenses</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span4">
						<div class="separator"></div>
						<div class="span12">
							<div class="span4">Month</div>
							<div class="span8">
								<select class="selectpicker span8" name="month" data-live-search="true">
									<?php 
										if(isset($edit_monthly_expenses->month))
										{
											
									?>
											<option value="<?php echo $edit_monthly_expenses->month;?>"><?php echo date('F',mktime(0, 0, 0, $edit_monthly_expenses->month+1, 0, 0));?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="<?php echo date('m');?>"><?php echo date('F');?></option>
									<?php
										}
									?>
									<?php
										for($x=1;$x<=12;$x++)
										{
											if(strlen($x)==1)
											{
												$x="0".$x;
											}
									?>
											<option value="<?php echo $x;?>" <?php echo set_select('month', mktime(0, 0, 0, $x, 0, 0)); ?>><?php echo date('F',mktime(0, 0, 0, $x+1, 0, 0));?></option>
									<?php
										}
									?>
								</select>
								<input class="span3" name="year" type="text" placeholder="Year" onkeypress="return isNumberKey(event)" maxlength="4" value="<?php echo (isset($edit_monthly_expenses->year))?$edit_monthly_expenses->year:date('Y');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Levy</div>
							<div class="span8 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="levy" type="text" placeholder="Levy" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_monthly_expenses->levy))?$edit_monthly_expenses->levy:set_value('levy');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_monthly_expenses->id))?$edit_monthly_expenses->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Dormitory</div>
							<div class="span8 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="dormitory" type="text" placeholder="Dormitory" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_monthly_expenses->dormitory))?$edit_monthly_expenses->dormitory:set_value('dormitory');?>"/>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span3">Transportation</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="transportation" type="text" placeholder="Transportation" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_monthly_expenses->transportation))?$edit_monthly_expenses->transportation:set_value('transportation');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Administration</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="administration" type="text" placeholder="Administration" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_monthly_expenses->administration))?$edit_monthly_expenses->administration:set_value('administration');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Operation</div>
							<div class="span6 input-prepend">
								<span class="add-on">$</span>
								<input id="prependedInput" class="span6" name="operation" type="text" placeholder="Operation" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_monthly_expenses->operation))?$edit_monthly_expenses->operation:set_value('operation');?>"/>
							</div>
						</div>
					</div>
					<div class="span8">	
						<hr class="separator" />
					</div>
					<div class="span8">
						<div class="span10 center">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
				</div>
			</form>
			<div class="separator"></div>
			<div class="widget-head"><h4 class="heading">Monthly Expenses List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th>Month</th>
							<th>Year</th>
							<th>Levy</th>
							<th>Dormitory</th>
							<th>Transportation</th>
							<th>Administration</th>
							<th>Operation</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($monthly_expenses as $monthly_expenses_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td class="center"><?php echo date("F",mktime(0, 0, 0, $monthly_expenses_item['month']+1, 0, 0)); ?></td>
									<td class="right"><?php echo $monthly_expenses_item['year']; ?></td>
									<td class="right"><?php echo number_format($monthly_expenses_item['levy'],2); ?></td>
									<td class="right"><?php echo number_format($monthly_expenses_item['dormitory'],2); ?></td>
									<td class="right"><?php echo number_format($monthly_expenses_item['transportation'],2); ?></td>
									<td class="right"><?php echo number_format($monthly_expenses_item['administration'],2); ?></td>
									<td class="right"><?php echo number_format($monthly_expenses_item['operation'],2); ?></td>
									<td class="center actions">
										<?php echo anchor('monthly_expenses/management/'.$monthly_expenses_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('monthly_expenses/delete/'.$monthly_expenses_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this Monthly Expenses data?')"));?>
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
		window.location.href = '<?PHP echo site_url("monthly_expenses/management"); ?>';
	}
</script>

<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
