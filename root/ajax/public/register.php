<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/AjaxScript.php");
require_once("$root/../lib/auth/UserAuth.php");
require_once("$root/../lib/user/User.php");

class Register extends AjaxScript {
  protected function getResponse() {
    $user_auth = new UserAuth();

    $user = $user_auth->createUser(
      $this->data['email'],
      $this->data['password'],
      $this->data['username']
    );

    if ($user !== null) {
      return 'success';
    } else {
      return 'fail';
    }
  }
}

$register_script = new Register();
$register_script->execute(array('email', 'password', 'username'));

?>
