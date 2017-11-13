<?php
include_once 'config.php';
include_once 'connectdb.php';
include_once 'helpers.php';
include_once 'arrays.php';

$errors = array();  // Array donde se guardaran los errores de validación
$error = false;     // Será true si hay errores de validación.

// Se construye un array asociativo $distro con todas sus claves vacías
$distro = array_fill_keys(["name","image", "ostype", "basedon", "origin", "arch", "desktop", "category", "status", "version", "web", "forums", "doc", "errorTracker", "description"], "");

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
        header('Location: .');
    }else{
        // Si tengo errores de validación
        $error = true;
    }
}

$error = !empty($errors)?true:false;

?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Starter Template for Bootstrap</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">DistroADA</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Inicio</a></li>
                <li><a href="add.php">Añadir Distro</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="container">
    <h1>Add New Distro</h1>
    <form action="" method="post">
        <div class="form-group<?php echo (isset($errors['nameDistro']['required'])?" has-error":""); ?>">
            <label for="inputName">Name</label>
                <input type="text" class="form-control" id="inputName" name="distroName" placeholder="Distro Name" value="<?=$distro['name']?>">
        </div>
        <?=generarAlert($errors, 'name')?>
        <div class="form-group">
            <label for="inputImage">Image</label>
            <input type="text" class="form-control" id="inputImage" name="image" placeholder="Distro Image URL" value="<?=$distro['image']?>">
        </div>
        <div class="form-group<?php echo (isset($errors['ostype']['required'])?" has-error":""); ?>">
            <label for="inputOsType">Os Type</label>
            <?=generarSelect($osTypeValues, $distro['ostype'], "ostype", false)?>
        </div>
        <?=generarAlert($errors, 'ostype')?>
        <div class="form-group<?php echo (isset($errors['basedon']['required'])?" has-error":""); ?>">
            <label for="inputBasedOn">Based On</label>
            <?=generarSelect($basedOnValues, $distro['basedon'], "basedon", true)?>
        </div>
        <?=generarAlert($errors, 'basedon')?>
        <div class="form-group<?php echo (isset($errors['origin']['required'])?" has-error":""); ?>">
            <label for="inputOrigin">Origin</label>
            <?=generarSelect($originValues, $distro['origin'], "origin");?>
        </div>
        <?=generarAlert($errors, 'origin')?>
        <div class="form-group<?php echo (isset($errors['architecture']['required'])?" has-error":""); ?>">
            <label for="inputArchitecture">Architecture</label>
            <?=generarSelect($archValues, $distro['arch'], "architecture", true);?>
        </div>
        <?=generarAlert($errors, 'arch')?>
        <div class="form-group<?php echo (isset($errors['desktop']['required'])?" has-error":""); ?>">
            <label for="inputDesktop">Desktop</label>
            <?=generarSelect($desktopValues, $distro['desktop'], "desktop", true)?>
        </div>
        <?=generarAlert($errors, 'desktop')?>
        <div class="form-group<?php echo (isset($errors['category']['required'])?" has-error":""); ?>">
            <label for="inputCategory">Category</label>
            <?=generarSelect($categoryValues, $distro['category'], "category", true)?>
        </div>
        <?=generarAlert($errors, 'category')?>
        <div class="form-group<?php echo (isset($errors['status']['required'])?" has-error":""); ?>">
            <label for="inputStatus">Status</label>
            <?=generarSelect($statusValues, $distro['status'], "status")?>
        </div>
        <?=generarAlert($errors, 'status')?>
        <div class="form-group">
            <label for="inputVersion">Version</label>
            <input type="text" class="form-control" id="inputVersion" name="version" placeholder="Distro Version" value="<?=$distro['version']?>">
        </div>
        <div class="form-group<?php echo (isset($errors['web']['required'])?" has-error":""); ?>">
            <label for="inputWeb">Web</label>
            <input type="text" class="form-control" id="inputWeb" name="web" placeholder="Distro Official Web" value="<?=$distro['web']?>">
        </div>
        <?=generarAlert($errors, 'web')?>
        <div class="form-group">
            <label for="inputDoc">Doc</label>
            <input type="text" class="form-control" id="inputDoc" name="doc" placeholder="Official Doc Website" value="<?=$distro['doc']?>">
        </div>
        <div class="form-group">
            <label for="inputForum">Forums</label>
            <input type="text" class="form-control" id="inputForum" name="forum" placeholder="Distro Official Forum Website" value="<?=$distro['forums']?>">
        </div>
        <div class="form-group">
            <label for="inputError">Error Tracker</label>
            <input type="text" class="form-control" id="inputError" name="errorTracker" placeholder="Distro Official Error Tracker Website" value="<?=$distro['errorTracker']?>">
        </div>
        <div class="form-group<?php echo (isset($errors['web']['required'])?" has-error":""); ?>">
            <label for="inputDescription">Description</label>
            <textarea class="form-control" name="description" id="inputDescription" rows="5"><?=$distro['description']?></textarea>
        </div>
        <?=generarAlert($errors, 'description')?>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div><!-- /.container -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>