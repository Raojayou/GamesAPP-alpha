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
                <li><a href="add">Añadir Distro</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <h1>Most Popular Distros</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Logo</th>
            <th>Name</th>
            <th>Os Type</th>
            <th>Version</th>
            <th>Web</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($distros as $distro): ?>
        <tr>
            <td><a href="distro/<?=$distro['id']?>"><img src="<?=$distro['image']?>" alt="Logo de <?=$distro['name']?>"></a></td>
            <td><a href="distro/<?=$distro['id']?>"><?=$distro['name']?></a></td>
            <td><?=$distro['basedon']?></td>
            <td><?=$distro['version']?></td>
            <td><?=$distro['web']?></td>
            <td>
                <a href="update/<?=$distro['id']?>" class="editar btn btn-link">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
            </td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?=$distro['id']?>">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-link btn-alert"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div><!-- /.container -->
</body>
</html>
