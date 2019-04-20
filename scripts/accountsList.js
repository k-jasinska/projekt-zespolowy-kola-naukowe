$(document).ready(function(){

  $(".account").click(function(){
    $(this).find("span > form").submit();
  });

  $(".account span button").click(function(e){
    var selector = $(this).attr("data-selector");    
    $.ajax({
      method: "POST",
      url: "login.php",
      data: {delete: selector}
    }).done(function(msg){
      if(msg * 1 == 1){
        $(this).parent().parent().remove();
      } else {
        alert("błąd");
      }
    });
    e.stopPropagation();
  });

});