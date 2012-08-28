$(function() {
  function studentRegisterFailed() {
    var container = $('#registerButton');
    container.removeClass('disabled');

    var button = $('#registerButton input[type="submit"]');
    button.removeAttr('disabled');

    // TODO (andrew): Let user know register failed
  }

  $('#public #register form').bind('submit', function() {
    var container = $(this).find('#registerButton');
    container.addClass('disabled');

    var button = $(this).find('input[type="submit"]');
    button.attr('disabled', 'disabled');

    var email = $(this).find('#registerEmail input[type="text"]').val();
    var password = $(this).find(
      '#registerPassword input[type="password"]'
    ).val();

    $.ajax({
      type: "POST",
      url: "/ajax/public/register.php",
      data: {email: email, password: password}
    }).done(function(msg) {
      if (msg == 'fail' || msg == 'missing data') {
        registerFailed();
      } else if (msg == 'success') {
        document.location.href = '/dashboard.php';
      } else {
        registerFailed();
      }
    });
  });
});
