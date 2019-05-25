$(document).ready(function(){
	initTable();
});

function start_modal(element){
	$("#coordinator-name").remove();
	$('.modal-body').prepend('<span id="coordinator-name">Obecny kordynator: ' + $(element).attr('data-name') + '</span>');
	$.ajax({
		method: "POST",
		url: "../subsites/coordinatorsList.php",
		data: {id: $(element).attr('data-id'), group: $(element).attr('data-group')}
	}).done(function(data){
		$("#select_coordinator").empty();
		$("#select_coordinator").html(data);
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
					console.log(data)
				}
				$("#change-btn").attr("disabled", false);
				$("#change-btn").html('Zmień');
			});
			return false;
		});
	});
};

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
		}],		
	});
	new $.fn.dataTable.FixedHeader("#stats");
}