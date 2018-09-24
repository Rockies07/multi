var colorDefault = "Black";
var colorRoll = "Orange";
var colorIBet = "Red";
var fBig = 1.6;
var fSml = 0.7;
var opNum, opBigNum, opSmlNum, opCmd, opAmt;
var oNum, oBigNum, oSmlNum, oCmd;
var iId;

function BackupValues(NumId) {
    iId = NumId;
    opNum = eval('document.PlaceBetForm.pNumberToBuy' + NumId);    
    opBigNum = eval('document.PlaceBetForm.pBigNum' + NumId);    
    opSmlNum = eval('document.PlaceBetForm.pSmlNum' + NumId);    
    opCmd = eval('document.PlaceBetForm.pCmd' + NumId);
    opAmt = eval('document.PlaceBetForm.pAmt' + NumId);
    
    oNum = eval('document.PlaceBetForm.NumberToBuy' + NumId);    
    oBigNum = eval('document.PlaceBetForm.BigNum' + NumId);    
    oSmlNum = eval('document.PlaceBetForm.SmlNum' + NumId);    
    oCmd = eval('document.PlaceBetForm.Cmd' + NumId);    
}
function SaveValues() {   
    opNum.value = oNum.value;
    opBigNum.value = oBigNum.value;
    opSmlNum.value = oSmlNum.value;
    opCmd.value = oCmd.value;
}
function ChangeDay(NumId) {
    if (document.getElementById) {
        oDay = document.getElementById("Day" + NumId);
    } else if (document.all) {
        oDay = document.all["Day" + NumId];
    }
    var iCur = oDay.selectedIndex;
    if (typeof(iCur) == 'undefined')
            iCur = 0;
    iCur = (iCur + 1) % 5;	
    oDay.options[iCur].selected = "selected";
    oDay.selectedIndex = iCur;
}
function SetDayAll(day) {
    var opDay;
    var iMaxCell = eval('document.PlaceBetForm.MaxCellId').value;
    if (document.getElementById) {
        for (i = 1; i <= iMaxCell; i ++) {
            opDay = document.getElementById("Day" + i);
            opDay.selectedIndex = day;
        }
    } else if (document.all) {
        for (i = 1; i <= iMaxCell; i ++) {
            opDay = document.all["Day" + i];
            opDay.selectedIndex = day;
        }
    }
    RefreshAll();
}

