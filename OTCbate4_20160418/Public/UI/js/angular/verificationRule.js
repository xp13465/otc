var verificationRule = {};
//验证是否是全汉字
verificationRule.isChinese = function(flag){
	var role = /^[\u4E00-\u9FA5]+$/;  
	return role.test(flag);
}
//验证身份证是否符合规则
verificationRule.isCardNum = function(flag) { 
	var arrExp = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];//加权因子
    var arrValid = [1, 0, "X", 9, 8, 7, 6, 5, 4, 3, 2];//校验码
    if(/^\d{17}\d|x$/i.test(flag)){  
        var sum = 0, idx;  
        for(var i = 0; i < flag.length - 1; i++){  
            // 对前17位数字与权值乘积求和  
            sum += parseInt(flag.substr(i, 1), 10) * arrExp[i];  
        }
        // 计算模（固定算法）
        idx = sum % 11;
        // 检验第18为是否与校验码相等
        return arrValid[idx] == flag.substr(17, 1).toUpperCase();
    }else{
        return false;
    }
}
//验证手机号是否符合规则
verificationRule.isIphone = function(flag){
	var role = /^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;  
	return role.test(flag);
}

//验证密码是否符合规则 
verificationRule.isPassword = function(flag){
	var role_one = /^(?:\d+|[a-zA-Z]+|[!@#$%^&*]+)$/;  
	var role_two = /^(?![a-zA-z]+$)(?!\d+$)(?![!@#$%^&*]+$)[a-zA-Z\d!@#$%^&*]+$/;  
	//var role_three= /^(?![a-zA-z]+$)(?!\d+$)(?![!@#$%^&*]+$)(?![a-zA-z\d]+$)(?![a-zA-z!@#$%^&*]+$)(?![\d!@#$%^&*]+$)[a-zA-Z\d!@#$%^&*]+$/;  
	if(role_one.test(flag)){
		return 'role_one'
	}else if(role_two.test(flag)){
		return 'role_two'
	}else if(flag){
		return 'role_three'
	}
}
