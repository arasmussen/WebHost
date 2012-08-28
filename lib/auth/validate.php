<?php

function validate_email($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return false;
  }

  return true;
}

function validate_password($password) {
  if (strlen($password) < 6) {
    return false;
  }

  if (!ctype_print($password)) {
    return false;
  }

  return true;
}

?>
