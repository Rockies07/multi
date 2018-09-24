
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>User Management</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>User</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add User</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Username</div>
							<div class="span8"><input type="text" name="username" placeholder="Username" class="span10"  value="<?php echo (isset($edit_user->username))?$edit_user->username:set_value('username');?>" maxlength="50"/></div>
						</div>
						<div class="span12">
							<div class="span2">Password</div>
							<div class="span8">
								<input type="text" name="password" placeholder="Password" class="span12"  value="<?php echo (isset($edit_user->password))?$edit_user->password:set_value('password');?>" maxlength="64"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Name</div>
							<div class="span8">
								<input type="text" name="name" placeholder="Name" class="span12"  value="<?php echo (isset($edit_user->name))?$edit_user->name:set_value('name');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_user->id))?$edit_user->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Phone</div>
							<div class="span8">
								<input type="text" name="phone" placeholder="Phone" class="span6" maxlength="32" value="<?php echo (isset($edit_user->phone))?$edit_user->phone:set_value('phone');?>"/>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Position</div>
							<div class="span9">
								<select name="position" class="selectpicker" data-live-search="true">
									<?php 
										if(isset($edit_user->position))
										{
											switch($edit_user->position)
											{
												case "1": $position_text="Staff"; break;
												case "2": $position_text="Supervisor"; break;
												case "3": $position_text="Manager"; break;
												case "4": $position_text="Sub Admin"; break;
												default : $position_text="Staff"; break;	
											}
									?>
											<option value="<?php echo $edit_user->position;?>"><?php echo $position_text;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">-Select-</option>
									<?php
										}
									?>
									<option value="1">Staff</option>
									<option value="2">Supervisor</option>
									<option value="3">Manager</option>
									<option value="4">Sub Admin</option>
								</select>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Department</div>
							<div class="span7">
								<select name="department" class="selectpicker" data-live-search="true">
									<?php 
										if(isset($edit_user->department))
										{
											
									?>
											<option value="<?php echo $edit_user->department;?>"><?php echo $edit_user->department;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">-Select-</option>
									<?php
										}
									?>
									<?php
										foreach ($department as $department_item){
									?>
											<option value="<?php echo $department_item['name'];?>" <?php echo set_select('department', $department_item['name']); ?>><?php echo $department_item['name'];?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="span10">	
						<hr class="separator" />
					</div>
					<div class="span12">
						<div class="span10 center">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
							<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
						</div>
					</div>
				</div>
			</form>
			<div class="separator"></div>
			<div class="widget-head"><h4 class="heading">User List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th width="180px">Username</th>
							<th width="100px" class="center">Password</th>
							<th>Name</th>
							<th width="180px" class="center">Phone</th>
							<th width="130px">Position</th>
							<th width="180px">Department</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($user as $user_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td><?php echo $user_item['username']; ?></td>
									<td class="center">
										&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;
									</td>
									<td><?php echo $user_item['name']; ?></td>
									<td class="center"><?php echo $user_item['phone']; ?></td>
									<td>
										<?php 
											switch($user_item['position'])
											{
												case "1": $position_text="Staff"; break;
												case "2": $position_text="Supervisor"; break;
												case "3": $position_text="Manager"; break;
												case "4": $position_text="Sub Admin"; break;
												default : $position_text="Staff"; break;	
											}
											echo $position_text; 
										?>
									</td>
									<td><?php echo $user_item['department']; ?></td>
									<td class="center actions">
										<?php echo anchor('user/management/'.$user_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('user/delete/'.$user_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this user data?')"));?>
									</td>
								</tr>
						<?php 
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("user/management"); ?>';
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
