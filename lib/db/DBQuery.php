<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);

// the below file with database credentials is ignored in git for security,
// reasons to get this working, create a mysql database using
// /sql/create_db.sql and then create a /lib/db/credentials.php file that has
// the following functions:
//   getDBHost()
//   getDBName()
//   getReadUser()
//   getReadPassword()
//   getWriteUser()
//   getWritePassword()
//
// you'll also need to create your own mysql read/write users
require_once("$root/../lib/db/credentials.php");

abstract class DBQuery {

  private
    $connection = null,
    $result = null,
    $table = null;

  protected
    $query = null;

  const MYSQL_READ = 1;
  const MYSQL_WRITE = 2;

  function __construct($privileges = self::MYSQL_READ) {
    $this->connect($privileges);
  }

  function __destruct() {
    if ($this->result && $this->result !== true) {
      mysql_free_result($this->result);
      $this->result = null;
    }
    $this->close();
  }

  private function connect($privileges) {
    $host = getDBHost();
    $db_name = getDBName();

    switch ($privileges) {
      case (self::MYSQL_READ):
        $user = getReadUser();
        $password = getReadPassword();
        break;
      case (self::MYSQL_WRITE):
        $user = getWriteUser();
        $password = getWritePassword();
        break;
      default:
        die('Tried to connect to MYSQL with invalid privileges');
        break;
    }

    $new_link = true;
    $this->connection = mysql_connect($host, $user, $password, $new_link)
      or die('MYSQL connection failure');
    mysql_select_db($db_name) or die('MYSQL database selection failure');
  }

  private function close() {
    if ($this->connection === null) {
      die('Not connected to database');
    }
    mysql_close($this->connection);
  }

  public function setTable($queryTable) {
    $this->queryTable = $queryTable;

    return $this;
  }

  public function execute() {
    if ($this->result && $this->result !== true) {
      mysql_free_result($this->result);
    }

    $this->composeQuery();
    $this->result = mysql_query($this->query);
    return $this->result;
  }

  public function getQuery() {
    $this->composeQuery();
    return $this->query;
  }

  abstract protected function composeQuery();
}

?>
