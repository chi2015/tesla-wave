//Используем измененную функцию pressbutt() для кодировки страницы в XHTML
function XHTMLpressbutt(subm,num,dir){
if(!dir) dir='';
var XHTML_element = 'm'+subm;
var XHTML_SUBMENU = document.getElementById(XHTML_element).style;
if(XHTML_SUBMENU.visibility=='hidden'){
	XHTML_SUBMENU.visibility = 'visible';
	XHTML_SUBMENU.position = 'relative';
}else{
	XHTML_SUBMENU.visibility = 'hidden';
	XHTML_SUBMENU.position = 'absolute';
}
for(i=0;i<num;i++)
	if(i != subm)
	var XHTML_element2 = 'm'+i;
	if(document.getElementById(XHTML_element2)){
		document.getElementById(XHTML_element2).style.visibility = 'hidden';
		document.getElementById(XHTML_element2).style.position = 'absolute';
	}
}