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
						<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle" width="20px">S/N</th>
									<th style="vertical-align:middle;">Name</th>
									<th style="vertical-align:middle; width:120px">VIP Level</th>
									<th style="vertical-align:middle; width:200px">Call Status</th>
									<th style="vertical-align:middle; width:60px">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i=0;
									foreach($customer as $customer_item)
									{
										$i++;
								?>
										<tr class="gradeX">
											<td class="center" style="vertical-align:middle">
												<?php
													echo $i;
												?>
											</td>
											<td>
												<?php
													echo $customer_item['username'].' - '.$customer_item['first_name'].' '.$customer_item['last_name'];
												?>
											</td>
											<td class="center">
												<?php
													echo $customer_item['level'];
												?>
											</td>
											<td class="center">
												<?php
													echo $customer_item['call_status'];
												?>
											</td>
											<td class="center" style="vertical-align:middle" width="60px">
												<?php
													echo anchor('customer/detail/'.$customer_item['id'], '<i></i>',array('class' => 'btn-action glyphicons eye_open btn-info'));
												?>
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
