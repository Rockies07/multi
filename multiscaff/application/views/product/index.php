
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" media="screen" href="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/css/TableTools.css" />
				
<div id="content">
	<ul class="breadcrumb">
		<li><a href="index.html?lang=en" class="glyphicons home"><i></i> <?php echo $title; ?></a></li>
		<li class="divider"></li>
		<li>Master</li>
		<li class="divider"></li>
		<li>Inventory</li>
	</ul>
	<div class="separator bottom"></div>
	<div class="validation_wrapper center">
		<?php echo validation_errors(); ?>
	</div>
	<h3 class="glyphicons table"><i></i>Inventory</h3>
	<div class="innerLR">
		<div class="widget widget-4 widget-body-white">
			<div class="widget-head">
				<h4 class="heading">Add Inventory</h4>
			</div>
			<?php echo form_open($action)?>
				<div class="row-fluid well">
					<div class="span6">
						<div class="span12">
							<div class="separator"></div>
							<div class="span12">
								<div class="span2">Code</div>
								<div class="span8">
									<input type="text" name="code" placeholder="Code" class="span8" maxlength="32" value="<?php echo (isset($edit_product->code))?$edit_product->code:set_value('code');?>"/>
									<input type="hidden" name="edit_id" value="<?php echo (isset($edit_product->id))?$edit_product->id:'0';?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Name</div>
								<div class="span8">
									<input type="text" name="name" placeholder="Name" class="span8" maxlength="100" value="<?php echo (isset($edit_product->name))?$edit_product->name:set_value('name');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Description</div>
								<div class="span10">
									<input type="text" name="description" placeholder="Description" class="span12" value="<?php echo (isset($edit_product->description))?$edit_product->description:set_value('description');?>"/>
								</div>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="span12">
							<div class="separator"></div>
							<div class="span12">
								<div class="span2">Sales Price</div>
								<div class="span8 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span4" name="sales_price" type="text" placeholder="Sales Price" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_product->sales_price))?$edit_product->sales_price:set_value('sales_price');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Purchase Price</div>
								<div class="span8 input-prepend">
									<span class="add-on">$</span>
									<input id="prependedInput" class="span4" name="purchase_price" type="text" placeholder="Purchase Price" onkeypress="return isNumberKey(event)" maxlength="10" value="<?php echo (isset($edit_product->purchase_price))?$edit_product->purchase_price:set_value('purchase_price');?>"/>
								</div>
							</div>
							<div class="span12">
								<div class="span2">Stock</div>
								<div class="span10">
									<input type="text" name="stock" placeholder="Stock" class="span2" maxlength="8" value="<?php echo (isset($edit_product->stock))?$edit_product->stock:set_value('stock');?>" onkeypress="return isNumberKey(event)"/>
									<input type="text" name="unit" placeholder="Unit" class="span3" maxlength="32" value="<?php echo (isset($edit_product->unit))?$edit_product->unit:set_value('unit');?>"/>
								</div>
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
			<div class="widget-head"><h4 class="heading">Inventory List</h4></div>
			<div class="widget-body">
				<table class="dynamicTable tableTools table table-striped table-bordered table-primary table-condensed">
					<thead>
						<tr>
							<th width="10px">S/N</th>
							<th>Code</th>
							<th>Name</th>
							<th width="60px">Stock</th>
							<th width="80px">Unit</th>
							<th width="120px">Sales Price</th>
							<th width="120px">Purchase Price</th>
							<th>Description</th>
							<th width="60px">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$i=0;
							foreach ($product as $product_item){
								$i++;
						?>
								<tr class="gradeX">
									<td class="center"><?php echo $i; ?></td>
									<td><?php echo $product_item['code']; ?></td>
									<td><?php echo $product_item['name']; ?></td>
									<td class="right"><?php echo $product_item['stock']; ?></td>
									<td><?php echo $product_item['unit']; ?></td>
									<td class="right" class="right"><?php echo $product_item['sales_price']; ?></td>
									<td class="right"><?php echo $product_item['purchase_price']; ?></td>
									<td><?php echo $product_item['description']; ?></td>
									<td class="center actions">
										<?php echo anchor('product/management/'.$product_item['id'], '<i></i>',array('class' => 'btn-action glyphicons pencil btn-success'));?>
										<?php echo anchor('product/delete/'.$product_item['id'].'/management', '<i></i>',array('class' => 'btn-action glyphicons remove_2 btn-danger','onclick'=>"return confirm('Are you sure to remove this product data?')"));?>
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
		window.location.href = '<?PHP echo site_url("product/management"); ?>';
	}
</script>

<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>
