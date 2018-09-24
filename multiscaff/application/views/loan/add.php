<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
			
<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
  	width: 55%;
}

.ui-datepicker-trigger{
    top: -5px;
    position: relative;
}
</style>

<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Loan</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Loan</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Loan</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span5">
						<div class="separator" style="padding: 2px 0;"></div>
						<div class="span12"><b><u>Borrower Particular Detail</u></b></div>
						<div class="span12">
							<div class="span3">Code/NTS</div>
							<div class="span6">
								<input type="text" name="borrower_code" placeholder="Emp. Code/NTS No." class="span10" maxlength="32" value="<?php echo (isset($edit_loan->borrower_code))?$edit_loan->borrower_code:set_value('borrower_code');?>" tabindex="1"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Name</div>
							<div class="span8">
								<input type="text" name="borrower_name" placeholder="Name" class="span12" maxlength="150" value="<?php echo (isset($edit_loan->borrower_name))?$edit_loan->borrower_name:set_value('borrower_name');?>" tabindex="2"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_loan->id))?$edit_loan->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Description</div>
							<div class="span8">
								<input type="text" name="borrower_description" placeholder="Description" class="span12" maxlength="150" value="<?php echo (isset($edit_loan->borrower_description))?$edit_loan->borrower_description:set_value('borrower_description');?>" tabindex="6"/>
							</div>
						</div>
						<div class="span12" style="padding: 10px 0;"><b><u>Loan Particular Detail</u></b></div>
						<div class="span12">
							<div class="span3">Invoice No.</div>
							<div class="span6">
								<input type="text" name="loan_no" placeholder="Loan No." class="span12" maxlength="32" value="<?php echo (isset($edit_loan->loan_no))?$edit_loan->loan_no:set_value('loan_no');?>" tabindex="6"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Loan Date</div>
							<div class="span8">
								<input type="text" class="datetimepicker span6" name="date" placeholder="Loan Date" value="<?php echo (isset($edit_loan->date))?date('m/d/Y',strtotime($edit_loan->date)):set_value('date');?>"tabindex="7"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Loan Amount</div>
							<div class="span8">
								<div class="span10 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span6 right" name="amount" type="text" placeholder="Loan Amount" onkeypress="return isNumberKey(event)" maxlength="15" value="<?php echo (isset($edit_loan->amount))?$edit_loan->amount:set_value('amount');?>" tabindex="8"/>
								</div>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Remark</div>
							<div class="span8">
								<input type="text" name="remark" placeholder="Remark" class="span12" value="<?php echo (isset($edit_loan->remark))?$edit_loan->remark:set_value('remark');?>"tabindex="9"/>
							</div>
						</div>
					</div>
					<div class="span5">
						<div class="separator" style="height:14px;"></div>
						<div class="span12">
							<div class="span3">Contact</div>
							<div class="span8">
								<div class="span6"><input type="text" name="borrower_contact" placeholder="Local Contact No." class="span12" maxlength="20" value="<?php echo (isset($edit_loan->borrower_contact))?$edit_loan->borrower_contact:set_value('borrower_contact');?>" tabindex="3"></div>
								<div class="span6"><input type="text" name="borrower_hm_contact" placeholder="Hm Contact No." class="span12" maxlength="20" value="<?php echo (isset($edit_loan->borrower_hm_contact))?$edit_loan->borrower_hm_contact:set_value('borrower_hm_contact');?>" tabindex="4"/></div>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Address</div>
							<div class="span8">
								<input type="text" name="borrower_address" placeholder="Local Address" class="span12" maxlength="100" value="<?php echo (isset($edit_loan->borrower_address))?$edit_loan->borrower_address:set_value('borrower_address');?>" tabindex="5"/>
							</div>
						</div>	
						<div class="span12" style="padding: 10px 0;">&nbsp;</div>
						<div class="span12" style="padding: 10px 0;">&nbsp;</div>
						<div class="span12">
							<div class="span3">Account</div>
							<div class="span8">
								<select class="selectpicker" data-live-search="true" name="account_id" id="account_id" tabindex="10">
									<?php 
										if(isset($edit_loan->account_id))
										{
											if($edit_loan->account_no!="")
											{
												$str_account_no="-".$edit_loan->account_no;
											}
											else
											{
												$str_account_no="";
											}
									?>
											<option value="<?php echo $edit_loan->account_id;?>"><?php echo $edit_loan->account_name.$str_account_no;?></option>
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
										foreach ($account as $account_item){
											if($account_item['account_no']!="")
											{
												$str_account_no="-".$account_item['account_no'];
											}
											else
											{
												$str_account_no="";
											}
									?>
											<option value="<?php echo $account_item['id'];?>" <?php echo set_select('account_id', $account_item['id']); ?>><?php echo $account_item['name'].$str_account_no;?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>	
						<div class="span12">
							<div class="span3">Term</div>
							<div class="span8">
								<select class="selectpicker" data-live-search="true" data-size='7' name="term" id="term" tabindex="11">
									<?php 
										if(isset($edit_loan->term))
										{
									?>
											<option value="<?php echo $edit_loan->term;?>"><?php echo $edit_loan->term;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="Open">Open</option>
									<?php
										}
									?>
									<?php
										for($i=1; $i<=12; $i++)
										{
									?>
											<option value="<?php echo $i;?>" <?php echo set_select('term', $i); ?>><?php echo $i;?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Package</div>
							<div class="span8">
								<select class="selectpicker" data-live-search="true" name="package" id="package" tabindex="12">
									<?php 
										if(isset($edit_loan->package))
										{
									?>
											<option value="<?php echo $edit_loan->package;?>"><?php echo $edit_loan->package;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="Free" <?php echo set_select('package', "Free"); ?>>Free</option>
									<?php
										}
									?>
									<option value="Monthly" <?php echo set_select('package', "Monthly"); ?>>Monthly</option>
									<option value="B/Weekly" <?php echo set_select('package', "B/Weekly"); ?>>B/Weekly</option>
									<option value="Weekly" <?php echo set_select('package', "Weekly"); ?>>Weekly</option>
								</select>
							</div>
						</div>	
					</div>
					<div class="span10">	
						<hr class="separator" />
					</div>
					<div class="span12">
						<div class="span10 center">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" tabindex="13"><i></i>Save</button>
							<?php 
								if($edit_id=='0')
								{
							?>
									<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
							<?php 
								}
								else
								{
							?>
									<button class="btn btn-icon btn-default glyphicons refresh"><i></i>Cancel</button>
							<?php
								}
							?>
						</div>
					</div>
				</div>
			</form>
			<div class="separator"></div>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("loan/add"); ?>';
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
