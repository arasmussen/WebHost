<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/../lib/db/SelectQuery.php");
require_once("$root/../lib/db/InsertQuery.php");
require_once("$root/../lib/auth/validate.php");

/**
 * UserAuth is a class that takes care of the dealing with the $_SESSION
 * global array and the user's php session. This includes initializing session
 * data upon user login and also checking whether a user is logged in at a
 * given time.
 */
class UserAuth {

  private
    $user = null,
    $loggedIn = false;

  public function create_user($email, $username, $password) {
    if (!validate_email($email)) {
      return null;
    }

    if (!validate_password($password)) {
      return null;
    }

    if ($this->userExists($email)) {
      return null;
    }

    $create_user_query = new InsertQuery();
    $create_user_query
      ->addColumn('email')
      ->addColumn('password')
      ->addColumn('username')
      ->setTable('Users')
      ->addValues(array($email, $password, $username), 1)
      ->execute();

    return $this->login($email, $password);
  }

  /**
   * Takes an email/password and tries to login.
   * returns the User on success, null on failure
   */
  public function login($email, $password) {
    $user_id = null;
    $is_student = null;

    if (!$this->userExists($email)) {
      return 'fail email';
    }

    $user_query = new SelectQuery();
    $user_result = $user_query
      ->setTable('Users')
      ->addColumn('id')
      ->addWhere('email', $email)
      ->addWhere('password', $password, 1)
      ->execute();

    if (mysql_num_rows($user_result) == 1) {
      $row = mysql_fetch_array($user_result, MYSQL_ASSOC);
      $user_id = $row['id'];
    }

    if ($user_id !== null) {
      $this->initializeSession($user_id);
    }

    return $this->user;
  }

  public function userExists($email) {
    $user_exists_query = new SelectQuery();
    $result = $user_exists_query
      ->addColumn('COUNT(*)')
      ->setTable('Users')
      ->addWhere('email', $email)
      ->execute();
    $row = mysql_fetch_array($result);
    if ($row['COUNT(*)'] != '1') {
      return false;
    }
    return true;
  }

  /**
   * Is the user logged in?
   * returns true/false
   */
  private function isLoggedIn() {
    return $this->loggedIn;
  }

  /**
   * gets the User object from the $_SESSION array
   * returns null if not logged in or no session
   */
  public function getUser() {
    if (!$this->isLoggedIn()) {
      return null;
    }

    return $this->user;
  }

  /**
   * Starts a session, should be called only the first time the
   * user creates their account or logs in
   */
  private function initializeSession($user_id) {
    if ($this->isLoggedIn()) {
      die('Session is already initialized');
    }

    session_start();

    $_SESSION['user_id'] = $user_id;
    $this->loggedIn = true;

    $this->user = new User($user_id);
  }

  /**
   * Kills the session. Should only be called when the user logs out
   */
  public function destroySession() {
    session_destroy();
    $this->loggedIn = false;
  }

  /**
   * Starts the session for this request. Should be called for every single
   * request that a user sends for the duration of their logged in stay on
   * the site.
   * Returns their User object
   */
  public function authUser()
  {
    session_start();

    if ($_SESSION['user_id'] !== null) {
      $this->user = new Student($_SESSION['user_id']);
      $this->loggedIn = true;
    }

    return $this->user;
  }
}
?>
