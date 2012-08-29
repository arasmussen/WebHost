<?php

class Project {
  private
    $name = null;

  public function __construct($user, $name) {
    $this->user = $user;
    $this->name = $name;
  }

  public function getProjectName() {
    return $this->name;
  }

  public function getProjectRoot() {
    $root = realpath($_SERVER['DOCUMENT_ROOT']);
    $username = $this->user->getUsername();

    return "$root/../projects/$username/$this->name";
  }

  public function getUrl() {
    $username = $this->user->getUsername();
    return "/projects/$username/$this->name";
  }
}

?>
