<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/jquery.ui.theme.css" type="text/css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/css/loading.css" />
			
<style>
.ui-datepicker-trigger{
    top: -5px;
    position: relative;
}

.ui-autocomplete { max-height: 300px; overflow-y: auto; overflow-x: hidden;}

</style>	

<div id="content">
	<div class="se-pre-con"></div>
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Setting</li>
		<li class="divider"></li>
		<li>Company Profile</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Setting</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Company Profile</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="span6" style="margin-left: 0px; width: 602px;">
					<div class="row-fluid well" style="min-height: 544px;">
						<div class="separator" style="padding: 2px 0;"></div>
						<div class="span12"><b><u>Particular Detail</u></b></div>
						<div class="span12">
							<div class="span3">Name</div>
							<div class="span6">
								<input type="text" name="name" placeholder="Company Name" class="span12" value="<?php echo (isset($edit_company->name))?$edit_company->name:$company->name;?>" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Licensee</div>
							<div class="span6">
								<input type="text" name="licensee" placeholder="Licensee" class="span12" maxlength="50" value="<?php echo (isset($edit_company->licensee))?$edit_company->licensee:$company->licensee;?>" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Licence No.</div>
							<div class="span6">
								<input type="text" name="licence_no" placeholder="Licence No." class="span6" maxlength="32" value="<?php echo (isset($edit_company->licence_no))?$edit_company->licence_no:$company->licence_no;?>" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Designation</div>
							<div class="span6">
								<input type="text" name="designation" placeholder="Designation" class="span10" maxlength="50" value="<?php echo (isset($edit_company->designation))?$edit_company->designation:$company->designation;?>" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Reference No.</div>
							<div class="span6">
								<input type="text" name="referenceno" placeholder="Reference No." class="span8" maxlength="20" value="<?php echo (isset($edit_company->referenceno))?$edit_company->referenceno:$company->referenceno;?>" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Phone No.</div>
							<div class="span6">
								<input type="text" name="phoneno" placeholder="Phone No." class="span5" maxlength="15" value="<?php echo (isset($edit_company->phoneno))?$edit_company->phoneno:$company->phoneno;?>" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Address</div>
							<div class="span8">
								<input type="text" name="postalcode" id="postalcode" placeholder="Postal Code" class="span3" maxlength="6" value="<?php echo (isset($edit_company->postalcode))?$edit_company->postalcode:$company->postalcode;?>" onkeypress="return isNumberKey(event)"/>
								<select name="buildingnumber" id="buildingnumber" style="width:60px">
									<option value="<?php echo $company->buildingnumber;?>"><?php echo $company->buildingnumber;?></option>	
								</select>
								<input type="text" name="unit" id="unit" placeholder="Unit" class="span3" maxlength="8" value="<?php echo (isset($edit_company->unit))?$edit_company->unit:$company->unit;?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">&nbsp;</div>
							<div class="span8">
								<input type="text" name="streetname" id="streetname" placeholder="Street Name" class="span12" value="<?php echo (isset($edit_company->streetname))?$edit_company->streetname:$company->streetname;?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">&nbsp;</div>
							<div class="span8">
								<input type="text" name="buildingname" id="buildingname" placeholder="Building Name" class="span12" value="<?php echo (isset($edit_company->buildingname))?$edit_company->buildingname:$company->buildingname;?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span3">Website</div>
							<div class="span6">
								<input type="text" name="website" placeholder="Website" class="span12" maxlength="50" value="<?php echo (isset($edit_company->website))?$edit_company->website:$company->website;?>" />
							</div>
						</div>
						<div class="span12">
							<div class="span3">Email</div>
							<div class="span6">
								<input type="text" name="email" placeholder="Email" class="span12" maxlength="50" value="<?php echo (isset($edit_company->email))?$edit_company->email:$company->email;?>" />
							</div>
						</div>
						<div class="span10">	
							<hr class="separator" />
						</div>
						<div class="span12">
							<div class="span10 center">
								<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" tabindex="13"><i></i>Save</button>
								<?php 
									if($edit_id=='0')
									{
								?>
										<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
								<?php 
									}
									else
									{
								?>
										<button class="btn btn-icon btn-default glyphicons refresh"><i></i>Cancel</button>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="span8" style="padding-left:20px;">
					<div class="tabsbar tabsbar-2">
						<ul class="row-fluid row-merge">
							<li class="span3 glyphicons circle_info active"><a href="#setting_fee" data-toggle="tab"><i></i> Fee</a></li>
							<li class="span3 glyphicons cargo" style="margin-left: 0px;"><a href="#setting_general" data-toggle="tab"><i></i> General</a></li>
							<li class="span3 glyphicons circle_info" style="margin-left: 0px;"><a href="#setting_numbering" data-toggle="tab"><i></i> Numbering</a></li>
							<li class="span3 glyphicons circle_info" style="margin-left: 0px;"><a href="#setting_column" data-toggle="tab"><i></i> Grid Column</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane active" id="setting_fee">
							<div class="widget-body">
								<div class="tab-content">
									<div class="tab-pane active" style="padding:0;">
										<div class="row-fluid well" style="min-height: 492px;">
											<div class="span11">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12"><b><u>Interest</u></b></div>
												<?php
													if($setting_content->interest_amt)
													{
												?>
														<div class="span12">
															<div class="span2">Interest($)</div>
															<div class="span8">
																<div class="span10 input-prepend">
																	<span class="add-on">$</span>
																	<input id="prependedInput" class="span4 right" name="interest_amt_value" type="text" placeholder="Interest($)" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo $content->interest_amt_value;?>" />
																</div>
															</div>
														</div>
												<?php
													}
													else
													{
												?>
														<div class="span12">
															<div class="span2">Interest p.a</div>
															<div class="span8">
																<div class="span10 input-append">
																	<input class="span4" name="interest_rate_value" type="text" placeholder="Interest p.a" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo $content->interest_rate_value;?>" />
																	<span class="add-on">%</span>
																</div>
															</div>
														</div>
												<?php
													}
												?>
												<div class="span12">
													<div class="span2">Late Interest</div>
													<div class="span8">
														<div class="span10 input-append">
															<input class="span4 right" name="late_interest_value" type="text" placeholder="Late Interest" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo $content->late_interest_value;?>" />
															<span class="add-on">%</span>
														</div>
													</div>
												</div>
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0;"><b><u>Fee</u></b></div>
												<div class="span12">
													<div class="span2">Fee Name</div>
													<div class="span8">
														<input type="text" name="fee_name" placeholder="Fee Name" class="span8" value="<?php echo (isset($edit_fee_setting->fee_name))?$edit_fee_setting->fee_name:$edit_fee->fee_name;?>"/>
														<input type="text" name="fee_value" placeholder="Value" class="span4" value="<?php echo (isset($edit_fee_setting->fee_value))?$edit_fee_setting->fee_value:$edit_fee->fee_value;?>"/>
														<input type="hidden" name="edit_id" class="span4" value="<?php echo $edit_id;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span2">Category</div>
													<div class="span7">
														<select class="span4" name="fee_category" id="fee_category">
															<?php 
																if(isset($edit_fee->fee_category))
																{
															?>
																	<option value="<?php echo $edit_fee->fee_category;?>"><?php echo $edit_fee->fee_category;?></option>
															<?php 
																}
																else
																{
															?>	
																	<option value="General">General</option>
															<?php
																}
															?>
															<option value="General">General</option>
															<option value="Enforcement">Enforcement</option>
														</select> 
														<select class="span3" name="fee_calculation_type" id="fee_calculation_type">
															<?php 
																if(isset($edit_fee->fee_calculation_type))
																{
															?>
																	<option value="<?php echo $edit_fee->fee_calculation_type;?>"><?php echo $edit_fee->fee_calculation_type;?></option>
															<?php 
																}
																else
																{
															?>	
																	<option value="Dollar">Dollar</option>
															<?php
																}
															?>
															<option value="Dollar">Dollar</option>
															<option value="Percent">Percent</option>
														</select> 
														<select class="span5" name="fee_deduction_term" id="fee_deduction_term">
															<?php 
																if(isset($edit_fee->fee_deduction_term))
																{
															?>
																	<option value="<?php echo $edit_fee->fee_deduction_term;?>"><?php echo $edit_fee->fee_deduction_term;?></option>
															<?php 
																}
																else
																{
															?>	
																	<option value="Per Occassion">Per Occassion</option>
															<?php
																}
															?>
															<option value="Per Occassion">Per Occassion</option>
															<option value="Per Month">Per Month</option>
															<option value="Per Week">Per Week</option>
															<option value="Per Daily">Per Daily</option>
														</select> 
													</div>
												</div>
												<div class="span12">
													<div class="span2">Description</div>
													<div class="span8">
														<input type="text" name="fee_description" placeholder="Description" class="span12" value="<?php echo (isset($edit_fee_setting->fee_description))?$edit_fee_setting->fee_description:$edit_fee->fee_description;?>"/>
													</div>
												</div>
												<div class="span12" style="padding-top:10px">
													<div class="span10 center">
														<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok" tabindex="13"><i></i>Save</button>
														<?php 
															if($edit_id=='0')
															{
														?>
																<button type="reset" class="btn btn-icon btn-default glyphicons circle_remove" onclick="reload()"><i></i>Clear</button>
														<?php 
															}
															else
															{
														?>
																<button class="btn btn-icon btn-default glyphicons refresh"><i></i>Cancel</button>
														<?php
															}
														?>
													</div>
												</div>
												<div class="span10">	
													<hr class="separator" />
												</div>
												<div class="span12" style="padding-top:10px"><b><u>Fee Detail</u></b></div>
												<div class="span12">
													<ul>
														<?php
															foreach ($fee as $fee_item)
															{
														?>
																<li style="padding: 8px 0">
																	<b>
																		<?php echo $fee_item['fee_name'];?>
																	</b>
																	: 
																	<?php 
																		if($fee_item['fee_calculation_type']=="Dollar")
																		{
																			$fee_percent="";
																			$fee_dollar="$";
																		}								
																		else
																		{
																			$fee_percent="%";
																			$fee_dollar="";
																		}	
																		echo $fee_dollar."".$fee_item['fee_value']."".$fee_percent." - ".$fee_item['fee_deduction_term']."&nbsp;&nbsp;&nbsp;";
																		echo anchor('setting/management/'.$fee_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'))."&nbsp;&nbsp;&nbsp;";
																		echo anchor('setting/delete_setting/mdm_company_setting_fee/'.$fee_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this Fee?')"));
																	?>
																</li>
														<?php
															}
														?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="setting_general">
							<div class="widget-body">
								<div class="tab-content">
									<div class="tab-pane active" style="padding:0;">
										<div class="row-fluid well" style="min-height: 492px;">
											<div class="span5" style="margin-left:20px">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Transaction Share</u></b></div>
												<div class="span12">
													<div class="span7">Share by Employee</div>
													<div class="span3">
														<?php
															$is_checked=$content->share_transaction_personal;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="share_transaction_personal" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Share by Team</div>
													<div class="span3">
														<?php
															$is_checked=$content->share_transaction_team;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="share_transaction_team" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Share by Level</div>
													<div class="span3">
														<?php
															$is_checked=$content->share_transaction_level;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="share_transaction_level" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Accounts Share</u></b></div>
												<div class="span12">
													<div class="span7">Share by Employee</div>
													<div class="span3">
														<?php
															$is_checked=$content->share_paymentmode_personal;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="share_paymentmode_personal" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Share by Team</div>
													<div class="span3">
														<?php
															$is_checked=$content->share_paymentmode_team;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="share_paymentmode_team" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Share by Level</div>
													<div class="span3">
														<?php
															$is_checked=$content->share_paymentmode_level;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="share_paymentmode_level" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Content</u></b></div>
												<div class="span12">
													<div class="span7">Loan Plan</div>
													<div class="span3">
														<?php
															$is_checked=$content->loanplan;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="loanplan" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Letter of Demand</div>
													<div class="span3">
														<?php
															$is_checked=$content->letterofdemand;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="letterofdemand" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Consent Letter</div>
													<div class="span3">
														<?php
															$is_checked=$content->consentletter;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="consentletter" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Term & Condition</div>
													<div class="span3">
														<?php
															$is_checked=$content->termandcondition;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="termandcondition" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Appointment Letter</div>
													<div class="span3">
														<?php
															$is_checked=$content->appointmentletter;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="appointmentletter" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Discharge Letter</div>
													<div class="span3">
														<?php
															$is_checked=$content->dischargeletter;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="dischargeletter" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0">&nbsp;</div>
												<div class="span12">
													<div class="span7">Variation Plan</div>
													<div class="span3">
														<?php
															$is_checked=$content->variation_plan;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="variation_plan" value="1"  <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Readonly Receipt</div>
													<div class="span3">
														<?php
															$is_checked=$content->readonly_receipt;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="readonly_receipt" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Email Required</div>
													<div class="span3">
														<?php
															$is_checked=$content->email_requirement;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="email_requirement" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Contact Required</div>
													<div class="span3">
														<?php
															$is_checked=$content->contact_requirement;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="contact_requirement" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Referral</div>
													<div class="span3">
														<?php
															$is_checked=$content->referral;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="referral" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Blocked User</div>
													<div class="span3">
														<?php
															$is_checked=$content->variation_plan;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="variation_plan" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Fee Display</u></b></div>
												<div class="span12">
													<div class="span7">Interest by Amount</div>
													<div class="span3">
														<?php
															$is_checked=$content->interest_amt;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="interest_amt" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">General Fee</div>
													<div class="span3">
														<?php
															$is_checked=$content->show_general_fee;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="show_general_fee" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Enforcement Fee</div>
													<div class="span3">
														<?php
															$is_checked=$content->show_enforcement_cost;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="show_enforcement_cost" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="setting_numbering">
							<div class="widget-body">
								<div class="tab-content">
									<div class="tab-pane active" style="padding:0;">
										<div class="row-fluid well" style="min-height: 492px;">
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12"><b><u>Loan Numbering</u></b></div>
												<div class="span12">
													<div class="span4">Auto Generate</div>
													<div class="span3">
														<?php
															$is_checked=$numbering->loanno_auto_generate;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="loanno_auto_generate" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Prefix</div>
													<div class="span7">
														<input type="text" name="loanno_prefix" placeholder="Prefix" class="span8" value="<?php echo (isset($edit_numbering->loanno_prefix))?$edit_numbering->loanno_prefix:$numbering->loanno_prefix;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Suffix</div>
													<div class="span7">
														<input type="text" name="loanno_suffix" placeholder="Suffix" class="span8" value="<?php echo (isset($edit_numbering->loanno_suffix))?$edit_numbering->loanno_suffix:$numbering->loanno_suffix;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Width</div>
													<div class="span7">
														<input type="text" name="loanno_width" placeholder="Width" class="span8" value="<?php echo (isset($edit_numbering->loanno_width))?$edit_numbering->loanno_width:$numbering->loanno_width;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Start</div>
													<div class="span7">
														<input type="text" name="loanno_start" placeholder="Start" class="span8" value="<?php echo (isset($edit_numbering->loanno_start))?$edit_numbering->loanno_start:$numbering->loanno_start;?>"/>
													</div>
												</div>
											</div>
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12"><b><u>Receipt Numbering</u></b></div>
												<div class="span12">
													<div class="span4">Auto Generate</div>
													<div class="span3">
														<?php
															$is_checked=$numbering->receiptno_auto_generate;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="receiptno_auto_generate" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Prefix</div>
													<div class="span7">
														<input type="text" name="receiptno_prefix" placeholder="Prefix" class="span8" value="<?php echo (isset($edit_numbering->receiptno_prefix))?$edit_numbering->receiptno_prefix:$numbering->receiptno_prefix;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Suffix</div>
													<div class="span7">
														<input type="text" name="receiptno_suffix" placeholder="Suffix" class="span8" value="<?php echo (isset($edit_numbering->receiptno_suffix))?$edit_numbering->receiptno_suffix:$numbering->receiptno_suffix;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Width</div>
													<div class="span7">
														<input type="text" name="receiptno_width" placeholder="Width" class="span8" value="<?php echo (isset($edit_numbering->receiptno_width))?$edit_numbering->receiptno_width:$numbering->receiptno_width;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Start</div>
													<div class="span7">
														<input type="text" name="receiptno_start" placeholder="Start" class="span8" value="<?php echo (isset($edit_numbering->receiptno_start))?$edit_numbering->receiptno_start:$numbering->receiptno_start;?>"/>
													</div>
												</div>
											</div>
											<div class="span5" style="margin:0; padding-top: 10px;">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12"><b><u>Invoice Numbering</u></b></div>
												<div class="span12">
													<div class="span4">Auto Generate</div>
													<div class="span3">
														<?php
															$is_checked=$numbering->accno_auto_generate;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="accno_auto_generate" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Prefix</div>
													<div class="span7">
														<input type="text" name="accno_prefix" placeholder="Prefix" class="span8" value="<?php echo (isset($edit_numbering->accno_prefix))?$edit_numbering->accno_prefix:$numbering->accno_prefix;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Suffix</div>
													<div class="span7">
														<input type="text" name="accno_suffix" placeholder="Suffix" class="span8" value="<?php echo (isset($edit_numbering->accno_suffix))?$edit_numbering->accno_suffix:$numbering->accno_suffix;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Width</div>
													<div class="span7">
														<input type="text" name="accno_width" placeholder="Width" class="span8" value="<?php echo (isset($edit_numbering->accno_width))?$edit_numbering->accno_width:$numbering->accno_width;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Start</div>
													<div class="span7">
														<input type="text" name="accno_start" placeholder="Start" class="span8" value="<?php echo (isset($edit_numbering->accno_start))?$edit_numbering->accno_start:$numbering->accno_start;?>"/>
													</div>
												</div>
											</div>
											<div class="span5" style="padding-top: 10px;">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12"><b><u>General Numbering</u></b></div>
												<div class="span12">
													<div class="span4">Interest Limit</div>
													<div class="span7">
														<input type="text" name="interest_limit" placeholder="Interest Limit" class="span8" value="<?php echo (isset($edit_content->interest_limit))?$edit_content->interest_limit:$content->interest_limit;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Income Limit</div>
													<div class="span7">
														<input type="text" name="income_limit" placeholder="Income Limit" class="span8" value="<?php echo (isset($edit_content->income_limit))?$edit_content->income_limit:$content->income_limit;?>"/>
													</div>
												</div>
												<div class="span12">
													<div class="span4">Decimal No.</div>
													<div class="span7">
														<input type="text" name="dec_rounding" placeholder="Decimal No." class="span8" value="<?php echo (isset($edit_content->dec_rounding))?$edit_content->dec_rounding:$content->dec_rounding;?>"/>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="setting_column">
							<div class="widget-body">
								<div class="tab-content">
									<div class="tab-pane active" style="padding:0;">
										<div class="row-fluid well" style="min-height: 492px;">
											<!-- <div class="span12" style="margin-left:8px">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span2">Row Per Page</div>
												<div class="span2">
													<input type="text" name="row_per_page" placeholder="Row" class="span8" maxlength="3" value="<?php echo (isset($edit_grid->row_per_page))?$edit_grid->row_per_page:$grid->row_per_page;?>"/>
												</div>
											</div> -->
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Daily Collection</u></b></div>
												<div class="span12">
													<div class="span7">Contact</div>
													<div class="span3">
														<?php
															$is_checked=$grid->loan_daily_contact;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="loan_daily_contact" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Address</div>
													<div class="span3">
														<?php
															$is_checked=$grid->loan_daily_address;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="loan_daily_address" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Client List</u></b></div>
												<div class="span12">
													<div class="span7">Contact</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_client_contact;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_client_contact" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Address</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_client_address;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_client_address" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Income P.a</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_client_incomepa;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_client_incomepa" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Loan Date</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_client_loan_date;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_client_loan_date" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Employee ID</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_client_employee_id;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_client_employee_id" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Principal</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_client_balance_principal;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_client_balance_principal" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Interest</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_client_balance_interest;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_client_balance_interest" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Bad Debt</u></b></div>
												<div class="span12">
													<div class="span7">Contact</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_contact;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_contact" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Address</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_address;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_address" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Principal</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_balance_principal;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_balance_principal" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Interest</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_balance_interest;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_balance_interest" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
											<div class="span5">
												<div class="separator" style="padding: 2px 0; margin-left: 10px;"></div>
												<div class="span12" style="padding:10px 0"><b><u>Bad Debt Reinstate</u></b></div>
												<div class="span12">
													<div class="span7">Contact</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_reinstate_contact;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_reinstate_contact" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Address</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_reinstate_address;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_reinstate_address" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Principal</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_reinstate_balance_principal;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_reinstate_balance_principal" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
												<div class="span12">
													<div class="span7">Interest</div>
													<div class="span3">
														<?php
															$is_checked=$grid->profile_baddebt_reinstate_balance_interest;
															if($is_checked=="1")
															{
																$set_checked="checked";
															}
															else
															{
																$set_checked="";
															}
														?>
														<input type="checkbox" name="profile_baddebt_reinstate_balance_interest" value="1" <?php echo $set_checked;?>/>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="separator"></div>
		</div>
	</div>
	
<script>
	function reload(){
		window.location.href = '<?PHP echo site_url("loan/add"); ?>';
	}

	$(function() {
		$(".datetimepicker").datepicker({
			showOn: 'both', 
			buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
			buttonImageOnly: true,
			changeMonth: true,
	      	changeYear: true,
		});

		$(".dob").datepicker({
			showOn: 'both', 
			buttonImage: '<?php echo base_url();?>public/images/icon/calendar.gif', 
			buttonImageOnly: true,
			changeMonth: true,
	      	changeYear: true,
	      	minDate: "-70Y",
	      	maxDate: "-18Y",
		});

		$("#borrower_code").autocomplete({
			source: "<?php echo site_url('loan/get_borrower_by_code/code'); ?>" // path to the get_birds method
	  	});

	  	$("#borrower_name").autocomplete({
			source: "<?php echo site_url('loan/get_borrower_by_code/name'); ?>" // path to the get_birds method
	  	});

	  	$("#borrower_code").blur(function(){
	  		var value=$("#borrower_code").val();

	  		$.ajax({
	 			type: "POST",
	 			dataType : "json",
	 			url: "<?php echo site_url('loan/get_borrower_detail/code/"+value+"'); ?>", //here we are calling our user controller and get_borrower_detail method with the country_id
	 			success: function(data) //we're calling the response json array 'cities'
	 			{
	 				var opt = $('<option />'); // here we're creating a new select option with for each city
					opt.val(value_selected);
					opt.text(text_selected);
					$('#site').append(opt);

	 				$.each(data,function(id,text) //here we're doing a foeach loop round each city with id as the key and city as the value
	 				{
	 					var opt = $('<option />'); // here we're creating a new select option with for each city
						opt.val(id);
						opt.text(text);
	 					$('#site').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
	 				});
	 			}
			});
	  	});
	});

	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>

<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>



