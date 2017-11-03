<?php
include_once 'config.php';
include_once 'connectdb.php';
include_once 'helpers.php';
include_once 'arrays.php';
include_once 'dbhelpers.php';

$id = $_REQUEST['id'];

// Recuperar datos
$distro = getDistro($id, $pdo);

//dameDato($distro);

if( !$distro ){
    header('Location: index.php');
}

dameDato($distro);