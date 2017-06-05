<?php 

$root_dir = $_SERVER['DOCUMENT_ROOT'];
$api_path = '/gk/api';
$class_path = '/class';

define('ENVIRONMENT', 'development');

define('APPPATH',$root_dir.$api_path.'/');

define('BASEPATH', $root_dir.$api_path.$class_path.'/');


?>