<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/db/SelectQuery.php");

class User {

  protected
    $userID,
    $username = null;

  public function __construct($user_id) {
    $this->userID = $user_id;
  }

  public function getUserID() {
    return $this->userID;
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
