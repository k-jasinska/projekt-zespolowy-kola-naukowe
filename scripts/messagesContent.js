var table_received = '<table id="received-messages" class="display nowrap table"><thead><tr><th class="td-sender">Nadawca</th><th>Data</th><th>Tytuł</th><th></th></tr></thead><tbody class="tbody-received"></tbody></table>';
var table_sent = '<table id="sent-messages" class="display nowrap table"><thead><tr><th>Nadawca</th><th>Data</th><th>Tytuł</th></tr></thead><tbody class="tbody-sent"></tbody></table>';

$(document).ready(function(){

	$(".msg-menu-item .nav-link").click(function(){
		$(".msg-menu-item .nav-link").removeClass("active-msg-menu-item");
		$(this).addClass("active-msg-menu-item");
	});

	getPeopleList();

	$("#check-users").change(getPeopleList);

	$("#msg-form").submit(function(){
		$("#send-msg").attr("disabled", true);
		$("#send-msg").html('<span class="spinner-border spinner-border-sm text-light"></span>');
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
			var info = "<div class='" + (received_data[0] * 1 == 0 ? "sent-success" : "sent-error") 
			+ "'>"+ received_data[1] +"<button type='button' class='close close-info'>&times;</button></div>";		
			$(".msg-info").html($(".msg-info").html() + info);
			$(".close-info").each(function(){
				$(this).click(removeInfoMsg);
			});
			$("#send-msg").attr("disabled", false);
			$("#send-msg").html("Wyślij");
			if(received_data[0] * 1 == 0){
				$("#nick").val("");
				$("#title").val("");
				$("#message").val("");
			}
		});
		return false;
	})

	$("#write-msg").click(function(){
		$(".right-part").removeClass("no-max-width");
		$("#received-msg-list").hide();
		$("#sent-msg-list").hide();
		$("#new-msg").show();
		$(".msg-menu-item .nav-link").click(function(){
			$(".msg-menu-item .nav-link").each(function(){
				$(this).removeClass("active-msg-menu-item");
			});
			$(this).addClass("active-msg-menu-item");
		});
	});

	$("#received-msg").click(function(){
		$(".right-part").addClass("no-max-width");
		$("#new-msg").hide();
		$("#sent-msg-list").hide();
		$("#received-msg-list").show();
		$(".msg-menu-item .nav-link").click(function(){
			$(".msg-menu-item .nav-link").each(function(){
				$(this).removeClass("active-msg-menu-item");
			});
			$(this).addClass("active-msg-menu-item");
		});
		if($(".table-contener-received").css("display") !== "none"){
			$.ajax({
				method: "POST",
				url: "../subsites/getMessages.php",
				dataType: 'json'
			}).done(function(data){	
				$(".table-contener-received").empty();
				$(".table-contener-received").html(table_received);
				data.forEach(element => {
					$(".tbody-received").html($(".tbody-received").html() + element.table);
				});
				initTable("#received-messages");
				initTooltip();
				$(".page-item").click(function(){
					initTooltip();
				});
				$("select").change(function(){
					initTooltip();
				});
				$(".form-control-sm").keydown(function(){
					initTooltip();
				});
				$("th").click(function(){
					initTooltip();
				});
				$("tbody tr .show-col").click(function(e){
					var idMessage = $(this).parent().attr("id").split("-")[1];
					var msg = $.grep(data, function(obj) {
						return obj.data.id_message == idMessage;
					});
					msg = msg[0].data;
					$(".msg-name").text(msg.name);
					$(".msg-surname").text(msg.surname);
					$(".msg-date").text(msg.date);
					$(".msg-title").text(msg.title);
					$(".msg-message").text(msg.message);
					$(".msg-header").hide();
					$(".table-contener-received").hide();
					$(".msg-show").show();
					$(".arrow-received").show();
					e.stopPropagation();
				});
			});
		}
	});

	$("#sent-msg").click(function(){
		$(".right-part").addClass("no-max-width");
		$("#new-msg").hide();
		$("#received-msg-list").hide();
		$("#sent-msg-list").show();
		$(".msg-menu-item .nav-link").click(function(){
			$(".msg-menu-item .nav-link").each(function(){
				$(this).removeClass("active-msg-menu-item");
			});
			$(this).addClass("active-msg-menu-item");
		});
	});
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

function initTable(table){
	$(table).DataTable({
		language:{
			"lengthMenu": "_MENU_ na stronę",
			"zeroRecords": "Brak danych",
			"info": "Strona _PAGE_ z _PAGES_",
			"infoEmpty": "Brak wiadomości",
			"infoFiltered": "(odfiltrowano z _MAX_ wszystkich rekordów)",
			"search": "",
			"searchPlaceholder": "Szukaj",
			"paginate": {
				"previous": "<i class='fa fa-chevron-left' aria-hidden='true'></i>",
				"next": "<i class='fa fa-chevron-right' aria-hidden='true'></i>"
			}
		},
		responsive: true,
		columnDefs: [ {
			targets: -1,		
			orderable: false,
			responsivePriority: 0
		 },
		{
			targets: 0,
			responsivePriority: 1
		},
		{
			targets: 1,
			responsivePriority: 2
		},
		{
			targets: 2,
			responsivePriority: 3
		}]		
	});
	new $.fn.dataTable.FixedHeader( table );
}

function initTooltip(){
	$('[data-toggle="tooltip"]').tooltip(); 
}

$(".arrow-received").click(function(){
	$(".msg-header").show();
	$(".table-contener-received").show();
	$(".msg-show").hide();
	$(".arrow-received").hide();
});