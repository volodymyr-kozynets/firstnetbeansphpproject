<?php
// Единая точка входа в приложение благодаря перенаправлениям .htaccess файлов

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');

require_once(ROOT.DS.'lib'.DS.'init.php');

session_start(); //позволяет работать с сессией, в независимости какая страница загружена

App::run($_SERVER['REQUEST_URI']);