<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<META http-equiv="Content-Type" content="text/html; charset=windows-1252"> 
        <META http-equiv="pragma" content="no-cache"> 
        <META http-equiv="cache-control" content="no-cache"> 
		<base href="<?PHP echo base_url(); ?>">
		<LINK href="assets/admin.css"  rel="stylesheet" type="text/css">

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
        <SCRIPT language="javascript">

        </SCRIPT>
            	<!-- Statistics Button Container -->
            	
                <!-- Panels Start -->
                           	
            
        <table cellSpacing="0" cellPadding="0" border="1" width="100%" >
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="0" cellPadding="0" border="0" align="left">
                        <tr>
                            </th>
                        </tr>
							<INPUT name="setday" type="hidden" value="N"> 
							<INPUT type="hidden" value="80" name="MaxCellId">
                    </table>
                </td></tr>
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="1" cellPadding="0" border="1" align="left">
                        <tr>
                            <th>							
							
								Page :&nbsp;<input maxLength="9" size="9" class="mws-form-item wcolor" value="<?PHP echo $betdata['pageref']; ?>" readonly> &nbsp;&nbsp;&nbsp;&nbsp
                                Big : <input maxLength="6" style="width: 50px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" class="wcolor" name="TotalBig" value="<?PHP echo  $betdata['amt_big'] + $betdata['amt_ibig']; ?>" readonly>
                                Sml : <input maxLength="6" style="width: 50px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" class="wcolor" name="TotalSml" value="<?PHP echo $betdata['amt_small'] + $betdata['amt_ismall']; ?>" readonly>
                                Amt : <input maxLength="6" style="width: 60px; FONT-WEIGHT: bold; FONT-SIZE: 12px;" class="wcolor" name="TotalAmt" 
								value="<?PHP echo number_format(((($betdata['amt_big'] + $betdata['amt_ibig']) * 1.6) + (($betdata['amt_small'] + $betdata['amt_ismall']) * 0.7)),2,'.',','); ?>" readonly>
							</th>
                        </tr>
                    </table>
                </td>
            </tr>


