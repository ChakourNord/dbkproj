
$(document).ready(function () {});

$("#login-button").click(function () {
  var username = $("#username-text").val();
  var password = $("#password-text").val();

  if (username == "" || password == "") {
    M.toast({
      html: "Username or password not allow to let in blank",
      classes: "rounded toast-error",
    });
  } else {
    var input = {
      username: username,
      password: password,
    };

    $.ajax({
      type: "POST",
      url: "../api/users/login.php",
      data: input,
      dataType: "json",
      success: function (data) {
        if (data.result === "SUCCESS") {
          location.href = "chooser.php";
        } else {
          if (data.result != "ERROR")
            M.toast({ html: "Error", classes: "rounded toast-error" });
          M.toast({ html: data.message, classes: "rounded toast-error" });
        }
      },
    });
  }
});
