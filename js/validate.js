function validateEmail(email) 
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validate() {
  var result = $("#result_form");
  var email = $('input[type="email"').val();

  if (validateEmail(email)) {
    result.text("Вы ввели нормальный email");
	$(".btn").removeAttr = "disabled";
  } else {
    
	result.text("Вы ввели неверный email");
    result.css("color", "red");
  }
}

$('#ajax_form input[type="email"').on("blur", function(){
	var result = $("#result_form");
  var email = $('input[type="email"').val();

  if (validateEmail(email)) {
    result.text("Вы ввели нормальный email");
	$(".btn").removeAttr = "disabled";
  } else {
    
	result.text("Вы ввели неверный email");
    result.css("color", "red");
  }
});