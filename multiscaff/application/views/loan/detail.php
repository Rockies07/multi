<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />

<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
  	width: 100%;
}

a{
	color:#484c50;
}

.control-label{
	font-weight: bold;
}

.modal-title{
	padding-top: 5px;
	height: 35px;
}

.modal-header{
	background-color: #EEE;
}


.ui-datepicker-trigger{
    top: -5px;
    position: relative;
}

input.hidden_text{
	border:none;
}

input[readonly]{
	background: transparent;
	cursor: auto;
}

.modal-title{
	padding-top: 5px;
	height: 35px;
}

.modal-header{
	background-color: #EEE;
}
</style>

<div id="content">
	<div class="se-pre-con"></div>
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Transaction</li>
		<li class="divider"></li>
		<li>Loan</li>
		<li class="divider"></li>
		<li>Loan Detail</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Loan Detail</h4>
			</div>
			<div class="separator"></div>
			<div class="row-fluid well">
				<div class="span12">
					<div class="span4" style="margin-left:0px;">
						<div class="separator" style="padding: 2px 0;"></div>
						<div class="span12"><b><u>Borrower Particular</u></b></div>
						<div class="span12">
							<div class="span4">Code/NTS</div>
							<div class="span8">: 
								<?php echo $loan->borrower_code;?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Name</div>
							<div class="span8">: <?php echo $loan->borrower_name;?></div>
						</div>
						<div class="span12">
							<div class="span4">Local Contact</div>
							<div class="span8">: 
								<?php 
									echo $loan->borrower_contact;
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Hm Contact</div>
							<div class="span8">: 
								<?php 
									if($loan->borrower_hm_contact!="")
									{
										$hm_contact=$loan->borrower_hm_contact;
									}
									else
									{
										$hm_contact="-";
									}

									echo $hm_contact;
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Address</div>
							<div class="span8">: <?php echo $loan->borrower_address;?></div>
						</div>
						<div class="span12">
							<div class="span4">Description</div>
							<div class="span8">: <?php echo $loan->borrower_description;?></div>
						</div>
					</div>
					<div class="span4" style="margin-left:0px;">
						<div class="span12" style="padding:2px 0;"><b><u>Loan Particular</u></b></div>
						<div class="span12">
							<div class="span4">Invoice No.</div>
							<div class="span8">: <?php echo $loan->loan_no;?></div>
						</div>
						<div class="span12">
							<div class="span4">Loan Date</div>
							<div class="span8">: 
								<?php 
									if($loan->date!="0000-00-00" && $loan->date!="")
									{
										echo date('d-M-Y',strtotime($loan->date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Loan Amount</div>
							<div class="span8">: 
								<?php echo number_format($loan->amount,2);?>
								<input type="hidden" name="amount" value="<?php echo $loan->amount;?>">
							</div>
						</div>
						<div class="span12">
							<div class="span4">Account</div>
							<div class="span8">: 
								<?php 
									if($loan->account_no!="")
									{
										$account_no=" - ".$loan->account_no;
									}
									else
									{
										$account_no="";
									}

									echo $loan->account_name.$account_no;
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Term - Package</div>
							<div class="span8">: 
								<?php 
									echo $loan->term." - ".$loan->package;
								?>
								<input type="hidden" name="term" value="<?php echo $loan->term;?>">
								<input type="hidden" name="package" value="<?php echo $loan->package;?>">
							</div>
						</div>
						<div class="span12">
							<div class="span4">Remark</div>
							<div class="span8">: 
								<?php 
									echo $loan->remark;
								?>
							</div>
						</div>
					</div>
					<div class="span4" style="margin-left:0px;">
						<div class="span12">
							<div class="span10 center">
								<?php echo anchor('loan/add/'.$loan->id, '<i></i>',array('class' => 'btn btn-action glyphicons pencil btn-success'));?>
								<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Back to Loan List</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12" style="margin-left:0px;">
					<div class="separator"></div>
					<table class="table table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th width="10px" class="center">S/N</th>
								<th width="120px" class="center">Date</th>
								<th width="180px"class="center">Account</th>
								<th width="120px" class="center">Total Payment</th>
								<th width="80px" class="center">Principal</th>
								<th width="80px" class="center">Other Fee</th>
								<th width="120px" class="center">Receipt</th>
								<th width="80px" class="center">Balance</th>
								<th class="center">Remark</th>
								<th class="center" width="100px">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=0;
								$balance=$loan->balance;
								foreach ($repayment as $repayment_item)
								{
									$i++;
									$principal=$repayment_item['principal'];
									$other_fee=$repayment_item['other_fee'];
									$total_amount=$principal+$other_fee;
									$status=$repayment_item['status'];
									$balance=$balance-$repayment_item['principal'];

									$balance=abs($balance);
									$account_name=$repayment_item['account_name'];
									if($repayment_item['account_no']!="")
									{
										$account_no=" - ".$loan->account_no;
									}
									else
									{
										$account_no="";
									}

									if($status=='1')
									{
							?>
										<tr class="gradeX">
											<td class="center"><?php echo $i; ?></td>
											<td><?php echo date('d-M-Y',strtotime($repayment_item['repayment_date'])); ?></td>
											<td><?php echo $account_name.$account_no; ?></td>
											<td class="right"><?php echo number_format($total_amount,2); ?></td>
											<td class="right"><?php echo number_format($principal,2); ?></td>
											<td class="right"><?php echo number_format($other_fee,2); ?></td>
											<td class="right"><?php echo $repayment_item['receipt']; ?></td>
											<td class="right"><?php echo number_format($balance,2); ?></td>
											<td><?php echo $repayment_item['remark']; ?></td>
											<td class="center actions">
												<a data-id="<?php echo $repayment_item['id'];?>" data-loanid="<?php echo $repayment_item['loan_id'];?>" data-principal="<?php echo $repayment_item['principal'];?>" data-otherfee="<?php echo $repayment_item['other_fee'];?>" data-date="<?php echo $repayment_item['repayment_date'];?>" data-accountid="<?php echo $repayment_item['account_id'];?>" data-accountname="<?php echo $repayment_item['accountname'];?>" data-receipt="<?php echo $repayment_item['receipt'];?>" data-remark="<?php echo $repayment_item['remark'];?>" title="Edit" class="open-editRepaymentModal btn-action glyphicons pencil btn-success normal_session" href="#editRepaymentModal"><i></i></a>
												<?php echo anchor('loan/delete_repayment/'.$repayment_item['id'].'/'.$loan->id, '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this payment?')"));?>
											</td>
										</tr>
							<?php 
									}
									else
									{
										$account_name=$loan->account_name;
										if($loan->account_no!="")
										{
											$account_no=" - ".$loan->account_no;
										}
										else
										{
											$account_no="";
										}
							?>
										<?php echo form_open($action)?>
											<tr class="gradeX">
												<td class="center"><?php echo $i; ?></td>
												<td class="center">
													<input type="text" class="datetimepicker span9" name="repayment_date" placeholder="Date" value="<?php echo date('m/d/Y');?>"/>
													<input type="hidden" name="repayment_id" placeholder="Repayment ID" value="<?php echo $repayment_item['id'];?>"/>
												</td>
												<td>
													<select class="selectpicker" data-live-search="true" name="account_id" id="account_id">
														<option value="<?php echo $repayment_item['account_id'];?>"><?php 
																if($repayment_item['account_no']!="")
																{
																	$str_account_no="-".$repayment_item['account_no'];
																}
																else
																{
																	$str_account_no="";
																}
																echo $repayment_item['account_name'].$str_account_no;
															?>
														</option>
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
												</td>
												<td class="center"><input type="text" class="hidden_text span12 right" name="total_amount" id="total_amount" placeholder="Total" readonly value="<?php echo number_format($total_amount,2);?>"/></td>
												<td class="center"><input type="text" class="span12 right" name="principal" id="principal" placeholder="Principal" value="<?php echo $principal;?>" onKeyUp="get_total_amount();get_last_balance(<?php echo $balance+$principal;?>);"/>
												</td>
												<td class="center"><input type="text" class="span12 right" name="other_fee" id="other_fee" placeholder="Other Fee" value="<?php echo $other_fee;?>" onKeyUp="get_total_amount()"/>
												</td>
												<td class="center"><input type="text" class="span12" id="receipt" name="receipt" placeholder="Receipt No." value="<?php echo $repayment_item['receipt'];?>"/></td>
												<td class="center">
													<input type="text" class="hidden_text span12 right" id="balance" name="balance" placeholder="Balance" readonly value="<?php echo number_format($balance,2);?>"/>
												</td>
												<td class="center">
													<input type="text" class="span12" name="remark" id="remark" placeholder="Remark"/>
												</td>
												<td class="center actions">
													<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" style="top: -5px; left: -4px; position: relative;" onclick="return validate_repayment();"><i></i>Submit</button>
												</td>
											</tr>
										</form>
							<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editRepaymentModal" tabindex="-1" role="dialog" aria-labelledby="editRepaymentModalLabel" aria-hidden="true" style="display:none;">
	 	<div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="editRepaymentModalLabel">Update Repayment</h4>
		      	</div>
		     	<div class="modal-body">
			        <form>
		            	<input type="hidden" class="form-control" name="edit_id" id="edit_id">
		            	<input type="hidden" class="form-control" name="edit_loanid" id="edit_loanid">
			          	<div class="form-group">
			            	<label for="edit_date" class="control-label">Date:</label>
			            	<input type="text" class="form-control datetimepicker" name="edit_date" id="edit_date" style="width:80px">
			          	</div>
			          	<div class="form-group">
			            	<label for="edit_account" class="control-label">Account ID</label>
							<select class="form-control" name="edit_account" id="edit_account">
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
			          	<div class="form-group">
			            	<label for="edit_principal" class="control-label">Principal</label>
			            	<input type="text" class="form-control" name="edit_principal" id="edit_principal" style="text-align:right; width:80px">
			          	</div>
			          	<div class="form-group">
			            	<label for="edit_other_fee" class="control-label">Other Fee</label>
			            	<input type="text" class="form-control" name="edit_other_fee" id="edit_other_fee" style="text-align:right; width:80px">
			          	</div>	
			          	<div class="form-group">
			            	<label for="edit_receipt" class="control-label">Receipt</label>
			            	<input type="text" class="form-control" name="edit_receipt" id="edit_receipt" style=" width:120px">
			          	</div>
			          	<div class="form-group">
			            	<label for="edit_remark" class="control-label">Remark</label>
			            	<input type="text" class="form-control" name="edit_remark" id="edit_remark" style="width:98%">
			          	</div>
			        </form>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-primary" onclick="update_repayment();">Submit</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      	</div>
		    </div>
		</div>
	</div>
	
<script>
	function get_last_balance(balance)
	{
		var principal_last=$("#principal").val();

		var value=(balance-principal_last).toFixed(2);

		$("#balance").val(value);
	}

	function reload(){
		window.location.href = '<?PHP echo site_url("loan/add"); ?>';
	}

	function validate_repayment()
	{
		var balance=$("#balance").val();

		if(balance<0)
		{
			alert('Balance cannot be less than 0');
			$("#principal").focus();
			return false;
		}
		else
		{
			return true;
		}
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

	$(document).on("click", ".open-editRepaymentModal", function (e) {

	    e.preventDefault();

	    var _self = $(this);

	    var id = _self.data('id');
		var principal = _self.data('principal');
		var other_fee = _self.data('otherfee');
		var remark = _self.data('remark');
		var account = _self.data('accountid');
		var receipt = _self.data('receipt');
		var loanid = _self.data('loanid');

	    var date_arr = _self.data('date').split("-");
		var date=date_arr[1]+"/"+date_arr[2]+"/"+date_arr[0];

	    $("#edit_id").val(id);
	    $("#edit_date").val(date);
	    $("#edit_principal").val(principal);
	    $("#edit_other_fee").val(other_fee);
	    $("#edit_remark").val(remark);
	    $("#edit_loanid").val(loanid);
	    $("#edit_receipt").val(receipt);
	    $('select[name=edit_account]').val(account);

	    $(_self.attr('href')).modal('show');
	});

	function update_repayment()
	{
		var id=$("#edit_id").val();
		
		if($("#edit_date").val()!="")
		{
			var principal=$("#edit_principal").val();
			var other_fee=$("#edit_other_fee").val();
			var remark=$("#edit_remark").val();
		    remark = remark.replace("/", "xyz");
			var loanid=$("#edit_loanid").val();
			var account=$("#edit_account").val();
			var receipt=$("#edit_receipt").val();

			var date_arr="";
			date_arr=$("#edit_date").val().split("/");
			var date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var string_data=id+"---"+date+"---"+principal+"---"+other_fee+"---"+account+"---"+receipt+"---"+remark;

		    $.ajax(
			{
				url: "<?php echo site_url('utility/update_repayment/"+string_data+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					alert("Data Updated");
					window.location.href = '<?PHP echo site_url("loan/detail/'+loanid+'"); ?>';
				},
				error:function(data){
					alert("Error when Saving");
				}
			});
		}
		else
		{
			alert("Repayment Date cannot be Empty");
		}
	}

	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});

	function get_total_amount()
	{
		if($("#principal").val()!="")
		{
			var principal=parseFloat($("#principal").val());
		}
		else
		{
			var principal=parseFloat(0);
		}
			
		if($("#other_fee").val()!="")
		{
			var other_fee=parseFloat($("#other_fee").val());
		}
		else
		{
			var other_fee=parseFloat(0);
		}

		var total=principal+other_fee;

		$("#total_amount").val(total.toFixed(2));
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
