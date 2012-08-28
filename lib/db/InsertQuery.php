<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/db/DBQuery.php");

class InsertQuery extends DBQuery {

  private
    $passwords = array(),
    $queryColumns = array(),
    $queryValues = array(),
    $valuesRow = 0;

  function __construct() {
    parent::__construct(self::MYSQL_WRITE);
  }

  public function addColumn($column) {
    array_push($this->queryColumns, $column);

    return $this;
  }

  public function clear() {
    $this->setTable(null);

    unset($this->passwords);
    unset($this->queryColumns);
    unset($this->queryValues);

    $this->passwords = array();
    $this->queryColumns = array();
    $this->queryValues = array();

    $this->valuesRow = 0;

    return $this;
  }

  public function addValues($values, $password = null) {
    array_push($this->queryValues, $values);

    if ($password !== null) {
      $this->passwords[$this->valuesRow] = $password;
    }

    $this->valuesRow++;
    return $this;
  }

  protected function composeQuery() {
    $this->query = 'INSERT INTO ';
    $this->query .= $this->queryTable;

    $this->query .= ' (';
    for ($i = 0; $i < sizeof($this->queryColumns); $i++) {
      $this->query .= $this->queryColumns[$i];

      if ($i < sizeof($this->queryColumns) - 1) {
        $this->query .= ',';
      }
    }
    $this->query .= ') VALUES ';

    for ($i = 0; $i < sizeof($this->queryValues); $i++) {
      $this->query .= '(';

      for ($j = 0; $j < sizeof($this->queryValues[$i]); $j++) {
        if ($this->queryValues[$i][$j] === null) {
          $this->query .= 'NULL';
        } else {
          $prepend = '';
          $append = '';

          if (array_key_exists($i, $this->passwords)) {
            if ($this->passwords[$i] == $j) {
              $prepend = 'PASSWORD(';
              $append = ')';
            }
          }

          $this->query .= $prepend . '\'';
          $this->query .= mysql_real_escape_string($this->queryValues[$i][$j]);
          $this->query .= '\'' . $append;
        }

        if ($j < sizeof($this->queryValues[$i]) - 1) {
          $this->query .= ',';
        }
      }

      $this->query .= ')';
      if ($i < sizeof($this->queryValues) - 1) {
        $this->query .= ',';
      }
    }
  }
}
?>
