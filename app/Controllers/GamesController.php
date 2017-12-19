<?php
namespace App\Controllers;

use App\Models\Comment;
use App\Models\Game;
use Sirius\Validation\Validator;

class GamesController extends BaseController {

    /**
     * Ruta [GET] /games/new que muestra el formulario de añadir un nuevo juego.
     *
     * @return string Render de la web con toda la información.
     */
    public function getNew(){
        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Añadir Juego',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        // Se construye un array asociativo $game con todas sus claves vacías
        $game = array_fill_keys(["name", "image", "platform", "description", "web", "doc", "forums", "error_tracker"]
                                ,"");

        return $this->render('formGames.twig', [
            'game'          => $game,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [POST] /games/new que procesa la introducción de un nuevo juego.
     *
     * @return string Render de la web con toda la información.
     */
    public function postNew(){
        $webInfo = [
            'h1'        => 'Añadir Juego',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        if (!empty($_POST)) {
            $validator = new Validator();

            $requiredFieldMessageError = "El {label} es requerido";

            $validator->add('name:Nombre', 'required',[],$requiredFieldMessageError);
            $validator->add('image:Imagen', 'required', [], $requiredFieldMessageError);
            $validator->add('platform:Plataforma', 'required',[], $requiredFieldMessageError);
            $validator->add('description:Descripción','required',[],$requiredFieldMessageError);
            $validator->add('web:Sitio Web', 'required',[], $requiredFieldMessageError);

            // Extraemos los datos enviados por POST
            $game['name'] = htmlspecialchars(trim($_POST['name']));
            $game['image'] = htmlspecialchars(trim($_POST['image']));
            $game['platform'] = $_POST['platform'];
            $game['description'] = htmlspecialchars(trim($_POST['description']));
            $game['forums'] = htmlspecialchars(trim($_POST['forum']));
            $game['web'] = htmlspecialchars(trim($_POST['web']));
            $game['doc'] = htmlspecialchars(trim($_POST['doc']));
            $game['error_tracker'] = htmlspecialchars(trim($_POST['error_tracker']));


            if ($validator->validate($_POST)) {
                $game = new Game([
                    'name'          => $game['name'],
                    'image'         => $game['image'],
                    'platform'      => $game['platform'],
                    'description'   => $game['description'],
                    'forums'        => $game['forums'],
                    'web'           => $game['web'],
                    'doc'           => $game['doc'],
                    'error_tracker' => $game['error_tracker'],

                ]);
                $game->save();

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }

        return $this->render('formGames.twig', [
            'game'          => $game,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [GET] /games/edit/{id} que muestra el formulario de actualización de un nuevo juego.
     *
     * @param id Código del juego.
     *
     * @return string Render de la web con toda la información.
     */
    public function getEdit($id){
        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Juego',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        // Recuperar datos
        $game = Game::find($id);

        if( !$game ){
            header("Location: game/$id.twig");
        }

        return $this->render('formGames.twig',[
            'game'          => $game,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [PUT] /games/edit/{id} que actualiza toda la información de un juego. Se usa el verbo
     * put porque la actualización se realiza en todos los campos de la base de datos.
     *
     * @param id Código del juego.
     *
     * @return string Render de la web con toda la información.
     */
    public function putEdit($id){
        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Juego',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        if( !empty($_POST)){
            $validator = new Validator();

            $requiredFieldMessageError = "El {label} es requerido";

            $validator->add('name:Nombre', 'required',[],$requiredFieldMessageError);
            $validator->add('image:Imagen', 'required', [], $requiredFieldMessageError);
            $validator->add('platform:Plataforma', 'required',[], $requiredFieldMessageError);
            $validator->add('description:Descripción','required',[],$requiredFieldMessageError);
            $validator->add('web:Sitio Web', 'required',[], $requiredFieldMessageError);

            // Extraemos los datos enviados por POST
            $game['id'] = $id;
            $game['name'] = htmlspecialchars(trim($_POST['name']));
            $game['image'] = htmlspecialchars(trim($_POST['image']));
            $game['platform'] = $_POST['platform'];
            $game['description'] = htmlspecialchars(trim($_POST['description']));
            $game['forums'] = htmlspecialchars(trim($_POST['forum']));
            $game['web'] = htmlspecialchars(trim($_POST['web']));
            $game['doc'] = htmlspecialchars(trim($_POST['doc']));
            $game['error_tracker'] = htmlspecialchars(trim($_POST['error_tracker']));


            if ($validator->validate($_POST)) {
                $game = Game::where('id', $id)->update([
                    'id'            => $game['id'],
                    'name'          => $game['name'],
                    'image'         => $game['image'],
                    'platform'      => $game['platform'],
                    'description'   => $game['description'],
                    'forums'        => $game['forums'],
                    'web'           => $game['web'],
                    'doc'           => $game['doc'],
                    'error_tracker' => $game['error_tracker'],

                ]);

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }

        return $this->render('formGames.twig', [
            'game'          => $game,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta raíz [GET] /games para la dirección home de la aplicación. En este caso se muestra la lista de juegos.
     *
     * @return string Render de la web con toda la información.
     *
     * Ruta [GET] /games/{id} que muestra la página de detalle del juego.
     * todo: La vista de detalle está pendiente de implementar.
     *
     * @param id Código del juego.
     *
     * @return string Render de la web con toda la información.
     */
    public function getIndex($id = null){
        if( is_null($id) ){
            $webInfo = [
                'title' => 'Página de Inicio - GamesAPP'
            ];

            $games = Game::query()->orderBy('id','desc')->get();
            //$games = Game::all();

            return $this->render('home.twig', [
                'games'     => $games,
                'webInfo'   => $webInfo
            ]);

        }else{
            // Recuperar datos

            $webInfo = [
                'title' => 'Página de Juego - GamesAPP'
            ];

            $game = Game::find($id);
            $comments = Comment::where('game_id', $id)->orderBy('created_at','DESC')->get();

            if( !$game ){
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            //dameDato($game);
            return $this->render('game/game.twig', [
                'game'      => $game,
                'webInfo'   => $webInfo,
                'comments'  => $comments
            ]);
        }

    }

    public function postIndex($id){
        $errors = [];
        $validator = new Validator();

        $validator->add('name:Nombre','required', [], 'El {label} es necesario para comentar');
        $validator->add('name:Nombre','minlength', ['min' => 5], 'El {label} debe tener al menos 5 caracteres');
        $validator->add('email:Email','required', [], 'El {label} no es válido');
        $validator->add('email:Email','required', [], 'El {label} es necesario para comentar');
        $validator->add('comment:Comentario', 'required', [], 'Aunque los silencios a veces dicen mucho no se permiten comentarios vacíos');

        if($validator->validate($_POST)){
            $comment = new Comment();

            $comment->game_id = $id;
            $comment->user = $_POST['name'];
            $comment->email = $_POST['email'];
            $comment->ip = getRealIP();
            $comment->text = $_POST['comment'];
            $comment->approved = true;

            $comment->save();

            header("Refresh: 0 " );
        }else{
            $errors = $validator->getMessages();
        }

        $webInfo = [
            'title' => 'Página de Juego - GamesAPP'
        ];

        $game = Game::find($id);
        $comments = Comment::all();
        $webInfo = [
            'title' => 'Página de Juego - GamesAPP'
        ];

        if( !$game ){
            return $this->render('404.twig', ['webInfo' => $webInfo]);
        }

        return $this->render('game/game.twig', [
            'errors'    => $errors,
            'webInfo'   => $webInfo,
            'game'    => $game,
            'comments'  => $comments
        ]);
    }

    /**
     * Ruta [DELETE] /games/delete para eliminar el juego con el código pasado
     */
    public function deleteIndex(){
        $id = $_REQUEST['id'];

        $game = Game::destroy($id);

        header("Location: ". BASE_URL);
    }
}