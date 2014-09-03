<?php

$configFile = '../offline/config.inc.php';

require $configFile;

header('Content-Type: application/javascript');
header('Last-Modified: ' . date ("F d Y H:i:s.", filemtime($configFile)) );

?>$(function(){$("[data-toggle=tooltip]").tooltip();$("h1 .editable").editable("<?php echo PREFIX_LINK; ?>ajax/editTag/",{indicator:"Saving ...",type:"text",name:"name",submit:"OK",cancel:"cancel",placeholder:"Double-click to rename your file...",tooltip:"Double-click to edit...",event:"dblclick",submitdata:function(b,e){return{id:document.getElementsByTagName("h1")[0].getAttribute("data-id"),element:"rename"}},ajaxoptions:{dataType:"json",error:function(){},success:function(){}},always:function(b, e,c,d,a,f){a.editing=!1;d.tooltip&&a.setAttribute("title",d.tooltip);if("undefined"==typeof b.readyState){if(!0===b.status){a.innerHTML=b.result;$.trim(a.innerHTML)||(a.innerHTML=d.placeholder);return}b=c;e="server";c=translate("Server error. Try later.")}a.innerHTML=a.revert;$.trim(a.innerHTML)||(a.innerHTML=d.placeholder);200!=b.status&&(c="HTTP ERROR "+b.status+" : "+b.statusText);alert(translate("An error occured.\n\nType : {{errType}}\nDetails : {{error}}",{errType:e,error:c}))}})});