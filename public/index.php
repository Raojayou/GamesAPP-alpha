<?php
require_once '../vendor/autoload.php';

use Phroute\Phroute\RouteCollector;

// Punto de entrada a la aplicación
require_once '../config.php';
require_once '../connectdb.php';
require_once '../arrays.php';
require_once '../helpers.php';
require_once '../dbhelpers.php';


$baseDir = str_replace(
    basename($_SERVER['SCRIPT_NAME']),
    '',
    $_SERVER['SCRIPT_NAME']);

$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);

$route = $_GET['route'] ?? "/";

function render($fileName, $params = []){
    // Activa el buffer interno de PHP para que toda la salida que va al navegador
    // se guarde en dicho buffer interno.
    ob_start(); // Omite cualquier salida de la aplicación y la almacena internamente

    extract($params); // Extrae los datos del array asociativo $params y los convierte en variables

    require($fileName);

    return ob_get_clean(); // Se trae los datos del buffer interno y lo limpia
}


$router = new RouteCollector();

$router->get('/', function() use ($pdo) {
    $query = $pdo->query("SELECT * from distro ORDER BY id DESC");

    $query->execute();

    // $distros es un array compuesto por tantos arrays asociativos como
    // distribuciones haya en la base de datos
    $distros = $query->fetchAll(PDO::FETCH_ASSOC);

    return render('../views/home.php', ['distros' => $distros]);
});

$router->get('/add', function() use ($osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues) {
    $errors = array();  // Array donde se guardaran los errores de validación
    $error = false;     // Será true si hay errores de validación.

// Se construye un array asociativo $distro con todas sus claves vacías
    $distro = array_fill_keys(["name","image", "ostype", "basedon", "origin", "arch", "desktop", "category", "status", "version", "web", "forums", "doc", "errorTracker", "description"], "");

    return render('../views/add.php', [
        'osTypeValues'  => $osTypeValues,
        'basedOnValues' => $basedOnValues,
        'desktopValues' => $desktopValues,
        'originValues'  => $originValues,
        'archValues'    => $archValues,
        'categoryValues'=> $categoryValues,
        'statusValues'  => $statusValues
    ]);
});

$router->post('/add', function() use ($pdo, $osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues) {
    if( !empty($_POST)){
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
            $errors['arch']['required'] = "El campo architecture debe tener al menos una opción seleccionada";
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
            //dameDato($distro);
            // Si no tengo errores de validación
            // Guardo en la BD
            $sql = "INSERT INTO distro (image, name, ostype, basedon, origin, arch, desktop, category, status, version, web, doc, forums, error_tracker, description, created_at) VALUES (:image, :name, :ostype, :basedon, :origin, :arch, :desktop, :category, :status, :version, :web, :doc, :forums, :error_tracker, :description, NOW())";

            $result = $pdo->prepare($sql);

            $result->execute([
                'image'         => $distro['image'],
                'name'          => $distro['name'],
                'ostype'        => $distro['ostype'],
                'basedon'       => convierteCadena( $distro['basedon']),
                'origin'        => $distro['origin'],
                'arch'          => convierteCadena( $distro['arch']),
                'desktop'       => convierteCadena( $distro['desktop']),
                'category'      => convierteCadena( $distro['category']),
                'status'        => $distro['status'],
                'version'       => $distro['version'],
                'web'           => $distro['web'],
                'doc'           => $distro['doc'],
                'forums'        => $distro['forums'],
                'error_tracker' => $distro['errorTracker'],
                'description'   => $distro['description']
            ]);

            // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
            header('Location: '. BASE_URL);
        }
    }

    return render('../views/add.php', [
        'osTypeValues'  => $osTypeValues,
        'basedOnValues' => $basedOnValues,
        'desktopValues' => $desktopValues,
        'originValues'  => $originValues,
        'archValues'    => $archValues,
        'categoryValues'=> $categoryValues,
        'statusValues'  => $statusValues,
        'errors'        => $errors
    ]);
});

$router->get('/update', function() use ($pdo,$osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues) {
    $id = $_REQUEST['id'];

    // Recuperar datos
    $distro = getDistro($id, $pdo);

    if( !$distro ){
        header('Location: home.php');
    }

    return render('../views/update.php',[
        'osTypeValues'  => $osTypeValues,
        'basedOnValues' => $basedOnValues,
        'desktopValues' => $desktopValues,
        'originValues'  => $originValues,
        'archValues'    => $archValues,
        'categoryValues'=> $categoryValues,
        'statusValues'  => $statusValues,
        'distro'        => $distro
    ]);
});

$router->post('/update', function () use ($pdo,$osTypeValues, $basedOnValues, $desktopValues, $originValues, $archValues, $categoryValues, $statusValues){
    $id = $_REQUEST['id'];

    $errors = array();  // Array donde se guardaran los errores de validación

    if( !empty($_POST)){
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

            $result = $pdo->prepare($sql);

            $result->execute([
                'id'            => $id,
                'image'         => $distro['image'],
                'name'          => $distro['name'],
                'ostype'        => $distro['ostype'],
                'basedon'       => convierteCadena( $distro['basedon']),
                'origin'        => $distro['origin'],
                'arch'          => convierteCadena( $distro['arch']),
                'desktop'       => convierteCadena( $distro['desktop']),
                'category'      => convierteCadena( $distro['category']),
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

    return render('../views/update.php', [
        'osTypeValues'  => $osTypeValues,
        'basedOnValues' => $basedOnValues,
        'desktopValues' => $desktopValues,
        'originValues'  => $originValues,
        'archValues'    => $archValues,
        'categoryValues'=> $categoryValues,
        'statusValues'  => $statusValues,
        'distro'        => $distro,
        'errors'        => $errors
    ]);
});

$router->get('/delete', function() use ($pdo) {
    $id = $_REQUEST['id'];

    $sql = "DELETE FROM distro WHERE id = :id";

    $result = $pdo->prepare($sql);

    $result->execute(['id' => $id]);

    header("Location: ". BASE_URL);
});

$router->get('/distro', function() use ($pdo){
    $id = $_REQUEST['id'];

    // Recuperar datos
    $distro = getDistro($id, $pdo);

    if( !$distro ){
        header('Location: '.BASE_URL);
    }

    dameDato($distro);

    //return render(...);
});
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

// Print out the value returned from the dispatched function
echo $response;








