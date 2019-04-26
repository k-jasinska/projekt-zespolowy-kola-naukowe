$(document).ready(function () {
	$('#insert_form').on("submit", function (event) {
		event.preventDefault();
		$.ajax({
			url: "../subsites/addPost.php",
			method: "POST",
			data: $('#insert_form').serialize(),
			success: function (data) {
				var cos = data.substring(0, 4);
				if (cos == "Błąd") {
					$('#err').html(data);
				} else {
					$('#insert_form')[0].reset();
					$('#postModal').modal('hide');
					$('#showContent').load('groupContent/posts.php');
				}
			}
		});
	});
});