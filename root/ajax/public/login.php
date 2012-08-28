<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/auth/UserAuth.php");
require_once("$root/../lib/user/User.php");

$user_auth = new UserAuth();

if (array_key_exists('email', $_POST) && array_key_exists('password', $_POST)) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!$user_auth->userExists($email)) {
    echo 'error username';
  }

  $user = $user_auth->login($email, $password);

  if ($user !== null) {
    echo 'success';
  } else {
    echo 'error password';
  }
} else {
  echo 'error data';
}

?>
