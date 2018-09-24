<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<style>
	.ui-autocomplete { max-height: 300px; overflow-y: auto; overflow-x: hidden;}
</style>	
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Journal</li>
		<li class="divider"></li>
		<li>Expenses</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Expenses</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<?php echo form_open($action)?>
				<div class="span6">
					<div class="row-fluid well">
						<div class="separator"></div>
						<div class="span12">
							<div class="span1">Site</div>
							<div class="span6">
								<select class="selectpicker span12" name="site" id="site" data-live-search="true">
									<?php 
										if(isset($edit_transaction_journal->site_id))
										{
											
									?>
											<option value="<?php echo $edit_transaction_journal->site_id;?>"><?php echo $edit_transaction_journal->name;?></option>
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
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_transaction_journal->id))?$edit_transaction_journal->id:'0';?>"/>
							</div>
							<div class="span5">
								<div class="span12 center">
									<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" onclick="return validate();"><i></i>Save</button>
									<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="span12">
					<div class="widget-body">
						<table class="table table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" width="20px">S/N</th>
									<th>Date</th>
									<th>Amount</th>
									<th>Payer/Payee</th>
									<th>Account</th>
									<th>Cheque No.</th>
									<th>Ledger</th>
									<th>GST</th>
									<th>Description</th>
								</tr>
							</thead>
							<tbody>
								<?php
									for($i=1;$i<=30;$i++)
									{
								?>
										<tr>
											<td class="center" style="vertical-align:middle">
												<?php echo $i;?>
											</td>
											<td class="center" style="vertical-align:middle">
												<input type="text" name="date_<?php echo $i;?>" id="date_<?php echo $i;?>" class="input-mini datepicker" value="<?php echo date("m/d/Y");?>" style="width: 70px;" />
											</td>
											<td style="vertical-align:middle" class="center">
												<input type="text" name="amount_<?php echo $i;?>" id="amount_<?php echo $i;?>" class="right" placeholder="Amount" maxlength="15" onkeypress="return isNumberKey(event)" style="width: 100px;"/>
											</td>
											<td style="vertical-align:middle" class="center">
												<input type="text" name="payer_payee_<?php echo $i;?>" id="payer_payee_<?php echo $i;?>" placeholder="Payer/Payee" maxlength="100"/>
											</td>
											<td style="vertical-align:middle">
												<select class="selectpicker" name="account_<?php echo $i;?>" id="account_<?php echo $i;?>" data-live-search="true">
													<option value="">-Select-</option>
													<?php
														foreach ($account as $account_item){
													?>
															<option value="<?php echo $account_item['id'];?>"><?php echo $account_item['name']."-".$account_item['account_no'];?></option>
													<?php
														}
													?>
												</select>
											</td>
											<td style="vertical-align:middle" class="center">
												<input type="text" name="cheque_<?php echo $i;?>" id="cheque_<?php echo $i;?>" placeholder="Cheque" maxlength="32" style="width: 120px;"/>
											</td>
											<td style="vertical-align:middle">
												<select class="selectpicker" name="ledger_<?php echo $i;?>" id="ledger_<?php echo $i;?>" data-live-search="true">
													<option value="">-Select-</option>
													<?php
														foreach ($ledger as $ledger_item){
													?>
															<option value="<?php echo $ledger_item['id'];?>"><?php echo $ledger_item['ledger'];?></option>
													<?php
														}
													?>
												</select>
											</td>
											<td class="center" style="vertical-align:middle" >
												<input type="checkbox" name="gst_<?php echo $i;?>" id="gst_<?php echo $i;?>" value="1">
											</td>
											<td class="center" style="vertical-align:middle" >
												<input type="text" name="description_<?php echo $i;?>" id="description_<?php echo $i;?>" placeholder="Description">
											</td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
					<div class="span12">
						<div class="span10 center">
							<div class="separator"></div>
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" onclick="return validate();"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
				</div>
			
			</form>
		</div>
	</div>
	
<script type="text/javascript">
	$(function() {
		$(".datepicker").datepicker({
			showOn: 'both', 
			buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
			buttonImageOnly: true,
			changeMonth: true,
	      	changeYear: true
		});
	});

	function reload(){
		window.location.href = '<?PHP echo site_url("transaction_journal/add_expenses"); ?>';
	}
	
	function validate()
	{
		var site=$("#site").val();
		var have_data=0;
		var get_amount="";
		var get_account="";
		var get_ledger="";

		if(site!="")
		{
			for(var i=1;i<=30;i++)
			{
				get_amount=$("#amount_"+i).val();
				get_ledger=$("#ledger_"+i).val();
				get_account=$("#account_"+i).val();
				
				if(get_amount>0 && get_ledger!="" && get_account!="")
				{
					have_data++;
				}
			}

			if(have_data>=1)
			{
				return true;
			}
			else
			{
				alert("No Expenses Data Inserted. Amount, Account and Ledger cannot be blank..");
				return false;
			}
		}
		else
		{
			alert("Site cannot be blank..");
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
