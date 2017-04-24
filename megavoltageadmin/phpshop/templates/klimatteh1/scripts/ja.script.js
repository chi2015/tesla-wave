var currentFontSize = 4;

function revertStyles(fontsize){
	currentFontSize = fontsize;
	changeFontSize(0);
}

function changeFontSize(sizeDifference){
	//get css font size
	var rule = getRuleByName("body.fs" + (currentFontSize + sizeDifference));
	if (rule){
		document.body.style.fontSize = rule.style.fontSize;
		currentFontSize = currentFontSize + sizeDifference;
		createCookie("FontSize", currentFontSize, 365);
		equalHeight();
	}
	return;
	
};

function getRuleByName(ruleName){
	for (i=0; i<document.styleSheets.length; i++){
		var style = document.styleSheets[i];
		var rules = style.cssRules?style.cssRules:style.rules;
		if (rules){
			for (j = 0; j<rules.length; j++){
				if (rules[j].selectorText.trim().toUpperCase() == ruleName.trim().toUpperCase()){
					return rules[j];
				}
			}
		}
	}
	return null;
}

function setActiveStyleSheet(title) {

	createCookie("ColorCSS", title, 365);
	window.location.reload();
	return;

  var i, a, main, arr;
  arr = document.getElementsByTagName("link");
  for(i=0; (a = arr[i]); i++) {
  	var ltitle = a.getAttribute("title");
    if(a.getAttribute("rel").indexOf("style") != -1 && ltitle) {
      a.disabled = true;
      if(ltitle == title) a.disabled = false;
    }
  }
  createCookie("ColorCSS", title, 365);
}

function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function setScreenType(screentype){
	bclass = document.body.className.trim();
	if (bclass.indexOf(' ') > 0){
		bclass = bclass.replace(/^\w+/,screentype);
	}else{
		bclass = screentype + ' ' + bclass;
	}

	document.body.className = bclass;
	equalHeight();
	createCookie("ScreenType", screentype, 365);
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

function changeToolHilite(oldtool, newtool) {
	if (oldtool != newtool) {
		if (oldtool) {
			oldtool.src = oldtool.src.replace(/-hilite/,'');
		}
		newtool.src = newtool.src.replace(/.gif$/,'-hilite.gif');
	}
}

//addEvent - attach a function to an event
function addEvent(obj, evType, fn){ 
 if (obj.addEventListener){ 
   obj.addEventListener(evType, fn, false); 
   return true; 
 } else if (obj.attachEvent){ 
   var r = obj.attachEvent("on"+evType, fn); 
   return r; 
 } else { 
   return false; 
 } 
}

function equalHeight (){
	var obj1 = getElem ('ja-box1');
	var obj2 = getElem ('ja-box2');
	var obj3 = getElem ('ja-box3');
	var maxh = 0;
	if (obj1) maxh = obj1.offsetHeight;
	if (obj2 && obj2.offsetHeight > maxh) maxh = obj2.offsetHeight;
	if (obj3 && obj3.offsetHeight > maxh) maxh = obj3.offsetHeight;
	if (obj1) obj1.parentNode.style.height = maxh + "px";
	if (obj2) obj2.parentNode.style.height = maxh + "px";
	if (obj3) obj3.parentNode.style.height = maxh + "px";
}

function getElem (id) {
	var obj = document.getElementById (id);
	if (!obj) return null;
	divs = obj.getElementsByTagName ('div');
	if (divs && divs.length > 1) return divs[divs.length - 1];
	return null;
}
addEvent (window, 'load', equalHeight);