$(document).ready(function() {
    $("#login-button").click(function(){
        doLogin();
    });
});

function doLogin()
{
    var input = {
        "email": $('#login-email').val(),
        "password": $('#login-password').val()
    };

    $.ajax({
        type: "POST",
        url: "api/users/login.php",
        data: JSON.stringify(input),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            if(data.result === 'SUCCESS')
            {
                setCookie('token', encodeURIComponent(data.token), 1);
                setCookie('logo', data.logo , 1);
				setCookie('ruolo', data.ruolo , 1);
				setCookie('id_loggia', data.id_loggia , 1);
                setCookie('background_color', data.background_color, 1);
                setCookie('foreground_color', data.foreground_color, 1);
                document.location.href = 'chooser.php';
            }else
            {
                swal( "Errore" ,  data.message ,  "error" );
            }
        }
    });
}
//novir