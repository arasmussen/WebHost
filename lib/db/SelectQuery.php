<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/db/DBQuery.php");

class SelectQuery extends DBQuery {

  private
    $passwords = array(),
    $queryColumns = array(),
    $queryJoins = array(),
    $queryWheres = array(),
    $wheresRow = 0;

  public function clear() {
    $this->setTable(null);

    unset($this->passwords);
    unset($this->queryColumns);
    unset($this->queryJoins);
    unset($this->queryWheres);

    $this->passwords = array();
    $this->queryColumns = array();
    $this->queryJoins = array();
    $this->queryWheres = array();

    $this->wheresRow = 0;

    return $this;
  }


  public function addColumn($column) {
    array_push($this->queryColumns, $column);

    return $this;
  }

  public function addJoin($t1, $j1, $j2) {
    array_push($this->queryJoins, array(
      'table' => $t1,
      'left_join' => $j1,
      'right_join' => $j2
    ));

    return $this;
  }

  public function addWhere($v1, $v2, $password = false) {
    array_push($this->queryWheres, array(
      'v1' => $v1,
      'v2' => $v2
    ));

    if ($password) {
      $this->passwords[$this->wheresRow] = true;
    }

    $this->wheresRow++;

    return $this;
  }

  protected function composeQuery() {
    $this->query = 'SELECT ';
    $this->query .= implode(',', $this->queryColumns) . ' ';
    $this->query .= 'FROM ';
    $this->query .= $this->queryTable;

    foreach ($this->queryJoins as $join) {
      $this->query .= ' INNER JOIN ';
      $this->query .= $join['table'];
      $this->query .= ' ON ';
      $this->query .= $join['left_join'];
      $this->query .= '=';
      $this->query .= $join['right_join'];
    }

    $num_wheres = sizeof($this->queryWheres);
    if ($num_wheres > 0) {
      $this->query .= ' WHERE ';
      for ($i = 0; $i < $num_wheres; $i++) {
        $where = $this->queryWheres[$i];

        $prepend = $append = '';
        if (array_key_exists($i, $this->passwords)) {
          $prepend = 'PASSWORD(';
          $append = ')';
        }

        $this->query .= $where['v1'];
        $this->query .= '=';
        $this->query .= $prepend . '\'';
        $this->query .= mysql_real_escape_string($where['v2']);
        $this->query .= '\'' . $append;

        if ($i < $num_wheres - 1) {
          $this->query .= ' AND ';
        }
      }
    }
  }
}

?>
