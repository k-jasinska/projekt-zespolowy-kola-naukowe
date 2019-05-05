$(document).ready(function(){
	$("#cpwd").keyup(function(){
		confirmPassword();
	});
	
	$("#cpwd").change(function(){
		confirmPassword();
	});

	$("#pwd").keyup(function(){
		confirmPassword();
	});
	
	$("#pwd").change(function(){
		confirmPassword();
	});

	function confirmPassword(){
		var pwd = $("#pwd").val();
		var cPwd = $("#cpwd").val();
		if(pwd != cPwd){
			$("#cpwd")[0].setCustomValidity("Hasła nie pasują!");
		} else {
			$("#cpwd")[0].setCustomValidity("");
		}
	}
	
	$("#email").blur(function(){
		checkEmail();
	});

	$("#email").keyup(function(){
		if(!$("#email")[0].checkValidity()){
			checkEmail();
		}
	});

	function checkEmail(){
		var emailValue = $("#email").val();
		$.ajax({
			method: "POST",
			url: "../subsites/checkEmail.php",
			data: {email: emailValue}
		}).done(function(msg){
			if(msg * 1 == 0){
				$("#email")[0].setCustomValidity("");				
			} else {
				$("#email")[0].setCustomValidity("Email jest zajęty!");				
			}
		})
	}

	$("#nick").blur(function(){
		checkNick();
	});

	$("#nick").keyup(function(){
		if(!$("#nick")[0].checkValidity()){
			checkNick();
		}
	});
	
	function checkNick(){
		var nickValue = $("#nick").val();
		$.ajax({
			method: "POST",
			url: "../subsites/checkNick.php",
			data: {nick: nickValue}
		}).done(function(msg){
			if(msg * 1 == 0){
				$("#nick")[0].setCustomValidity("");				
			} else {
				$("#nick")[0].setCustomValidity("Nick jest zajęty!");				
			}
		})
	}
});