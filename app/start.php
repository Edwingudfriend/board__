<?php
session_start();
ini_set('display_errors','Off');

define('APP_ROOT',__DIR__);
define('VIEW_ROOT',APP_ROOT.'/views');
define('BASE_URL','http://localhost/board__');

date_default_timezone_set('Africa/Dar_es_Salaam');

$link = mysqli_connect('localhost', 'root', '', 'board');

require 'functions.php';
