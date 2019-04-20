$(document).ready(function(){

  $(".account").click(function(){
    $(this).find("span > form").submit();
  });

  function removeErrorMsg(){
    $(this).parent().remove();
  }

  $(".delete-account").click(function(e){
    var selector = $(this).attr("data-selector");    
    var element = $(this);
    $.ajax({
      method: "POST",
      url: "login.php",
      data: {delete: selector}
    }).done(function(msg){
      if(msg * 1 == 1){
        element.parent().parent().remove();
        if($("#accounts>.modal-dialog>.modal-content>.modal-body>.account").length == 0){
          $("#btn-remember").hide();
          $("#accounts").modal("hide");
        }        
      } else {
        var msg = "<div class='delete-error'>Błąd usuwania!<button type='button' class='close close-error'>&times;</button></div>";
        $("#accounts > .modal-dialog > .modal-content > .modal-body").prepend(msg);
        $(".close-error").click(removeErrorMsg);
      }
    });
    e.stopPropagation();
  });

});