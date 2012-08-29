<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/../lib/template/PrivatePage.php");

class Dashboard extends PrivatePage {

  protected function getPageContent() {
    return
      $this->getUserContent() .
      $this->getProjectContent();
  }

  private function getUserContent() {
    $username = $this->getUser()->getUsername();
    return '<p>' . $username . '</p>';
  }

  private function getProjectContent() {
    $projects = $this->getuser()->getProjects();

    $contents = '<div id="projects"><ul>';
    foreach ($projects as $project) {
      $contents .=
        '<li>' .
          '<a href="' . $project->getUrl() . '">' .
            '<h3>' . $project->getName() . '</h3>' .
          '</a>' .
        '</li>';
    }
    $contents .= '</ul></div>';

    return
      '<h2>Projects (' . sizeof($projects) . ')</h2>' .
      '<a href="javascript:void(0)" id="createProject">Create a project</a>' .
      $contents;
  }

  protected function getPageTitle() {
    return 'Logged in dashboard';
  }
}

$page = new Dashboard();
$page->render();

?>