function KeyUpInNum(e, NumId) {
    evt = e ||  window.event;
    BackupValues(NumId);
    //alert (evt.keyCode);
    
    var oUpNum, oDownNum, oUpSmlNum, oUpBigNum, oUpCmd;
    
    //var oNum = eval('document.PlaceBetForm.NumberToBuy' + NumId);    
    //var oBigNum = eval('document.PlaceBetForm.BigNum' + NumId);    
    //var oSmlNum = eval('document.PlaceBetForm.SmlNum' + NumId);    
    //var oCmd = eval('document.PlaceBetForm.Cmd' + NumId);    
    
    var nMaxCellId = parseInt(document.PlaceBetForm.MaxCellId.value);
    
    if (NumId > 1) {
        oUpNum = eval('document.PlaceBetForm.NumberToBuy' + (NumId - 1));
        oUpSmlNum = eval('document.PlaceBetForm.SmlNum' + (NumId - 1));
        oUpBigNum = eval('document.PlaceBetForm.BigNum' + (NumId - 1));
        oUpCmd = eval('document.PlaceBetForm.Cmd' + (NumId - 1));
    }
    if (NumId < nMaxCellId) {
        oDownNum = eval('document.PlaceBetForm.NumberToBuy' + (NumId + 1));
    } else {
        oDownNum = eval('document.PlaceBetForm.NumberToBuy1');
    }
//0:48(96)-------------9:57(105)
    switch (evt.keyCode) {
        case 13: // enter key            
            if (oNum.value.length < 4 || isNaN(oNum.value))
                oNum.value = '';
            
            if (oNum.value != '') {
                oBigNum.focus();
                oBigNum.select();
            } else {
                oNum.focus();
                oNum.select();
            }
            break
        case 187:   // + key: IE
        case 61:    // + key: FF
            
            if (evt.shiftKey) {
                if (NumId > 1) {                    
                    if (isNaN(oNum.value)) {
                        oNum.value = oNum.value.substring(0, oNum.value.length - 1);
                    }
                    
                    //oCmd.value = oUpCmd.value;
                    //oNum.value = oUpNum.value;
                    oBigNum.value = oUpBigNum.value;
                    oSmlNum.value = oUpSmlNum.value;                    
                }
            }
            
            
            break
        case 37: // left key
            if (NumId > 1) {
                if (oNum.value.length < 4 || isNaN(oNum.value))
                    oNum.value = '';
                
                oUpSmlNum.focus();
                oUpSmlNum.select();
            }
            break
        case 38: // up key
            if (NumId > 1) {
                if (oNum.value.length < 4 || isNaN(oNum.value))
                    oNum.value = '';
                
                oUpNum.focus();
                oUpNum.select();
            }
            break
        case 39: // right key
            if (oNum.value.length < 4 || isNaN(oNum.value))
                oNum.value = '';
            
            oBigNum.focus();
            oBigNum.select();
            break
        case 40: // down key
            if (NumId < nMaxCellId) {
                if (oNum.value.length < 4 || isNaN(oNum.value))
                    oNum.value = '';
                
                oDownNum.focus();
                oDownNum.select();
            }
            break
        case 106: 
        case 56: // * key: change day
            if (evt.shiftKey) {
                if (isNaN(oNum.value)) {
                    oNum.value = oNum.value.substring(0, oNum.value.length - 1);
                }
                ChangeDay(NumId); // inside ChangeDay: update Day's pvalue
            }
            break
        case 189: // - key: remove row
            if (event.shiftKey == false) {
                oNum.value = '';
                oBigNum.value = '';
                oSmlNum.value = '';
                oCmd.value = '';                
            }
            oNum.focus();
            break
        case 191: // / key : Roll Number
        case 82: // r key: roll
            if (oCmd.value == 'r' || oCmd.value == 'R') {
                oNum.style.color = colorDefault;
                oBigNum.style.color = colorDefault;
                oSmlNum.style.color = colorDefault;
                oCmd.style.color = colorDefault;                
                oCmd.value = "";
            } else {
                oNum.style.color = colorRoll;
                oBigNum.style.color = colorRoll;
                oSmlNum.style.color = colorRoll;
                oCmd.style.color = colorRoll;
                oCmd.value = "R";
            }
            if (isNaN(oNum.value)) {
                oNum.value = oNum.value.substring(0, oNum.value.length - 1);
            }             
            break
        case 73: // i key: i bet
            if (oCmd.value == 'i' || oCmd.value == 'I') {                
                oNum.style.color = colorDefault;
                oBigNum.style.color = colorDefault;
                oSmlNum.style.color = colorDefault;
                oCmd.style.color = colorDefault;                
                oCmd.value = "";
            } else {                
                oNum.style.color = colorIBet;
                oBigNum.style.color = colorIBet;
                oSmlNum.style.color = colorIBet;
                oCmd.style.color = colorIBet;
                oCmd.value = "i";
            }
            if (isNaN(oNum.value)) {
                oNum.value = oNum.value.substring(0, oNum.value.length - 1);
            }            
            break
        default:
            switch (oNum.value.length) {
                case 0:                    
                    break
                default:
                    if (isNaN(oNum.value) || oNum.value.charAt(oNum.value.length - 1) == ".") {
                        //oNum.value = opNum.value;
                        oNum.focus();
                        oNum.select();
                    }
            }
    }
    CalculateAmount_Total();
    SaveValues();
}
function KeyUpInBig(e, NumId) {
    evt = e ||  window.event;
    BackupValues(NumId);
    
    //var oNum = eval('document.PlaceBetForm.NumberToBuy' + NumId);
    //var oBigNum = eval('document.PlaceBetForm.BigNum' + NumId);
    //var oSmlNum = eval('document.PlaceBetForm.SmlNum' + NumId);
    //var oCmd = eval('document.PlaceBetForm.Cmd' + NumId);
    var oDownNum;
    var nMaxCellId = parseInt(document.PlaceBetForm.MaxCellId.value);
    
    if (NumId > 1) {
        var oUpSmlNum = eval('document.PlaceBetForm.SmlNum' + (NumId - 1));
        var oUpBigNum = eval('document.PlaceBetForm.BigNum' + (NumId - 1));
        var oUpCmd = eval('document.PlaceBetForm.Cmd' + (NumId - 1));
    }
    if (NumId < nMaxCellId) {
        var oDownBigNum = eval('document.PlaceBetForm.BigNum' + (NumId + 1));
        oDownNum = eval('document.PlaceBetForm.NumberToBuy' + (NumId + 1));
    } else {
        oDownNum = eval('document.PlaceBetForm.NumberToBuy1');
    }
// 106 == * 107 == + 109 == - 110 == . 111 == /
    switch (evt.keyCode) {
        case 37: // left key
            if (isNaN(oBigNum.value))
                oBigNum.value = '';
            oNum.focus();
            oNum.select();
            break
        case 38: // up key
            if (isNaN(oBigNum.value))
                oBigNum.value = '';
            if (NumId > 1) {
                oUpBigNum.focus();
                oUpBigNum.select();
            }
            break
        case 39: // right key
            if (isNaN(oBigNum.value))
                oBigNum.value = '';
            oSmlNum.focus();
            oSmlNum.select();
            break
        case 40: // down key
            if (isNaN(oBigNum.value)) {
                oBigNum.value = '';
            }
            if (NumId < nMaxCellId) {
                oDownBigNum.focus();
                oDownBigNum.select();
            }
            break
        case 13: // Enter key: copy previous number's big & sml
            if (oBigNum.value == '') {
                oBigNum.value = oUpBigNum.value;
            }
            if (isNaN(oBigNum.value))
                oBigNum.value = '';
            oSmlNum.focus();
            oSmlNum.select();
            break
            
        default:
            //if (isNaN(oBigNum.value)) {
            if (isNaN(oBigNum.value)) {
                if ((evt.keyCode) == 190)
                    oBigNum.value = '0.';
                else
                    oBigNum.value = oBigNum.value.substring(0, oBigNum.value.length - 1);
            }           
    }    
    CalculateAmount_Total();
    SaveValues();
}
function KeyUpInSml(e, NumId) {
    evt = e || window.event;
    BackupValues(NumId);
    //alert (evt.keyCode);
    
    //var oCmd = eval("document.PlaceBetForm.Cmd" + NumId);
    //var oNum = eval('document.PlaceBetForm.NumberToBuy' + NumId);
    //var oSmlNum = eval('document.PlaceBetForm.SmlNum' + NumId);    
    //var oBigNum = eval('document.PlaceBetForm.BigNum' + NumId);
    var sCurSmlValue = oSmlNum.value;
    var oDownNum;
    
    var nMaxCellId = parseInt(document.PlaceBetForm.MaxCellId.value);
    if (NumId > 1) {
        var oUpSmlNum = eval('document.PlaceBetForm.SmlNum' + (NumId - 1));
        var oUpBigNum = eval('document.PlaceBetForm.BigNum' + (NumId - 1));
        var oUpCmd = eval('document.PlaceBetForm.Cmd' + (NumId - 1));
    }
    if (NumId < nMaxCellId) {
        var oDownSmlNum = eval('document.PlaceBetForm.SmlNum' + (NumId + 1));
        oDownNum = eval('document.PlaceBetForm.NumberToBuy' + (NumId + 1));
    } else {
        oDownNum = eval('document.PlaceBetForm.NumberToBuy1');
    }
    
// 106 == * 107 == + 109 == - 110 == . 111 == /
    switch (evt.keyCode) {
        case 13: // enter key: to cmd field
            if (oSmlNum.value == '') {
                if (NumId > 1) {
                    oSmlNum.value = oUpSmlNum.value;                    
                } else {
                    oSmlNum.value = '';
                }
            }
            oDownNum.focus();
            oDownNum.select();
            break
        case 37: // left key
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = '';
            }
            oBigNum.focus();
            oBigNum.select();
            break
        case 38: // up key
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = '';
            }
            if (NumId > 1) {
                oUpSmlNum.focus();
                oUpSmlNum.select();
            }
            break
        case 39: // right key
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = '';
            }
            if (NumId < nMaxCellId) {
                oDownNum.focus();
                oDownNum.select();
            }
            break
        case 40: // down key
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = '';
            }
            if (NumId < nMaxCellId) {
                oDownSmlNum.focus();
                oDownSmlNum.select();
            }
            break
        case 106:
        case 56: // * key: change day
            
            if (oSmlNum.value.length > 1 && isNaN(oSmlNum.value)) {
                oSmlNum.value = oSmlNum.value.substring(0, oSmlNum.value.length - 1);
            }
            ChangeDay(NumId); // inside ChangeDay: update Day's pvalue
            break
        case 191: // / key : Roll Number
        case 82: // r key: roll
            if (oCmd.value == 'r' || oCmd.value == 'R') {
                oNum.style.color = colorDefault;
                oBigNum.style.color = colorDefault;
                oSmlNum.style.color = colorDefault;
                oCmd.style.color = colorDefault;                
                oCmd.value = "";
            } else {
                oNum.style.color = colorRoll;
                oBigNum.style.color = colorRoll;
                oSmlNum.style.color = colorRoll;
                oCmd.style.color = colorRoll;
                oCmd.value = "R";
            }            
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = oSmlNum.value.substring(0, oSmlNum.value.length - 1);                   
            }            
            oDownNum.focus();
            oDownNum.select();
            break
        case 73: // i key: roll
            //alert (window.event.keyCode);
            if (oCmd.value == 'i' || oCmd.value == 'I') {
                oNum.style.color = colorDefault;
                oBigNum.style.color = colorDefault;
                oSmlNum.style.color = colorDefault;
                oCmd.style.color = colorDefault;                
                oCmd.value = "";
            } else {
                oNum.style.color = colorIBet;
                oBigNum.style.color = colorIBet;
                oSmlNum.style.color = colorIBet;
                oCmd.style.color = colorIBet;                
                oCmd.value = "i";
            }
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = oSmlNum.value.substring(0, oSmlNum.value.length - 1);
            }
            oDownNum.focus();
            oDownNum.select();
            break  
        case 190: // . 
            oSmlNum.value = oSmlNum.value.substring(0, oSmlNum.value.length - 1);
            return;
            break
        default:
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = oSmlNum.value.substring(0, oSmlNum.value.length - 1);
            }
    }
    CalculateAmount_Total();
    SaveValues();
}

