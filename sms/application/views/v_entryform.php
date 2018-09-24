<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" ""><HTML><HEAD><META 
            content="IE=5.0000" http-equiv="X-UA-Compatible">
        <TITLE></TITLE> 
        <META http-equiv="Content-Type" content="text/html; charset=windows-1252"> 
        <META http-equiv="pragma" content="no-cache"> 
        <META http-equiv="cache-control" content="no-cache"> 
		<base href="<?PHP echo base_url(); ?>">
        <META name="GENERATOR" content="MSHTML 10.00.9200.16521"> 
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
                
                htmlday = '<OPTION value="3" ' + htmlsetday + '>3</OPTION><OPTION value="3">3</OPTION><OPTION value="2">2</OPTION><OPTION value="6">6</OPTION><OPTION value="7">7</OPTION><OPTION value="1">1</OPTION>';
                
                document.writeln('<tr class=' + rowstyle + '>');
                document.writeln('  <td>' + n + '</td>');
                document.writeln('  <td><select tabindex="-1" size="1" name="Day' + n + '" id="Day' + n + '" ' + htmlday + '</select></td>');
                document.writeln('  <td><input maxLength="4" style="width: 41px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="NumberToBuy' + n + '" id=NTB' + n + '" value=""  onkeyup="javascript: KeyUpInNum(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="BigNum' + n + '" id="BN' + n + '" value="" onkeyup="javascript: KeyUpInBig(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="SmlNum' + n + '" id="SN' + n + '" value="" onkeyup="javascript: KeyUpInSml(event, ' + n + ');"></td>');
                document.writeln('  <td><input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Cmd' + n + '" id="CMD' + n + '" value="" disabled></td>');
                document.writeln('</tr>');
                document.writeln('  <input type="hidden" value="0" name="pCmd' + n + '">');
            }
        </SCRIPT>
    </HEAD> 
    <BODY>
		<?php
			$attributes = array('name' => 'PlaceBetForm');
			$hidden = array('meb_id' => '11111111', 'mas_id' => '11',
							'agg_id' => '1111', 'agt_id' => '111111');
			echo form_open('c_checkout', $attributes, $hidden); 
		?>
            <INPUT name="setday" type="hidden" value="N"> 
            <INPUT type="hidden" value="80" name="MaxCellId">
            <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                <TBODY>
                    <TR>
                        <TD align="center">Please select an account to place bets
                        </TD>
                    </TR>
                </TBODY>
            </TABLE>
        

        <table cellSpacing="1" cellPadding="0" border="1">
            <tr>
                <td colspan="4">
                    <table width="100%" cellSpacing="1" cellPadding="0" border="0" align="left">
                        <tr>
                            <th>Account&nbsp;<?PHP echo form_dropdown('meb_id', $meb_id);?>&nbsp;&nbsp;&nbsp;Page&nbsp;
                                <input maxLength="8" size="8" style="FONT-WEIGHT: bold; FONT-SIZE: 12px;" name="txtPage" onkeyup="lf_KeyPage()"> (
                                | <a href="javascript:SetDayAll(0);">3:We</a>
                                | <a href="javascript:SetDayAll(1);">2:Sa|Su</a>
                                | <a href="javascript:SetDayAll(2);">6:Sa</a>
                                | <a href="javascript:SetDayAll(3);">7:Su</a>
                                | <a href="javascript:SetDayAll(4);">1:We|Sa|Su</a>
                            )</th>
                        </tr>
                    </table>
                </td></tr>
            <tr>
                <td colspan="3">
                    <table width="100%" cellSpacing="1" cellPadding="0" border="1" align="left">
                        <tr>
                            <th>Grand Total&nbsp;
                                Big : <input maxLength="6" style="width: 50px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="TotalBig" value="0" disabled>
                                Sml : <input maxLength="6" style="width: 50px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="TotalSml" value="0" disabled>
                                Amt : <input maxLength="6" style="width: 60px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="TotalAmt" value="0" disabled>                                                                
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
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane1Big" value="0" disabled>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane1Sml" value="0" disabled>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane1Amt" value="0" disabled>                                                                
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
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane2Big" value="0" disabled>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane2Sml" value="0" disabled>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane2Amt" value="0" disabled>                                                                
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
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane3Big" value="0" disabled>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane3Sml" value="0" disabled>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane3Amt" value="0" disabled>                                                                
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
                            Big : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane4Big" value="0" disabled>
                            Sml : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane4Sml" value="0" disabled>
                            Amt : <input maxLength="6" style="width: 35px; FONT-WEIGHT: bold; FONT-SIZE: 13px;" name="Pane4Amt" value="0" disabled>                                                                
                        </th>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td><INPUT type="button" value="Calculate Amount"></td>
                            <td><INPUT type="button" value="Submit" onclick="javascript : SubmitForm();"></td>
                            <td><INPUT type="reset" value="Reset"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </FORM>

</body>
</html>

</BODY>


</HTML>
