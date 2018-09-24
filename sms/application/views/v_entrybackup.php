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
        <SCRIPT src="assets/event.js"></SCRIPT>
<SCRIPT language="javascript"> 
            function dM(rowstyle, n, d) {
                var htmlday;
                setd = document.PlaceBetForm.setday.value;
                if (setd == 'Y') {
                    htmlsetday = 'selected ';
                } else {
                    htmlsetday = '';
                }
                
                htmlday = '<OPTION value="3" ' + htmlsetday + ' style="color:#33CCFF">3</OPTION><OPTION value="3" style="color:#33CCFF">3</OPTION><OPTION value="2" style="color:#FF9900">2</OPTION><OPTION value="6" style="color:#CC00CC">6</OPTION><OPTION value="7" style="color:#33CC00">7</OPTION><OPTION value="1" style="color:#CC0000">1</OPTION>';
                
                document.writeln('<tr>');
                document.writeln('  <td>' + n + '</td>');
                document.writeln('  <td><select tabindex="-1" size="1" name="Day' + n + '" id="Day' + n + '"> ' + htmlday + '</select></td>');
                document.writeln('  <td><input maxLength="4" style="width: 41px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="NumberToBuy' + n + '" id=NTB' + n + '" value=""  onkeyup="javascript: KeyUpInNum(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="4" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="BigNum' + n + '" id="BN' + n + '" value="" onkeyup="javascript: KeyUpInBig(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="3" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="SmlNum' + n + '" id="SN' + n + '" value="" onkeyup="javascript: KeyUpInSml(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="1" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Cmd' + n + '" id="CMD' + n + '" value="" disabled></td>');
                document.writeln('</tr>');
                document.writeln('  <input type="hidden" value="0" name="pNumberToBuy' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pBigNum' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pSmlNum' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pCmd' + n + '">');
                document.writeln('  <input type="hidden" value="0" name="pAmt' + n + '">');
            }
        </SCRIPT>

        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	
                <!-- Panels Start -->
                
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i><b> Please select an account to place bets</b></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <!-- Entry -->
						
			<FORM name="PlaceBetForm" action="aEntryP.asp" method="post">
            <INPUT name="smalldeno" type="hidden" value="0.5"> 
            <INPUT name="maxstake" type="hidden" value="-1"> 
            <INPUT name="enableibet" type="hidden" value="Y"> 
            <INPUT name="enablekbet" type="hidden" value="N"> 
            <INPUT name="setday" type="hidden" value="N"> 
            <INPUT name="txtrbig" type="hidden" value="2"> 
            <INPUT name="txtrsmall" type="hidden" value="1"> 
            <INPUT name="txtTimeStamp" type="hidden" value="4/10/2013 1:53:52 AM"> 
            <INPUT name="txtRDate" type="hidden"> 
            <INPUT name="txtMember" type="hidden"> 
            <INPUT name="txtsuid" type="hidden" value="DJA6006"> 
            <INPUT type="hidden" value="80" name="MaxCellId">
            <SPAN id="convertbs"><INPUT name="cbs" type="hidden" value="N">
                <INPUT name="cbsrefresh" type="hidden" value="60000">
            </SPAN>              
            
        <table cellSpacing="0" cellPadding="0" border="1" width="100%" >
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="0" cellPadding="0" border="0" align="left">
                        <tr>
                            <th>Account&nbsp;account&nbsp;&nbsp;&nbsp;Page&nbsp;<input maxLength="8" size="8" class="mws-form-item" name="txtPage" onkeyup="lf_KeyPage()"> 
                            </th>
                        </tr>
						<tr>
							<th>Day:
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(5);"><font color="#CC0000"><u>1 = Wed,Sat,Sun</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(2);"><font color="#FF9900"><u>2 = Sat,Sun</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(1);" ><font color="#33CCFF"><u>3 = Wed</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(3);"><font color="#CC00CC"><u>6 = Sat</u></font></a>
                                &nbsp;&nbsp;<a href="javascript:SetDayAll(4);"><font color="#33CC00"><u>7 = Sun</u></font></a>
                            </th>

						</tr>
                    </table>
                </td></tr>
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="1" cellPadding="0" border="1" align="left">
                        <tr>
                            <th>Grand Total&nbsp;
                                Big : <input maxLength="6" class="mws-form-item" name="TotalBig" value="0" disabled>
                                Sml : <input maxLength="6" class="mws-form-item" name="TotalSml" value="0" disabled>
                                Amt : <input maxLength="6" class="mws-form-item" name="TotalAmt" value="0" disabled>                                                                
                            </th>
                        </tr>
                    </table>
                </td>
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
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 3);
                        </SCRIPT>
                        <th colspan="6"> 
                            Big : <input maxLength="6" class="mws-form-item" style="width: 35px;" name="Pane1Big" value="0" disabled>
                            Sml : <input maxLength="6" class="mws-form-item" style="width: 35px;" name="Pane1Sml" value="0" disabled>
                            Amt : <input maxLength="6" class="mws-form-item" style="width: 35px;" name="Pane1Amt" value="0" disabled>                                                                
                        </th>
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
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 3);
                        </SCRIPT>
                        <th colspan="6">
                            Big : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane2Big" value="0" disabled>
                            Sml : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane2Sml" value="0" disabled>
                            Amt : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane2Amt" value="0" disabled>                                                                
                        </th>
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
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 3);
                        </SCRIPT>
                        <th colspan="6">
	                        Big : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane3Big" value="0" disabled>
                            Sml : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane3Sml" value="0" disabled>
                            Amt : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane3Amt" value="0" disabled>                                                                
                        </th>
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
                                dM(i%2==0 ? 'rEven': 'rOdd', i, 3);
                        </SCRIPT>
                        <th colspan="6">
                            Big : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane4Big" value="0" disabled>
                            Sml : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane4Sml" value="0" disabled>
                            Amt : <input maxLength="6" class="mws-form-item" style="width: 35px;"  name="Pane4Amt" value="0" disabled>                                                                
                        </th>
                    </table>
                </td>
            </tr>
          
			<tr>	
				<td colspan="4" style="align:center;">
                    
                      <table align="center">
                        
                        <tr>
                          <td><button type="button" class="btn " value="Calculate Amount">Calculate Amount</button></td> 
                          <td><button type="button" class="btn " onclick="javascript : SubmitForm();" value="Submit">Submit</button></td>
                          <td><button type="button" class="btn " value="Reset">Reset</button></td>
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
