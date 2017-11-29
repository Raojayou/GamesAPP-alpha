<?php
namespace App\Controllers;

use App\Models\Distro;

class ApiController {

    public function getDistros(){
        $distros = Distro::all();

        header('Content-Type: application/json');
        return json_encode($distros);
    }

    public function getDistro($id){
        $distro = Distro::find($id);

        header('Content-Type: application/json');
        return json_encode($distro);
    }

    public function postDistro(){
        //Creo una distro en la BD desde un Json
        
    }
}