function myParseInt(str) {
    if (str == '' || isNaN(str))
        return 0;
    else 
        return parseInt(str);
}
function myParseFloat(str) {
    if (str == '' || isNaN(str))
        return 0;
    else 
        return parseFloat(str);
}
function CountSysNum(sNumber) {
    var nCount, n4D, D1, D2, D3, D4, aSysNums;
    n4D = sNumber;
    D1 = n4D.charAt(0);
    D2 = n4D.charAt(1);
    D3 = n4D.charAt(2);
    D4 = n4D.charAt(3);
    nCount = 1;
    if (D2 != D1) {
        nCount = nCount + 1;
    }
    if (D3 != D1 && D3 != D2) {
        nCount = nCount + 1;
    }
    if (D4 != D1 && D4 != D2 && D4 != D3) {
        nCount = nCount + 1;
    }
    if (nCount == 2) {
        if ((D1 != D2 && D1 != D3 && D1 != D4) || (D2 != D1 && D2 != D3 && D2 != D4) || (D3 != D1 && D3 != D2 && D3 != D4) || (D4 != D1 && D4 != D2 && D4 != D3)) {
            nCount = 5;
        }
    }
    aSysNums = new Array(6);
    aSysNums[1] = 1;
    aSysNums[2] = 6;
    aSysNums[3] = 12;
    aSysNums[4] = 24;
    aSysNums[5] = 4;
    return aSysNums[nCount];
}

