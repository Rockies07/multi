<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />

<style>
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
		<li>HRM</li>
		<li class="divider"></li>
		<li>Employee</li>
		<li class="divider"></li>
		<li>Detail Employee</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Detail Employee</h4>
			</div>
			<div class="separator"></div>
			<div class="row-fluid well" style="width:97%">
				<div class="span12">
					<div class="span4" style="margin-left:0px;">
						<div class="separator" style="padding: 2px 0;"></div>
						<div class="span12"><b><u>Employee Particular Detail</u></b></div>
						<div class="span12">
							<div class="span4">NTS No.</div>
							<div class="span8">: 
								<?php echo $employee->nts;?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Name</div>
							<div class="span8">: <?php echo $employee->name;?></div>
						</div>
						<div class="span12">
							<div class="span4">Nationality</div>
							<div class="span8">: <?php echo $employee->nationality;?></div>
						</div>
						<div class="span12">
							<div class="span4">Date of Birth</div>
							<div class="span8">: 
								<?php 
									if($employee->date_of_birth!="0000-00-00" && $employee->date_of_birth!="")
									{
										echo date('d-M-Y',strtotime($employee->date_of_birth));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Email Address</div>
							<div class="span8">: <?php echo $employee->email;?></div>
						</div>
						<div class="span12">
							<div class="span4">Date Joined</div>
							<div class="span8">: 
								<?php 
									if($employee->start_work_date!="0000-00-00" && $employee->start_work_date!="")
									{
										echo date('d-M-Y',strtotime($employee->start_work_date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Referral</div>
							<div class="span8">: <?php echo $employee->referral;?></div>
						</div>
						<div class="span12">
							<div class="span4">Prev. Work Exp</div>
							<div class="span8">: 
								<?php
									echo sprintf("%02d", $employee->prev_work_exp_year)."Y ".sprintf("%02d", $employee->prev_work_exp_month)."M ".sprintf("%02d", $employee->prev_work_exp_day)."D"; 
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Status</div>
							<div class="span8">: 
								<?php 
									echo $employee->status;

									if($employee->status!="Active")
									{
										echo " on ".date('d-M-Y',strtotime($employee->end_work_date));
									}
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Contact No.</div>
							<div class="span8">: 
								<?php 
									$hm_contact=$employee->hm_contact;

									if($hm_contact!="")
									{
										$hm_contact="/".$employee->hm_contact;
									}
									echo $employee->local_contact."".$hm_contact;
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">Local Address</div>
							<div class="span8">: <?php echo $employee->local_address;?></div>
						</div>
						<div class="span12">
							<div class="span4">Position</div>
							<div class="span8">: <?php echo $employee->position;?></div>
						</div>
						<div class="span12">
							<div class="span4">Daily Rate</div>
							<div class="span8">: <?php echo "$".$employee->daily_rate;?></div>
						</div>
						<div class="span12">
							<div class="span4">Levy</div>
							<div class="span8">: <?php echo "$".$employee->levy;?></div>
						</div>
					</div>
					<div class="span4">
						<div class="separator" style="padding: 2px 0;"></div>
						<div class="span12"><b><u>Work Permit Detail</u></b></div>
						<div class="span12">
							<div class="span4">Fin No.</div>
							<div class="span8">: <?php echo $employee->fin_no;?></div>
						</div>
						<div class="span12">
							<div class="span4">WP No.</div>
							<div class="span8">: <?php echo $employee->wp_no;?></div>
						</div>
						<div class="span12">
							<div class="span4">Date of Application</div>
							<div class="span8">: 
								<?php 
									if($employee->wp_application_date!="0000-00-00" && $employee->wp_application_date!="")
									{
										echo date('d-M-Y',strtotime($employee->wp_application_date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">WP Issuance Date</div>
							<div class="span8">: 
								<?php 
									if($employee->wp_issued_date!="0000-00-00" && $employee->wp_issued_date!="")
									{
										echo date('d-M-Y',strtotime($employee->wp_issued_date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">WP Exp Date</div>
							<div class="span8">: 
								<?php 
									if($employee->wp_exp_date!="0000-00-00" && $employee->wp_exp_date!="")
									{
										echo date('d-M-Y',strtotime($employee->wp_exp_date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="separator" style="padding: 2px 0;"></div>
						<div class="span12"><b><u>Airport Pass Detail</u></b></div>
						<div class="span12">
							<div class="span4">Date of Application</div>
							<div class="span8">: 
								<?php 
									if($employee->ap_application_date!="0000-00-00" && $employee->ap_application_date!="")
									{
										echo date('d-M-Y',strtotime($employee->ap_application_date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="span12">
							<div class="span4">AP Exp Date</div>
							<div class="span8">: 
								<?php 
									if($employee->ap_exp_date!="0000-00-00" && $employee->ap_exp_date!="")
									{
										echo date('d-M-Y',strtotime($employee->ap_exp_date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
						<div class="separator" style="padding: 2px 0;"></div>
						<div class="span12"><b><u>Passport Detail</u></b></div>
						<div class="span12">
							<div class="span4">Passport No.</div>
							<div class="span8">: <?php echo $employee->passport;?></div>
						</div>
						<div class="span12">
							<div class="span4">Passport Exp. Date</div>
							<div class="span8">: 
								<?php 
									if($employee->passport_exp_date!="0000-00-00" && $employee->passport_exp_date!="")
									{
										echo date('d-M-Y',strtotime($employee->passport_exp_date));
									}
									else
									{
										echo "-";
									}
								?>
							</div>
						</div>
					</div>
					<div class="span4">
						<div class="separator" style="padding: 2px 0;"></div>
						<?php
							$mses_no=$employee->mses_no;
							$msec_no=$employee->msec_no;
							$wahs_no=$employee->wahs_no;
							$wahw_no=$employee->wahw_no;

							if(($mses_no!="")||($msec_no!="")||($wahs_no!="")||($wahw_no!=""))
							{
								$is_basic=1;
							}
							else
							{
								$is_basic=0;
							}

							$bcss_no=$employee->bcss_no;
							$csoc_no=$employee->csoc_no;

							if(($bcss_no!="")||($csoc_no!=""))
							{
								$is_compulsory=1;
							}
							else
							{
								$is_compulsory=0;
							}

							$core_trade_type=$employee->core_trade_type;
							$core_trade_course=$employee->core_trade_course;
							$core_register_no=$employee->core_register_no;

							$is_low_levy=0;
							if(($core_trade_type!="")||($core_trade_course!="")||($core_register_no!=""))
							{
								$is_core_trade=1;
								$is_low_levy=1;
							}
							else
							{
								$is_core_trade=0;
							}

							$multi_skill_1=$employee->multi_skill_1;
							$multi_skill_2=$employee->multi_skill_2;
							$multi_skill_register_no=$employee->multi_skill_register_no;

							if(($multi_skill_1!="")||($multi_skill_2!="")||($multi_skill_register_no!=""))
							{
								$is_multi_skill=1;
								$is_low_levy=1;
							}
							else
							{
								$is_multi_skill=0;
							}

						?>

						<?php
							if($is_basic)
							{
						?>
								<div class="span12"><b><u>Basic Course</u></b></div>
								<div class="span12">
									<div class="span4">MSES No.</div>
									<div class="span8">: <?php echo $employee->mses_no;?></div>
								</div>
								<div class="span12">
									<div class="span4">MSEC No.</div>
									<div class="span8">: <?php echo $employee->msec_no;?></div>
								</div>
								<div class="span12">
									<div class="span4">WAHS No.</div>
									<div class="span8">: <?php echo $employee->wahs_no;?></div>
								</div>
								<div class="span12">
									<div class="span4">WAHW No.</div>
									<div class="span8">: <?php echo $employee->wahw_no;?></div>
								</div>
						<?php
							}
						?>

						<?php
							if($is_compulsory)
							{
						?>
								<div class="span12"><b><u>Compulsory Course</u></b></div>
								<div class="span12">
									<div class="span4">BCSS No.</div>
									<div class="span8">: <?php echo $employee->bcss_no;?></div>
								</div>
								<div class="span12">
									<div class="span4">CSOC No.</div>
									<div class="span8">: <?php echo $employee->csoc_no;?></div>
								</div>
								<div class="span12">
									<div class="span4">CSOC Exp. Date</div>
									<div class="span8">: 
										<?php 
											if($employee->csoc_exp_date!="0000-00-00" && $employee->csoc_exp_date!="")
											{
												echo date('d-M-Y',strtotime($employee->csoc_exp_date));
											}
											else
											{
												echo "-";
											}
										?>
									</div>
								</div>
						<?php
							}
						?>

						<?php
							if($is_low_levy)
							{
						?>
								<div class="span12"><b><u>Low Levy Course</u></b></div>
								<div class="span12">
									<div class="span4">Core Trade Type</div>
									<div class="span8">: <?php echo $employee->core_trade_type;?></div>
								</div>
								<div class="span12">
									<div class="span4">Course Title</div>
									<div class="span8">: <?php echo $employee->core_trade_course;?></div>
								</div>
								<div class="span12">
									<div class="span4">Registration No.</div>
									<div class="span8">: <?php echo $employee->core_register_no;?></div>
								</div>
								<div class="span12">
									<div class="span4">Expiry Date</div>
									<div class="span8">
										<?php 
											if($employee->core_exp_date!="0000-00-00" && $employee->core_exp_date!="")
											{
												echo date('d-M-Y',strtotime($employee->core_exp_date));
											}
											else
											{
												echo "-";
											}
										?>
									</div>
								</div>
								<div class="span12">
									<div class="span4">1st SEC</div>
									<div class="span8">: <?php echo $employee->multi_skill_1;?></div>
								</div>
								<div class="span12">
									<div class="span4">2nd SEC</div>
									<div class="span8">: <?php echo $employee->multi_skill_2;?></div>
								</div>
								<div class="span12">
									<div class="span4">Registration No.</div>
									<div class="span8">: <?php echo $employee->multi_skill_register_no;?></div>
								</div>
								<div class="span12">
									<div class="span4">Expiry Date</div>
									<div class="span8">
										<?php 
											if($employee->multi_skill_exp_date!="0000-00-00" && $employee->multi_skill_exp_date!="")
											{
												echo date('d-M-Y',strtotime($employee->multi_skill_exp_date));
											}
											else
											{
												echo "-";
											}
										?>
									</div>
								</div>
						<?php
							}
						?>
					</div>
				</div>	
				<div class="span12" style="margin-left:10px;">
					<?php 
						if(!empty($home_leave))
						{
					?>
							<div class="span4" style="margin-left:0px;">
								<div class="span12"><b><u>Home Leave Detail</u></b></div>
								<?php
									foreach ($home_leave as $home_leave_item){
								?>
										<div class="span8" style="margin-left:2px;">
											<b>&#187;</b>
											<a data-id="<?php echo $home_leave_item['id'];?>" data-starthldate="<?php echo $home_leave_item['start_hl_date'];?>" data-endhldate="<?php echo $home_leave_item['end_hl_date'];?>" data-nts="<?php echo $employee->nts;?>" title="Update Home Leave" class="open-homeLeaveModal" href="#homeLeaveModal">
												<?php 
												$date_diff=(strtotime($home_leave_item['end_hl_date'])-strtotime($home_leave_item['start_hl_date']))/60/60/24+1;
												echo date('d-M-Y',strtotime($home_leave_item['start_hl_date']))." to ".date('d-M-Y',strtotime($home_leave_item['end_hl_date']))." (".$date_diff." days)";
												;?>
											</a>
										</div>
											
										</th>
								<?php
									}
								?>	
							</div>
					<?php
						}
					?>
					<?php 
						if(!empty($mc_detail))
						{
					?>
							<div class="span4">
								<div class="span12"><b><u>MC Detail</u></b></div>
								<?php
									$i=0;
									foreach ($mc_detail as $mc_detail_item){
										$i++;
								?>
										<div class="span8" style="margin-left:2px;">
											<b>&#187;</b>
											<?php 
											echo date('d-M-Y',strtotime($mc_detail_item['date']))." ($i)";
											;?>
										</div>
											
										</th>
								<?php
									}
								?>	
							</div>	
					<?php
						}
					?>
				</div>
				<div class="span12">
					<div class="span10 center">
						<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Back to Employee List</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="homeLeaveModal" tabindex="-1" role="dialog" aria-labelledby="homeLeaveModalLabel" aria-hidden="true" style="display:none;">
	 	<div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="homeLeaveModalLabel">Update Home Leave</h4>
		      	</div>
		     	<div class="modal-body">
			        <form>
		            	<input type="hidden" class="form-control" name="id" id="id">
		            	<input type="hidden" class="form-control" name="nts" id="nts">
			          	<div class="form-group">
			            	<label for="start_work_date" class="control-label">Date Start:</label>
			            	<input type="text" class="form-control datetimepicker" name="start_hl_date" id="start_hl_date">
			          	</div>
			          	<div class="form-group">
			            	<label for="end_hl_date" class="control-label">Date End:</label>
			            	<input type="text" class="form-control datetimepicker" name="end_hl_date" id="end_hl_date">
			          	</div>
			        </form>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-primary" onclick="update_home_leave();">Submit</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      	</div>
		    </div>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("employee/management"); ?>';
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

	$(document).on("click", ".open-homeLeaveModal", function (e) {

	    e.preventDefault();

	    var _self = $(this);

	    var nts = _self.data('nts');
	    var id = _self.data('id');

	    var date_arr = _self.data('starthldate').split("-");
		var start_hl_date=date_arr[1]+"/"+date_arr[2]+"/"+date_arr[0];

		var date_arr = _self.data('endhldate').split("-");
		var end_hl_date=date_arr[1]+"/"+date_arr[2]+"/"+date_arr[0];

	    $("#id").val(id);
	    $("#start_hl_date").val(start_hl_date);
	    $("#end_hl_date").val(end_hl_date);
	    $("#nts").val(nts);

	    $(_self.attr('href')).modal('show');
	});

	function update_home_leave()
	{
		var id=$("#id").val();
		var nts=$("#nts").val();
		if($("#start_hl_date").val()!="")
		{
			var date_arr="";
			date_arr=$("#start_hl_date").val().split("/");
			var start_hl_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var date_arr="";
			date_arr=$("#end_hl_date").val().split("/");
			var end_hl_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var string_data=id+"---"+nts+"---"+start_hl_date+"---"+end_hl_date;

		    $.ajax(
			{
				url: "<?php echo site_url('utility/update_home_leave/"+string_data+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					alert("Data Updated");
					window.location.href = '<?PHP echo site_url("employee/detail/'+nts+'"); ?>';
				},
				error:function(data){
					alert("Error when Saving");
				}
			});
		}
		else
		{
			alert("Start Home Leave Date cannot be Empty");
		}
	}

	function show_hl_date()
	{
		var status=$("#status").val();
		if(status=="Cancel Permit" || status=="Resign" || status=="Terminated" || status=="Transfer")
		{
			$(".end_date").show();
		}
		else
		{
			$(".end_date").hide();
		}
	}

	$(document).ready(function(){
		show_hl_date();
	});

	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});

	function show_detail(id, value, width)
	{
		var table_width=$('#table_container').width();

		if($('#' + id).is(":checked"))
		{
			$('.' + value).show();
			
			table_width=table_width+width;
			$('#table_container').width(table_width);
		}
		else
		{
			$('.' + value).hide();
			table_width=table_width-width;
			$('#table_container').width(table_width);
		}
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
