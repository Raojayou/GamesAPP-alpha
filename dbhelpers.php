<?php

function getDistro($id, $pdo){
    $sql = "SELECT * FROM distro WHERE id = :id";
    $result = $pdo->prepare($sql);

    $result->execute([ 'id' => $id]);

    return $result->fetch(PDO::FETCH_ASSOC);
}