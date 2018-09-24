<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Transaction</li>
		<li class="divider"></li>
		<li>Daily (Unit)</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Transaction Unit</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<?php echo form_open($action)?>
				<div class="span8">
					<div class="row-fluid well">
						<div class="span12">
							<div class="separator"></div>
							<div class="span12">
								<div class="span2">Date</div>
								<div class="span8">
									<input type="text" name="date" id="transaction_date" class="input-mini" value="<?php echo date("m/d/Y");?>" style="width: 70px;" />
									&nbsp;&nbsp; 
									<input type="checkbox" name="ph" id="ph" value="1" style="vertical-align:top"><span style="vertical-align:top"> PH</span>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Site</div>
								<div class="span8">
									<select class="selectpicker span6" name="site" id="site">
										<?php 
											if(isset($edit_transaction_unit->site_id))
											{
												
										?>
												<option value="<?php echo $edit_transaction_unit->site_id;?>"><?php echo $edit_transaction_unit->name;?></option>
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
							<div class="span12">
								<div class="span2">Group</div>
								<div class="span8">
									<select class="selectpicker span6" name="group" id="group">
										<option value="">-Select-</option>
										<?php
											foreach ($group as $group_item){
												$group_name_arr=explode(" ",$group_item['name']);
												$group_name=$group_name_arr[1]." Group";
										?>
												<option value="<?php echo $group_item['nts'];?>" <?php echo set_select('group', $group_item['nts']); ?>><?php echo $group_name;?></option>
										<?php
											}
										?>
									</select>
									<input type="text" name="work_hour" id="work_hour" class="right" placeholder="Hour" style="width:70px" onkeypress="return isNumberKey(event)"/>
									<input type="text" name="ot_hour" id="ot_hour" class="right" placeholder="OT Hour" style="width:70px" onkeypress="return isNumberKey(event)"/>
									&nbsp;&nbsp; 
									<input type="checkbox" name="ns" id="ns" value="1" style="vertical-align:top"><span style="vertical-align:top"> NS</span>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Location</div>
								<div class="span8">
									<input type="text" name="location" placeholder="Location" class="span7" maxlength="32" value="<?php echo (isset($edit_site->location))?$edit_site->location:set_value('location');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Unit Amount</div>
								<div class="span8 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span6" name="amount" id="amount" type="text" placeholder="Unit Amount" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_site->amount))?$edit_site->amount:set_value('amount');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span12 center">
									<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
									<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="span12">
				<div class="separator"></div>
				<div class="widget-head"><h4 class="heading">Transaction Unit List</h4></div>
				<div class="separator"></div>
				<div class="widget-body">
					<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th width="10px">S/N</th>
								<th>Date</th>
								<th>Project</th>
								<th>Site</th>
								<th>Group</th>
								<th>Location</th>
								<th>Amount</th>
								<th width="60px">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=0;
								foreach ($transaction_unit as $transaction_unit_item){
									$i++;
							?>
									<tr class="gradeX">
										<td class="center"><?php echo $i; ?></td>
										<td><?php echo date('d M Y',strtotime($transaction_unit_item['date'])); ?></td>
										<td><?php echo $transaction_unit_item['project_name']; ?></td>
										<td><?php echo $transaction_unit_item['site_name']; ?></td>
										<td>
											<?php 
												$group_name_arr=explode(" ",$transaction_unit_item['group_name']);
												$group_name=$group_name_arr[1]." Group";
												echo $group_name; 
											?>
										</td>
										<td><?php echo $transaction_unit_item['location']; ?></td>
										<td class="right"><?php echo number_format($transaction_unit_item['amount'],2); ?></td>
										<td class="center actions">
											<?php echo anchor('transaction_unit/delete/'.$transaction_unit_item['id'].'/add', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this data?')"));?>
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
		window.location.href = '<?PHP echo site_url("transaction_unit/add"); ?>';
	}
	
	function validate()
	{
		var site=$("#site").val();
		var have_data=0;
		var get_nts="";
		var amount=$("#amount").val();
		
		if(site!="")
		{
			if(amount!="")
			{
				return true;
			}
			else
			{
				alert("Amount cannot be 0");
				return false;
			}
		}
		else
		{
			alert("Site cannot be empty..");
			return false;
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
