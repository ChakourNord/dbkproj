var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.7.1.min.js'; // Check https://jquery.com/ for the current version
document.getElementsByTagName('head')[0].appendChild(script);



const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
const appendAlert = (message, type) => {
  const wrapper = document.createElement('div')
  wrapper.innerHTML = [
    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
    `   <div>${message}</div>`,
    '   <button type="button" class="btn btn-alert" id="none" data-dismiss="alert" aria-label="Close"></button>',
    '</div>'
  ].join('')

  alertPlaceholder.append(wrapper)
}




$(document).ready(function () {
    $(".del_row").click(function () {
  var id = this.dataset.id;
 
  var table = this.dataset.table;

 
    var input = {
      id: id,
      table: table
    };

    $.ajax({
      type: "POST",
      url: "del.php",
      data: input,
      dataType: "json",
      success: function (data) {
        if (data.result === "SUCCESS") {
            localStorage.setItem('showToast', 'true');
          window.location.reload();
           
        } 
      },
    });
  }
);

$('.auto_kun_ver').on('click', function () {
  $('.id_autover').attr("value", this.dataset.id);
})

  $(".del_M_row").click(function () {
var id = this.dataset.id;
var user_id = this.dataset.users_id;
var table = this.dataset.table;


var input = {
  user_id: user_id,
  id: id,
  table: table
};

  $.ajax({
    type: "POST",
    url: "del_M.php",
    data: input,
    dataType: "json",
    success: function (data) {
      if (data.result === "SUCCESS") {
          localStorage.setItem('showToast', 'true');
          window.location.reload();
         
      } 
    },
  });
}
);


$(document).ready(function() {
    if (localStorage.getItem('showToast') === 'true') {
        appendAlert('Data row Delete', 'danger')
        setTimeout(() => {  $('.btn-alert').click() }, 2000);
      localStorage.removeItem('showToast');
    }
  });});