<?PHP
	$count = 0;
	if($tablecount < 0)
	{
		$tablecount = 1;
	}
	for ($a = 1; $a<=$tablecount; $a++)
	{
?>


            <tr>
                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
<?PHP
                            for ($i = 1+$count; $i<21+$count; $i++)
							{
								if(!isset($pagearray[$i]['draws']))
								{
									$pagearray[$i]['draws'] = '';
								}
								if(!isset($pagearray[$i]['number']))
								{
									$pagearray[$i]['number'] = '';
								}
								if(!isset($pagearray[$i]['amt_big']))
								{
									$pagearray[$i]['amt_big'] = '';
								}
								if(!isset($pagearray[$i]['amt_small']))
								{
									$pagearray[$i]['amt_small'] = '';
								}
								if(!isset($pagearray[$i]['cmd']))
								{
									$pagearray[$i]['cmd'] = '';
								}

								switch ($pagearray[$i]['cmd'])
								{
									case 'R': $fontcolor = "yellow";
										break;
									case 'I': $fontcolor = "red";
										break;
									default: $fontcolor = "White";
										break;
								}
								switch($pagearray[$i]['draws'])
								{
									case 1: $daycolor = "#CC0000";
											break;
									case 2: $daycolor = "#F7FE2E";
											break;
									case 3: $daycolor = "#33CCFF";
											break;
									case 6: $daycolor = "#CC00CC";
											break;
									case 7: $daycolor = "#33CC00";
											break;
								}


								echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td><input maxLength="1" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$daycolor.';" 
								value ="'.$pagearray[$i]['draws'].'" readonly></td>';
								echo '<td><input maxLength="4" style="width: 41px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['number'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_big'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_small'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE: 13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['cmd'].'" readonly></td>';
								echo '</tr>';
							}
?>
                    </table></td>

                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
<?PHP
                            for ($i = 21+$count; $i<41+$count; $i++)
							{
								if(!isset($pagearray[$i]['draws']))
								{
									$pagearray[$i]['draws'] = '';
								}
								if(!isset($pagearray[$i]['number']))
								{
									$pagearray[$i]['number'] = '';
								}
								if(!isset($pagearray[$i]['amt_big']))
								{
									$pagearray[$i]['amt_big'] = '';
								}
								if(!isset($pagearray[$i]['amt_small']))
								{
									$pagearray[$i]['amt_small'] = '';
								}
								if(!isset($pagearray[$i]['cmd']))
								{
									$pagearray[$i]['cmd'] = '';
								}

								switch ($pagearray[$i]['cmd'])
								{
									case 'R': $fontcolor = "orange";
										break;
									case 'I': $fontcolor = "red";
										break;
									default: $fontcolor = "White";
										break;
								}

								echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td><input maxLength="1" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$daycolor.';" 
								value ="'.$pagearray[$i]['draws'].'" readonly></td>';
								echo '<td><input maxLength="4" style="width: 41px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['number'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_big'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_small'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE: 13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['cmd'].'" readonly></td>';
								echo '</tr>';
							}
?>
                    </table></td>

                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
<?PHP
                            for ($i = 41+$count; $i<61+$count; $i++)
							{
								if(!isset($pagearray[$i]['draws']))
								{
									$pagearray[$i]['draws'] = '';
								}
								if(!isset($pagearray[$i]['number']))
								{
									$pagearray[$i]['number'] = '';
								}
								if(!isset($pagearray[$i]['amt_big']))
								{
									$pagearray[$i]['amt_big'] = '';
								}
								if(!isset($pagearray[$i]['amt_small']))
								{
									$pagearray[$i]['amt_small'] = '';
								}
								if(!isset($pagearray[$i]['cmd']))
								{
									$pagearray[$i]['cmd'] = '';
								}

								switch ($pagearray[$i]['cmd'])
								{
									case 'R': $fontcolor = "orange";
										break;
									case 'I': $fontcolor = "red";
										break;
									default: $fontcolor = "White";
										break;
								}

								echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td><input maxLength="1" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$daycolor.';" 
								value ="'.$pagearray[$i]['draws'].'" readonly></td>';
								echo '<td><input maxLength="4" style="width: 41px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['number'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_big'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_small'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE: 13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['cmd'].'" readonly></td>';
								echo '</tr>';
							}
?>
                    </table>
                </td>

                <td>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
<?PHP
                            for ($i = 61+$count; $i<81+$count; $i++)
							{
								if(!isset($pagearray[$i]['draws']))
								{
									$pagearray[$i]['draws'] = '';
								}
								if(!isset($pagearray[$i]['number']))
								{
									$pagearray[$i]['number'] = '';
								}
								if(!isset($pagearray[$i]['amt_big']))
								{
									$pagearray[$i]['amt_big'] = '';
								}
								if(!isset($pagearray[$i]['amt_small']))
								{
									$pagearray[$i]['amt_small'] = '';
								}
								if(!isset($pagearray[$i]['cmd']))
								{
									$pagearray[$i]['cmd'] = '';
								}

								switch ($pagearray[$i]['cmd'])
								{
									case 'R': $fontcolor = "orange";
										break;
									case 'I': $fontcolor = "red";
										break;
									default: $fontcolor = "White";
										break;
								}

								echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td><input maxLength="1" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$daycolor.';" 
								value ="'.$pagearray[$i]['draws'].'" readonly></td>';
								echo '<td><input maxLength="4" style="width: 41px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['number'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_big'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 35px; FONT-WEIGHT:bold; FONT-SIZE:13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['amt_small'].'" readonly></td>';
								echo '<td><input maxLength="6" style="width: 20px; FONT-WEIGHT:bold; FONT-SIZE: 13px; color:'.$fontcolor.';" value="'.$pagearray[$i]['cmd'].'" readonly></td>';
								echo '</tr>';
							}
?>
                    </table>
                </td>
            </tr>
  
		  
<?PHP
		$count = $count + 80;
	}
?>



			<tr>	
				<td colspan="4" style="align:center;">
                    
                </td>
            </tr>
        </table>
    </FORM>
						
						<!-- Entry End -->
						
						
						
                    </div>
                </div>
				
				
				
				
				
				
				
				
            	
                
              <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
        </div>
        <!-- Main Container End -->
        
    </div>

    <!-- JavaScript Plugins -->
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
