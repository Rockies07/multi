<!-- plupload -->
<style type="text/css">@import url(<?php echo base_url();?>public/theme/scripts/plugins/forms/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>

<!-- Theme -->
<link rel="stylesheet" href="<?php echo base_url();?>public/theme/css/style.css?1370451130" />

<div id="content">
	<div class="separator bottom"></div>

		<h3 class="glyphicons suitcase"><i></i> File Managers</h3>
		<div class="innerLR">
			<div class="widget widget-2">
				<div class="widget-head">
					<h4 class="heading glyphicons file_import"><i></i>File Manager</h4>
				</div>
				<div class="widget-body">
					<form id="pluploadForm">
						<div id="pluploadUploader">
							<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
						</div>
					</form>
				</div>
			</div>
		</div>		
				<!-- End Content -->
	</div>
		
				<!-- End Wrapper -->
</div>

<script src="<?php echo base_url();?>public/js/utility.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/extras/TableTools/media/js/TableTools.min.js"></script>
<script src="<?php echo base_url();?>public/theme/scripts/plugins/tables/DataTables/media/js/DT_bootstrap.js"></script>

<!-- Form Elements Custom script -->
<script src="<?php echo base_url();?>public/theme/scripts/demo/form_elements.js" type="text/javascript"></script>

<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="<?php echo base_url();?>public/theme/scripts/plugins/forms/plupload/js/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/theme/scripts/plugins/forms/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<!-- File Managers Demo Script -->
<script type="text/javascript">
	BASE_URL = "<?php echo site_url();?>"
</script>
<script src="<?php echo base_url();?>public/js/file_managers.js"></script>
