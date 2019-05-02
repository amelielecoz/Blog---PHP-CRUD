<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <link href="public/css/app.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=9o0bwilvuxfu8apr3jfarzj1ne9onrrdyj4kdyet29nax94e"></script>

    <script>
        tinymce.init({
            selector: '#myeditable-h5',
            inline: true,
            menubar: false,
            branding: false,
            toolbar: 'undo redo'
        });

        tinymce.init({
            selector: '#myeditable-div',
            branding: false,
            menubar: false,
            plugins: [
                'link',
                'textcolor',
                'lists',
                'powerpaste',
                'autolink',
                'tinymcespellchecker'
            ]
        });
    </script>
</head>

<body>
    <pre>
    <?= var_dump($_SESSION) ?>
    </pre>
    <header role="banner">
        <nav class="navbar navbar-expand-md navbar-light bg-white absolute-top">
            <div class="container">

                <button class="navbar-toggler order-2 order-md-1" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3 order-md-2" id="navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=about">à propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=contact">Contact</a>
                        </li>
                    </ul>
                </div>

                <a class="navbar-brand mx-auto order-1 order-md-3" href="index.php">Jean Forterøche</a>

                <div class="collapse navbar-collapse order-4 order-md-4" id="navbar">
                    <ul class="navbar-nav ml-auto">
                        <form class="form-inline">
                            <?php if (!isset($_SESSION['connected'])) : ?>
                                <a href="index.php?action=connexion" class="btn btn-secondary m-2 my-sm-0">Se connecter</a>
                                <a href="index.php?action=subscription" class="btn btn-secondary m-2 my-sm-0">S'inscrire</a>
                            <?php else :  ?>
                                <a href="index.php?action=logout" class="btn btn-secondary m-2 my-sm-0">Se déconnecter</a>
                            <?php endif;  ?>
                        </form>
                    </ul>

                </div>
            </div>
        </nav>
    </header>


    <div class="jumbotron jumbotron-fluid">
        <div class="container-fluid">
            <div class="container">
                <h1 class="display-4">Blog de Jean</h1>
                <p class="lead">Billet pour l'Alaska</p>
            </div>
        </div>
    </div>

    <?= $content ?>


    <div class="site-newsletter">
        <div class="container">
            <div class="text-center">
                <h3 class="h4 mb-2">Recevez la newsletter de Jean Forteroche</h3>
                <p class="text-muted">Rejoignez notre communauté et ne manquez plus nos nouveaux articles.</p>

                <div class="row">
                    <div class="col-xs-12 col-sm-9 col-md-7 col-lg-5 ml-auto mr-auto">
                        <div class="input-group mb-3 mt-3">
                            <input type="text" class="form-control" placeholder="Adresse email" aria-label="Email address">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">Souscrire</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-instagram">
        <div class="action">
            <a class="btn btn-light" href="#">
                Follow Jean @ Instagram
            </a>
        </div>
        <div class="row no-gutters">
            <div class="col-sm-6">
                <div class="row no-gutters">
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/1.jpg" alt="" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/2.jpg" alt="" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/3.jpg" alt="" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/4.jpg" alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row no-gutters">
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/5.jpg" alt="" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/6.jpg" alt="" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/7.jpg" alt="" />
                        </a>
                    </div>
                    <div class="col-3">
                        <a class="photo" href="#">
                            <img class="img-fluid" src="./public/images/instagram/8.jpg" alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="site-footer bg-darkest" role="contentinfo">
        <div class="container">

            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">Crédits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=privacy">Confidentialité</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=contact">Contact</a>
                </li>
            </ul>
            <div class="copy">
                &copy; Amélie Le Coz 2019<br />
                All rights reserved
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="./public/js/script.js"></script>

</body>

</html>
