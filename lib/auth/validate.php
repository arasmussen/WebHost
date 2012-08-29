<?php

function validate_email($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return false;
  }

  return true;
}

function validate_username($username) {
  // is alphanumeric
  if (!ctype_alnum($username)) {
    return false;
  }

  if (strlen($username) < 1) {
    return false;
  }

  return true;
}

function validate_password($password) {
  if (strlen($password) < 6) {
    return false;
  }

  // printable characters only
  if (!ctype_print($password)) {
    return false;
  }

  return true;
}

?>
