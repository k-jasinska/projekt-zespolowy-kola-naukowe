function fillDescription(id) {
	$.ajax({
		method: "POST",
		url: '../subsites/showGroupDescription.php',
		data: {
			id: id
		},
		success: function (data) {
			$('#showContent').html(data);
		},
		error: function () {
			throw "Nie udało się wysłać danych!";
		}
	});
}


$(document).ready(function () {
	$('.choose a').click(function () {
		var page = $(this).attr('href');
		$('#showContent').load('groupContent/' + page + '.php');
		return false;
	});
});