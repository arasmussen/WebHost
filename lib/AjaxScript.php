<?php

abstract class AjaxScript {

  protected
    $data = array();

  public function execute($keys) {
    if ($this->processKeys($keys)) {
      $response = $this->getResponse();
    } else {
      $response = 'missing data';
    }
    echo $response;
  }

  private function processKeys($keys) {
    foreach ($keys as $key) {
      if (array_key_exists($key, $_POST)) {
        $this->data[$key] = $_POST[$key];
      } else {
        return false;
      }
    }
    return true;
  }

  abstract protected function getResponse();
}

?>
