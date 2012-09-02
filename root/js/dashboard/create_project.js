$(function() {
  $('#showCreateProject').bind('click', function() {
    $('#createProject').show();
  });

  $('#hideCreateProject').bind('click', function() {
    $('#createProject').hide();
  });

  function createProjectFailed() {
    var button = $('#createProject form input[type="submit"]');
    button.removeAttr('disabled');

    alert('failed');
  }

  $('#createProject form').bind('submit', function() {
    var input = $(this).find('#createProjectName input[type="text"]');
    var project_name = input.val();
    var button = $(this).find('input[type="submit"]');
    button.attr('disabled', 'disabled');

    $.ajax({
      type: "POST",
      url: "/ajax/dashboard/create_project.php",
      data: {project_name: project_name}
    }).done(function(msg) {
      var response = msg.split(' ');
      if (response[0] == 'error') {
        createProjectFailed();
      } else if (response[0] == 'success') {
        document.location.href = '/project.php?id=' + response[1];
      } else {
        createProjectFailed();
      }
    });

    return false;
  });
});
