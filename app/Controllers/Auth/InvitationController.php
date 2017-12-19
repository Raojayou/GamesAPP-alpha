<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Invitation;
use Sirius\Validation\Validator;

class InvitationController extends BaseController {

    public function getInvitation(){
        return $this->render('auth/invitation.twig',[]);
    }

    public function postInvitation(){
        $errors = [];
        $validator = new Validator();

        $validator->add('inputEmail:Email', 'required', [], 'El {label} es obligatorio');
        $validator->add('inputEmail:Email', 'email', [], 'No es un email válido');

        if($validator->validate($_POST)){
            $invitation = new Invitation();

            $invitation->email = $_POST['inputEmail'];

            $invitation->save();

            header('Location: '.BASE_URL);
        }else{
            $errors = $validator->getMessages();
        }

        return $this->render('auth/invitation.twig', ['errors' => $errors]);
    }
}