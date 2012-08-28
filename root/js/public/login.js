$(function() {
  function loginFailed() {
    var container = $('#login #loginButton');
    container.removeClass('disabled');

    var button = $('#login input[type="submit"]');
    button.removeAttr('disabled');
  }

  $('#public #login form').bind('submit', function() {
    var container = $(this).find('#loginButton');
    container.addClass('disabled');

    var button = $(this).find('input[type="submit"]');
    button.attr('disabled', 'disabled');

    var email = $(this).find('#loginEmail input[type="text"]').val();
    var password = $(this).find('#loginPassword input[type="password"]').val();

    $.ajax({
      type: "POST",
      url: "/ajax/public/login.php",
      data: {email: email, password: password}
    }).done(function(msg) {
      if (msg == 'error username') {
        var username = $('#login #loginEmail');
        username.addClass('error');
        loginFailed();
      } else if (msg == 'error password') {
        var password = $('#login #loginPassword');
        password.addClass('error');
        loginFailed();
      } else if (msg == 'success') {
        document.location.href = '/dashboard.php';
      }
    });

    return false;
  });
});
