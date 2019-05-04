$(document).ready(function(){

	$(".msg-menu-item .nav-link").click(function(){
		$(".msg-menu-item .nav-link").removeClass("active-msg-menu-item");
		$(this).addClass("active-msg-menu-item");
	});

	getPeopleList();

	$("#check-users").change(getPeopleList);

	$("#msg-form").submit(function(){
		$("#send-msg").hide();
		$("#loader").show();		
		$.ajax({
			method: "POST",
			url: "../subsites/sendMessage.php",
			data: {
				nick: $("#nick").val(), 
				title: $("#title").val(),
				message: $("#message").val()
			}
		}).done(function(data){	
			var received_data = data.split(":");		
			var info = "<div class='" + (received_data[0] * 1 == 0 ? "sent-success" : "sent-error") + "'>"+ received_data[1] +"<button type='button' class='close close-info'>&times;</button></div>"			
			$(".msg-info").html($(".msg-info").html() + info);
			$("#loader").hide();
			$("#send-msg").show();
			if(received_data[0] * 1 == 0){
				$("#nick").val("");
				$("#title").val("");
				$("#message").val("");
			}
		});
		return false;
	})

});

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
		$.getScript('../scripts/searchList.js', function()
		{
			searchList("searchInput", "peopleList");
		});
	});
}

function chooseNick(event){
	var nick = $(event.data.element).text();
	$("#nick").val(nick);
}

function removeInfoMsg(){
    $(this).parent().remove();
  }