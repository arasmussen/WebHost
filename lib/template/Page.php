<?php

abstract class Page {
  final public function render() {
    if (!$this->authorizeUser()) {
      header('Location: /');
    }

    $content =
      '<!DOCTYPE html>' .
      '<html>' .
      '<head>' .
        '<title>' . $this->getPageTitle() . '</title>' .
        '<link rel="stylesheet" type="text/css" href="/css/global/reset.css" />' .
        '<link rel="stylesheet" type="text/css" href="/css/global/global.css" />' .
        $this->getPageStyles() .
        '<script type="text/javascript" src="/js/global/jquery-1.7.2.min.js"></script>' .
        '<script type="text/javascript" src="/js/global/jquery-ui-1.8.22.custom.min.js"></script>' .
        $this->getPageScripts() .
        '<meta http-equiv="content-type" content="text/html;charset=utf-8">' .
      '</head>' .
      '<body>' .
        '<div id="center">' .
          '<div id="' . $this->getPageType() . '">' .
            '<div id="header">' .
              $this->getHeaderContent() .
            '</div>' .
            '<div id="content">' .
              $this->getPageContent() .
            '</div>' .
            '<div id="footer">' .
              $this->getFooterContent() .
            '</div>' .
          '</div>' .
        '</div>' .
      '</body>' .
      '</html>';

    echo $content;
  }

  // implement these in abstract children
  // (PublicPage, PrivatePage)
  abstract protected function authorizeUser();
  abstract protected function getHeaderContent();
  abstract protected function getFooterContent();
  abstract protected function getPageScripts();
  abstract protected function getPageStyles();
  abstract protected function getPageType();

  // implement these in grandchildren
  abstract protected function getPageContent();
  abstract protected function getPageTitle();
}

?>
