
<HEAD>

<script type="text/javascript">

function startCalc(){
  interval = setInterval("calc()",1);
}
function calc(){
  one = document.autoSumForm.firstBox.value;
  two = document.autoSumForm.secondBox.value;
  document.autoSumForm.thirdBox.value = (one * 1) + (two * 1);
}
function stopCalc(){
  clearInterval(interval);
}

</script>
</HEAD>
<BODY>

<form name="autoSumForm"><input type=text name="thirdBox">
<input type=text name="firstBox" value="" onFocus="startCalc();" onBlur="stopCalc();"> +
<input type=text name="secondBox" value="" onFocus="startCalc();" onBlur="stopCalc();"> =

</form>
</BODY>
