<?php
namespace App\Controllers;

use App\Models\Comment;
use App\Models\Distro;
use Sirius\Validation\Validator;

class DistrosController extends BaseController {

    /**
     * Ruta [GET] /distros/new que muestra el formulario de añadir una nueva distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function getNew(){
        global $osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues;

        $errors = array();  // Array donde se guardaran los errores de validación
        $error = false;     // Será true si hay errores de validación.

        $webInfo = [
            'h1'        => 'Añadir Distro',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        // Se construye un array asociativo $distro con todas sus claves vacías
        $distro = array_fill_keys(["name","image", "ostype", "basedon", "origin", "arch", "desktop", "category", "status", "version", "web", "forums", "doc", "errorTracker", "description"], "");

        return $this->render('formDistros.twig', [
            'osTypeValues'  => $osTypeValues,
            'basedOnValues' => $basedOnValues,
            'desktopValues' => $desktopValues,
            'originValues'  => $originValues,
            'archValues'    => $archValues,
            'categoryValues'=> $categoryValues,
            'statusValues'  => $statusValues,
            'distro'        => $distro,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [POST] /distros/new que procesa la introducción de una nueva distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function postNew(){
        global $osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues;

        $webInfo = [
            'h1'        => 'Añadir Distro',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        if (!empty($_POST)) {
            $validator = new Validator();

            $requiredFieldMessageError = "El {label} es requerido";

            $validator->add('name:Nombre', 'required',[],$requiredFieldMessageError);
            $validator->add('ostype:Os Type', 'required', [], $requiredFieldMessageError);
            $validator->add('basedon:Based On', 'required',[], $requiredFieldMessageError);
            $validator->add('origin:Origen','required',[],$requiredFieldMessageError);
            $validator->add('architecture:Arquitectura','required',[],$requiredFieldMessageError);
            $validator->add('desktop:Desktop','required',[],$requiredFieldMessageError);
            $validator->add('category:Categoría','required',[],$requiredFieldMessageError);
            $validator->add('status:Estado','required',[],$requiredFieldMessageError);
            $validator->add('web:Sitio Web', 'required',[], $requiredFieldMessageError);
            $validator->add('description:Descripción','required',[],$requiredFieldMessageError);

            // Extraemos los datos enviados por POST
            $distro['name'] = htmlspecialchars(trim($_POST['name']));
            $distro['image'] = htmlspecialchars(trim($_POST['image']));
            $distro['ostype'] = $_POST['ostype'];
            $distro['basedon'] = $_POST['basedon'];
            $distro['origin'] = htmlspecialchars(trim($_POST['origin']));
            $distro['architecture'] = $_POST['architecture'];
            $distro['desktop'] = $_POST['desktop'];
            $distro['category'] = $_POST['category'];
            $distro['status'] = htmlspecialchars(trim($_POST['status']));
            $distro['version'] = htmlspecialchars(trim($_POST['version']));
            $distro['web'] = htmlspecialchars(trim($_POST['web']));
            $distro['forums'] = htmlspecialchars(trim($_POST['forum']));
            $distro['doc'] = htmlspecialchars(trim($_POST['doc']));
            $distro['errorTracker'] = htmlspecialchars(trim($_POST['errorTracker']));
            $distro['description'] = htmlspecialchars(trim($_POST['description']));

            if ($validator->validate($_POST)) {
                $distro = new Distro([
                    'image'         => $distro['image'],
                    'name'          => $distro['name'],
                    'ostype'        => $distro['ostype'],
                    'basedon'       => $distro['basedon'],
                    'origin'        => $distro['origin'],
                    'architecture'  => $distro['architecture'],
                    'desktop'       => $distro['desktop'],
                    'category'      => $distro['category'],
                    'status'        => $distro['status'],
                    'version'       => $distro['version'],
                    'web'           => $distro['web'],
                    'doc'           => $distro['doc'],
                    'forums'        => $distro['forums'],
                    'error_tracker' => $distro['errorTracker'],
                    'description'   => $distro['description']
                ]);
                $distro->save();

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }

        return $this->render('formDistros.twig', [
            'osTypeValues'  => $osTypeValues,
            'basedOnValues' => $basedOnValues,
            'desktopValues' => $desktopValues,
            'originValues'  => $originValues,
            'archValues'    => $archValues,
            'categoryValues'=> $categoryValues,
            'statusValues'  => $statusValues,
            'distro'        => $distro,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [GET] /distros/edit/{id} que muestra el formulario de actualización de una nueva distribución.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function getEdit($id){
        global $osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues;

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Distro',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        // Recuperar datos
        $distro = Distro::find($id);

        if( !$distro ){
            header('Location: home.twig');
        }

        return $this->render('formDistros.twig',[
            'osTypeValues'  => $osTypeValues,
            'basedOnValues' => $basedOnValues,
            'desktopValues' => $desktopValues,
            'originValues'  => $originValues,
            'archValues'    => $archValues,
            'categoryValues'=> $categoryValues,
            'statusValues'  => $statusValues,
            'distro'        => $distro,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [PUT] /distros/edit/{id} que actualiza toda la información de una distribución. Se usa el verbo
     * put porque la actualización se realiza en todos los campos de la base de datos.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function putEdit($id){
        global $osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues;

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Distro',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        if( !empty($_POST)){
            $validator = new Validator();

            $requiredFieldMessageError = "El {label} es requerido";

            $validator->add('name:Nombre', 'required',[],$requiredFieldMessageError);
            $validator->add('ostype:Os Type', 'required', [], $requiredFieldMessageError);
            $validator->add('basedon:Based On', 'required',[], $requiredFieldMessageError);
            $validator->add('origin:Origen','required',[],$requiredFieldMessageError);
            $validator->add('architecture:Arquitectura','required',[],$requiredFieldMessageError);
            $validator->add('desktop:Desktop','required',[],$requiredFieldMessageError);
            $validator->add('category:Categoría','required',[],$requiredFieldMessageError);
            $validator->add('status:Estado','required',[],$requiredFieldMessageError);
            $validator->add('web:Sitio Web', 'required',[], $requiredFieldMessageError);
            $validator->add('description:Descripción','required',[],$requiredFieldMessageError);

            // Extraemos los datos enviados por POST
            $distro['id'] = $id;
            $distro['name'] = htmlspecialchars(trim($_POST['name']));
            $distro['image'] = htmlspecialchars(trim($_POST['image']));
            $distro['ostype'] = $_POST['ostype'];    // Si no se recibe nada se carga un array vacío
            $distro['basedon'] = $_POST['basedon'];
            $distro['origin'] = htmlspecialchars(trim($_POST['origin']));
            $distro['architecture'] = $_POST['architecture'];
            $distro['desktop'] = $_POST['desktop'];
            $distro['category'] = $_POST['category'];
            $distro['status'] = htmlspecialchars(trim($_POST['status']));
            $distro['version'] = htmlspecialchars(trim($_POST['version']));
            $distro['web'] = htmlspecialchars(trim($_POST['web']));
            $distro['forums'] = htmlspecialchars(trim($_POST['forum']));
            $distro['doc'] = htmlspecialchars(trim($_POST['doc']));
            $distro['error_tracker'] = htmlspecialchars(trim($_POST['errorTracker']));
            $distro['description'] = htmlspecialchars(trim($_POST['description']));

            if ( $validator->validate($_POST) ){
                $distro = Distro::where('id', $id)->update([
                    'id'            => $distro['id'],
                    'image'         => $distro['image'],
                    'name'          => $distro['name'],
                    'ostype'        => $distro['ostype'],
                    'basedon'       => $distro['basedon'],
                    'origin'        => $distro['origin'],
                    'architecture'  => $distro['architecture'],
                    'desktop'       => $distro['desktop'],
                    'category'      => $distro['category'],
                    'status'        => $distro['status'],
                    'version'       => $distro['version'],
                    'web'           => $distro['web'],
                    'doc'           => $distro['doc'],
                    'forums'        => $distro['forums'],
                    'error_tracker' => $distro['error_tracker'],
                    'description'   => $distro['description']
                ]);

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }
        return $this->render('formDistros.twig', [
            'osTypeValues'  => $osTypeValues,
            'basedOnValues' => $basedOnValues,
            'desktopValues' => $desktopValues,
            'originValues'  => $originValues,
            'archValues'    => $archValues,
            'categoryValues'=> $categoryValues,
            'statusValues'  => $statusValues,
            'distro'        => $distro,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta raíz [GET] /distros para la dirección home de la aplicación. En este caso se muestra la lista de distribuciones.
     *
     * @return string Render de la web con toda la información.
     *
     * Ruta [GET] /distros/{id} que muestra la página de detalle de la distribución.
     * todo: La vista de detalle está pendiente de implementar.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function getIndex($id = null){
        if( is_null($id) ){
            $webInfo = [
                'title' => 'Página de Inicio - DistroADA'
            ];

            $distros = Distro::query()->orderBy('id','desc')->get();
            //$distros = Distro::all();

            return $this->render('home.twig', [
                'distros' => $distros,
                'webInfo' => $webInfo
            ]);

        }else{
            // Recuperar datos

            $webInfo = [
                'title' => 'Página de Distro - DistroADA'
            ];

            $distro = Distro::find($id);
            $comments = Comment::where('distro_id', $id)->orderBy('created_at','DESC')->get();

            if( !$distro ){
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            //dameDato($distro);
            return $this->render('distro/distro.twig', [
                'distro'    => $distro,
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

            $comment->distro_id = $id;
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
            'title' => 'Página de Distro - DistroADA'
        ];

        $distro = Distro::find($id);
        $comments = Comment::all();
        $webInfo = [
            'title' => 'Página de Distro - DistroADA'
        ];

        if( !$distro ){
            return $this->render('404.twig', ['webInfo' => $webInfo]);
        }

        return $this->render('distro/distro.twig', [
            'errors'    => $errors,
            'webInfo'   => $webInfo,
            'distro'    => $distro,
            'comments'  => $comments
        ]);
    }

    /**
     * Ruta [DELETE] /distros/delete para eliminar la distribución con el código pasado
     */
    public function deleteIndex(){
        $id = $_REQUEST['id'];

        $distro = Distro::destroy($id);

        header("Location: ". BASE_URL);
    }
}