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
	<div class="widget-body">
		<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
			<thead>
				<tr>
					<th width="10px">S/N</th>
					<th>Username</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th width="60px">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$i=0;
					foreach ($test as $test_item){
						$i++;
				?>
						<tr class="gradeX">
							<td class="center"><?php echo $i; ?></td>
							<td><?php echo $test_item['username']; ?></td>
							<td><?php echo $test_item['first_name']; ?></td>
							<td><?php echo $test_item['last_name']; ?></td>
						</tr>
				<?php 
					}
				?>
			</tbody>
		</table>
	</div>
	<?php print_r($test);?>
	
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
