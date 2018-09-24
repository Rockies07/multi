
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Group</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Group</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Group</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span2">
						<select name="assign" id="assign">
							<option value="1">Create New Group</option>
							<option value="2">Assign to Group</option>
						</select>
						<input type="text" name="group_leader" id="group_leader" placeholder="Group Leader NTS" onblur="complete_nts_by_field('group_leader');get_exist_group('group_leader');get_employee_detail_by_field('group_leader');">
						<div class="widget-body">
							<table class="table table-bordered table-primary table-condensed">
								<thead>
									<tr>
										<th class="center" width="20px">S/N</th>
										<th>NTS No.</th>
									</tr>
								</thead>
								<tbody>
									<?php
										for($i=1;$i<=10;$i++)
										{
									?>
											<tr>
												<td class="center" style="vertical-align:middle">
													<?php echo $i;?>
												</td>
												<td class="center">
													<input type="text" name="nts_<?php echo $i;?>" id="nts_<?php echo $i;?>" class="nts_no" placeholder="NTS No." style="width:100px" value="<?php echo set_value('nts_$i');?>" onkeyup="up(this)" onblur="complete_nts('<?php echo $i;?>');get_employee_detail('<?php echo $i;?>');get_exist_group('nts_<?php echo $i;?>');"/>
												</td>
											</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
						<div class="separator bottom"></div>
						<div class="span12 center">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" onclick="return validate();"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
					<div class="span1">
						&nbsp;
					</div>
					<div class="span8">
						<div class="widget-body">
							<table class="table table-bordered table-primary table-condensed">
								<thead>
									<tr>
										<th width="10px">S/N</th>
										<th>Group</th>
										<th>Name</th>
										<th>NTS</th>
										<th width="60px">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=0;
										$group_counter=0;
										foreach ($group as $group_item){
											$i++;
									?>
										<?php
											if($group_item['pos']=='1')
											{
												echo "<tr class='gradeX'>";
										?>
												<td class="center"><a href="#" onclick="show_member('<?php echo $group_item['lev1'];?>')">+</a></td>
										<?php 
											}
											else
											{
												echo "<tr class='gradeX member $group_item[lev1]'>";
										?>
												<td class="center">&nbsp;</td>
										<?php 
											}
													$group_name_arr=explode(" ",$group_item['group_name']);
													$group_name=$group_name_arr[1]." Group";
												?>
												<td><?php echo $group_name; ?></td>
												<td><?php echo $group_item['emp_name']; ?></td>
												<td><?php echo $group_item['nts']; ?></td>
												<td class="center actions">
													<?php echo anchor('employee/delete_group/'.$group_item['id'].'/group', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this employee data?')"));?>
												</td>
											</tr>
									<?php 		
										}
									?>
								</tbody>
							</table>
							<font color="red">** Remove Leader means remove a whole group</font>
						</div>
					</div>
				</div>
			</form>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("employee/group"); ?>';
	}

	function get_employee_detail(counter)
	{
		var value=$("#nts_"+counter).val();
		
		var transaction_date="0000-00-00";
		
		if(value!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('utility/get_employee_detail/"+value+"/"+transaction_date+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					if(data.error)
					{
						alert("NTS No. Not Found");
						$("#nts_"+counter).val('');
						$("#nts_"+counter).focus();
					}
				},
				error:function(data){
					alert("NTS No. Not Found");
				}
			});
		}
	}

	function get_employee_detail_by_field(field)
	{
		var value=$("#"+field).val();
		
		var transaction_date="0000-00-00";
		
		if(value!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('utility/get_employee_detail/"+value+"/"+transaction_date+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					if(data.error)
					{
						alert("NTS No. Not Found");
						$("#"+field).val('');
						$("#"+field).focus();
					}
				},
				error:function(data){
					alert("NTS No. Not Found");
				}
			});
		}
	}

	function get_exist_group(field)
	{
		var value=$("#"+field).val();
		var assign=$("#assign").val();
		
		if(value!="")
		{
			$.ajax(
			{
				url: "<?php echo site_url('utility/get_exist_group/"+value+"'); ?>",
				type:'POST', //data type
				dataType : "json",
				success:function(data){
					if((data.error) && (assign!="2"))
					{
						alert("NTS Worker has inside group");
						$("#"+field).val('');
						$("#"+field).focus();
					}
				},
				error:function(data){
					alert("NTS Worker has inside group");
				}
			});
		}
	}

	$(document).ready(function(){
		hide_member();
	})

	function show_member(group_class)
	{
		$(".member").hide();
		$("."+group_class).show();
	}

	function hide_member()
	{
		$(".member").hide();
	}

	$("#nts_1").bind('keyup blur',function()
	{
		var assign=$("#assign").val();
		if(assign==1)
		{
			$("#group_leader").val($("#nts_1").val());
		}
	});

	function validate()
	{
		var assign=$("#assign").val();
		var group_leader=$("#group_leader").val();

		if((assign=="2")&&(group_leader==""))
		{
			alert("To Assign to Group, Group Leader cannot be Empty");
			return false;
		}
		else
		{
			return true;
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
