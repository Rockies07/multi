<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><!--<![endif]-->
<META http-equiv="Content-Type" content="text/html; charset=windows-1252"> 
        <META http-equiv="pragma" content="no-cache"> 
        <META http-equiv="cache-control" content="no-cache"> 
		<base href="<?PHP echo base_url(); ?>">
		<LINK href="assets/admin.css"  rel="stylesheet" type="text/css">
        <SCRIPT src="assets/fixevent.js"></SCRIPT>
		<script src="assets/js/libs/jquery-1.8.3.min.js"></script>

<script>
function base64_encode (data) {
  // http://kevin.vanzonneveld.net
  // +   original by: Tyler Akins (http://rumkin.com)
  // +   improved by: Bayron Guevara
  // +   improved by: Thunder.m
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Pellentesque Malesuada
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Rafał Kukawski (http://kukawski.pl)
  // *     example 1: base64_encode('Kevin van Zonneveld');
  // *     returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
  // mozilla has this native
  // - but breaks in 2.0.0.12!
  //if (typeof this.window['btoa'] === 'function') {
  //    return btoa(data);
  //}
  var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    enc = "",
    tmp_arr = [];

  if (!data) {
    return data;
  }

  do { // pack three octets into four hexets
    o1 = data.charCodeAt(i++);
    o2 = data.charCodeAt(i++);
    o3 = data.charCodeAt(i++);

    bits = o1 << 16 | o2 << 8 | o3;

    h1 = bits >> 18 & 0x3f;
    h2 = bits >> 12 & 0x3f;
    h3 = bits >> 6 & 0x3f;
    h4 = bits & 0x3f;

    // use hexets to index into b64, and append result to encoded string
    tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
  } while (i < data.length);

  enc = tmp_arr.join('');

  var r = data.length % 3;

  return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);

}	

</script>
        <SCRIPT language="javascript">
		

