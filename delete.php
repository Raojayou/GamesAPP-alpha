<?php

include_once 'config.php';
include_once 'connectdb.php';
include_once 'helpers.php';

$id = $_REQUEST['id'];

$sql = "DELETE FROM distro WHERE id = :id";

$result = $pdo->prepare($sql);

$result->execute(['id' => $id]);

header("Location: .");