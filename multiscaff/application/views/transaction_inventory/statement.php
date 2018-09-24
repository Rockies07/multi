<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />

<style>
input.edit_text{
	border:none;
}
input.hidden_text{
	border:none;
}
input[readonly]{
	background: transparent;
	cursor: auto;
}
.hidden_element{
	display:none;
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
</style>

<div id="content">
	<div class="se-pre-con"></div>
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Journal Statement</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Journal Statement</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="filter-bar">
				<?php echo form_open($action)?>
					<div class="lbl glyphicons cogwheel"><i></i>Filter</div>
					<div>
						<label>From:</label>
						<div>
							<input type="text" name="date_from" id="date_from" class="input-mini datetimepicker" value="<?php if($filter_date_from=="") echo date("m/d/Y"); else echo $filter_date_from;?>" style="width: 70px;" />
						</div>
					</div>
					<div>
						<label>To:</label>
						<div>
							<input type="text" name="date_to" id="date_to" class="input-mini datetimepicker" value="<?php if($filter_date_to=="") echo date("m/d/Y"); else echo $filter_date_to;?>" style="width: 70px;" />
						</div>
					</div>
					<div>
						<label>Project:</label>
						<div>
							<select name="project" id="project" onchange="init_filter_site();">
								<?php 
									if($filter_project!="")
									{
										
								?>
										<option value="<?php echo $filter_project;?>"><?php echo $filter_project_name;?></option>
								<?php 
									}
									else
									{
								?>	
										<option value="">-Select All-</option>
								<?php
									}
								?>	
									<option value="">-Select All-</option>
								<?php
									foreach ($project as $project_item){
								?>
										<option value="<?php echo $project_item['id'];?>" <?php echo set_select('site', $project_item['id']); ?>><?php echo $project_item['name'];?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					<div>
						<label>Site:</label>
						<div>
							<select name="site" id="site">
								<?php 
									if($filter_site!="0")
									{
										
								?>
										<option value="<?php echo $filter_site;?>"><?php echo $filter_site_name;?></option>
								<?php 
									}
									else
									{
								?>	
										<option value="0">-Select All-</option>
								<?php
									}
								?>	
									<option value="0">-Select All-</option>
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
					<div>
						<button type="submit" class="btn btn-icon btn-primary glyphicons search"><i></i>Search</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
			<div>
				<?php echo form_open($action)?>
					<div class="widget-body">
						<table class="table table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle" width="20px">S/N</th>
									<!--<th width="100px">Project</th>-->
									<th style="vertical-align:middle; width:120px">Date</th>
									<th style="vertical-align:middle">Site</th>
									<th style="vertical-align:middle">Amount</th>
									<th style="vertical-align:middle">Payer/Payee</th>
									<th style="vertical-align:middle">Account</th>
									<th style="vertical-align:middle">Cheque No.</th>
									<th style="vertical-align:middle">Ledger</th>
									<th style="vertical-align:middle">GST</th>
									<th style="vertical-align:middle">Description</th>
									<th style="vertical-align:middle">Type</th>
									<th style="vertical-align:middle">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(($transaction_journal))
									{
										$i=0;
										foreach($transaction_journal as $transaction_journal_item)
										{
											$i++;
								?>
											<tr class="gradeX">
												<td class="center" style="vertical-align:middle">
													<?php
														if($edit_id!=$transaction_journal_item["id"])
														{ 
															echo $i;
														}
														else
														{
														?>
														<?php
															echo "-".anchor('transaction_journal/management', '<i></i>',array('class' => 'btn-action glyphicons repeat btn-danger'));
														}
													?>
												</td>
												<td style="vertical-align:middle">
													<?php echo date("d-M-Y",strtotime($transaction_journal_item["date"]));?>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_journal_item["site_name"];?>
												</td>
												<td class="right" style="vertical-align:middle">
													<?php echo $transaction_journal_item["amount"];?>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_journal_item["payer_payee"];?>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_journal_item["account_name"]."-".$transaction_journal_item['account_no'];?>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_journal_item["cheque"];?>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_journal_item["ledger"];?>
												</td>
												<td style="vertical-align:middle" class="center">
													<?php
														if($transaction_journal_item["gst"]>0)
														{
															$gst_checked="checked";
														}
														else
														{
															$gst_checked="";
														}
													?>
													<input type="checkbox" name="gst" id="gst" value="1" <?php echo $gst_checked;?> disabled>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_journal_item["description"];?>
												</td>
												<td style="vertical-align:middle">
													<?php echo $transaction_journal_item["type"];?>
												</td>
												<td class="center actions" style="vertical-align:middle; padding-left: 1px;" >
													<a data-id="<?php echo $transaction_journal_item['id'];?>" data-siteid="<?php echo $transaction_journal_item['site_id'];?>" data-projectid="<?php echo $transaction_journal_item['project_id'];?>" data-date="<?php echo $transaction_journal_item['date'];?>" data-amount="<?php echo $transaction_journal_item['amount'];?>" data-ledger="<?php echo $transaction_journal_item['ledger_id'];?>" data-description="<?php echo $transaction_journal_item['description'];?>" data-type="<?php echo $transaction_journal_item['type'];?>" data-account="<?php echo $transaction_journal_item['account_id'];?>" data-payerpayee="<?php echo $transaction_journal_item['payer_payee'];?>" data-gst="<?php echo $transaction_journal_item['gst'];?>" data-cheque="<?php echo $transaction_journal_item['cheque'];?>" title="Edit" class="open-editStatementModal btn-action glyphicons pencil btn-success normal_session" href="#editStatementModal"><i></i></a>
													<?php
														echo anchor('transaction_journal/delete/'.$transaction_journal_item['id'].'/journal_statement', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger normal_session','onclick'=>"return confirm('Are you sure to remove this journal data?')"));
													?>
												</td>
											</tr>
								<?php
										}
									}
									else
									{
								?>
										<tr class="gradeX">
											<td colspan='11' style="vertical-align:middle">
												No data available in table
											</td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="editStatementModal" tabindex="-1" role="dialog" aria-labelledby="editStatementModalLabel" aria-hidden="true" style="display:none;">
	 	<div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="editStatementModalLabel">Update Statement</h4>
		      	</div>
		     	<div class="modal-body">
			        <form>
		            	<input type="hidden" class="form-control" name="id" id="id">
		            	<input type="hidden" class="form-control" name="edit_type" id="edit_type">
		            	<input type="hidden" class="form-control" name="edit_project_id" id="edit_project_id">
		            	<div class="form-group">
			            	<label for="edit_date" class="control-label">Date:</label>
			            	<input type="text" class="form-control datetimepicker" name="edit_date" id="edit_date">
			          	</div>
			          	<div class="form-group" style="height: 66px;">
			            	<label for="edit_site" class="control-label">Site:</label>
			            	<select class="selectpicker span12" name="edit_site" id="edit_site" data-live-search="true" style="maxOptions:3">
								<?php
									foreach ($site as $site_item){
								?>
										<option value="<?php echo $site_item['id'];?>"><?php echo $site_item['name'];?></option>
								<?php
									}
								?>
							</select>
			          	</div>
			          	<div class="form-group">
			            	<label for="edit_amount" class="control-label">Amount :</label>
			            	<input type="text" class="form-control" name="edit_amount" id="edit_amount" maxlength="15" onkeypress="return isNumberKey(event)">
			            	&nbsp;&nbsp;<b>GST<b>&nbsp;&nbsp;<input type="checkbox" class="form-control" name="edit_gst" id="edit_gst" value="1" style="vertical-align:middle;">
			          	</div>
			          	<div class="form-group">
			            	<label for="edit_payer_payee" class="control-label">Payer/Payee:</label>
			            	<input type="text" class="form-control" name="edit_payer_payee" maxlength="100" id="edit_payer_payee">
			          	</div>
			          	<div class="form-group" style="height: 66px;">
			            	<label for="edit_account" class="control-label">Account:</label>
			            	<select class="selectpicker span12" data-live-search="true" name="edit_account" id="edit_account" style="maxOptions:3">
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
										<option value="<?php echo $account_item['id'];?>"><?php echo $account_item['name'].$str_account_no;?></option>
								<?php
									}
								?>
							</select>
			          	</div>
			          	<div class="form-group">
			            	<label for="edit_cheque" class="control-label">Cheque No.:</label>
			            	<input type="text" class="form-control" maxlength="32" name="edit_cheque" id="edit_cheque">
			          	</div>
			          	<div class="form-group" style="height: 66px;">
			            	<label for="edit_ledger" class="control-label">Ledger:</label>
			            	<select class="selectpicker span12 dropup" data-live-search="true" name="edit_ledger" id="edit_ledger" style="maxOptions:3">
								<option value="">-Select-</option>
								<?php
									foreach ($ledger as $ledger_item){
								?>
										<option value="<?php echo $ledger_item['id'];?>"><?php echo $ledger_item['ledger'];?></option>
								<?php
									}
								?>
							</select>
			          	</div>
			          	<div class="form-group">
			            	<label for="edit_description" class="control-label">Description:</label>
			            	<input type="text" class="form-control" name="edit_description" id="edit_description">
			          	</div>
			        </form>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-primary" onclick="update_statement();">Submit</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      	</div>
		    </div>
		</div>
	</div>
	
<script type="text/javascript">
	$(document).ready(function(){
		$(".edit_session").hide();
		init_filter_site();

		$('.selectpicker').selectpicker({
	      	size: 10,
	  	});
	});

	$(function() {
		$(".datetimepicker").datepicker({
			showOn: 'both', 
			buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
			buttonImageOnly: true,
			changeMonth: true,
	      	changeYear: true
		});
	});

	$(document).on("click", ".open-editStatementModal", function (e) {

	    e.preventDefault();

	    var _self = $(this);

	    var id = _self.data('id');
	    var siteid = _self.data('siteid');
	    var project_id = _self.data('projectid');
	    var amount = _self.data('amount');
	    
	    var date_arr = _self.data('date').split("-");
		var date=date_arr[1]+"/"+date_arr[2]+"/"+date_arr[0];

	    var cheque = _self.data('cheque');
	    var payerpayee = _self.data('payerpayee');
	    var ledger = _self.data('ledger');
	    var description = _self.data('description');
	    var gst = _self.data('gst');
	    var account = _self.data('account');
	    var type = _self.data('type');

	    $("#id").val(id);
	    $("#edit_project_id").val(project_id);
	    $('select[name=edit_site]').val(siteid);
		$('select[name=edit_account]').val(account);
		$('select[name=edit_ledger]').val(ledger);

		$('.selectpicker').selectpicker('refresh')

	    $("#edit_amount").val(Math.abs(amount));
	    $("#edit_date").val(date);
	    $("#edit_cheque").val(cheque);
	    $("#edit_payer_payee").val(payerpayee);
	    $("#edit_description").val(description);
	    $("#edit_type").val(type);
	    if(gst)
	    {
	    	$("#edit_gst").prop('checked', true);
	    }

	    $(_self.attr('href')).modal('show');
	});

	function reload(){
		window.location.href = '<?PHP echo site_url("transaction_journal/journal_statement"); ?>';
	}

	function init_filter_site()
	{ //any select change on the dropdown with id country trigger this code
		var text_selected=$("#site option:selected").text();
		var value_selected=$("#site").val();
		$("#site > option").remove(); //first of all clear select items
 		var project = $('#project').val(); // here we are taking country id of the selected one.
		$.ajax({
 			type: "POST",
 			dataType : "json",
 			url: "<?php echo site_url('transaction_journal/get_site_list_by_value/"+project+"'); ?>", //here we are calling our user controller and get_cities method with the country_id
 			success: function(data) //we're calling the response json array 'cities'
 			{
 				var opt = $('<option />'); // here we're creating a new select option with for each city
				opt.val(value_selected);
				opt.text(text_selected);
				$('#site').append(opt);

 				$.each(data,function(id,text) //here we're doing a foeach loop round each city with id as the key and city as the value
 				{
 					var opt = $('<option />'); // here we're creating a new select option with for each city
					opt.val(id);
					opt.text(text);
 					$('#site').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
 				});
 			}
		});
 	};

 	function update_statement()
	{
		var id=$("#id").val();
		if($("#edit_amount").val()!="")
		{
		    var project_id = $("#edit_project_id").val();
		    var siteid = $("#edit_site").val();
		    var amount = $("#edit_amount").val();
		    
		    var date_arr="";
			date_arr=$("#edit_date").val().split("/");
			var date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var cheque = $("#edit_cheque").val();
		    var payerpayee = $("#edit_payer_payee").val();
		    var ledger = $("#edit_ledger").val();
		    var description = $("#edit_description").val();
		    if($("#edit_gst").is(':checked'))
		    {
		    	var gst = 1;
		    }
		    else
		    {
		    	var gst = 0;
		    }
		    var account = $("#edit_account").val();
		    var type = $("#edit_type").val();

		    var string_data=id+"---"+siteid+"---"+amount+"---"+date+"---"+cheque+"---"+payerpayee+"---"+ledger+"---"+description+"---"+gst+"---"+account+"---"+type+"---"+project_id;

		    $.ajax(
			{
				url: "<?php echo site_url('utility/update_statement/"+string_data+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					alert("Data Updated");
					location.reload();
				},
				error:function(data){
					alert("Error when Saving");
				}
			});
		}
		else
		{
			alert("Amount cannot be empty");
		}
	}

 	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
