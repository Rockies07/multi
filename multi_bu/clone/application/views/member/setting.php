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
									<th class="center" style="vertical-align:middle; width:100px">MD</th>
									<th class="center" style="vertical-align:middle; width:100px">Name</th>
									<th class="center" style="vertical-align:middle; width:100px">Show</th>
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
													echo $member_item['memberid'];
												?>
												<input type="hidden" id="memberid_<?php echo $i;?>" value="<?php echo $member_item['memberid'];?>">
											</td>
											<td class="center">
												<?php
													echo $member_item['managerid'];
												?>
											</td>
											<td class="center">
												<?php
													echo $member_item['membername'];
												?>
											</td>
											<td class="center">
												<?php
													if($member_item['clone_show']=='1')
													{
														$clone_show_checkbox='checked';
													}
													else
													{
														$clone_show_checkbox='';
													}
												?>
												<input type='checkbox' name='show_clone_<?php echo $i;?>' id='show_clone_<?php echo $i;?>' <?php echo $clone_show_checkbox;?> onChange="update_clone_show(<?php echo $i;?>);">
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

	function update_clone_show(counter)
 	{
 		var memberid = $("#memberid_"+counter).val();

 		if($("#show_clone_"+counter).is(':checked'))
 		{
 			var value='1';
 		}
 		else
 		{
 			var value='0';
 		}

 		$.ajax(
		{
			url: "<?php echo site_url('member/update_clone_show/"+memberid+"/"+value+"'); ?>",
			type:'POST', //data type
			dataType : "json",
			success:function(data){
				alert("Data Updated");
			},
			error:function(data){
				alert("Error when Saving");
			}
		});
 	}
</script>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<script src="<?php echo base_url();?>public/js/modernizr.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
