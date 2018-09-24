
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Supplier</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Supplier</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Supplier</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Name</div>
							<div class="span8"><input type="text" name="name" placeholder="Name" class="span12"  value="<?php echo (isset($edit_supplier->name))?$edit_supplier->name:set_value('name');?>"/></div>
						</div>
						<div class="span12">
							<div class="span2">Contact</div>
							<div class="span8">
								<input type="text" name="phone" placeholder="Contact No." class="span6" maxlength="32" value="<?php echo (isset($edit_supplier->phone))?$edit_supplier->phone:set_value('phone');?>"/>
								<input type="text" name="contact_person" placeholder="Contact Person" class="span6" maxlength="32" value="<?php echo (isset($edit_supplier->contact_person))?$edit_supplier->contact_person:set_value('contact_person');?>"/>
								<input type="hidden" name="edit_id" value="<?php echo (isset($edit_supplier->id))?$edit_supplier->id:'0';?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Fax No.</div>
							<div class="span6">
								<input type="text" name="fax" placeholder="Fax No." class="span12" maxlength="32" value="<?php echo (isset($edit_supplier->fax))?$edit_supplier->fax:set_value('fax');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Email</div>
							<div class="span7">
								<input type="email" name="email" placeholder="Email" class="span12" maxlength="100" value="<?php echo (isset($edit_supplier->email))?$edit_supplier->email:set_value('email');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Credit Term</div>
							<div class="span7">
								<select name="credit_term" class="selectpicker" data-live-search="true">
									<?php 
										if(isset($edit_supplier->credit_term))
										{
											
									?>
											<option value="<?php echo $edit_supplier->credit_term;?>"><?php echo $edit_supplier->credit_term;?></option>
									<?php 
										}
										else
										{
									?>	
											<option value="">-Select-</option>
									<?php
										}
									?>
									<option value="COD">COD</option>
									<option value="Weekly">Weekly</option>
									<option value="B/Weekly">B/Weekly</option>
									<option value="Monthly">Monthly</option>
									<option value="EOM">EOM</option>
								</select>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="separator"></div>
						<div class="span12">
							<div class="span2">Address</div>
							<div class="span9">
								<input type="text" name="address" placeholder="Address" class="span12" value="<?php echo (isset($edit_supplier->address))?$edit_supplier->address:set_value('address');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">City</div>
							<div class="span7">
								<input type="text" name="city" placeholder="City" class="span12" maxlength="100" value="<?php echo (isset($edit_supplier->city))?$edit_supplier->city:set_value('city');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">State</div>
							<div class="span7">
								<input type="text" name="state" placeholder="State" class="span12" maxlength="100" value="<?php echo (isset($edit_supplier->state))?$edit_supplier->state:set_value('state');?>"/>
							</div>
						</div>
						<div class="span12">
							<div class="span2">Country</div>
							<div class="span7">
								<input type="text" name="country" placeholder="Country" class="span12" maxlength="100" value="<?php echo (isset($edit_supplier->country))?$edit_supplier->country:set_value('country');?>"/>
							</div>
							<div class="span2">
								<input type="text" name="postalcode" placeholder="Postcode" class="span12" maxlength="8" value="<?php echo (isset($edit_supplier->postalcode))?$edit_supplier->postalcode:set_value('postalcode');?>"/>
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
			<div class="widget-head"><h4 class="heading">Supplier List</h4></div>
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
							<th>Credit Term</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($supplier as $supplier_item){
								$i++;
								$address=$supplier_item['address'];
								$city=$supplier_item['city'];
								if($city!="")
								{
									$city=", ".$supplier_item['city'];
								}
								else
								{
									$city="";
								}
								
								$state=$supplier_item['state'];
								if($state!="")
								{
									$state=", ".$supplier_item['state'];
								}
								else
								{
									$state="";
								}
								
								$country=$supplier_item['country'];
								if($country!="")
								{
									$country=", ".$supplier_item['country'];
								}
								else
								{
									$country="";
								}
								
								$postalcode=$supplier_item['postalcode'];
								if($postalcode!="")
								{
									$postalcode=" ".$postalcode;
								}
								else
								{
									$country="";
								}
								$fulladdress=$address."".$city."".$state."".$country."".$postalcode;

								$contact_person=$supplier_item['contact_person'];
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
									<td><?php echo $supplier_item['name']; ?></td>
									<td>
										<?php echo $supplier_item['phone']."".$contact_person; ?>
									</td>
									<td><?php echo $supplier_item['fax']; ?></td>
									<td><?php echo $supplier_item['email']; ?></td>
									<td><?php echo $fulladdress; ?></td>
									<td class="center"><?php echo $supplier_item['credit_term']; ?></td>
									<td class="center actions">
										<?php echo anchor('supplier/management/'.$supplier_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('supplier/delete/'.$supplier_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this supplier data?')"));?>
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
		window.location.href = '<?PHP echo site_url("supplier/management"); ?>';
	}
</script>	
	
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
