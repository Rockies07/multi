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
</style>

<div id="content">
	<div class="se-pre-con"></div>
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
						<table class="table table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle" width="20px">ID</th>
									<th class="center" style="vertical-align:middle; width:100px">Name</th>
									<th class="center" style="vertical-align:middle; width:100px">Total</th>
									<th class="center" style="vertical-align:middle; width:100px">Outstanding</th>
									<th class="center" style="vertical-align:middle; width:100px">Amount Due</th>
									<th class="center" style="vertical-align:middle; width:100px">Mobile 1</th>
									<!-- <th class="center" style="vertical-align:middle; width:100px">Last Login</th>
									<th class="center" style="vertical-align:middle; width:100px">Bank Acc.</th>
									<th class="center" style="vertical-align:middle;">Remarks</th>
									<th class="center" style="vertical-align:middle; width:60px">Ranking</th>
									<th class="center" style="vertical-align:middle; width:60px">MD</th> -->
								</tr>
							</thead>
							<tbody>
								<?php
									$i=0;
									foreach($member as $member_item)
									{
										$i++;
								?>
										<tr class="gradeX">
											<td class="center" style="vertical-align:middle">
												<?php
													echo anchor('member/edit/'.$member_item['memberid'], "<font color='black'><b>".$member_item['memberid']."</b></font>");
												?>
											</td>
											<td class="center">
												<?php
													echo $member_item['membername']." ".$get_total['grand_total'];
												?>
											</td>
											<td class="center">
												<?php
													$outstanding=$member_item['outstanding'];
													$amountdue=$member_item['amountdue'];
													$total=$outstanding+$amountdue;
													$data=$total;
													if($data>=0)
													{
														echo anchor('member/detail/'.$member_item['memberid'], "<font color='blue'><b>".number_format($data,2)."</b></font>", array('target' => '_blank'));
													}
													else
													{
														echo anchor('member/detail/'.$member_item['memberid'], "<font color='red'><b>".number_format($data,2)."</b></font>",array('target' => '_blank'));
													}
												?>
											</td>
											<td class="center">
												<?php
													$data=$outstanding;
													if($data>=0)
													{
														echo anchor('member/detail/'.$member_item['memberid'], "<font color='blue'><b>".number_format($data,2)."</b></font>",array('target' => '_blank'));
													}
													else
													{
														echo anchor('member/detail/'.$member_item['memberid'], "<font color='red'><b>".number_format($data,2)."</b></font>",array('target' => '_blank'));
													}
												?>
											</td>
											<td class="center" style="vertical-align:middle" width="60px">
												<?php
													$data=$amountdue;
													if($data>=0)
													{
														echo anchor('member/detail/'.$member_item['memberid'], "<font color='blue'><b>".number_format($data,2)."</b></font>",array('target' => '_blank'));
													}
													else
													{
														echo anchor('member/detail/'.$member_item['memberid'], "<font color='red'><b>".number_format($data,2)."</b></font>",array('target' => '_blank'));
													}
												?>
											</td>
											<td class="center">
												<?php
													echo $member_item['membercontact1'];
												?>
											</td>
											<!-- <td class="center">
												<?php
													$data=$member_item['logindate'];
													if($data=='')
													{
														echo '-';
													}
													else
													{
														echo date('d/m/y H:i',strtotime($data));
													}
												?>
											</td>
											<td class="center">
												<?php
													$data=$member_item['bankaccount'];
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
													$data=$member_item['remarks'];
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
													echo $member_item['ranking_name'];
												?>
											</td>
											<td class="center">
												<?php
													echo $member_item['managerid'];
												?>
											</td> -->
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
	
<script type="text/javascript">
	$(document).ready(function(){
		/*$('.dynamicTable.tableTools').dataTable({
			"iDisplayLength": 50
		});*/
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

 	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<script src="<?php echo base_url();?>public/js/modernizr.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
