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

.hide_row{
	display: none;
}
</style>

<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i><?php echo $title; ?></a></li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="span12" style="margin-left: 0px; width:100%;">
				<?php echo form_open($action)?>
					<div class="widget-body">
						<p align='center'>
							<input type='hidden' name='grand_total' id='grand_total' value="<?php echo $transaction_total['grand_total'];?>">
							<input type='hidden' name='total_outstanding' id='total_outstanding' value="<?php echo $transaction_total['total_outstanding'];?>">
							<input type='hidden' name='total_due' id='total_due' value="<?php echo $transaction_total['total_due'];?>">
							<input type='hidden' name='memberid' id='memberid' value="<?php echo $memberid;?>">
							<b>Gross Total : $</b> 
							<?php 
								$data=$transaction_total['grand_total'];
								if($data>=0)
								{
									echo "<font color='blue'><b>".number_format($data,2)."</b></font>";
								}
								else
								{
									echo "<font color='red'><b>".number_format($data,2)."</b></font>";
								}
							?>   
							<b>Outstanding : $</b> 
							<?php 
								$data=$transaction_total['total_outstanding'];
								if($data>=0)
								{
									echo "<font color='blue'><b>".number_format($data,2)."</b></font>";
								}
								else
								{
									echo "<font color='red'><b>".number_format($data,2)."</b></font>";
								}
							?>    
							<b>Amt Due : $</b>
							<?php 
								$data=$transaction_total['total_due'];
								if($data>=0)
								{
									echo "<font color='blue'><b>".number_format($data,2)."</b></font>";
								}
								else
								{
									echo "<font color='red'><b>".number_format($data,2)."</b></font>";
								}
							?>   
						</p>
						<table class="table table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle; height: 30px" colspan='9'>
										Show Hidden&nbsp;&nbsp;
										<input type='checkbox' name='all_member_hide' id='all_member_hide' onChange="show_clr();" style='margin:0px;'>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="center" style="vertical-align:middle" colspan='8'>&nbsp;</td>
									<td class="center" style="vertical-align:middle">
										<input type="submit" value="Save">
									</td>
								</tr>
								<tr>
									<tr>
										<th class="center" style="vertical-align:middle; width:140px">
											<?php 
												echo $memberid;

												$member_total_detail=$member_model->get_member_report_total($memberid);
												$outstanding=$member_total_detail->outstanding;
												$pmdue=$member_total_detail->pmdue;
												$total=$outstanding+$pmdue;

												$data=$outstanding;
												if($data>=0)
												{
													$outstanding_str="<font color='blue'><b>$".number_format($data,2)."</b></font>";
												}
												else
												{
													$outstanding_str="<font color='red'><b>$".number_format($data,2)."</b></font>";
												}

												$data=$pmdue;
												if($data>=0)
												{
													$pmdue_str="<font color='blue'><b>$".number_format($data,2)."</b></font>";
												}
												else
												{
													$pmdue_str="<font color='red'><b>$".number_format($data,2)."</b></font>";
												}

												$data=$total;
												if($data>=0)
												{
													$total_str="<font color='blue'><b>$".number_format($data,2)."</b></font>";
												}
												else
												{
													$total_str="<font color='red'><b>$".number_format($data,2)."</b></font>";
												}
											?>
										</th>
										<th class="right" colspan='6' style="vertical-align:middle;">Sub Total : <?php echo $total_str;?>   Outstanding : <?php echo $outstanding_str;?>   Amt Due : <?php echo $pmdue_str;?>	</th>
										<th class="center" style="vertical-align:middle; width:50px">D</th>
										<th class="center" style="vertical-align:middle; width:50px">H</th>
									</tr>
									<tr>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff;">Date</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">ID</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">@</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">Subbmcode</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">Accounts</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:150px">Amount</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff;">Remarks</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:50px">
											<input type='checkbox' name="all_pm" id="all_pm" onChange="all_pm_check_list('pm','<?php echo $memberid;?>');">
										</th>
										<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:50px">
											<input type='checkbox' name="all_clr" id="all_clr" onChange="all_clr_check_list('clr','<?php echo $memberid;?>');">
										</th>
									</tr>
								<?php
									$i=0;
									$current_member='';
									foreach($member as $member_item)
									{
										if($current_member!='' && $current_member!=$member_item['memberid'])
										{
								?>
											<tr>
												<td class="center" style="vertical-align:middle" colspan='8'>&nbsp;</td>
												<td class="center" style="vertical-align:middle">
													<input type="submit" value="Save">
												</td>
											</tr>
											<tr>
												<th class="center" style="vertical-align:middle">
													<?php 
													echo $member_item['memberid'];

													$member_total_detail=$member_model->get_member_report_total($member_item['memberid']);
													$outstanding=$member_total_detail->outstanding;
													$pmdue=$member_total_detail->pmdue;
													$total=$outstanding+$pmdue;

													$data=$outstanding;
													if($data>=0)
													{
														$outstanding_str="<font color='blue'><b>$".number_format($data,2)."</b></font>";
													}
													else
													{
														$outstanding_str="<font color='red'><b>$".number_format($data,2)."</b></font>";
													}

													$data=$pmdue;
													if($data>=0)
													{
														$pmdue_str="<font color='blue'><b>$".number_format($data,2)."</b></font>";
													}
													else
													{
														$pmdue_str="<font color='red'><b>$".number_format($data,2)."</b></font>";
													}

													$data=$total;
													if($data>=0)
													{
														$total_str="<font color='blue'><b>$".number_format($data,2)."</b></font>";
													}
													else
													{
														$total_str="<font color='red'><b>$".number_format($data,2)."</b></font>";
													}
												?>
											</th>
											<th class="right" colspan='6' style="vertical-align:middle;">Sub Total : <?php echo $total_str;?>   Outstanding : <?php echo $outstanding_str;?>   Amt Due : <?php echo $pmdue_str;?>	</th>
												<th class="center" style="vertical-align:middle; width:50px">D</th>
												<th class="center" style="vertical-align:middle; width:50px">H</th>
											</tr>
											<tr>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff;">Date</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">ID</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">@</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">Subbmcode</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:100px">Accounts</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:150px">Amount</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff;">Remarks</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:50px">
													<input type='checkbox' name="<?php echo $member_item['memberid'];?>_pm" id="<?php echo $member_item['memberid'];?>_pm" onChange="pm_member_check('<?php echo $member_item[memberid];?>');">
												</th>
												<th class="center" style="vertical-align:middle; background:#37a6cd; color: #fff; width:50px">
													<input type='checkbox' name="<?php echo $member_item['memberid'];?>_clr" id="<?php echo $member_item['memberid'];?>_clr" onChange="clr_member_check('<?php echo $member_item[memberid];?>');">
												</th>
											</tr>
								<?php
										}
										$i++;
										$clr=$member_item['clr'];
										if($clr)
										{
											$hide_row="hide_row";
										}
										else
										{
											$hide_row="";
										}
										$bmcode_detail=$bm_model->get_bmcode($member_item['cpyaccount']);
										$bmcode=$bmcode_detail->bmcode;
										$bmname=$bmcode_detail->bmname;
								?>
										<tr class="gradeX <?php echo $hide_row;?>">
											<td class="center" style="vertical-align:middle">
												<?php
													echo date('D, d M Y',strtotime($member_item['bmdate']));
												?>
											</td>
											<td class="center">
												<?php
													echo $member_item['memberid']." ".$i;;
												?>
												<input type='hidden' name='method_<?php echo $i;?>' id='method_<?php echo $i;?>' value='<?php echo $member_item['method'];?>'>
												<input type='hidden' name='ref_<?php echo $i;?>' id='ref_<?php echo $i;?>' value='<?php echo $member_item['ref'];?>'>
												<input type='hidden' name='amount_<?php echo $i;?>' id='amount_<?php echo $i;?>' value='<?php echo $member_item['amount'];?>'>
											</td>
											<td class="center">
												<?php
													$data=$bmcode;
													if($data=='')
													{
														echo '-';
													}
													else
													{
														echo $data;
													}
												?>
											</td>
											<td class="center">
												<?php
													$data=$bmname;
													if($data=='')
													{
														echo '-';
													}
													else
													{
														echo $data;
													}
												?>
											</td>
											<td class="center">
												<?php
													$data=$member_item['cpyaccount'];
													if($bmcode=='')
													{
														echo $data;
													}
													else
													{
														echo '-';
													}
												?>
											</td>
											<td class="center">
												<?php
													$data=$member_item['amount'];
													if($data>=0)
													{
														echo "<font color='blue'><b>".number_format($data,2)."</b></font>";
													}
													else
													{
														echo "<font color='red'><b>".number_format($data,2)."</b></font>";
													}
												?>
											</td>
											<td class="center">
												<?php
													echo $member_item['remark'];
												?>
											</td>
											<td class="center">
												<?php
													if($member_item['pm'])
													{
														$pm_check="checked";
													}
													else
													{
														$pm_check="";
													}
												?>
												<!-- <input type="checkbox" class="pm_all <?php echo $member_item['memberid'];?>_pm" name="pm_check_<?php echo $i;?>" id="pm_check_<?php echo $i;?>" onChange="update_pm_clr('pm',<?php echo $i;?>);" <?php echo $pm_check;?>> -->
												<input type="checkbox" class="pm_all <?php echo $member_item['memberid'];?>_pm" name="pm_check_<?php echo $i;?>" id="pm_check_<?php echo $i;?>" <?php echo $pm_check;?>>
											</td>
											<td class="center" style="vertical-align:middle" width="50px">
												<?php
													if($member_item['clr'])
													{
														$clr_check="checked";
													}
													else
													{
														$clr_check="";
													}
												?>
												<!-- <input type="checkbox" class="clr_all <?php echo $member_item['memberid'];?>_clr" name="clr_check_<?php echo $i;?>" id="clr_check_<?php echo $i;?>" onChange="update_pm_clr('clr',<?php echo $i;?>);" <?php echo $clr_check;?>> -->
												<input type="checkbox" class="clr_all <?php echo $member_item['memberid'];?>_clr" name="clr_check_<?php echo $i;?>" id="clr_check_<?php echo $i;?>" <?php echo $clr_check;?>>
											</td>
										</tr>
								<?php
										$current_member=$member_item['memberid'];
									}
								?>
								<input type="hidden" name="member_count" value="<?php echo $i;?>">
							</tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<script type="text/javascript">
 	function all_pm_check_list(type,member)
 	{
 		if($("#all_pm").is(':checked'))
		{
			$(".pm_all").attr('checked', true);
		}
		else
		{
			$(".pm_all").attr('checked', false);
		}

 		/*if($("#all_pm").is(':checked'))
		{
			var value='1';
		}
		else
		{
			var value='0';
		}

 		$.ajax(
		{
			url: "<?php echo site_url('transaction/update_all_pm_clr/"+type+"/"+member+"/"+value+"'); ?>",
			type:'POST', //data type
			dataType : "json",
			success:function(data){
				//location.reload();
				if($("#all_pm").is(':checked'))
				{
					$(".pm_all").attr('checked', true);
				}
				else
				{
					$(".pm_all").attr('checked', false);
				}
			},
			error:function(data){
				alert("Error when Saving");
			}
		});*/
 	}

 	function all_clr_check_list(type,member)
 	{
 		if($("#all_clr").is(':checked'))
		{
			$(".clr_all").attr('checked', true);
		}
		else
		{
			$(".clr_all").attr('checked', false);
		}

 		/*if($("#all_clr").is(':checked'))
		{
			var value='1';
		}
		else
		{
			var value='0';
		}

 		$.ajax(
		{
			url: "<?php echo site_url('transaction/update_all_pm_clr/"+type+"/"+member+"/"+value+"'); ?>",
			type:'POST', //data type
			dataType : "json",
			success:function(data){
				//location.reload();
				if($("#all_clr").is(':checked'))
				{
					$(".clr_all").attr('checked', true);
				}
				else
				{
					$(".clr_all").attr('checked', false);
				}
			},
			error:function(data){
				alert("Error when Saving");
			}
		});*/
 	}

 	function clr_member_check(member)
 	{
 		if($("#"+member+"_clr").is(':checked'))
		{
			$("."+member+"_clr").attr('checked', true);
		}
		else
		{
			$("."+member+"_clr").attr('checked', false);
		}
 	}

 	function pm_member_check(member)
 	{
 		if($("#"+member+"_pm").is(':checked'))
		{
			$("."+member+"_pm").attr('checked', true);
		}
		else
		{
			$("."+member+"_pm").attr('checked', false);
		}
 	}

 	function show_clr()
 	{
 		if($("#all_member_hide").is(':checked'))
		{
			$(".hide_row").show();
		}
		else
		{
			$(".hide_row").hide();
		}
 	}

 	function update_pm_clr(type,counter)
 	{
 		var method = $("#method_"+counter).val();
 		var ref = $("#ref_"+counter).val();
 		var amount = $("#amount_"+counter).val();
 		var total_due=$("#total_due").val();
 		var total_outstanding=$("#total_outstanding").val();
 		var grand_total=$("#grand_total").val();
 		var memberid=$("#memberid").val();

 		if($("#"+type+"_check_"+counter).is(':checked'))
 		{
 			var value='1';
 		}
 		else
 		{
 			var value='0';
 		}

 		var string=type+"XXX"+method+"XXX"+ref+"XXX"+value+"XXX"+amount+"XXX"+total_due+"XXX"+total_outstanding+"XXX"+grand_total+"XXX"+memberid;

 		$.ajax(
		{
			url: "<?php echo site_url('transaction/update_pm_clr_single/"+string+"'); ?>",
			type:'POST', //data type
			dataType : "json",
			success:function(data){
				//location.reload();
			},
			error:function(data){
				alert("Error when Saving");
			}
		});
 	}
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
