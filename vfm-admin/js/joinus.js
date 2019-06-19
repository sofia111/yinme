var submit = document.getElementById('submit');
submit.disabled = true;
function isSingle(e) {
	var rem = /^\d+(\.\d+)?$/;
	var IS = rem.test(e.value);
	if(IS == false) {
		submit.disabled = true;
		e.style.border = "1px red solid";
	}else {
		submit.disabled = false;
		e.style.border = "1px #ccc solid";
	}
}
function isDoubles(e) {
	var rem = /^\d+(\.\d+)?$/;
	var IS = rem.test(e.value);
	if(IS == false) {
		submit.disabled = true;
		e.style.border = "1px red solid";
	}else {
		submit.disabled = false;
		e.style.border = "1px #ccc solid";
	}
}
function isCement(e) {
	var rem = /^\d+(\.\d+)?$/;
	var IS = rem.test(e.value);
	if(IS == false) {
		submit.disabled = true;
		e.style.border = "1px red solid";
	}else {
		submit.disabled = false;
		e.style.border = "1px #ccc solid";
	}
}
function isPhone(e) {
	var rem = /^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/;
	var IS = rem.test(e.value);
	if(IS == false) {
		submit.disabled = true;
		e.style.border = "1px red solid";
	}else {
		submit.disabled = false;
		e.style.border = "1px #ccc solid";
	}
}