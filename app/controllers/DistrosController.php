<?php
namespace App\Controllers;

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
            // Extraemos los datos enviados por POST
            $distro['name'] = htmlspecialchars(trim($_POST['distroName']));
            $distro['image'] = htmlspecialchars(trim($_POST['image']));
            $distro['ostype'] = $_POST['ostype'] ?? array();    // Si no se recibe nada se carga un array vacío
            $distro['basedon'] = $_POST['basedon'] ?? array();
            $distro['origin'] = htmlspecialchars(trim($_POST['origin']));
            $distro['arch'] = $_POST['architecture'] ?? array();
            $distro['desktop'] = $_POST['desktop'] ?? array();
            $distro['category'] = $_POST['category'] ?? array();
            $distro['status'] = htmlspecialchars(trim($_POST['status']));
            $distro['version'] = htmlspecialchars(trim($_POST['version']));
            $distro['web'] = htmlspecialchars(trim($_POST['web']));
            $distro['forums'] = htmlspecialchars(trim($_POST['forum']));
            $distro['doc'] = htmlspecialchars(trim($_POST['doc']));
            $distro['errorTracker'] = htmlspecialchars(trim($_POST['errorTracker']));
            $distro['description'] = htmlspecialchars(trim($_POST['description']));

            // Comprobar que se han enviado los campos requeridos
            // Name, OsType, Origin, BasedOn, Architectura, Desktop, Category, Status, Web, Description
            if ($distro['name'] == "") {
                $errors['name']['required'] = "El campo nombre es requerido";
            }

            if ($distro['ostype'] == "") {
                $errors['ostype']['required'] = "El campo Os Type es requerido";
            }

            if (empty($distro['basedon'])) {
                $errors['basedon']['required'] = "El campo based on debe tener al menos una opción seleccionada";
            }
            if (empty($distro['origin'])) {
                $errors['origin']['required'] = "El campo origin debe tener al menos una opción seleccionada";
            }

            if (empty($distro['arch'])) {
                $errors['arch']['required'] = "El campo architecture debe tener al menos una opción seleccionada";
            }

            if (empty($distro['desktop'])) {
                $errors['desktop']['required'] = "El campo desktop debe tener al menos una opción seleccionada";
            }

            if (empty($distro['category'])) {
                $errors['category']['required'] = "El campo Category es requerido";
            }

            if ($distro['status'] == "") {
                $errors['status']['required'] = "El campo Status es requerido";
            }
            if ($distro['web'] == "") {
                $errors['web']['required'] = "El campo web es requerido";
            }

            if ($distro['description'] == "") {
                $errors['description']['required'] = "El campo Description es requerido";
            }

            if (empty($errors)) {
                //dameDato($distro);
                // Si no tengo errores de validación
                // Guardo en la BD
                $sql = "INSERT INTO distro (image, name, ostype, basedon, origin, arch, desktop, category, status, version, web, doc, forums, error_tracker, description, created_at) VALUES (:image, :name, :ostype, :basedon, :origin, :arch, :desktop, :category, :status, :version, :web, :doc, :forums, :error_tracker, :description, NOW())";

                $result = $this->pdo->prepare($sql);

                $result->execute([
                    'image' => $distro['image'],
                    'name' => $distro['name'],
                    'ostype' => $distro['ostype'],
                    'basedon' => implode(", ", $distro['basedon']),
                    'origin' => $distro['origin'],
                    'arch' => implode(", ", $distro['arch']),
                    'desktop' => implode(", ", $distro['desktop']),
                    'category' => implode(", ", $distro['category']),
                    'status' => $distro['status'],
                    'version' => $distro['version'],
                    'web' => $distro['web'],
                    'doc' => $distro['doc'],
                    'forums' => $distro['forums'],
                    'error_tracker' => $distro['errorTracker'],
                    'description' => $distro['description']
                ]);

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
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
        $distro = getDistro($id, $this->pdo);

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
            // Extraemos los datos enviados por POST
            $distro['id'] = $id;
            $distro['name'] = htmlspecialchars(trim($_POST['distroName']));
            $distro['image'] = htmlspecialchars(trim($_POST['image']));
            $distro['ostype'] = $_POST['ostype'] ?? array();    // Si no se recibe nada se carga un array vacío
            $distro['basedon'] = $_POST['basedon'] ?? array();
            $distro['origin'] = htmlspecialchars(trim($_POST['origin']));
            $distro['arch'] = $_POST['architecture'] ?? array();
            $distro['desktop'] = $_POST['desktop'] ?? array();
            $distro['category'] = $_POST['category'] ?? array();
            $distro['status'] = htmlspecialchars(trim($_POST['status']));
            $distro['version'] = htmlspecialchars(trim($_POST['version']));
            $distro['web'] = htmlspecialchars(trim($_POST['web']));
            $distro['forums'] = htmlspecialchars(trim($_POST['forum']));
            $distro['doc'] = htmlspecialchars(trim($_POST['doc']));
            $distro['error_tracker'] = htmlspecialchars(trim($_POST['errorTracker']));
            $distro['description'] = htmlspecialchars(trim($_POST['description']));

            // Comprobar que se han enviado los campos requeridos
            // Name, OsType, Origin, BasedOn, Architectura, Desktop, Category, Status, Web, Description
            if( $distro['name'] == "" ){
                $errors['name']['required'] = "El campo nombre es requerido";
            }

            if( $distro['ostype'] == "" ){
                $errors['ostype']['required'] = "El campo Os Type es requerido";
            }

            if( empty($distro['basedon']) ){
                $errors['basedon']['required'] = "El campo based on debe tener al menos una opción seleccionada";
            }
            if( empty($distro['origin']) ){
                $errors['origin']['required'] = "El campo origin debe tener al menos una opción seleccionada";
            }

            if( empty($distro['arch']) ){
                $errors['architecture']['required'] = "El campo architecture debe tener al menos una opción seleccionada";
            }

            if( empty($distro['desktop']) ){
                $errors['desktop']['required'] = "El campo desktop debe tener al menos una opción seleccionada";
            }

            if( empty($distro['category']) ){
                $errors['category']['required'] = "El campo Category es requerido";
            }

            if( $distro['status'] == "" ){
                $errors['status']['required'] = "El campo Status es requerido";
            }
            if( $distro['web'] == "" ){
                $errors['web']['required'] = "El campo web es requerido";
            }

            if( $distro['description'] == "" ){
                $errors['description']['required'] = "El campo Description es requerido";
            }

            if ( empty($errors) ){
                // Si no tengo errores de validación
                // Guardo en la BD
                $sql = "UPDATE distro SET image = :image, name = :name, ostype = :ostype, basedon = :basedon, origin = :origin, arch = :arch, desktop = :desktop, category = :category, status = :status, version = :version, web = :web, doc = :doc, forums = :forums, error_tracker = :error_tracker, description = :description, updated_at = NOW() WHERE id = :id LIMIT 1";

                $result = $this->pdo->prepare($sql);

                $result->execute([
                    'id'            => $distro['id'],
                    'image'         => $distro['image'],
                    'name'          => $distro['name'],
                    'ostype'        => $distro['ostype'],
                    'basedon'       => implode(", ", $distro['basedon']),
                    'origin'        => $distro['origin'],
                    'arch'          => implode(", ", $distro['arch']),
                    'desktop'       => implode(", ", $distro['desktop']),
                    'category'      => implode(", ", $distro['category']),
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
                // Si tengo errores de validación
                $error = true;
            }
        }

        $error = !empty($errors);

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
     * Ruta [GET] /distro/{id} que muestra la página de detalle de la distribución.
     * todo: La vista de detalle está pendiente de implementar.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function getIndex($id = null){
        if( is_null($id) ){
            $query = $this->pdo->query("SELECT * from distro ORDER BY id DESC");

            $query->execute();

            $webInfo = [
                'title' => 'Página de Inicio - DistroADA'
            ];

            // $distros es un array compuesto por tantos arrays asociativos como
            // distribuciones haya en la base de datos
            $distros = $query->fetchAll(\PDO::FETCH_ASSOC);

            return $this->render('home.twig', [
                'distros' => $distros,
                'webInfo' => $webInfo
            ]);

        }else{
            // Recuperar datos
            $distro = getDistro($id, $this->pdo);

            $webInfo = [
                'title' => 'Página de Distro - DistroADA'
            ];

            if( !$distro ){
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            //dameDato($distro);
            return $this->render('distro.twig', [
                'distro' => $distro,
                'webInfo'=> $webInfo]);
        }

    }

    /**
     * Ruta [DELETE] /distros/delete para eliminar la distribución con el código pasado
     */
    public function deleteIndex(){
        $id = $_REQUEST['id'];

        $sql = "DELETE FROM distro WHERE id = :id";

        $result = $this->pdo->prepare($sql);

        $result->execute(['id' => $id]);

        header("Location: ". BASE_URL);
    }
}