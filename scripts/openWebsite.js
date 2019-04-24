(function () {
	$(document).ready(function () {
      $(".navbar-brand").click(function (e) {
        	location.replace("index.php");
      });
      $("#link2").click(function (e) {
        	location.replace("index.php?focus=.dzialalnosc");
      });
      $("#link3").click(function (e) {
			location.replace("index.php?focus=.group");
      });
      $("#link4").click(function (e) {
        	location.replace("index.php?focus=.contactHeader");
      });
  	});
})();