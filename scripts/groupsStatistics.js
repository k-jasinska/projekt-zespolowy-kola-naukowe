$(document).ready(function(){
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
		}]	
	});
	new $.fn.dataTable.FixedHeader("#stats");
});