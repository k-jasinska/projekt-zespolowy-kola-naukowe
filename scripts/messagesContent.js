$(document).ready(function(){

	$(".msg-menu-item .nav-link").click(function(){
		$(".msg-menu-item .nav-link").removeClass("active-msg-menu-item");
		$(this).addClass("active-msg-menu-item");
	});

	getPeopleList();

	$("#check-users").change(getPeopleList);

	function getPeopleList(){
		$("#peopleList").empty();
		$.ajax({
			method: "GET",
			url: "../subsites/peopleList.php",
			data: {all: $("#check-users").is(':checked')}
		}).done(function(data){
			$("#peopleList").html(data);
			$("#peopleList > .list-group-item").each(function(){
				$(this).click({element: this}, chooseNick);
			});
			$.getScript('/pz/scripts/searchList.js', function()
			{
				searchList("searchInput", "peopleList");
			});
		});
	}

	function chooseNick(event){
		var nick = $(event.data.element).text();
		$("#nick").val(nick);
	}

});