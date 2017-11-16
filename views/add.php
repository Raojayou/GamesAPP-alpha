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
            <a class="navbar-brand" href="<?=BASE_URL?>">DistroADA</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="add">Añadir Distro</a></li>
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