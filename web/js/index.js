window.onload=function () {

	var oul=document.getElementById('nav_ul');
    var oLi=oul.getElementsByTagName('a')[1];
    var oSubul=oul.getElementsByTagName('ul')[0];
    var timer=null;

    oSubul.onmouseover=oLi.onmouseover=function () {
        clearInterval(timer);
	    oSubul.style.display="block";
    }
	oSubul.onmouseout=oLi.onmouseout=function () {
	        timer=setInterval(function () {
	    	oSubul.style.display="none";
	    },300);
		
	}
}
