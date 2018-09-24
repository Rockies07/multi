<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<base href="<?PHP echo base_url(); ?>">
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<!-- Plugin Stylesheets first to ease overrides -->
<link rel="stylesheet" type="text/css" href="assets/plugins/colorpicker/colorpicker.css" media="screen">

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/fonts/ptsans/stylesheet.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/fonts/icomoon/style.css" media="screen">

<link rel="stylesheet" type="text/css" href="assets/css/mws-style.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/icons/icol16.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/icons/icol32.css" media="screen">

<!-- Demo Stylesheet -->
<link rel="stylesheet" type="text/css" href="assets/css/demo.css" media="screen">

<!-- jQuery-UI Stylesheet -->
<link rel="stylesheet" type="text/css" href="assets/jui/css/jquery.ui.all.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/jui/css/jquery.ui.timepicker.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/jui/jquery-ui.custom.css" media="screen">

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="assets/css/mws-theme.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/themer.css" media="screen">

<script>
	function startTime()
	{
		var today=new Date();
		var h=today.getHours();
		var m=today.getMinutes();
		var s=today.getSeconds();
		// add a zero in front of numbers<10
		m=checkTime(m);
		s=checkTime(s);
		document.getElementById('txt').innerHTML="System Time: "+h+":"+m+":"+s;
		t=setTimeout(function(){startTime()},500);
	}

	function checkTime(i)
	{
		if (i<10)
		  {
		  i="0" + i;
		  }
		return i;
	}
</script>


<title><?PHP echo $sitename;?></title>
  
</head>
        
        <!-- Main Container Start -->
		
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                
                <!-- Panels Start -->
               
            	<div class="mws-panel grid_5">
                	<div class="mws-panel-header">
                    	<span><i class="icon-official"></i><b> Bet Summary</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                              
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="boldr" align="right"></i>Member ID</td>
                                    <td><?PHP echo $this->session->flashdata('meb_id');?></td>
                                </tr>
                                <tr>
                                    <td class="boldr" align="right"> Name</span></td>
                                    <td><?PHP echo $this->session->flashdata('meb_name');?></td>
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Ticket Rate</td>
									<td> 
										<span style="width:100%;">
										<span style="width:50%;"><b>Big:</b> <?PHP echo $bigvalue;?></span>
										<span style="width:50%; padding-left:25%;"><b>Small:</b> <?PHP echo $smallvalue;?></span>
										</span>
									</td>
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Ticket Commission</td>
                                    <td><?PHP echo number_format($this->session->flashdata('placeout_com'),2,'.','.');?> %</td>
                                    
                                </tr>

                                <tr>
                                    <td class="boldr" align="right">Total Big</td>
                                    <td><?PHP echo $this->session->flashdata('totalbig');?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Total Small</td>
                                    <td><?PHP echo $this->session->flashdata('totalsmall');?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Total iBig</td>
                                    <td><?PHP echo $this->session->flashdata('totalibig');?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Total iSmall</td>
                                    <td><?PHP echo $this->session->flashdata('totalismall');?></td> 
                                </tr>
                                <tr>
                                    <td class="boldr" align="right">Total Nett</td>
                                    <td><?PHP echo number_format($this->session->flashdata('totalamt'),2,'.',',');?></td> 
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
           	
            <!-- Inner Container End -->
                       
            <!-- Footer -->
        </div>
        <!-- Main Container End -->
        
    </div>

    <!-- JavaScript Plugins -->
    <script src="assets/js/libs/jquery-1.8.3.min.js"></script>
    <script src="assets/js/libs/jquery.mousewheel.min.js"></script>
    <script src="assets/js/libs/jquery.placeholder.min.js"></script>
    <script src="assets/custom-plugins/fileinput.js"></script>
    
    <!-- jQuery-UI Dependent Scripts -->
    <script src="assets/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="assets/jui/jquery-ui.custom.min.js"></script>
    <script src="assets/jui/js/jquery.ui.touch-punch.js"></script>

    <!-- Plugin Scripts -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/colorpicker/colorpicker-min.js"></script>

    <!-- Core Script -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script src="assets/js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script src="assets/js/demo/demo.table.js"></script>

</body>
</html>
