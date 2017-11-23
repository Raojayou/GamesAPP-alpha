<?php
namespace App\Controllers;

class HomeController {

    /**
     * Ruta / donde se muestra la página de inicio del proyecto.
     *
     * @return string Render de la página
     */
    public function getIndex(){
        $distros = new DistrosController();

        return $distros->getIndex();
    }

    public function getContacto(){
        return 'Información de contacto';
    }
}