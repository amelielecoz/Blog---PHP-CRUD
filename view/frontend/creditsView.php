<?php
$title = 'Crédits';

?>

<?php ob_start(); ?>

<main class="main pt-4" role="main">

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8 mx-auto">

                <article class="card mb-4">
                    <header class="card-header text-center">
                        <h1 class="card-title">Crédits</h1>
                    </header>
                    <div class="card-body">

                        <h3>Conception et réalisation</h3>
                        <p>Amélie Le Coz - <a href="www.amelielecoz.com">www.amelielecoz.com</a></p>
                        <p>Toute reproduction interdite</p>

                        <h3>Images, multimédia</h3>
                        <p>Thème Bootstrap : Milo<br />
                            Icons used (Font Icons) :<br />
                            Icon Pack – <a href="http://linhpham.me/miu/">http://linhpham.me/miu/</a><br />
                            Fonts used :<br />
                            Open Sans Font – <a href="http://www.google.com/fonts/specimen/Open+Sans">http://www.google.com/fonts/specimen/Open+Sans</a></p>

                        <p>Photos Credits Goes to:<br />
                            <ul>
                                <li>http://www.flickr.com</li>
                                <li>http://picjumbo.com/</li>
                                <li>http://photodune.net</li>
                            </ul>
                        </p>

                        <p>Header Hero Elements: <br />
                            You can buy them from http://graphicriver.net/item/art-equipments-mock-up/9414880
                        </p>

                    </div>
                </article>

            </div>
        </div>
    </div>
</main>


<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
