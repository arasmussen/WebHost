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

  private function getCreateProjectContent() {
    return
      '<div id="createProject">' .
        '<a href="javascript:void(0)" id="hideCreateProject">' .
          'Cancel' .
        '</a>' .
        '<form method="post" action="javascript:void(0)">' .
          '<div id="createProjectName">' .
            '<label>Project Name</label>' .
            '<input type="text" name="projectName" />' .
          '</div>' .
          '<div id="createProjectButton">' .
            '<input type="submit" value="Create Project" />' .
          '</div>' .
        '</form>' .
      '</div>';
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
      '<a href="javascript:void(0)" id="showCreateProject">' .
        'Create a project' .
      '</a>' .
      $this->getCreateProjectContent() .
      $contents;
  }

  protected function getPageStyles() {
    return
      parent::getPageStyles() .
      '<link rel="stylesheet" type="text/css" href="/css/dashboard/create_project.css">';
  }

  protected function getPageScripts() {
    return
      parent::getPageScripts() .
      '<script type="text/javascript" src="/js/dashboard/create_project.js"></script>';
  }

  protected function getPageTitle() {
    return 'Logged in dashboard';
  }
}

$page = new Dashboard();
$page->render();

?>
