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
                               <div id class="mws-form-row">
                                    <label class="mws-form-label"><b>Member ID </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
										<input type="text" maxlength="2" style="width: 100px; FONT-WEIGHT: bold;" name="meb_id" value="<?php echo $uid_data['meb_id']; ?>" readonly> 
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Name </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="15" style="width: 160px; FONT-WEIGHT: bold;" name="name"  value="<?php echo set_value('name',$uid_data['name']); ?>">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Password </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="password" maxlength="15" style="width: 160px; FONT-WEIGHT: bold;" name="password" value="<?php echo set_value('password',$uid_data['password']); ?>">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Ticket Commission </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="4" style="width: 50px; FONT-WEIGHT: bold;" name="placeout_com" value="<?php echo set_value('placeout_com',$uid_data['placeout_com']); ?>"> <b>%</b>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Credit </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <b>$</b>&nbsp&nbsp<input type="text" maxlength="8" style="width: 110px; FONT-WEIGHT: bold;" name="credit" value="<?php echo set_value('credit',number_format($uid_data['credit'],2,'.',',')); ?>" readonly>
 										&nbsp&nbsp&nbsp&nbsp<b>Add/Deduct $</b>&nbsp&nbsp<input type="text" maxlength="8" style="width: 110px; FONT-WEIGHT: bold;" name="updatecredit" value="<?php echo set_value('updatecredit','0'); ?>">
                                   </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Balance </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <b>$</b>&nbsp&nbsp<input type="text" maxlength="8" style="width: 110px; FONT-WEIGHT: bold;" name="balance" value="<?php echo set_value('balance',number_format($uid_data['balance'],2,'.',',')); ?>" readonly>
										&nbsp&nbsp&nbsp&nbsp<b>Add/Deduct $</b>&nbsp&nbsp<input type="text" maxlength="8" style="width: 110px; FONT-WEIGHT: bold;" name="updatebal" value="<?php echo set_value('updatebal','0'); ?>">
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
                                        <input type="text" maxlength="12" style="width: 130px; FONT-WEIGHT: bold;" name="handphone1" value="<?php echo set_value('handphone1',$uid_data['handphone1']); ?>"> <b></b>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label"><b>Mobile Number 2 </b><span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="text" maxlength="12" style="width: 130px; FONT-WEIGHT: bold;" name="handphone2" value="<?php echo set_value('handphone2',$uid_data['handphone2']); ?>"> <b></b>
                                    </div>
                                </div>   
								<div class="mws-form-row">
                                    <label class="mws-form-label"><b>Close Account</b></label>
                                    <div class="mws-form-item">
                                        Yes&nbsp&nbsp<input type="radio" name="status" value="closed" <?php echo set_radio('refresh', 'closed'); ?> /><br>
										No&nbsp&nbsp<input type="radio" name="status" value="active" <?php echo set_radio('refresh', 'active', TRUE); ?> />
                                    </div>
                                </div>
						</fieldset>

							</form>
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
