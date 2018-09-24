<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Report</li>
		<li class="divider"></li>
		<li>Man Count Summary</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Man Count Summary <?php echo $project_site_name;?> (<?php echo date('d M Y',strtotime($filter_date_from));?>)</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="span12">
				<div class="widget-body">
					<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<th width="10px">S/N</th>
								<th>Name</th>
								<th class="center">NTS No.</th>
								<th class="center">Position</th>
								<th class="center">Hours</th>
								<th class="center">OT Hours</th>
								<th class="center">N.Salary</th>
								<th class="center">OT.Salary</th>
								<th class="center">Allowance</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$i=0;
								foreach ($man_count_detail as $man_count_detail_item){
									$i++;
							?>
									<tr class="gradeX">
										<td class="center"><?php echo $i; ?></td>
										<td><?php echo $man_count_detail_item['emp_name']; ?></td>
										<td class="center"><?php echo $man_count_detail_item['nts']; ?></td>
										<td class="center"><?php echo $man_count_detail_item['position']; ?></td>
										<td class="right"><?php echo number_format($man_count_detail_item['work_hour'],2); ?></td>
										<td class="right"><?php echo number_format($man_count_detail_item['ot_hour'],2); ?></td>
										<td class="right"><?php echo number_format($man_count_detail_item['normal_salary'],2); ?></td>
										<td class="right"><?php echo number_format($man_count_detail_item['ot_salary'],2); ?></td>
										<td class="right"><?php echo number_format($man_count_detail_item['meal_fee']+$man_count_detail_item['ns_fee'],2); ?></td>
									</tr>
							<?php 
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
