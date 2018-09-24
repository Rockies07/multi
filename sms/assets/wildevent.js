var colorDefault = "White";
var colorRoll = "Orange";
var colorIBet = "Red";
var fBig = 1.6;
var fSml = 0.7;
var opDay, opNum, opBigNum, opSmlNum, opCmd, opAmt;
var oNum, oBigNum, oSmlNum, oCmd;
var iDay;
var iId;

function BackupValues(NumId) {
    iId = NumId;

    opNum = eval('document.PlaceBetForm.pNumberToBuy' + iId);
    opBigNum = eval('document.PlaceBetForm.pBigNum' + iId);
    opSmlNum = eval('document.PlaceBetForm.pSmlNum' + iId);
    opCmd = eval('document.PlaceBetForm.pCmd' + iId);
    opAmt = eval('document.PlaceBetForm.pAmt' + iId);

    oNum = eval('document.PlaceBetForm.NumberToBuy' + iId);
    oBigNum = eval('document.PlaceBetForm.BigNum' + iId);
    oSmlNum = eval('document.PlaceBetForm.SmlNum' + iId);
    oCmd = eval('document.PlaceBetForm.Cmd' + iId);
}
function SaveValues() {
    opNum.value = oNum.value;
    opBigNum.value = oBigNum.value;
    opSmlNum.value = oSmlNum.value;
    opCmd.value = oCmd.value;
}

function KeyUpInNum(e, NumId) {
    evt = e || window.event;
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
            if (oNum.value != '') {
                oBigNum.focus();
                oBigNum.select();
            } else {
                oNum.focus();
                oNum.select();
            }
            break
        case 37: // left key
            if (NumId > 1) {
                ValidateNum(oNum);                
                oUpSmlNum.focus();
                oUpSmlNum.select();
            }
            break
        case 38: // up key
            if (NumId > 1) {
                ValidateNum(oNum);
                oUpNum.focus();
                oUpNum.select();
            }
            break
        case 39: // right key            
            ValidateNum(oNum);
            oBigNum.focus();
            oBigNum.select();
            break
        case 40: // down key
            if (NumId < nMaxCellId) {
                ValidateNum(oNum);
                oDownNum.focus();
                oDownNum.select();
            }
            break
	}
}
function KeyUpInBig(e, NumId) {
    evt = e || window.event;
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
            ValidateBig(oBigNum);
            oNum.focus();
            oNum.select();
            break
        case 38: // up key
            ValidateBig(oBigNum);
            if (NumId > 1) {
                oUpBigNum.focus();
                oUpBigNum.select();
            }
            break
        case 39: // right key
            ValidateBig(oBigNum);
            oSmlNum.focus();
            oSmlNum.select();
            break
        case 40: // down key
            ValidateBig(oBigNum);
            if (NumId < nMaxCellId) {
                oDownBigNum.focus();
                oDownBigNum.select();
            }
            break
        case 13: // Enter key: copy previous number's big & sml
            if (oBigNum.value == '') {
                oBigNum.value = oUpBigNum.value;
            }
            ValidateBig(oBigNum);
            oSmlNum.focus();
            oSmlNum.select();
            break

        default:           
            if (isNaN(oBigNum.value)) {
                if ((evt.keyCode) == 190 || (evt.keyCode) == 110)
                    oBigNum.value = '0.';
                else
                    oBigNum.value = oBigNum.value.substring(0, oBigNum.value.length - 1);
            }
    }
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
            if ((oSmlNum.value - Math.floor(oSmlNum.value)) != 0) {
				oSmlNum.value = '';
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
        case 190: // . 
            oSmlNum.value = oSmlNum.value.substring(0, oSmlNum.value.length - 1);
            return;
            break
        default:
            if (isNaN(oSmlNum.value)) {
                oSmlNum.value = oSmlNum.value.substring(0, oSmlNum.value.length - 1);
            }
    }
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
        for (i = 1; i <= iMaxCell; i++) {
            opDay = document.getElementById("Day" + i);
            document.getElementById("Day" + i).setAttribute("class", "day"+day);			
            opDay.value = day;
        }
    } else if (document.all) {
        for (i = 1; i <= iMaxCell; i++) {
            opDay = document.all["Day" + i].setAttribute("class", "day"+day);
            opDay.value = day;
        }
    }
}

function ChangeValue(NumId) {
    BackupValues(NumId);
	document.getElementById("Day"+NumId).setAttribute("class", "day"+document.getElementById("Day"+NumId).value);
    //ChangeDay(NumId);
    //alert(oDay.value);
    SaveValues();
}

function ValidateNum(obj) {
    if (obj.value.length < 4 || isNaN(obj.value)) {
        obj.value = '';
        return false;
    } else {
        return true;
    }
}

