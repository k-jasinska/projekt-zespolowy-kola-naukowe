$(document).ready(function(){
	initTable();
});

function start_modal(element){
	$("#coordinator-name").remove();
	$(".msg-info").empty();
	$('.modal-body-change .msg-text').html('<span id="coordinator-name">Obecny kordynator: ' + $(element).attr('data-name') + '</span>');
	$.ajax({
		method: "POST",
		url: "../subsites/coordinatorsList.php",
		data: {id: $(element).attr('data-id'), group: $(element).attr('data-group')}
	}).done(function(data){
		$("#select_coordinator").empty();
		$("#select_coordinator").html(data);
	});
};

$(document).ready(function(){
	$(".change-coordinator").submit(function(){
		$("#change-btn").attr("disabled", true);
		$("#change-btn").html('<span class="spinner-border spinner-border-sm text-light"></span>');
		$.ajax({
			method: "POST",
			url: "../subsites/changeCoordinator.php",
			data: {id: $("#select_coordinator").val()}
		}).done(function(data){
			if(data != 0 && data != 1 && data != 2){
				start_modal(element);
				$(".table-container").empty();
				$(".table-container").html(data);
				initTable();
				$('#coordinator').modal('toggle');
			} else {
				var info = "<div class='sent-error'>Błąd zmiany kordynatora!<button type='button' class='close close-info'>&times;</button></div>";		
				$(".msg-info").html($(".msg-info").html() + info);
				$(".close-info").each(function(){
					$(this).click(removeInfoMsg);
				});
			}
			$("#change-btn").attr("disabled", false);
			$("#change-btn").html('Zmień');
		}).fail(function(){
			var info = "<div class='sent-error'>Błąd zmiany kordynatora!<button type='button' class='close close-info'>&times;</button></div>";		
			$(".msg-info").html($(".msg-info").html() + info);
			$(".close-info").each(function(){
				$(this).click(removeInfoMsg);
			});
			$("#change-btn").attr("disabled", false);
			$("#change-btn").html('Zmień');
		});
		return false;
	});
})

function initTable(){
	$("#stats").DataTable({
		language:{
			"lengthMenu": "_MENU_ na stronę",
			"zeroRecords": "Brak danych",
			"info": "Strona _PAGE_ z _PAGES_",
			"infoEmpty": "Brak danych",
			"infoFiltered": "(odfiltrowano z _MAX_ wszystkich rekordów)",
			"search": "",
			"searchPlaceholder": "Szukaj",
			"paginate": {
				"previous": "<i class='fa fa-chevron-left' aria-hidden='true'></i>",
				"next": "<i class='fa fa-chevron-right' aria-hidden='true'></i>"
			}
		},
		responsive: true,
		columnDefs: [
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
		},
		{
			targets: 3,
			responsivePriority: 4
		},
		{
			targets: 4,
			responsivePriority: 5
		},
		{
			targets: 5,
			responsivePriority: 6,
			orderable: false		
		}],
	});
	new $.fn.dataTable.FixedHeader("#stats");
}

function remove_group(element){
	$("#remove-id").val($(element).attr("data-group"));
	$("#remove-msg").text("Czy na pewno chcesz usunąć " + $(element).attr("data-name") + "?");
	$(".msg-info-remove").empty();
}

$(document).ready(function(){
	$("#remove-form").submit(function(){
		$("#remove-btn").attr("disabled", true);
		$("#remove-btn").html('<span class="spinner-border spinner-border-sm text-light"></span>');
		$.ajax({
			method: "POST",
			url: "../subsites/removeGroup.php",
			data: {id: $("#remove-id").val()}
		}).done(function(data){
			if(data != 0 && data != 1){
				$(".table-container").empty();
				$(".table-container").html(data);
				initTable();
				$('#remove').modal('toggle');
			} else {
				var info = "<div class='sent-error'>Błąd usuwania grupy!<button type='button' class='close close-info'>&times;</button></div>";		
				$(".msg-info-remove").html($(".msg-info-remove").html() + info);
				$(".close-info").each(function(){
					$(this).click(removeInfoMsg);
				});
			}
			$("#remove-btn").attr("disabled", false);
			$("#remove-btn").html("Usuń");
		}).fail(function(){
			var info = "<div class='sent-error'>Błąd usuwania grupy!<button type='button' class='close close-info'>&times;</button></div>";		
			$(".msg-info-remove").html($(".msg-info-remove").html() + info);
			$(".close-info").each(function(){
				$(this).click(removeInfoMsg);
			});
			$("#remove-btn").attr("disabled", false);
			$("#remove-btn").html('Usuń');
		});
		return false;
	});
});

function removeInfoMsg(){
	$(this).parent().remove();
}