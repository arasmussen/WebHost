<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/Project.php");
require_once("$root/../lib/db/SelectQuery.php");

class User {
  protected
    $projects = null,
    $userID,
    $username = null;

  public function __construct($user_id) {
    $this->userID = $user_id;
  }

  public function getUserID() {
    return $this->userID;
  }

  public function getProjects() {
    if ($this->projects !== null) {
      return $this->projects;
    }

    $projects_query = new SelectQuery();
    $projects_results = $projects_query
      ->setTable('Projects')
      ->addColumn('name')
      ->addWhere('user_id', $this->userID)
      ->execute();

    $this->projects = array();
    while ($row = mysql_fetch_array($projects_results, MYSQL_ASSOC)) {
      array_push($this->projects, new Project($this, $row['name']));
    }
    return $this->projects;
  }

  public function getUsername() {
    if ($this->username !== null) {
      return $this->username;
    }

    $username_query = new SelectQuery();
    $username_results = $username_query
      ->setTable('Users')
      ->addColumn('username')
      ->addWhere('id', $this->userID)
      ->execute();

    $row = mysql_fetch_array($username_results, MYSQL_ASSOC);
    return $row['username'];
  }
}

?>
