<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />
				
<style>
.passport,.work_permit,.airport_pass,.employee_detail,.compulsory_course,.basic_course,.low_levy_course{
	display: none;
}

#table_container{
	overflow:scroll;
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
		<li>HRM</li>
		<li class="divider"></li>
		<li>NTS Worker List (Active)</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>NTS Worker</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">NTS Worker List</h4>
			</div>
			<div class="widget-body" id="table_container">
				<div class="filter-bar">
					<?php echo form_open($action)?>
						<div class="lbl glyphicons cogwheel"><i></i>Filter</div>
						<div>
							<label>Nationality:</label>
							<div>
								<select name="filter_nationality" id="filter_nationality">
									<?php 
										if($filter_nationality!="")
										{
											
									?>
											<option value="<?php echo $filter_nationality;?>"><?php echo $filter_nationality;?></option>
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
										foreach ($country as $country_item){
									?>
											<option value="<?php echo $country_item['nationality'];?>" <?php echo set_select('nationality', $country_item['nationality']); ?>><?php echo $country_item['nationality'];?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div>
							<label>Work Exp.:</label>
							<div>
								<input type="text" name="filter_work_exp" id="filter_work_exp" value="<?php echo $filter_work_exp;?>" style="vertical-align:top;" class="span1" placeholder="Exp."> year(s)
							</div>
						</div>
						<div>
							<label>Other:</label>
							<div>
								<select name="filter_have" id="filter_have" class="span2">
									<?php 
										if($filter_have!="")
										{
											
									?>
											<option value="<?php echo $filter_have;?>"><?php echo $filter_have;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">All</option>
									<?php
										}
									?>
									<option value="">All</option>
									<option value="Have">Have</option>
									<option value="Don't Have">Don't Have</option>
								</select>
								<select name="filter_other" id="filter_other">
									<?php 
										if($filter_other!="0")
										{
											switch($filter_other)
											{
												case '0': $filter_other_text="-Select-"; break;
												case '1': $filter_other_text="Airport Pass"; break;
												case '2': $filter_other_text="Compulsory Course"; break;
												case '3': $filter_other_text="Basic Course"; break;
												case '4': $filter_other_text="Low Levy Course"; break;
											}
											
									?>
											<option value="<?php echo $filter_other;?>"><?php echo $filter_other_text;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="0">-Select-</option>
									<?php
										}
									?>
									<option value="0">-Select-</option>
									<option value="1">Airport Pass</option>
									<option value="2">Compulsory Course</option>
									<option value="3">Basic Course</option>
									<option value="4">Low Levy Course</option>
								</select>
							</div>
						</div>
						<div>
							<button type="submit" class="btn btn-icon btn-primary glyphicons search"><i></i>Search</button>
						</div>
						<div class="clearfix"></div>
					</form>
				</div>
				<div class="span12" style="padding:0;margin:0;">
					<div class="span10" style="padding:0;margin:0;">
						<h5>
							<!--
								Passport&nbsp;&nbsp;<input type="checkbox" id="show_passport" style="vertical-align:top" onchange="show_detail(this.id,'passport',230);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							-->
							Work Permit&nbsp;&nbsp;<input type="checkbox" id="show_work_permit" style="vertical-align:top" onchange="show_detail(this.id,'work_permit',610);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Airport Pass&nbsp;&nbsp;<input type="checkbox" id="show_airport_pass" style="vertical-align:top" onchange="show_detail(this.id,'airport_pass',280);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<!--
								Other Particular&nbsp;&nbsp;<input type="checkbox" id="show_employee_detail" style="vertical-align:top" onchange="show_detail(this.id,'employee_detail',940);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							-->
							Compulsory Course&nbsp;&nbsp;<input type="checkbox" id="show_compulsory_course" style="vertical-align:top" onchange="show_detail(this.id,'compulsory_course',260);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Basic Course&nbsp;&nbsp;<input type="checkbox" id="show_basic_course" style="vertical-align:top" onchange="show_detail(this.id,'basic_course',220);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Low Levy Course&nbsp;&nbsp;<input type="checkbox" id="show_low_levy_course" style="vertical-align:top" onchange="show_detail(this.id,'low_levy_course',1420);">
						</h5>
					</div>
					<div class="span2 right" style="padding:0;margin:0;">	
						<button type="reset" class="btn btn-icon btn-success glyphicons user_add span3" onclick="add_employee()"><i></i>Add New NTS Worker</button>
					</div>
				</div>
				<div class="separator"></div>
				<div class="separator"></div>
				<div style="height:600px">
					<table class="table table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th width="10px">S/N</th>
								<th width="300px">Name</th>
								<th class="center" width="100px">NTS No.</th>
								<th class="center">Nationality</th>
								<th class="center">Position</th>
								<th class="center" width="110px">Salary Rate</th>
								<th class="center">Levy</th>
								<th class="center" width="100px">Date Joined</th>
								<th class="center" width="130px">MSE Work Day</th>
								<th class="center" width="140px">Prev Work Exp.</th>
								<th class="center" width="100px">Work Exp.</th>
								<!--
								<th class="center passport" width="120px">Passport No.</th>
								<th class="center passport" width="100px">Exp. date</th>
								-->
								<th class="center work_permit" width="100px">WP DoA</th>
								<th class="center work_permit" width="140px">WP Issued Date</th>
								<th class="center work_permit" width="120px">WP No.</th>
								<th class="center work_permit" width="100px">Fin No.</th>
								<th class="center work_permit" width="120px">WP Exp. date</th>
								<th class="center airport_pass" width="100px">AP DoA</th>
								<th class="center airport_pass" width="120px">AP Exp. date</th>
								<!--
									<th class="center employee_detail" width="100px">L.Contact</th>
									<th class="center employee_detail" width="160px">HM.Contact</th>
									<th class="center employee_detail" width="100px">L.Address</th>
									<th class="center employee_detail" width="200px">Email</th>
									<th class="center employee_detail" width="140px">Ref</th>
									<th class="center employee_detail" width="100px">DoB</th>
								-->
								<th class="center compulsory_course" width="40px">BCSS</th>
								<th class="center compulsory_course" width="40px">CSOC</th>
								<th class="center compulsory_course" width="140px">CSOC Exp. Date</th>
								<th class="center basic_course" width="40px">MSES</th>
								<th class="center basic_course" width="40px">MSEC</th>
								<th class="center basic_course" width="40px">WAHS</th>
								<th class="center basic_course" width="40px">WAHW</th>
								<th class="center low_levy_course" width="200px">CT Type</th>
								<th class="center low_levy_course" width="200px">CT Course</th>
								<th class="center low_levy_course" width="140px">CT Reg. No.</th>
								<th class="center low_levy_course" width="120px">CT Exp.Date</th>
								<th class="center low_levy_course" width="200px">1st SEC</th>
								<th class="center low_levy_course" width="200px">2nd SEC</th>
								<th class="center low_levy_course" width="140px">MS Reg. No.</th>
								<th class="center low_levy_course" width="120px">MS Exp. Date</th>
								<th width="60px" >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=0;
								foreach ($employee as $employee_item){

									$exp_month = (strtotime($employee_item['ap_exp_date'])-strtotime(date('Y-m-d')))/(60*60*24);
									if($exp_month<=$expiry_limit)
									{
										$red_style_ap="style='background:rgb(252, 184, 184)'";
									}
									else
									{
										$red_style_ap="";
									}

									$exp_month = (strtotime($employee_item['wp_exp_date'])-strtotime(date('Y-m-d')))/(60*60*24);
									if($exp_month<=$expiry_limit)
									{
										$red_style_wp="style='background:rgb(252, 184, 184)'";
									}
									else
									{
										$red_style_wp="";
									}

									$exp_month = (strtotime($employee_item['passport_exp_date'])-strtotime(date('Y-m-d')))/(60*60*24);
									if($exp_month<=$expiry_limit)
									{
										$red_style_passport="style='background:rgb(252, 184, 184)'";
									}
									else
									{
										$red_style_passport="";
									}

									$exp_month = (strtotime($employee_item['csoc_exp_date'])-strtotime(date('Y-m-d')))/(60*60*24);
									if($exp_month<=$expiry_limit)
									{
										$red_style_csoc="style='background:rgb(252, 184, 184)'";
									}
									else
									{
										$red_style_csoc="";
									}

									$exp_month = (strtotime($employee_item['core_exp_date'])-strtotime(date('Y-m-d')))/(60*60*24);
									if($exp_month<=$expiry_limit)
									{
										$red_style_core_trade="style='background:rgb(252, 184, 184)'";
									}
									else
									{
										$red_style_core_trade="";
									}

									$exp_month = (strtotime($employee_item['multi_skill_exp_date'])-strtotime(date('Y-m-d')))/(60*60*24);
									if($exp_month<=$expiry_limit)
									{
										$red_style_multi_skill="style='background:rgb(252, 184, 184)'";
									}
									else
									{
										$red_style_multi_skill="";
									}

									$nts=$employee_item['nts'];

									$date_joined = new DateTime($employee_item['start_work_date']);
									$date_now = new DateTime(date('d-M-Y'));
									$interval = $date_joined->diff($date_now);
									$work_year=$interval->y;
									$work_month=$interval->m;
									$work_day=$interval->d;

									$total_year=$work_year+$employee_item['prev_work_exp_year'];
									$total_month=$work_month+$employee_item['prev_work_exp_month'];
									
									$total_day=$work_day+$employee_item['prev_work_exp_day'];
									if($total_day>30)
									{
										$total_day=$total_day-30;
										$total_month++;
									}

									if($total_month>12)
									{
										$total_month=$total_month-12;
										$total_year++;
									}

									if($total_year>=$filter_work_exp)
									{
										$i++;
							?>
										<tr class="gradeX">
											<td class="center"><?php echo $i; ?></td>
											<td><?php echo anchor('employee/detail/'.$nts, $employee_item['name']); ?></td>
											<td class="center"><?php echo anchor('employee/detail/'.$nts, $employee_item['nts']); ?></td>
											<td><?php echo $employee_item['nationality']; ?></td>
											<td class="center"><?php echo $employee_item['position']; ?></td>
											<td class="right"><?php echo number_format($employee_item['daily_rate'],2); ?></td>
											<td class="right"><?php echo number_format($employee_item['levy'],2); ?></td>
											<td class="center"><?php echo date('d-M-Y',strtotime($employee_item['start_work_date'])); ?></td>
											<td class="center">
												<?php
													echo sprintf("%02d", $work_year)."Y ".sprintf("%02d", $work_month)."M ".sprintf("%02d", $work_day)."D"; 
												?>
											</td>
											<td class="center">
												<?php
													echo sprintf("%02d", $employee_item['prev_work_exp_year'])."Y ".sprintf("%02d", $employee_item['prev_work_exp_month'])."M ".sprintf("%02d", $employee_item['prev_work_exp_day'])."D"; 
												?>
											</td>
											<td class="center">
												<?php
													echo sprintf("%02d", $total_year)."Y ".sprintf("%02d", $total_month)."M ".sprintf("%02d", $total_day)."D"; 
												?>
											</td>
											<!--
											<td class="center passport"><?php echo $employee_item['passport']; ?></td>
											<td class="center passport" <?php echo $red_style_passport;?>>
												<?php 
													if($employee_item['passport_exp_date']!="0000-00-00" && $employee_item['passport_exp_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['passport_exp_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											-->
											<td class="center work_permit">
												<?php 
													if($employee_item['wp_application_date']!="0000-00-00" && $employee_item['wp_application_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['wp_application_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<td class="center work_permit">
												<?php 
													if($employee_item['wp_issued_date']!="0000-00-00" && $employee_item['wp_issued_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['wp_issued_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<td class="center work_permit"><?php echo $employee_item['wp_no']; ?></td>
											<td class="center work_permit"><?php echo $employee_item['fin_no']; ?></td>
											<td class="center work_permit" <?php echo $red_style_wp;?>>
												<?php 
													if($employee_item['wp_exp_date']!="0000-00-00" && $employee_item['wp_exp_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['wp_exp_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<td class="center airport_pass">
												<?php 
													if($employee_item['ap_application_date']!="0000-00-00" && $employee_item['ap_application_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['ap_application_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<td class="center airport_pass" <?php echo $red_style_ap;?>>
												<?php 
													if($employee_item['ap_exp_date']!="0000-00-00" && $employee_item['ap_exp_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['ap_exp_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<!--
												<td class="center employee_detail"><?php echo $employee_item['local_contact']; ?></td>
												<td class="center employee_detail"><?php echo $employee_item['hm_contact']; ?></td>
												<td class="center employee_detail"><?php echo $employee_item['local_address']; ?></td>
												<td class="employee_detail"><?php echo $employee_item['email']; ?></td>
												<td class="employee_detail"><?php echo $employee_item['referral']; ?></td>
												<td class="center employee_detail">
													<?php 
														if($employee_item['date_of_birth']!="0000-00-00" && $employee_item['date_of_birth']!="")
														{
															echo date('d-M-Y',strtotime($employee_item['date_of_birth']));
														}
														else
														{
															echo "";
														}
													?>
												</td>
											-->
											<td class="center compulsory_course">
												<?php 
													if($employee_item['bcss_no']!="")
													{
														$is_check="&#10003";
													}
													else
													{
														$is_check="";
													}
													echo $is_check; 
												?>
											</td>
											<td class="center compulsory_course">
												<?php 
													if($employee_item['csoc_no']!="")
													{
														$is_check="&#10003";
													}
													else
													{
														$is_check="";
													}
													echo $is_check; 
												?>
											</td>
											<td class="center compulsory_course" <?php echo $red_style_csoc;?>>
												<?php 
													if($employee_item['csoc_exp_date']!="0000-00-00" && $employee_item['csoc_exp_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['csoc_exp_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<td class="center basic_course">
												<?php 
													if($employee_item['mses_no']!="")
													{
														$is_check="&#10003";
													}
													else
													{
														$is_check="";
													}
													echo $is_check; 
												?>
											</td>
											<td class="center basic_course">
												<?php 
													if($employee_item['msec_no']!="")
													{
														$is_check="&#10003";
													}
													else
													{
														$is_check="";
													}
													echo $is_check; 
												?>
											</td>
											<td class="center basic_course">
												<?php 
													if($employee_item['wahs_no']!="")
													{
														$is_check="&#10003";
													}
													else
													{
														$is_check="";
													}
													echo $is_check; 
												?>
											</td>
											<td class="center basic_course">
												<?php 
													if($employee_item['wahw_no']!="")
													{
														$is_check="&#10003";
													}
													else
													{
														$is_check="";
													}
													echo $is_check; 
												?>
											</td>
											<td class="center low_levy_course"><?php echo $employee_item['core_trade_type']; ?></td>
											<td class="low_levy_course"><?php echo $employee_item['core_trade_course']; ?></td>
											<td class="center low_levy_course"><?php echo $employee_item['core_register_no']; ?></td>
											<td class="center low_levy_course" <?php echo $red_style_core_trade;?>>
												<?php 
													if($employee_item['core_exp_date']!="0000-00-00" && $employee_item['core_exp_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['core_exp_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<td class="low_levy_course"><?php echo $employee_item['multi_skill_1']; ?></td>
											<td class="low_levy_course"><?php echo $employee_item['multi_skill_2']; ?></td>
											<td class="center low_levy_course"><?php echo $employee_item['multi_skill_register_no']; ?></td>
											<td class="center low_levy_course" <?php echo $red_style_multi_skill;?>>
												<?php 
													if($employee_item['multi_skill_exp_date']!="0000-00-00" && $employee_item['multi_skill_exp_date']!="")
													{
														echo date('d-M-Y',strtotime($employee_item['multi_skill_exp_date']));
													}
													else
													{
														echo "";
													}
												?>
											</td>
											<td class="center actions" style="padding-left:2px;">
												<?php echo anchor('employee/add/'.$employee_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
												<a data-nts="<?php echo $employee_item['nts'];?>" title="Set Home Leave" class="open-homeLeaveModal btn-action glyphicons beach_umbrella btn-info" href="#homeLeaveModal"><i></i></a>
											</td>
										</tr>
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
	
	<div class="modal fade" id="homeLeaveModal" tabindex="-1" role="dialog" aria-labelledby="homeLeaveModalLabel" aria-hidden="true" style="display:none;">
	 	<div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="homeLeaveModalLabel">Set Home Leave</h4>
		      	</div>
		     	<div class="modal-body">
			        <form>
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
		        	<button type="button" class="btn btn-primary" onclick="save_home_leave();">Submit</button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      	</div>
		    </div>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("employee/management"); ?>';
	}

	function add_employee(){
		window.location.href = '<?PHP echo site_url("employee/add"); ?>';
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
	    $("#nts").val(nts);

	    $(_self.attr('href')).modal('show');
	});

	function save_home_leave()
	{
		var nts=$("#nts").val();
		if($("#start_hl_date").val()!="")
		{
			var date_arr="";
			date_arr=$("#start_hl_date").val().split("/");
			var start_hl_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var date_arr="";
			date_arr=$("#end_hl_date").val().split("/");
			var end_hl_date=date_arr[2]+"-"+date_arr[0]+"-"+date_arr[1];

		    var string_data=nts+"---"+start_hl_date+"---"+end_hl_date;

		    $.ajax(
			{
				url: "<?php echo site_url('utility/save_home_leave/"+string_data+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					alert("Data Updated");
					window.location.href = '<?PHP echo site_url("employee/management"); ?>';
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
