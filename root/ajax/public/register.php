<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/auth/UserAuth.php");
require_once("$root/../lib/user/User.php");

$user_auth = new UserAuth();

if (!array_key_exists('email', $_POST) ||
    !array_key_exists('password', $_POST)) {
  echo 'missing data';
  exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

$user = $user_auth->create_user($email, $password);

if ($user) {
  echo 'success';
} else {
  echo 'fail';
}

?>