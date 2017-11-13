<?php
// Punto de entrada a la aplicación
require_once '../config.php';
require_once '../connectdb.php';
require_once '../helpers.php';

$route = $_GET['route'] ?? "/";

switch ($route){
    case '/':
        require_once '../index.php';
        break;
    case 'add':
        require_once '../add.php';
        break;
    case 'distro':
        require_once '../distro.php';
        break;
    case 'update':
        require_once '../update.php';
        break;
    case 'delete':
        require_once '../delete.php';
        break;
    default:
        require_once '../404.php';
}









