<?php
namespace App\Controllers;

class BaseController {

    public $pdo;

    public function __construct()
    {
        global $pdo;

        $this->pdo = $pdo;
    }
}