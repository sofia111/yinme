function checkForm() {
	var idtip = checkUserId();
	var nametip = checkUserName();
	var phoneNumtip = checkPhoneNum();
	var passwordtip = checkPassword();
	var confirmPassword = checkConfirmPassword();
	return idtip && nametip && phoneNumtip && passwordtip && confirmPassword;
}
//验证用户名
function checkUserName(){
	var username = document.getElementById('userName');
	var errname = document.getElementById('nameErr');
	var pattern = /^\S{3,6}$/;
	if (username.value.length == 0) {
		errname.innerHTML = "用户名不能为空";
		errname.className = "error";
		return false;
	}
	if (!pattern.test(username.value)) {
		errname.innerHTML = "用户名不合规范";
		errname.className = "error";
		return false;
	}
	else{
		errname.innerHTML = "OK";
		errname.className  = "success";
		return true;
	}
}
//验证手机号
function checkPhoneNum(){
    var phonenum = document.getElementById('phoneNum');
    var errphonenum = document.getElementById('phoneNumErr');
    var pattern = /^\d{11}$/;
    if (phonenum.value.length == 0) {
    	errphonenum.innerHTML = "手机号不能为空";
    	errphonenum.className = "error";
    	return false;
    }
    if (!pattern.test(phonenum.value)) {
	    errphonenum.innerHTML = "手机号不合规范";
	    errphonenum.className = "error";
	    return false;
    }
    else{
	    errphonenum.innerHTML = "OK";
	    errphonenum.className  = "success";
	    return true;
        }
}
//验证密码
function checkPassword(){
	var userpassword = document.getElementById('userPassword');
	var errpassword = document.getElementById('passwordErr');
	var pattern = /^\w{6,8}$/;
	if (userpassword.value.length == 0) {
    	errpassword.innerHTML = "密码不能为空";
    	errpassword.className = "error";
    	return false;
    }
    if (!pattern.test(userpassword.value)) {
	    errpassword.innerHTML = "密码不合规范";
	    errpassword.className = "error";
	    return false;
    }
    else{
	    errpassword.innerHTML = "OK";
	    errpassword.className  = "success";
	    return true;
        }
}
//验证确认密码
function checkConfirmPassword(){
	var userpassword = document.getElementById('userPassword');
	var confirmpassword = document.getElementById('confirmPassword');
	var errconfirmpassword = document.getElementById('conpasswordErr');
	if ((userpassword.value) != (confirmpassword.value) || 
		confirmpassword.value.length == 0) {
        errconfirmpassword.innerHTML = "上下密码不一致";
        errconfirmpassword.className = "error";
        return false;
	}
	else{
		errconfirmpassword.innerHTML = "OK";
		errconfirmpassword.className = "success";
		return true;
	}

}