function CalculateAmount_One(iNum, fBigNum, iSmlNum, sCmd, iDay) {
    var fAmount = 0;
    var iCount = CountSysNum(iNum);
    var bSys = sCmd == 'R' || sCmd.value == 'r' ? true : false;
    if (bSys == true) {
        fAmount =  iCount * (fBigNum * fBig + iSmlNum * fSml) 
    } else {
        fAmount = fBigNum * fBig + iSmlNum * fSml;
    }
    
    if (iDay == 1) {
            fAmount = fAmount * 3;
    } else if (iDay == 2) {
            fAmount = fAmount * 2;
    } 
    
    fAmount = Math.round(fAmount * 100) / 100;
    //fAmount = fAmount.toFixed(2);
    return fAmount;
}
function CalculateAmount_Total() {
	
    var oBigTotal = eval('document.PlaceBetForm.TotalBig');
    var fBigTotal = myParseFloat(oBigTotal.value);
    var fBigNum_Prv = myParseFloat(opBigNum.value);
    var fBigNum = myParseFloat(oBigNum.value);   	
    var fBig_Chg = fBigNum_Prv - fBigNum;
    fBigTotal = fBigTotal - fBig_Chg;	
    fBigTotal = Math.round(fBigTotal * 100) / 100;
    oBigTotal.value = fBigTotal;
	
    
    var oSmlTotal = eval('document.PlaceBetForm.TotalSml');
    var iSmlTotal = myParseInt(oSmlTotal.value);
    var iSmlNum_Prv = myParseInt(opSmlNum.value);
    var iSmlNum = myParseInt(oSmlNum.value);   
    var iSml_Chg = iSmlNum_Prv - iSmlNum;
    iSmlTotal = iSmlTotal - iSml_Chg;
    oSmlTotal.value = iSmlTotal;
    
    var oAmtTotal = eval('document.PlaceBetForm.TotalAmt');
    var fAmtTotal = myParseFloat(oAmtTotal.value);
    
    if (document.getElementById) {
        oDay = document.getElementById("Day" + iId);
    } else if (document.all) {
        oDay = document.all["Day" + iId];
    }
    
    var fAmt_Prv = myParseFloat(opAmt.value);
    var fAmt = CalculateAmount_One(oNum.value, oBigNum.value, oSmlNum.value, oCmd.value, oDay.value);
    var fAmt_Chg = fAmt_Prv - fAmt;
	
    
    var iPane = Math.floor((iId - 1) / 20) + 1;    
    var oPaneBig = eval('document.PlaceBetForm.Pane' + iPane + 'Big');
    var oPaneSml = eval('document.PlaceBetForm.Pane' + iPane + 'Sml');
    var oPaneAmt = eval('document.PlaceBetForm.Pane' + iPane + 'Amt');    
    var fTemp, iTemp;

    
    fTemp = myParseFloat(oPaneBig.value);
    fTemp = fTemp - fBig_Chg;
    //fTemp = Math.round(fTemp * 100) / 100;
    fTemp = fTemp.toFixed(2);
    oPaneBig.value = fTemp;
	
    
    iTemp = myParseInt(oPaneSml.value);
    iTemp = iTemp - iSml_Chg;
    oPaneSml.value = iTemp;
    
    fTemp = myParseFloat(oPaneAmt.value);
    fTemp = fTemp - fAmt_Chg;
    //fTemp = Math.round(fTemp * 100) / 100;
    fTemp = fTemp.toFixed(2);
    oPaneAmt.value = fTemp;   
    
    opAmt.value = fAmt; // Save Amount in pAmt
    
    fAmtTotal = fAmtTotal - fAmt_Chg;
    //fAmtTotal = Math.round(fAmtTotal * 100) / 100;    
    fAmtTotal = fAmtTotal.toFixed(2);
    oAmtTotal.value = fAmtTotal;
}
function RefreshAll() {
    var oBigTotal = eval('document.PlaceBetForm.TotalBig');
    var oSmlTotal = eval('document.PlaceBetForm.TotalSml');
    var oAmtTotal = eval('document.PlaceBetForm.TotalAmt');
    var oPane1Big = eval('document.PlaceBetForm.Pane1Big');
    var oPane1Sml = eval('document.PlaceBetForm.Pane1Sml');
    var oPane1Amt = eval('document.PlaceBetForm.Pane1Amt');
    var oPane2Big = eval('document.PlaceBetForm.Pane2Big');
    var oPane2Sml = eval('document.PlaceBetForm.Pane2Sml');
    var oPane2Amt = eval('document.PlaceBetForm.Pane2Amt');
    var oPane3Big = eval('document.PlaceBetForm.Pane3Big');
    var oPane3Sml = eval('document.PlaceBetForm.Pane3Sml');
    var oPane3Amt = eval('document.PlaceBetForm.Pane3Amt');
    var oPane4Big = eval('document.PlaceBetForm.Pane4Big');
    var oPane4Sml = eval('document.PlaceBetForm.Pane4Sml');
    var oPane4Amt = eval('document.PlaceBetForm.Pane4Amt');
    
    var fBigTotal = 0, fBigTmp = 0;
    var iSmlTotal = 0, iSmlTmp = 0;
    var fAmtTotal = 0, fAmtTmp = 0;   
    
    var fBigPane1 = 0, fBigPane2 = 0, fBigPane3 = 0, fBigPane4 = 0;
    var iSmlPane1 = 0, iSmlPane2 = 0, iSmlPane3 = 0, iSmlPane4 = 0;
    var fAmtPane1 = 0, fAmtPane2 = 0, fAmtPane3 = 0, fAmtPane4 = 0;       
    
    for (i = 1; i <= 80; i ++) {
        if (document.getElementById) {
            oDay = document.getElementById("Day" + i);
        } else if (document.all) {
            oDay = document.all["Day" + i];
        }
        BackupValues(i);
        var fAmtTmp = CalculateAmount_One(oNum.value, oBigNum.value, oSmlNum.value, oCmd.value, oDay.value);
        if (fAmtTmp > 0) {
            SaveValues();
            fBigTmp = myParseFloat(oBigNum.value);
            iSmlTmp = myParseInt(oSmlNum.value);
            
            fBigTotal = fBigTotal + fBigTmp;
            iSmlTotal = iSmlTotal + iSmlTmp;
            fAmtTotal = fAmtTotal + fAmtTmp;           
            
            if (i <= 20) {
                fBigPane1 = fBigPane1 + fBigTmp;
                iSmlPane1 = iSmlPane1 + iSmlTmp;
                fAmtPane1 = fAmtPane1 + fAmtTmp;               
            } else if (i <= 40) {
                fBigPane2 = fBigPane2 + fBigTmp;
                iSmlPane2 = iSmlPane2 + iSmlTmp;
                fAmtPane2 = fAmtPane2 + fAmtTmp;               
            } else if (i <= 60) {
                fBigPane3 = fBigPane3 + fBigTmp;
                iSmlPane3 = iSmlPane3 + iSmlTmp;
                fAmtPane3 = fAmtPane3 + fAmtTmp;               
            } else if (i <= 80) {
                fBigPane4 = fBigPane4 + fBigTmp;
                iSmlPane4 = iSmlPane4 + iSmlTmp;
                fAmtPane4 = fAmtPane4 + fAmtTmp;             
            }
        }       
    }    
    
    fBigTotal = fBigTotal.toFixed(2);
    fAmtTotal = fAmtTotal.toFixed(2);
    
    fBigPane1 = fBigPane1.toFixed(2);
    fAmtPane1 = fAmtPane1.toFixed(2);
    
    fBigPane2 = fBigPane2.toFixed(2);
    fAmtPane2 = fAmtPane2.toFixed(2);
    
    fBigPane3 = fBigPane3.toFixed(2);
    fAmtPane3 = fAmtPane3.toFixed(2);
    
    fBigPane4 = fBigPane4.toFixed(2);
    fAmtPane4 = fAmtPane4.toFixed(2);
    
    oBigTotal.value = fBigTotal;
    oSmlTotal.value = iSmlTotal;
    oAmtTotal.value = fAmtTotal;
    
    oPane1Big.value = fBigPane1;
    oPane1Sml.value = iSmlPane1;
    oPane1Amt.value = fAmtPane1;
    
    oPane2Big.value = fBigPane2;
    oPane2Sml.value = iSmlPane2;
    oPane2Amt.value = fAmtPane2;
    
    oPane3Big.value = fBigPane3;
    oPane3Sml.value = iSmlPane3;
    oPane3Amt.value = fAmtPane3;
    
    oPane4Big.value = fBigPane4;
    oPane4Sml.value = iSmlPane4;
    oPane4Amt.value = fAmtPane4;
}

