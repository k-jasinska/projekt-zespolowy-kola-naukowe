$(document).ready(function(){

	$(".msg-menu-item .nav-link").click(function(){
		$(".msg-menu-item .nav-link").removeClass("active-msg-menu-item");
		$(this).addClass("active-msg-menu-item");
	});

	$("#peopleList .list-group-item").click(function(){
		console.log("Asd");
		var nick = $(this).text();
		$("#nick").val(nick);
	});

});