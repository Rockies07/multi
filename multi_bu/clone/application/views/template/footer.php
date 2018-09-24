	</div>
<!-- Sticky Footer -->
		<div id="footer" class="visible-desktop">
	      	<div class="wrap">
	      		<ul>
	      			<li>
	      				<span>2015 Copyright by MSe. All rights reserved. Singapore</span>
	      			</li>
	      		</ul>
	      	</div>
	    </div>
	    				
	</div>
	
	<!-- JQueryUI v1.9.2 -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/system/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
	
	<!-- JQueryUI Touch Punch -->
	<!-- small hack that enables the use of touch events on sites using the jQuery UI user interface library -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/system/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
	
	<!-- Select2 -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/forms/select2/select2.js"></script>
	
	<!-- jQuery Slim Scroll Plugin -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/other/jquery-slimScroll/jquery.slimscroll.min.js"></script>
	
	<!-- Common Demo Script -->
	<script src="<?php echo base_url();?>public/theme/scripts/demo/common.js?1370451130"></script>
	
	<!-- Holder Plugin -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/other/holder/holder.js"></script>
	<script>Holder.add_theme("dark", {background:"#000", foreground:"#aaa", size:9})</script>
	
	<!-- Themer -->
	<script>
	var themerPrimaryColor = '#008BFF';
	</script>
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/system/jquery.cookie.js"></script>
	<script src="<?php echo base_url();?>public/theme/scripts/demo/themer.js"></script>
	
	<!-- Global -->
	<script>
	var basePath = '',
		commonPath = '<?php echo base_url();?>public/',
		
		// charts data
		charts_data = {
			
			// 24 hours
			graph24hours: {
				from: 1370210400000,
				to: 1370296800000			},

			// 7 days
			graph7days: {
				from: 1369692000000,
				to: 1370296800000			},

			// 14 days
			graph14days: {
				from: 1369087200000,
				to: 1370296800000			},

			// main dashboard graph - website traffic
			website_traffic: {
				d1: [[1367791200000, 2892],[1367877600000, 2086],[1367964000000, 2468],[1368050400000, 2188],[1368136800000, 3046],[1368223200000, 2769],[1368309600000, 3468],[1368396000000, 2927],[1368482400000, 2531],[1368568800000, 3637],[1368655200000, 3078],[1368741600000, 3317],[1368828000000, 2658],[1368914400000, 2922],[1369000800000, 3403],[1369087200000, 2178],[1369173600000, 2562],[1369260000000, 3761],[1369346400000, 2570],[1369432800000, 3980],[1369519200000, 3095],[1369605600000, 2306],[1369692000000, 2540],[1369778400000, 2323],[1369864800000, 3564],[1369951200000, 2449],[1370037600000, 2477],[1370124000000, 3372],[1370210400000, 2651],[1370296800000, 3943]],
				d2: [[1367791200000, 449],[1367877600000, 400],[1367964000000, 443],[1368050400000, 671],[1368136800000, 645],[1368223200000, 441],[1368309600000, 610],[1368396000000, 545],[1368482400000, 578],[1368568800000, 569],[1368655200000, 687],[1368741600000, 655],[1368828000000, 513],[1368914400000, 584],[1369000800000, 572],[1369087200000, 460],[1369173600000, 464],[1369260000000, 608],[1369346400000, 450],[1369432800000, 627],[1369519200000, 634],[1369605600000, 474],[1369692000000, 417],[1369778400000, 481],[1369864800000, 645],[1369951200000, 556],[1370037600000, 471],[1370124000000, 446],[1370210400000, 693],[1370296800000, 513]]	
			}

		};
	</script>

		<!--  Flot (Charts) JS -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/charts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/charts/flot/jquery.flot.pie.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/charts/flot/jquery.flot.tooltip.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/charts/flot/jquery.flot.selection.js"></script>
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/charts/flot/jquery.flot.resize.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/charts/flot/jquery.flot.orderBars.js" type="text/javascript"></script>
	
	<!-- Charts Helper Demo Script -->
	<script src="<?php echo base_url();?>public/theme/scripts/demo/charts.helper.js?1370451130"></script>
	
	<!-- Finances Page Demo Script -->
	<script src="<?php echo base_url();?>public/theme/scripts/demo/finances.js?1370451130"></script>
	
	
	<!-- Resize Script -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/other/jquery.ba-resize.js"></script>
	
	<!-- Uniform -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/forms/pixelmatrix-uniform/jquery.uniform.min.js"></script>
	
	<!-- Bootstrap Script -->
	<script src="<?php echo base_url();?>public/bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Bootstrap Extended -->
	<script src="<?php echo base_url();?>public/bootstrap/extend/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<script src="<?php echo base_url();?>public/bootstrap/extend/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js"></script>
	<script src="<?php echo base_url();?>public/bootstrap/extend/jasny-bootstrap/js/jasny-bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>public/bootstrap/extend/jasny-bootstrap/js/bootstrap-fileupload.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>public/bootstrap/extend/bootbox.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>public/bootstrap/extend/bootstrap-wysihtml5/js/bootstrap-wysihtml5-0.0.2.js" type="text/javascript"></script>
	<!-- Layout Options DEMO Script -->
	<script src="<?php echo base_url();?>public/theme/scripts/demo/layout.js"></script>
	
	<!-- google-code-prettify -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/other/google-code-prettify/prettify.js"></script>
	
	<!-- Gritter Notifications Plugin -->
	<script src="<?php echo base_url();?>public/theme/scripts/plugins/notifications/Gritter/js/jquery.gritter.min.js"></script>
	
	<!-- Notyfy -->
	<script type="text/javascript" src="<?php echo base_url();?>public/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.js"></script>
	
	<!-- Utility -->
	<script type="text/javascript" src="<?php echo base_url();?>public/js/utility.js"></script>