var is_mozilla = navigator.userAgent.toLowerCase().indexOf('mozilla') > -1;
var is_ie = navigator.userAgent.toLowerCase().indexOf('msie') > -1;
alert(navigator.userAgent.toLowerCase());
if (!is_mozilla) {
alert('Browser not supported, please use Mozilla/IE Only');
window.location = "http://www.google.com/";
is_ie=true;
break;
}
else if (!is_ie) {
alert('Browser not supported, please use Mozilla/IE Only');
window.location = "http://www.google.com/";
break;
}