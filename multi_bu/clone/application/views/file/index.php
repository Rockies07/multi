<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />

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
						<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
							<thead>
								<tr>
									<th class="center" style="vertical-align:middle" width="20px">S/N</th>
									<th style="vertical-align:middle;">File Name</th>
									<th style="vertical-align:middle; width:100px">Size(byte)</th>
									<th style="vertical-align:middle; width:200px">Assign To:</th>
									<th style="vertical-align:middle; width:100px">Status</th>
									<th style="vertical-align:middle; width:100px">Progress</th>
									<th style="vertical-align:middle;">Upload Date</th>
									<th style="vertical-align:middle; width:60px">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i=0;
									foreach($file as $file_item)
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
													echo $file_item['name'];
												?>
												<input type="hidden" id="file_<?php echo $i;?>" value="<?php echo $file_item['file_id'];?>">
											</td>
											<td class="center">
												<?php
													echo $file_item['size'];
												?>
											</td>
											<td class="center">
												<select name='user_id' id='user_id_<?php echo $i;?>'>
													<?php 
														if($file_item['user_id']!='')
														{
													?>
															<option value='<?php echo $file_item['user_id'];?>'><?php echo $file_item['username'].' - '.$file_item['user_name'];?></option>
													<?php
														}
														else
														{
													?>
															<option value=''>-- Select --</option>
													<?php
														}

														foreach ($user as $user_item)
														{
													?>
															<option value='<?php echo $user_item['id'];?>'><?php echo $user_item['username'].' - '.$user_item['name'];?></option>
													<?php
														}
													?>
												</select>
											</td>
											<td class="center">
												<?php
													echo $file_item['status'];
												?>
											</td>
											<td class="center">
												<?php
													echo $file_item['total_done'].'/'.$file_item['total_row'];
												?>
											</td>
											<td class="center">
												<?php
													echo date('d M Y',strtotime($file_item['createdate']));
												?>
											</td>
											<td class="center" style="vertical-align:middle" width="60px">
												<a href="#" class="btn-action glyphicons pencil btn-success" onclick="assign_user(<?php echo $i;?>);"><i></i></a>
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
	function assign_user(counter){
		var file_id=$("#file_"+counter).val();
		var user_id=$("#user_id_"+counter).val();

		if(file_id!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('file/assign_user/"+file_id+"/"+user_id+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					alert('Data submitted');
				},
				error:function(data){
					alert("Data not found");
				}
			});
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