// <![CDATA[
    $(document).ready(function()
	{      
        $('#downline_id').change(function() //any select change on the dropdown with id trigger this code    
		{     
            $("#meb_id > option").remove(); //first of all clear select items
            var downline_id = $('#downline_id').val();  // here we are taking country id of the selected one.
            $.ajax(
			{
                type: "POST",
                url: "<?PHP echo site_url('/c_entry/getmemberdata/"+downline_id+"'); ?>", //here we are calling our user controller and get_cities method with the country_id
                dataType : "json",
                success: function(meb_id) //we're calling the response json array 'cities'
                {
					var opt = $('<option >'); // here we're creating a new select option with for each city
					opt.val('#');
					opt.text('--- Select Member ---');
					$('#meb_id').append(opt); //here we will append these new select options to a dropdown with the id 'cities'

                    $.each(meb_id,function(id,m_id) //here we're doing a foeach loop round each city with id as the key and city as the value
                    {
                        var opt = $('<option >'); // here we're creating a new select option with for each city
                        opt.val(id);
                        opt.text(m_id);
                        $('#meb_id').append(opt); //here we will append these new select options to a dropdown with the id 'cities'
                    });
                }
                 
            });
             
        });

        $('#meb_id').change(function() //any select change on the dropdown with id trigger this code    
		{     
			$("#meb_page > option").remove(); //first of all clear select items
            var meb_id = $('#meb_id').val();  
            $.ajax(
			{
                type: "POST",
                url: "<?PHP echo site_url('/c_entryfix/getmemberpage/"+meb_id+"'); ?>", 
                dataType : "json",
                success: function(meb_page)
                {
					var opt = $('<option>'); 
					opt.val('#');
					opt.text('--- Select ---');
					$('#meb_page').append(opt); 
				
				    $.each(meb_page,function(id,pageref) 
                    {
                        var opt = $('<option>');
                        opt.val(id);
                        opt.text(pageref);
                        $('#meb_page').append(opt); 
                    });
                }
                 
            });
             
        });
        $('#meb_page').change(function() 
		{     
            var meb_id = $('#meb_id').val();
			var meb_page = $('#meb_page').val();
			document.PlaceBetForm.WhoseBet.value=meb_id;
			document.PlaceBetForm.txtPage.value=meb_page;
			document.PlaceBetForm.txtPage.readOnly=false;
			document.PlaceBetForm.send.value = 'Submit';
			document.PlaceBetForm.send.innerHTML = 'Submit';

			if(meb_page.length > 0)
			{
				document.PlaceBetForm.txtPage.readOnly=true;
				document.PlaceBetForm.send.value = 'Update';
				document.PlaceBetForm.send.innerHTML = 'Update';
			}
			
			
			for(i=1; i<=80; i++){
				$('input[name=NumberToBuy'+i+']').val("").css( "color", "White" );
				$('input[name=BigNum'+i+']').val("").css( "color", "White" );
				$('input[name=SmlNum'+i+']').val("").css( "color", "White" );
				$('input[name=Cmd'+i+']').val("").css( "color", "White" );
			}

            $.ajax(
			{
                type: "POST",
                url: "<?PHP echo site_url('/c_entryfix/getfixpagedata/"+meb_id+"/"+base64_encode(meb_page)+"'); ?>", 
                dataType : "json",
                success: function(page_data)
                {
					
                    $.each(page_data,function(i,data) 
                    {
						if(data.cmd == 'R')
						{
							$('input[name=NumberToBuy'+data.numinpage+']').val(data.number).css( "color", "Orange" );
							$('input[name=BigNum'+data.numinpage+']').val(data.amt_big).css( "color", "Orange" );
							$('input[name=SmlNum'+data.numinpage+']').val(data.amt_small).css( "color", "Orange" );
							$('input[name=Cmd'+data.numinpage+']').val(data.cmd).css( "color", "Orange" );
							$('input[name=pCmd'+data.numinpage+']').val(data.cmd).css( "color", "Orange" );
						}
						if(data.cmd == 'I')
						{
							$('input[name=NumberToBuy'+data.numinpage+']').val(data.number).css( "color", "red" );
							$('input[name=BigNum'+data.numinpage+']').val(data.amt_big).css( "color", "red" );
							$('input[name=SmlNum'+data.numinpage+']').val(data.amt_small).css( "color", "red" );
							$('input[name=Cmd'+data.numinpage+']').val(data.cmd).css( "color", "red" );
							$('input[name=pCmd'+data.numinpage+']').val(data.cmd).css( "color", "red" );
						}
						else
						{
							$('input[name=NumberToBuy'+data.numinpage+']').val(data.number);
							$('input[name=BigNum'+data.numinpage+']').val(data.amt_big);
							$('input[name=SmlNum'+data.numinpage+']').val(data.amt_small);
							$('input[name=Cmd'+data.numinpage+']').val(data.cmd);
							$('input[name=pCmd'+data.numinpage+']').val(data.cmd);
						}
						
					});
					
                }
                 
            });
             
        });
        $('#delete').click(function() 
		{     
			var meb_id = $('#meb_id').val();
			var meb_page = $('#meb_page').val();
			if(meb_id == '' || meb_id == '#') {
				alert("Please select member id first!");
				return false;
			}
			if(meb_page == '#' || meb_page == '') {
				alert("Please select a valid Fix Page to delete!");
				return false;
			}
			if (confirm('Are you sure you want to delete this fix entry?')){
			$.ajax({
			  type: "POST", //or GET
			  url: "<?PHP echo site_url('/c_entryfix/delfixpagedata/"+meb_id+"/"+base64_encode(meb_page)+"'); ?>", 
			  data: '',
			  success: function(response){
				alert("Fix Entry page Deleted!");
				window.location.reload();
			  }
			});
		  }
		});
    });
    // ]]>

            function dM(rowstyle, n, d) {
                var htmlday;
				
                document.writeln('<tr class=' + rowstyle + '>');
                document.writeln('  <td>' + n + '</td>');
                document.writeln('  <td><input maxLength="1" style="width: 30px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="fix" value="FIX" align="center" disabled></td>');
                document.writeln('  <td><input maxLength="4" style="width: 41px; FONT-WEIGHT: bold; FONT-SIZE: 13px; color: white;" name="NumberToBuy' + n + '" id="NTB' + n + '" value=""  onkeyup="javascript: KeyUpInNum(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="4" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px; color: white;" name="BigNum' + n + '" id="BN' + n + '" value="" onkeyup="javascript: KeyUpInBig(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="4" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px; color: white;" name="SmlNum' + n + '" id="SN' + n + '" value="" onkeyup="javascript: KeyUpInSml(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="1" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px; color: white;" name="Cmd' + n + '" id="CMD' + n + '" value="" disabled></td>');
                document.writeln('</tr>');
                document.writeln('  <input type="hidden" value="0" name="pDay' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pNumberToBuy' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pBigNum' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pSmlNum' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pCmd' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pAmt' + n + '">');
            }
        </SCRIPT>

<?PHP

?>
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                <!-- Panels Start -->
                
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Fix Entry</b></span>

                    </div>
                    <div class="mws-panel-body no-padding">
                        <!-- Entry -->
					
            
        <table cellSpacing="0" cellPadding="0" border="1" width="100%" >
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="0" cellPadding="0" border="0" align="left" >
<?PHP
	if(strlen($uid) < 6)// show different dropdown for agent and member
	{
		$attributes = array('name' => 'SelAgentForm');
		$meb_id['#'] = '-';
		$meb_page['#'] = '-';
?>
                        <tr>
                            <td align="center" style="color:orange;font-size:14px;">Select Downline&nbsp;<?php echo form_dropdown('downline_id', $downlinedata , '#' ,'id="downline_id" class="wcolor"'); ?>&nbsp;&nbsp;&nbsp;
							Select Member : <?php echo form_dropdown('WhoseBet', $meb_id, '#' ,'id="meb_id" class="wcolor"'); ?>
                            </td>
                        </tr>
						<tr>
							<td align="center" style="color:orange;font-size:14px;">
							<br>
							Select : <?php echo form_dropdown('txtPage', $meb_page, '#' ,'id="meb_page" class="wcolor"'); ?>

<?PHP
		$attributes = array('name' => 'PlaceBetForm');
		echo form_open('c_checkoutfix', $attributes); 							

?>
								<INPUT name="WhoseBet" type="hidden" value="-"> 
								Page :&nbsp;<input maxLength="9" size="9" class="mws-form-item wcolor" name="txtPage"> &nbsp;&nbsp;&nbsp;&nbsp
								<INPUT name="setday" type="hidden" value="N"> 
								<INPUT type="hidden" value="80" name="MaxCellId">
                            </td>
						</tr>
<?PHP
		}
?>


<?PHP
	if(strlen($uid) == 6)// show different dropdown for agent and member
	{
		$attributes = array('name' => 'SelAgentForm');
		$meb_id['#'] = '-';
		$meb_page['#'] = '-';
?>
                        <tr>
                            <th>
							Select Member : <?php echo form_dropdown('WhoseBet', $downlinedata, '#' ,'id="meb_id" class="wcolor"'); ?>
                            </th>
                        </tr>
						<tr>
							<th>
								Select Page : <?php echo form_dropdown('txtPage', $meb_page, '#' ,'id="meb_page" class="wcolor"'); ?>
								<INPUT name="WhoseBet" type="hidden" value="-"> 

<?PHP
		$attributes = array('name' => 'PlaceBetForm');
		echo form_open('c_checkoutfix', $attributes); 							
?>								
								<INPUT name="WhoseBet" type="hidden" value="-"> 
								Page&nbsp;<input maxLength="9" size="9" class="mws-form-item wcolor" name="txtPage"> &nbsp;&nbsp;&nbsp;&nbsp
								<button type="button" class="btn" value="Delete" id="delete">Delete Page</button>
								<INPUT name="setday" type="hidden" value="N"> 
								<INPUT type="hidden" value="80" name="MaxCellId">
                            </th>
						</tr>
<?PHP
		}
?>

<?PHP
	if(strlen($uid) == 8)// show different dropdown for agent and member
	{
		$attributes = array('name' => 'SelAgentForm');
?>
						<tr>
							<th>
								ID: <INPUT name="meb_id" id="meb_id" value="<?php echo $uid; ?>"> 
								Select Page : <?php echo form_dropdown('txtPage', $pagedata, '#' ,'id="meb_page" class="wcolor"'); ?>

<?PHP
		$attributes = array('name' => 'PlaceBetForm');
		echo form_open('c_checkoutfix', $attributes); 							
?>
								<INPUT name="WhoseBet" type="hidden" value="<?php echo $uid; ?>"> 
								Page&nbsp;<input maxLength="9" size="9" class="mws-form-item wcolor" name="txtPage"> &nbsp;&nbsp;&nbsp;&nbsp
								<button type="button" class="btn" value="Delete" id="delete">Delete Page</button>
								<INPUT name="setday" type="hidden" value="N"> 
								<INPUT type="hidden" value="80" name="MaxCellId">
                            </th>
						</tr>
<?PHP
	}
?>
						<tr>
							<th>							
                          </th>
						</tr>
						<tr>
							<th>							
								<b><font size="4" color="red">Fix Entry will be loaded at 2:30 p.m on every draw date.</font></b>
                          </th>
						</tr>
                    </table>
                </td></tr>
            <tr>
            </tr>
            <tr>

                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
                        <SCRIPT>
                            for (i = 1; i<21; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 'f');
                        </SCRIPT>
                    </table></td>

                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
                        <SCRIPT>
                            for (i = 21; i<41; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 'f');
                        </SCRIPT>
                    </table></td>

                <td>
                    <table><tr>
                            <th>No.</th>
                            <th>Day</th>
                            <th>4D</th>
                            <th>Big</th>
                            <th>Small</th>
                            <th>Roll</th></tr>
                        <SCRIPT>
                            for (i = 41; i<61; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 'f');
                        </SCRIPT>
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
                        <SCRIPT>
                            for (i = 61; i<81; i++) 
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 'f');
                        </SCRIPT>
                    </table>
                </td>
            </tr>
          
			<tr>	
				<td colspan="4" style="align:center;">
                    
                      <table align="center">
                        
                        <tr>
							<td><button type="button" name="delete" class="btn" value="Delete" id="delete">Delete Page</button></td>
							<td><button type="button" name="send" id="send" class="btn btn-danger" onclick="javascript : ValidateForm();" value="Submit">Submit</button></td>
                          </tr>
                        
                        </table>
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
