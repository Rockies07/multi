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
<div class="separator bottom"></div>

	<div class="widget widget-2 widget-tabs widget-tabs-2 tabs-right border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active"><a class="glyphicons settings" href="#account-settings" data-toggle="tab"><i></i>Account Informations</a></li>
			</ul>
		</div>
	</div>
	<div class="innerLR">
		<?php echo form_open($action,array('class' => 'form-horizontal'));?>
		<div class="tab-content">
			<div class="tab-pane active" id="account-settings">
				<div class="widget widget-2">
					<div class="widget-head">
						<h4 class="heading glyphicons edit"><i></i>Personal details</h4>
					</div>
					<div class="widget-body" style="padding-bottom: 0;">
						<div class="row-fluid">
							<div class="span6">
								<div class="control-group">
									<label class="control-label">Username 用户名</label>
									<div class="controls">
										<input type="text" name='username' value="<?php echo $customer->username;?>" class="span10" />
										<input type="hidden" name='edit_id' value="<?php echo $customer->id;?>" class="span10" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">First name 姓</label>
									<div class="controls">
										<input type="text" name='first_name' value="<?php echo $customer->first_name;?>" class="span10" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Last name 名</label>
									<div class="controls">
										<input type="text" name='last_name' value="<?php echo $customer->last_name;?>" class="span10" />
									</div>
								</div>
							</div>
							<div class="span6">
								<div class="control-group">
									<label class="control-label">Level 级别 </label>
									<div class="controls">
										<input type="text" name='level' value="<?php echo $customer->level;?>" class="input-mini" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Call Status 通话状态</label>
									<div class="controls">
										<select class="span6" name='call_status' >
											<?php 
												if($customer->call_status!='')
												{
											?>
													<option value='<?php echo $customer->call_status;?>'><?php echo $customer->call_status;?></option>
											<?php
												}
												else
												{
											?>
													<option value=''>-- Select --</option>
											<?php
												}
											?>
											
											<option value="通话状态">通话状态</option>
											<option value="通话中">通话中</option>
											<option value="空号">空号</option>
											<option value="关机">关机</option>
											<option value="稍后再拨">稍后再拨</option>
											<option value="没兴趣">没兴趣</option>
											<option value="有兴趣">有兴趣</option>
										</select>
									</div>
								</div>
								
							</div>
						</div>

					</div>
			
			
						<hr class="separator bottom" />
						<div class="row-fluid">
							<div class="span2">
								<strong>Contact details</strong>
							</div>
							<div class="span9">
								<div class="row-fluid">
								<div class="span6">
									<label for="inputPhone">Phone 手机号码</label>
									<div class="input-prepend">
										<span class="add-on glyphicons phone"><i></i></span>
										<input type="text" name='phone' value="<?php echo $customer->phone;?>" id="inputPhone" class="input-large" placeholder="01234567897" />
									</div>
									<div class="separator"></div>
										
									<label for="inputEmail">E-mail 邮件</label>
									<div class="input-prepend">
										<span class="add-on glyphicons envelope"><i></i></span>
										<input type="text" name='email' value="<?php echo $customer->email;?>" id="inputEmail" class="input-large" placeholder="contact@mosaicpro.biz" />
									</div>
									<div class="separator"></div>
										
									<label for="inputWebsite">Wechat ID 微信号</label>
									<div class="input-prepend">
										<span class="add-on glyphicons link"><i></i></span>
										<input type="text" id="inputWebsite" name='wechat_id' class="input-large" placeholder="humsome_man" value="<?php echo $customer->wechat_id;?>"/>
									</div>
									<div class="separator"></div>
									
									
									<div class="row-fluid">
									<label for="inputWebsite">Remarks 其他备注</label>
										<div>
											<textarea id="mustHaveId" name='remark' class="wysihtml5 span12" rows="5"><?php echo $customer->remark;?></textarea>
										</div>
									</div>								
									<div class="separator"></div>

								</div>
								<div class="span6">
									<label for="inputFacebook">QQ ID QQ号</label>
									<div class="input-prepend">
										<span class="add-on glyphicons facebook"><i></i></span>
										<input type="text" id="inputFacebook" name='qq_id' value="<?php echo $customer->qq_id;?>" class="input-large" placeholder="123456789" />
									</div>
									<div class="separator"></div>

									<label for="inputFacebook">Notification Method</label>
										<?php 
											if(strtoupper($customer->notification)=='MESSAGE')
											{
												$is_message="checked";
												$is_email="";
											}
											else
											{
												$is_message="";
												$is_email="checked";
											}
										?>
										<input type="radio" name="notification" value="email" <?php echo $is_email;?>/>
										<div style='margin-top: 3px;display: inline-block;vertical-align: middle;'>&nbsp;&nbsp;&nbsp;Email</div>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="notification" value="message" <?php echo $is_message;?> />
										<div style='margin-top: 3px;display: inline-block;vertical-align: middle;'>&nbsp;&nbsp;&nbsp;Message</div>
									
									<div class="separator"></div>
								</div>							
								<div class="separator"></div>
									<div class="separator"></div>
								</div>			
							</div>	
						</div>
						<div class="form-actions" style="margin: 0; padding-right: 0;">
							<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok pull-right"><i></i>Save changes</button>
							<button type="button" class="btn btn-icon btn-default glyphicons circle_remove"><i></i>Cancel</button>
							
						</div>
					</div>
				</div>
				
			</div>
		</div>
		</form>
		
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
