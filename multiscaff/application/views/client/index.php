
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Client</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Client</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Client</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Name</div>
							<div class="span8"><input type="text" name="name" placeholder="Name" class="span12"  value="<?php echo (isset($edit_client->name))?$edit_client->name:set_value('name');?>"/></div>
						</div>
						<div class="span12">
							<div class="span2">Contact</div>
							<div class="span8">
								<input type="text" name="phone" placeholder="Contact No." class="span6" maxlength="32" value="<?php echo (isset($edit_client->phone))?$edit_client->phone:set_value('phone');?>"/>
								<input type="text" name="contact_person" placeholder="Contact Person" class="span6" maxlength="32" value="<?php echo (isset($edit_client->contact_person))?$edit_client->contact_person:set_value('contact_person');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_client->id))?$edit_client->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Fax No.</div>
							<div class="span6">
								<input type="text" name="fax" placeholder="Fax No." class="span12" maxlength="32" value="<?php echo (isset($edit_client->fax))?$edit_client->fax:set_value('fax');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Email</div>
							<div class="span7">
								<input type="email" name="email" placeholder="Email" class="span12" maxlength="100" value="<?php echo (isset($edit_client->email))?$edit_client->email:set_value('email');?>"/>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Address</div>
							<div class="span9">
								<input type="text" name="address" placeholder="Address" class="span12" value="<?php echo (isset($edit_client->address))?$edit_client->address:set_value('address');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">City</div>
							<div class="span7">
								<input type="text" name="city" placeholder="City" class="span12" maxlength="100" value="<?php echo (isset($edit_client->city))?$edit_client->city:set_value('city');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">State</div>
							<div class="span7">
								<input type="text" name="state" placeholder="State" class="span12" maxlength="100" value="<?php echo (isset($edit_client->state))?$edit_client->state:set_value('state');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Country</div>
							<div class="span7">
								<input type="text" name="country" placeholder="Country" class="span12" maxlength="100" value="<?php echo (isset($edit_client->country))?$edit_client->country:set_value('country');?>"/>
							</div>
							<div class="span2">
								<input type="text" name="postalcode" placeholder="Postcode" class="span12" maxlength="8" value="<?php echo (isset($edit_client->postalcode))?$edit_client->postalcode:set_value('postalcode');?>"/>
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
			<div class="widget-head"><h4 class="heading">Client List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th>Name</th>
							<th>Contact</th>
							<th>Fax</th>
							<th>Email</th>
							<th>Address</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($client as $client_item){
								$i++;
								$address=$client_item['address'];
								$city=$client_item['city'];
								if($city!="")
								{
									$city=", ".$client_item['city'];
								}
								else
								{
									$city="";
								}
								
								$state=$client_item['state'];
								if($state!="")
								{
									$state=", ".$client_item['state'];
								}
								else
								{
									$state="";
								}
								
								$country=$client_item['country'];
								if($country!="")
								{
									$country=", ".$client_item['country'];
								}
								else
								{
									$country="";
								}
								
								$postalcode=$client_item['postalcode'];
								if($postalcode!="")
								{
									$postalcode=" ".$postalcode;
								}
								else
								{
									$country="";
								}
								$fulladdress=$address."".$city."".$state."".$country."".$postalcode;

								$contact_person=$client_item['contact_person'];
								if($contact_person!="")
								{
									$contact_person=" (".$contact_person.")";
								}
								else
								{
									$contact_person="";
								}
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td><?php echo $client_item['name']; ?></td>
									<td>
										<?php echo $client_item['phone']."".$contact_person; ?>
									</td>
									<td><?php echo $client_item['fax']; ?></td>
									<td><?php echo $client_item['email']; ?></td>
									<td><?php echo $fulladdress; ?></td>
									<td class="center actions">
										<?php echo anchor('client/management/'.$client_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('client/delete/'.$client_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this client data?')"));?>
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
		window.location.href = '<?PHP echo site_url("client/management"); ?>';
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
