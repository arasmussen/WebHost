<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/auth/UserAuth.php");

$user_auth = new UserAuth();

if ($user_auth->authUser() !== null) {
  $user_auth->destroySession();
}

header('Location: /');

?>
