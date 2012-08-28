<?php

abstract class User {

  protected
    $userID;

  public function __construct($user_id) {
    $this->userID = $user_id;
  }

  public function getUserID() {
    return $this->userID;
  }
}


?>
