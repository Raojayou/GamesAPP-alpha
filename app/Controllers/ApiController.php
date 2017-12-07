<?php
namespace App\Controllers;

use App\Models\Distro;

class ApiController
{

    public function getDistros($id = null)
    {
        if (is_null($id)) {
            $distros = Distro::all();

            header('Content-Type: application/json');
            return json_encode($distros);
        } else {
            $distro = Distro::find($id);

            header('Content-Type: application/json');
            return json_encode($distro);
        }
    }
}