$(document).ready(function(){

	$("#searchInput").on("keyup", function() {
    	searchList("searchInput", "peopleList");
	  });

});

function searchList(inputId, listId){
	var value = $("#" + inputId).val().toLowerCase();
 $("#" + listId + " li").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
});
}