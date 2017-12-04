<?php
namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController {

    /**
     * @return string
     */
    public function getIndex(){
        $users = User::all();

        return $this->render('auth/login.twig',[]);
    }


}