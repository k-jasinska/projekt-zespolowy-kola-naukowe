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
		var emailValue = $("#email").val();
		$.ajax({
			method: "POST",
			url: "checkEmail.php",
			data: {email: emailValue}
		}).done(function(msg){
			if(msg * 1 == 0){
				$("#email")[0].setCustomValidity("");				
			} else {
				$("#email")[0].setCustomValidity("Email jest zajęty!");				
			}
		})
	});
});