<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once("$root/../lib/AjaxScript.php");
require_once("$root/../lib/db/SelectQuery.php");
require_once("$root/../lib/db/InsertQuery.php");

class CreateProject extends AjaxScript {
  protected function requiresAuth() {
    return true;
  }

  protected function getResponse() {
    if ($this->projectExists()) {
      return 'error exists';
    }

    $id = $this->insertProject();
    return 'success ' . $id;
  }

  private function projectExists() {
    $project_exists_query = new SelectQuery();
    $project_exists_result = $project_exists_query
      ->setTable('Projects')
      ->addColumn('id')
      ->addWhere('user_id', $this->user->getUserID())
      ->addWhere('name', $this->data['project_name'])
      ->execute();

    if (mysql_num_rows($project_exists_result) > 0) {
      return true;
    }
    return false;
  }

  private function insertProject() {
    $create_project_query = new InsertQuery();
    $create_project_query
      ->setTable('Projects')
      ->addColumn('user_id')
      ->addColumn('name')
      ->addValues(array($this->user->getUserID(), $this->data['project_name']))
      ->execute();

    return mysql_insert_id();
  }
}

$create_project_script = new CreateProject();
$create_project_script->execute(array('project_name'));

?>
