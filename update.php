<?php
include_once 'config.php';
include_once 'connectdb.php';
include_once 'helpers.php';
include_once 'arrays.php';
include_once 'dbhelpers.php';

$id = $_REQUEST['id'];

// Recuperar datos
$distro = getDistro($id, $pdo);

if( !$distro ){
    header('Location: index.php');
}

$distro['basedon'] = convierteArray($distro['basedon']);
$distro['arch'] = convierteArray($distro['arch']);
$distro['desktop'] = convierteArray($distro['desktop']);
$distro['category'] = convierteArray($distro['category']);

$errors = array();  // Array donde se guardaran los errores de validación
$error = false;     // Será true si hay errores de validación.

// Se construye un array asociativo $distro con todas sus claves vacías


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
            <?=generarSelect($osTypeValues, $distro['ostype'], "ostype")?>
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
        <?php if( isset($errors['architecture']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['architecture']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group<?php echo (isset($errors['desktop']['required'])?" has-error":""); ?>">
            <label for="inputDesktop">Desktop</label>
            <?=generarSelect($desktopValues, $distro['desktop'], "desktop", true)?>
        </div>
        <?php if( isset($errors['desktop']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['desktop']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group<?php echo (isset($errors['category']['required'])?" has-error":""); ?>">
            <label for="inputCategory">Category</label>
            <?=generarSelect($categoryValues, $distro['category'], "category", true)?>
        </div>
        <?php if( isset($errors['category']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['category']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group<?php echo (isset($errors['status']['required'])?" has-error":""); ?>">
            <label for="inputStatus">Status</label>
            <?=generarSelect($statusValues, $distro['status'], "status")?>
        </div>
        <?php if( isset($errors['status']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['status']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="inputVersion">Version</label>
            <input type="text" class="form-control" id="inputVersion" name="version" placeholder="Distro Version" value="<?=$distro['version']?>">
        </div>
        <div class="form-group<?php echo (isset($errors['web']['required'])?" has-error":""); ?>">
            <label for="inputWeb">Web</label>
            <input type="text" class="form-control" id="inputWeb" name="web" placeholder="Distro Official Web" value="<?=$distro['web']?>">
        </div>
        <?php if( isset($errors['web']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['web']['required']?></strong>
            </div>
        <?php endif; ?>
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
            <input type="text" class="form-control" id="inputError" name="errorTracker" placeholder="Distro Official Error Tracker Website" value="<?=$distro['error_tracker']?>">
        </div>
        <div class="form-group<?php echo (isset($errors['web']['required'])?" has-error":""); ?>">
            <label for="inputDescription">Description</label>
            <textarea class="form-control" name="description" id="inputDescription" rows="5"><?=$distro['description']?></textarea>
        </div>
        <?php if( isset($errors['description']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['description']['required']?></strong>
            </div>
        <?php endif; ?>
        <input type="hidden" name="id" value="<?=$id?>">
        <button type="submit" class="btn btn-default">Actualizar</button>
    </form>
</div><!-- /.container -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>