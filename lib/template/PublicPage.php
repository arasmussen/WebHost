<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once('Page.php');

abstract class PublicPage extends Page
{
  final protected function authorizeUser() {
    return true;
  }

  final protected function getHeaderContent() {
    return
      '<div id="logo">' .
      '</div>' .
      '<div id="login">' .
        '<form method="post" action="javascript:void(0)">' .
          '<div id="loginEmail">' .
            '<label>Email</label>' .
            '<input type="text" name="email" />' .
          '</div>' .
          '<div id="loginPassword">' .
            '<label>Password</label>' .
            '<input type="password" name="password" />' .
          '</div>' .
          '<div id="loginButton">' .
            '<input type="submit" value="Sign in" />' .
          '</div>' .
        '</form>' .
      '</div>';
  }

  final protected function getFooterContent() {
    return '';
  }

  protected function getPageScripts() {
    return
      '<script type="text/javascript" src="/js/public/login.js"></script>' .
      '<script type="text/javascript" src="/js/public/register.js"></script>';
  }

  protected function getPageStyles() {
    return
      '<link rel="stylesheet" type="text/css" href="/css/public/public.css">' .
      '<link rel="stylesheet" type="text/css" href="/css/public/login.css">' .
      '<link rel="stylesheet" type="text/css" href="/css/public/register.css">';
  }

  final protected function getPageType() {
    return 'public';
  }
}
