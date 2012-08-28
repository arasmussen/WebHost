<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/db/DBQuery.php");

class UpdateQuery extends DBQuery {
  private
    $password = null,
    $queryColumns = array(),
    $queryValues = null,
    $queryWheres = array();

  function __construct() {
    parent::__construct(self::MYSQL_WRITE);
  }

  public function addColumn($column) {
    array_push($this->queryColumns, $column);

    return $this;
  }

  public function clear() {
    $this->setTable(null);

    unset($this->queryColumns);
    unset($this->queryWheres);

    $this->password = null;
    $this->queryColumns = array();
    $this->queryWheres = array();
    $this->queryValues = null;

    return $this;
  }

  public function setValues($values, $password = null) {
    $this->queryValues = $values;

    if ($password !== null) {
      $this->password = $password;
    } else {
      $this->password = null;
    }

    return $this;
  }

  public function addWhere($v1, $v2) {
    array_push($this->queryWheres, array(
      'v1' => $v1,
      'v2' => $v2
    ));

    return $this;
  }

  protected function composeQuery() {
    $this->query = 'UPDATE ';
    $this->query .= $this->queryTable;

    $this->query .= ' SET ';
    for ($i = 0; $i < sizeof($this->queryColumns); $i++) {
      $this->query .= $this->queryColumns[$i] . '=';

      $value = $this->queryValues[$i];

      if ($value === null) {
        $this->query .= 'NULL';
      } else {
        $prepend = '\'';
        $append = '\'';
  
        if ($this->password === $i) {
          $prepend = 'PASSWORD(\'';
          $append = '\')';
        }
  
        $this->query .= $prepend;
        $this->query .= mysql_real_escape_string($value);
        $this->query .= $append;
      }

      if ($i < sizeof($this->queryColumns) - 1) {
        $this->query .= ',';
      }
    }

    $num_wheres = sizeof($this->queryWheres);
    if ($num_wheres > 0) {
      $this->query .= ' WHERE ';
      for ($i = 0; $i < $num_wheres; $i++) {
        $where = $this->queryWheres[$i];

        $this->query .= $where['v1'];
        $this->query .= '=';
        $this->query .= '\'';
        $this->query .= mysql_real_escape_string($where['v2']);
        $this->query .= '\'';

        if ($i < $num_wheres - 1) {
          $this->query .= ' AND ';
        }
      }
    }
  }
}
?>
