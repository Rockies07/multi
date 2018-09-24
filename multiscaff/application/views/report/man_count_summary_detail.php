<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<style>
a{
	color:#000;
}
</style>

<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Report</li>
		<li class="divider"></li>
		<li>Man Count Summary</li>
		<li class="divider"></li>
		<li>Detail</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Man Count Summary Report (Detail)</h3>
	
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="filter-bar">
				<?php echo form_open($action)?>
					<div class="lbl glyphicons cogwheel"><i></i>Filter</div>
					<div>
						<label>From:</label>
						<div>
							<input type="text" name="date_filter_from" id="date_filter_from" class="input-mini datetimepicker" value="<?php if($filter_date_from=="") echo date("m/d/Y"); else echo date("m/d/Y",strtotime($filter_date_from));?>" style="width: 90px;" />
						</div>
						<label>To:</label>
						<div>
							<input type="text" name="date_filter_to" id="date_filter_to" class="input-mini datetimepicker" value="<?php if($filter_date_to=="") echo date("m/d/Y"); else echo date("m/d/Y",strtotime($filter_date_to));?>" style="width: 90px;" />
							<input type="hidden" name="project" value="<?php echo $project;?>">
						</div>
					</div>
					<div>
						<button type="submit" class="btn btn-icon btn-primary glyphicons search"><i></i>Search</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
			<div class="span12">
				<div class="widget-body">
					<table class="table table-bordered table-primary table-condensed">
						<thead>
							<tr>
								<?php
									$date_from=date('Y-m-d',strtotime($filter_date_from));
									$date_to=date('Y-m-d',strtotime($filter_date_to));
									$count=(strtotime($date_to)-strtotime($date_from))/(60*60*24);
								?>
								<th style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);" class="center">Site</th>
								<?php
									for($x=0;$x<=$count;$x++)
									{
										if($date_from=="1970-01-01")
										{
											$date_from=date("Y-m-d");
										}

										if($x==0)
										{
											$set_date=date('d M',strtotime($date_from));
											$date[$x]=date("Y-m-d", strtotime($date_from));
										}
										else
										{
											$set_date=date('d M',strtotime($set_date.'+1 days'));
											$date[$x]=date("Y-m-d", strtotime($set_date));
										}
								?>
										<th style="vertical-align:middle; background: rgb(190, 58, 58); border-color: rgb(190, 58, 58);" class="center">
											<?php echo $set_date;?>
										</th>
								<?php
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($man_count_report as $man_count_report_item)
								{
									$project_name=$man_count_report_item['project_name'];
									$site_name=$man_count_report_item['site_name'];
							?>
									<tr>
										<td class="center" style="vertical-align:middle;">
											<?php 
												echo $site_name;
											?>
										</td>
										<?php 

											for($x=0;$x<=$count;$x++)
											{
										?>
												<td class="center" style="vertical-align:middle;">
													<span style="font-weight:bold;">
														<?php 
															echo anchor('report/man_count_detail/'.$man_count_report_item['site_id'].'/'.$man_count_report_item['page'].'/'.$date[$x].'/'.$date_filter_to, $man_count_report_item[$x]);
														?>
													</span>
												</td>
										<?php
											}
										?>
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
</div>
	
<script type="text/javascript">
	$(function() {
		$(".datetimepicker").datepicker({
		showOn: 'both', 
		buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
		buttonImageOnly: true,
		changeMonth: true,
      	changeYear: true
		});
	});

	function reload(){
		window.location.href = '<?PHP echo site_url("report/project"); ?>';
	}
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
