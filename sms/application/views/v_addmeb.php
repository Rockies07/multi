<!DOCTYPE html>

<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<base href="<?PHP echo base_url(); ?>">
<meta charset="utf-8">


<!-- Plugin Stylesheets first to ease overrides -->
<link rel="stylesheet" type="text/css" href="assets/plugins/colorpicker/colorpicker.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/custom-plugins/wizard/wizard.css" media="screen">

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
<link rel="stylesheet" type="text/css" href="assets/jui/jquery-ui.custom.css" media="screen">

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="assets/css/mws-theme.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/css/themer.css" media="screen">



</head>
<body>
<html>
<BR>
<div class="mws-panel grid_8">

                	<div class="mws-panel-header">
                    	<span><i class="icon-magic"></i><b> Add Member</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">

<?PHP
		$select_attributes = array('id' => 'downline_id',
							'class' => 'mws-form-item',
							);
		$attributes = array('class' => 'mws-form wzd-default',
							);
		echo form_open('', $attributes); 
?>
                            
                            <fieldset class="wizard-step mws-form-inline">
							<font color="red" size="4"><?php echo validation_errors(); ?></font>

                                <legend class="wizard-label"><i class="icol-vcard"></i><b> Profile</b></legend>
						<?php 
							if(strlen($uid) <= 4)
							{
						?>
                                 <div id class="mws-form-row">
                                    <label class="mws-form-label"><b>Downline</b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <?php 
											if(strlen($uid) <= 4)
											{
												echo form_dropdown('agt_id', $downlinedata , '#' ,$select_attributes); 
											}
										?> 
                                    </div>
                                </div>
						<?PHP
							}
						?> 

                               <div id class="mws-form-row">
                                    <label class="mws-form-label"><b>Member ID </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                <?PHP if(strlen($uid) == 6)
										{
											echo "<b>".$uid."</b>&nbsp&nbsp";
										}
								?>
										<input type="text" maxlength="2" style="width: 45px; FONT-WEIGHT: bold;" name="meb_id" value="<?php echo set_value('meb_id'); ?>"> 
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Name </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="15" style="width: 160px; FONT-WEIGHT: bold;" name="name"  value="<?php echo set_value('name'); ?>">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Password </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="15" style="width: 160px; FONT-WEIGHT: bold;" name="password" value="<?php echo set_value('password'); ?>">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Ticket Commission </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="4" style="width: 50px; FONT-WEIGHT: bold;" name="placeout_com" value="<?php echo set_value('placeout_com','0'); ?>"> <b>%</b>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Credit </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <b>$</b>&nbsp&nbsp<input type="text" maxlength="6" style="width: 80px; FONT-WEIGHT: bold;" name="credit" value="<?php echo set_value('credit','0'); ?>">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Auto Refresh Credit </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        Yes&nbsp&nbsp<input type="radio" name="refresh" value="Y" <?php echo set_radio('refresh', 'Y', TRUE); ?> /><br>
										No&nbsp&nbsp<input type="radio" name="refresh" value="N" <?php echo set_radio('refresh', 'N'); ?> />
                                    </div>
                                </div>
								<hr>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Mobile Number 1 </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="12" style="width: 130px; FONT-WEIGHT: bold;" name="handphone1" value="<?php echo set_value('handphone1','0'); ?>"> <b></b>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Mobile Number 2 </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="12" style="width: 130px; FONT-WEIGHT: bold;" name="handphone2" value="<?php echo set_value('handphone2','0'); ?>"> <b></b>
                                    </div>
                                </div>
                               </div>
                            </fieldset>

							</form>
                    </div>
                </div>

            <!-- Inner Container End -->
                       
            <!-- Footer -->
   <!-- JavaScript Plugins -->
    <script src="assets/js/libs/jquery-1.8.3.min.js"></script>
    <script src="assets/js/libs/jquery.mousewheel.min.js"></script>
    <script src="assets/js/libs/jquery.placeholder.min.js"></script>
    <script src="assets/custom-plugins/fileinput.min.js"></script>

    <!-- jQuery-UI Dependent Scripts -->
    <script src="assets/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="assets/jui/jquery-ui.custom.min.js"></script>
    <script src="assets/jui/js/jquery.ui.touch-punch.min.js"></script>

    <!-- Plugin Scripts -->
    <script src="assets/plugins/colorpicker/colorpicker-min.js"></script>
    <script src="assets/plugins/validate/jquery.validate-min.js"></script>

    <!-- Wizard Plugin -->
    <script src="assets/custom-plugins/wizard/wizard.min.js"></script>
    <script src="assets/custom-plugins/wizard/jquery.form.min.js"></script>

    <!-- Core Script -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script src="assets/js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script src="assets/js/demo/demo.wizard.js"></script>

</body>
</html>
