function fillDescription(id) {
	$.ajax({
		method: "POST",
		url: '../subsites/showGroupDescription.php',
		data: {
			id: id
		},
		success: function (data) {
			$('.choose').load('groupContent/buttons.php');
			$('#showContent').html(data);
		},
		error: function () {
			throw "Nie udało się wysłać danych!";
		}
	});
}