function ValidateBig(obj) {
    if (isNaN(obj.value)) {
        obj.value = '';
        return false;
    }
    
    var fValTemp = obj.value;
    if ((fValTemp * 100) % 25 == 0) {        
        //alert ("Good");
        return true;
    } else {
        //alert ("Bad");
        obj.value = '';
        return false;
    }
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
    var fBigTmp = 0;
    var fSmlTmp = 0;
    var iMltVal = 1;       // Additional Multiplication Value

    var fAmount = 0;
    fAmount = fBigNum * fBig + iSmlNum * fSml;

    var iCount = CountSysNum(iNum);
    var bSys = sCmd == 'R' || sCmd.value == 'r' ? true : false;

    if (bSys == true) {
        iMltVal = iCount;
    } else {
        iMltVal = 1;
    }

    if (iDay == 1) {
        iMltVal = iMltVal * 3;
    } else if (iDay == 2) {
        iMltVal = iMltVal * 2;
    } else if (iDay == 0) {
        iMltVal = 0;
    }

    fReturn = new Array(
            iMltVal * fBigNum,
            iMltVal * iSmlNum,
            iMltVal * (fBigNum * fBig + iSmlNum * fSml)
            );
    //fAmount = Math.round(fAmount * 100) / 100;
    //fAmount = fAmount.toFixed(2);
    return fReturn;
}
function CalculateAmount_Total() {
    var fResultOld = CalculateAmount_One(opNum.value, opBigNum.value, opSmlNum.value, opCmd.value);
    var fResultNew = CalculateAmount_One(oNum.value, oBigNum.value, oSmlNum.value, oCmd.value);

    var oBigTotal = eval('document.PlaceBetForm.TotalBig');
    var oSmlTotal = eval('document.PlaceBetForm.TotalSml');
    var oAmtTotal = eval('document.PlaceBetForm.TotalAmt');

    oBigTotal.value = oBigTotal.value - fResultOld[0] + fResultNew[0];
    oSmlTotal.value = oSmlTotal.value - fResultOld[1] + fResultNew[1];
    oAmtTotal.value = (oAmtTotal.value - fResultOld[2] + fResultNew[2]).toFixed(2);

    var iPane = Math.floor((iId - 1) / 20) + 1;

    var oPaneBig = eval('document.PlaceBetForm.Pane' + iPane + 'Big');
    var oPaneSml = eval('document.PlaceBetForm.Pane' + iPane + 'Sml');
    var oPaneAmt = eval('document.PlaceBetForm.Pane' + iPane + 'Amt');

    oPaneBig.value = oPaneBig.value - fResultOld[0] + fResultNew[0];
    oPaneSml.value = oPaneSml.value - fResultOld[1] + fResultNew[1];
    oPaneAmt.value = (oPaneAmt.value - fResultOld[2] + fResultNew[2]).toFixed(2);
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
    
    var fResultTemp;

    for (i = 1; i <= 80; i++) {
        BackupValues(i);
        if (myParseFloat(oBigNum.value) == 0 && myParseFloat(oSmlNum.value) == 0) {
            continue;
        }
        fResultTemp = CalculateAmount_One(oNum.value, oBigNum.value, oSmlNum.value, oCmd.value, oDay.value);
        if (fResultTemp[2] > 0) {
            SaveValues();
            fBigTmp = myParseFloat(oBigNum.value);
            iSmlTmp = myParseInt(oSmlNum.value);

            fBigTotal = fBigTotal + fResultTemp[0];
            iSmlTotal = iSmlTotal + fResultTemp[1];
            fAmtTotal = fAmtTotal + fResultTemp[2];

            if (i <= 20) {
                fBigPane1 = fBigPane1 + fResultTemp[0];
                iSmlPane1 = iSmlPane1 + fResultTemp[1];
                fAmtPane1 = fAmtPane1 + fResultTemp[2];
            } else if (i <= 40) {
                fBigPane2 = fBigPane2 + fResultTemp[0];
                iSmlPane2 = iSmlPane2 + fResultTemp[1];
                fAmtPane2 = fAmtPane2 + fResultTemp[2];
            } else if (i <= 60) {
                fBigPane3 = fBigPane3 + fResultTemp[0];
                iSmlPane3 = iSmlPane3 + fResultTemp[1];
                fAmtPane3 = fAmtPane3 + fResultTemp[2];
            } else if (i <= 80) {
                fBigPane4 = fBigPane4 + fResultTemp[0];
                iSmlPane4 = iSmlPane4 + fResultTemp[1];
                fAmtPane4 = fAmtPane4 + fResultTemp[2];
            }
        }
    }

    oBigTotal.value = fBigTotal.toFixed(2);
    oSmlTotal.value = iSmlTotal.toFixed(2);
    oAmtTotal.value = fAmtTotal.toFixed(2);

    oPane1Big.value = fBigPane1.toFixed(2);
    oPane1Sml.value = iSmlPane1.toFixed(2);
    oPane1Amt.value = fAmtPane1.toFixed(2);

    oPane2Big.value = fBigPane2.toFixed(2);
    oPane2Sml.value = iSmlPane2.toFixed(2);
    oPane2Amt.value = fAmtPane2.toFixed(2);

    oPane3Big.value = fBigPane3.toFixed(2);
    oPane3Sml.value = iSmlPane3.toFixed(2);
    oPane3Amt.value = fAmtPane3.toFixed(2);

    oPane4Big.value = fBigPane4.toFixed(2);
    oPane4Sml.value = iSmlPane4.toFixed(2);
    oPane4Amt.value = fAmtPane4.toFixed(2);
}

