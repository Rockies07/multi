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
		<li>Payment</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<?php echo form_open($action)?>
				<div class="span12" style="margin-left:0px">
					<div class="span1">Date</div>
					<div class="span2">
						<input type="text" name="date" id="transaction_date" class="input-mini" value="<?php echo date("m/d/Y");?>" style="width: 70px; vertical-align: top;" />
					</div>
					<div class="span8">
						<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" onclick="return validate();"><i></i>Save</button>
						<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
					</div>
				</div>
				<div class="span12" style="margin-left:0px">
					<div class="span5">
						<div class="widget-body">
							<table class="table table-bordered table-primary table-condensed">
								<thead>
									<tr>
										<th class="center" width="20px">S/N</th>
										<th>ID</th>
										<th>Amount</th>
										<th>Remark</th>
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
												<td class="center">
													<input type="text" name="memberid_<?php echo $i;?>" id="memberid_<?php echo $i;?>" placeholder="ID" style="width:100px" />
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="amount_<?php echo $i;?>" id="amount_<?php echo $i;?>" class="right" placeholder="Amount" style="width:70px" onkeypress="return isNumberKeyNegative(event)"/>
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="remark_<?php echo $i;?>" id="remark_<?php echo $i;?>" class="right" placeholder="Remark" style="width:280px"/>
												</td>
											</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="span1">
						&nbsp;
					</div>
					<div class="span5" style="margin-left:40px;">
						<div class="widget-body">
							<table class="table table-bordered table-primary table-condensed">
								<thead>
									<tr>
										<th class="center" width="20px">S/N</th>
										<th>ID</th>
										<th>Amount</th>
										<th>Remark</th>
									</tr>
								</thead>
								<tbody>
									<?php
										for($i=31;$i<=60;$i++)
										{
									?>
											<tr>
												<td class="center" style="vertical-align:middle">
													<?php echo $i;?>
												</td>
												<td class="center">
													<input type="text" name="memberid_<?php echo $i;?>" id="memberid_<?php echo $i;?>" placeholder="ID" style="width:100px" />
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="amount_<?php echo $i;?>" id="amount_<?php echo $i;?>" class="right" placeholder="Amount" style="width:70px" onkeypress="return isNumberKeyNegative(event)"/>
												</td>
												<td style="vertical-align:middle" class="center">
													<input type="text" name="remark_<?php echo $i;?>" id="remark_<?php echo $i;?>" class="right" placeholder="Remark" style="width:280px"/>
												</td>
											</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
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
		$("#transaction_date").datepicker({
		showOn: 'both', 
		buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
		buttonImageOnly: true,
		changeMonth: true,
      	changeYear: true
		});
	});

	function reload(){
		window.location.href = '<?PHP echo site_url("transaction_employee/management"); ?>';
	}
	
	(function($){
		$(function(){
			$(".nts_no").autocomplete({
				source: "<?php echo site_url('transaction_employee/get_employee_by_nts'); ?>" // path to the get_birds method
		  	});
		});
	})(jQuery);
	
	function get_employee_detail(counter)
	{
		var value=$("#nts_"+counter).val();
		
		var transaction_date=$("#transaction_date").val();
		var date_arr=transaction_date.split("/");
		
		transaction_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];
		
		if(value!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('utility/get_employee_detail/"+value+"/"+transaction_date+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					if(data.error)
					{
						alert("Employee NTS No. Not Found");
						$("#nts_"+counter).val('');
						$("#nts_"+counter).focus();
					}
				},
				error:function(data){
					alert("Employee NTS No. Not Found");
				}
			});
		}
	}

	function get_employee_check_hours(counter)
	{
		var value=$("#nts_"+counter).val();
		
		var transaction_date=$("#transaction_date").val();
		var date_arr=transaction_date.split("/");
		
		transaction_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];
		
		if(value!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('utility/get_employee_check_hours/"+value+"/"+transaction_date+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					if(data.error)
					{
						alert("Employee has work more than 8 hours");
					}
				},
				error:function(data){
					alert("Your data got error, please ask administrator to check");
				}
			});
		}
	}
	
	function validate()
	{
		var site=$("#site").val();
		var have_data=0;
		var get_nts="";
		for(var i=0;i<=30;i++)
		{
			get_nts=$("#nts_"+i).val();
			
			if(get_nts!="")
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
			alert("No Employee Data Inserted..");
			return false;
		}
	}

	function complete_nts(counter)
	{
		var value=$("#nts_"+counter).val();
		var str_len=value.length;


		if(parseFloat(value)>0)
		{
			if((value!="")&&(str_len<=3))
			{
				switch(str_len)
				{
					case 3 : value = "NTS-"+value; break;
					case 2 : value = "NTS-0"+value; break;
					case 1 : value = "NTS-00"+value; break;
					default : value = value; break;
				}
				
				$("#nts_"+counter).val(value);
			}
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