function Validate4D(NumId) {
    var bValid4D = true;
    var eNumberToBuy = eval("document.PlaceBetForm.NumberToBuy" + NumId);
    if (eNumberToBuy.value == "") {
        bValid4D = false;
    } else {
        if (eNumberToBuy.value.length != 4) {
            bValid4D = false;
        } else {
            if (isNaN(eNumberToBuy.value)) {
                bValid4D = false;
            }
        }
    }
    return bValid4D;
}
function ValidateForm() {
    var bFormValid = true;
    var nNumCount = 0;
    var i, oBigNum, oSmlNum, oCmd, oNum, oDay;
    var betbet = document.PlaceBetForm.WhoseBet.value;
    var peyg = document.PlaceBetForm.PageNo.value;
    for (i = 0; i < peyg.length; i++)
    {
        if (peyg.charAt(i) == '&')
        {
            alert("Invalid Page Reference");
            bFormValid = false;
            document.PlaceBetForm.PageNo.focus();
        }
    }
    if (peyg.indexOf("FIX-") != -1) {
        alert("Pls. dont use words FIX-,SMS- and WAP-");
        bFormValid = false;
        document.PlaceBetForm.PageNo.focus();
    }
    if (peyg.indexOf("SMS-") != -1) {
        alert("Pls. dont use words FIX-,SMS- and WAP-");
        bFormValid = false;
        document.PlaceBetForm.PageNo.focus();
    }
    if (peyg.indexOf("WAP-") != -1) {
        alert("Pls. dont use words FIX-,SMS- and WAP-");
        bFormValid = false;
        document.PlaceBetForm.PageNo.focus();
    }
    if (peyg.indexOf("fix-") != -1) {
        alert("Pls. dont use words FIX-,SMS- and WAP-");
        bFormValid = false;
        document.PlaceBetForm.PageNo.focus();
    }
    if (peyg.indexOf("sms-") != -1) {
        alert("Pls. dont use words FIX-,SMS- and WAP-");
        bFormValid = false;
        document.PlaceBetForm.PageNo.focus();
    }
    if (peyg.indexOf("wap-") != -1) {
        alert("Pls. dont use words FIX-,SMS- and WAP-");
        bFormValid = false;
        document.PlaceBetForm.PageNo.focus();
    }
    if (betbet == "---- Select Member ----" || betbet == "")
    {
        alert("Please choose a member!");
        bFormValid = false;
    }
    if (betbet != "---- Select Member ----")
    {
        for (i = 1; i <= nNumOfRows * 4; i++) {
            oBigNum = eval("document.PlaceBetForm.BigNum" + i);
            oSmlNum = eval("document.PlaceBetForm.SmlNum" + i);
            oCmd = eval("document.PlaceBetForm.Cmd" + i);
            oNum = eval("document.PlaceBetForm.NumberToBuy" + i);
            oDay = eval("document.PlaceBetForm.Day" + i);
            if (oNum.value != "") {
                if (oNum.value.length != 4) {
                    bFormValid = false;
                    alert("Please enter the 4D in correct format!");
                    oNum.focus();
                } else {
                    if (isNaN(oNum.value)) {
                        bFormValid = false;
                        alert("Please enter the 4D in correct format!");
                        oNum.focus();
                    } else {
                        if (isNaN(oBigNum.value) || isNaN(oSmlNum.value)) {
                            bFormValid = false;
                            alert("Please enter Big and Small amount to bet!");
                            oBigNum.focus();
                        } else {
                            if (oBigNum.value == "") {
                                oBigNum.value = 0;
                            }
                            if (oSmlNum.value == "") {
                                oSmlNum.value = 0;
                            }
                            if (oBigNum.value == 0 &&
                                    oSmlNum.value == 0) {
                                bFormValid = false;
                                alert("Please select how many you want to buy!");
                                oBigNum.focus();
                            } else {
                                if (isNaN(oDay.value) || oDay.value == "") {
                                    bFormValid = false;
                                    alert("Please select at least one Draw Date!");
                                    oDay.focus()
                                } else {
                                    nNumCount += 1;
                                    if (oCmd.value == 'r' || oCmd.value == 'R') {
//AddCmd(i);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    else {
        alert("Please choose a member!");
        bFormValid = false;
    }
    if (bFormValid == true) {
        if (nNumCount > 0) {
            if (confirm("Please note: once submit the bets, you would not be able to change them!\nClick Ok to proceed your bets, or Cancel to make changes!"))
            {
// document.PlaceBetForm.SendBut.disabled=true;
// var balance = parseFloat(document.PlaceBetForm.Balance.value);
// var total_amount = parseFloat(document.getElementById('TotalAmt').value);
// alert(document.PlaceBetForm.Balance.value);
// alert(document.getElementById('TotalAmt').value);
//if (total_amount > balance)
//{
// alert("Bets exceed your remaining balance.\nPlease change your bets or contact your agent.");
// return false;
//}
//document.PlaceBetForm.TotBig.value=document.PlaceBetForm.TotalBig.value;
//document.PlaceBetForm.TotSml.value=document.PlaceBetForm.TotalSml.value;
                document.PlaceBetForm.submit();
            } else {
                return false;
            }
        } else {
            alert("Please buy at least one number!");
            return false;
        }
    } else {
        return false;
    }
} 
function ResetForm() {
    if (confirm('Are you sure to clear the form?') == true) {
        document.PlaceBetForm.reset();
    }
    document.PlaceBetForm.NumberToBuy1.focus();
    document.PlaceBetForm.NumberToBuy1.select();
}
function SubmitForm() {    
    var FlagValidate = false;
    // Write your own code befor Submit
    if (FlageValidate)
        document.PlaceBetForm.submit();
}
