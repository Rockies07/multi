<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />
				
<style>
.passport,.work_permit,.airport_pass,.user_detail,.compulsory_course,.basic_course,.low_levy_course{
	display: none;
}

#table_container{
	overflow:scroll;
}
</style>

<div id="content">
	<div class="se-pre-con"></div>
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>User Management</li>
		<li class="divider"></li>
		<li>User</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<?php
					if($edit_user->id!=0)
					{
				?>	
						<h4 class="heading">Edit User</h4>
				<?php 
					}
					else
					{
				?>
						<h4 class="heading">Add User</h4>
				<?php 
					}
				?>
			</div>
			<?php echo form_open($action)?>
				<div class="widget widget-tabs-icons-only">
					<div class="separator"></div>
					<!-- Widget Heading -->
						<div class="row-fluid well">
							<div class="span6" style="height:200px;">
								<div class="separator"></div>
								<div class="span12">
									<div class="span3">Username</div>
									<div class="span8">
										<input type="text" name="username" placeholder="Username" class="span6" maxlength="30" value="<?php echo (isset($edit_user->username))?$edit_user->username:set_value('username');?>"/>
										<input type="hidden" name="edit_id" value="<?php echo (isset($edit_user->id))?$edit_user->id:'0';?>"/>
									</div>
								</div>
								<div class="span12">
									<div class="span3">Password</div>
									<div class="span8"><input type="password" name="password" placeholder="Password" class="span6"  value="<?php echo (isset($edit_user->password))?$edit_user->password:set_value('password');?>"/></div>
								</div>
								<div class="span12">
									<div class="span3">Status</div>
									<div class="span4">
										<select class="selectpicker span8" name="status" id="status" onchange="show_hl_date();">
											<?php 
												if(isset($edit_user->status))
												{
													
											?>
													<option value="<?php echo $edit_user->status;?>"><?php echo $edit_user->status;?></option>
											<?php 
												}
											?>
											<option value="Active" <?php echo set_select('status', 'Active'); ?>>Active</option>
											<option value="Suspend" <?php echo set_select('status', 'Suspend'); ?>>Suspend</option>
											<option value="Blocked" <?php echo set_select('status', 'Blocked'); ?>>Blocked</option>
										</select>
									</div>
								</div>
							</div>
							<div class="span6">
								<div class="separator"></div>
								<div class="span12">
									<div class="span12"><b><u>User Permission</u></b></div>
								</div>
								<div class="span12">
									<div class="span3">Admin</div>
									<div class="span3">
										<?php
											$is_checked=$edit_user->is_admin;
											if($is_checked=="1")
											{
												$set_checked="checked";
											}
											else
											{
												$set_checked="";
											}
										?>
										<input type="checkbox" name="is_admin" value="1" <?php echo $set_checked;?>/>
									</div>
								</div>
							</div>
							<div class="span10">	
								<hr class="separator" />
							</div>
							<div class="span12">
								<div class="span10 center">
									<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
									<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Back to User List</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("user/management"); ?>';
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

	$(function() {
		$("#dob").datepicker({
			showOn: 'both', 
			buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
			buttonImageOnly: true,
			changeMonth: true,
	      	changeYear: true,
	      	yearRange: '-50:+1'
		});
	});

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