function SubmitForm() {
        document.PlaceBetForm.submit();
}

function ResetForm(){
  if(confirm('Are you sure to clear the form?')==true){
    document.PlaceBetForm.reset();
  }
  for(i=1; i<=80; i++){

  }
  document.PlaceBetForm.NumberToBuy1.focus();
  document.PlaceBetForm.NumberToBuy1.select();
}

function ValidateForm(){

	var bFormValid = true;
	var nNumCount=0;
	var i, oBigNum,oSmlNum,oSysEntry,oNum,oDay;
	var betmebid = document.PlaceBetForm.WhoseBet.value;
	var betpage = document.PlaceBetForm.txtPage.value;
	betpage = betpage.toLowerCase();

for (i=0;i<betpage.length;i++)
{
   if (betpage.charAt(i)=='&')
   	{
	 alert("Invalid Character in Page Reference");
 	 bFormValid = false;	
	 document.PlaceBetForm.txtPage.focus();
	}
}

if (betpage.indexOf("fix-")!=-1) {
	 alert("FIX- in Page Reference is reserved for system use.");
 	 bFormValid = false;	
	 document.PlaceBetForm.txtPage.focus();
}
if (betpage.indexOf("sms-")!=-1) {
	 alert("SMS- in Page Reference is reserved for system use.");
 	 bFormValid = false;	
	 document.PlaceBetForm.txtPage.focus();
}
if (betpage.indexOf("wap-")!=-1) {
	 alert("WAP- in Page Reference is reserved for system use.");
 	 bFormValid = false;	
	 document.PlaceBetForm.txtPage.focus();
}
if (betpage.indexOf("mob-")!=-1) {
	 alert("MOB- in Page Reference is reserved for system use.");
 	 bFormValid = false;	
	 document.PlaceBetForm.txtPage.focus();
}
if (betpage.indexOf("wld-")!=-1) {
	 alert("WLD- in Page Reference is reserved for system use.");
 	 bFormValid = false;	
	 document.PlaceBetForm.txtPage.focus();
}
if (betpage.indexOf("ara-")!=-1) {
	 alert("ARA- in Page Reference is reserved for system use.");
 	 bFormValid = false;	
	 document.PlaceBetForm.txtPage.focus();
}

if (betmebid.length != 8)
{
	alert("Please choose a member!");
	bFormValid = false;
}
  
if (betmebid.length = 8)
{
	for(i=1; i<11; i++)
	{

		oBigNum=eval("document.PlaceBetForm.BigNum"+i);
		oSmlNum=eval("document.PlaceBetForm.SmlNum"+i);
		oSysEntry=eval("document.PlaceBetForm.Cmd"+i);
		oNum=eval("document.PlaceBetForm.NumberToBuy"+i);
		oDay=eval("document.PlaceBetForm.Day"+i);

		if (oNum.value != "")
		{
			if (oNum.value.length != 4)
			{
				bFormValid = false;
				alert("Please enter the 4D in correct format!");
				oNum.focus();
			}
			else
			{
				if (isNaN(oBigNum.value) || isNaN(oSmlNum.value))
				{
					bFormValid = false;
					alert("Please enter Big and Small amount to bet!");
					oBigNum.focus();
				}
				else
				{
					if (oBigNum.value == "")
					{
					  oBigNum.value = 0;
					}
					if (oSmlNum.value == "")
					{
					  oSmlNum.value = 0;
					}
					if ((oBigNum.value * 100) % 25 != 0) 
					{
						bFormValid = false;
						alert("only .25 .5 and .75 allowed in big!");
						oBigNum.focus();
					}
					if (oSmlNum.value > 0 && oSmlNum.value < 1)
					{
						bFormValid = false;
						alert("Small number cannot be smaller than 1!");
						oSmlNum.focus();
					}
					if (oBigNum.value == 0 && oSmlNum.value == 0)
					{
						bFormValid = false;
						alert("Please enter Big and Small amount to bet!");
						oBigNum.focus();
					}
					else
					{
						nNumCount+=1;
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

if (bFormValid == true){
    if (nNumCount>0){
      
        document.PlaceBetForm.submit();
    }else{

      alert("Please buy at least one number!");

      return false;

    }

  }else{

    return false;

  }

}