<?php
$title = 'Mentions légales';

?>

<?php ob_start(); ?>

<main class="main pt-4">

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8 mx-auto">

                <article class="card mb-4">
                    <header class="card-header text-center">
                        <h1 class="card-title">Mentions légales</h1>
                    </header>
                    <div class="card-body">

                        <p>amelielecoz.com est hébergé par la société suivante : <br />
                            <strong>1&1 IONOS SE</strong> <br />
                            Elgendorfer Str. 57 <br />
                            56410 Montabaur <br />
                            Allemagne <br />
                            Site de l’hébergeur : <a href="https://www.ionos.fr">IONOS</a> </p>

                    </div>
                </article>

            </div>
        </div>
    </div>
</main>


<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
