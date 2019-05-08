<?php $title = 'Blog de Jean'; ?>

<?php ob_start(); ?>

<main class="main pt-4" role="main">

    <div class="container">


        <div class="btn-group dropleft">
            <a href="index.php"><button class="btn btn-secondary dropdown-toggle">Retour à la liste des billets</button></a>
        </div>

        <div class="row">
            <div class="col-md-9">

                <article class="card mb-4">
                    <header class="card-header text-center">
                        <div class="card-meta">
                            <p><?= $post['creation_date_fr'] ?></p>
                        </div>
                        <a href="#">
                            <h1 class="card-title"><?= htmlspecialchars_decode($post['title']) ?></h1>
                        </a>
                    </header>
                    <a href="#">
                        <img class="card-img" src="./public/images/articles/<?= $_GET['id'] % 22 ?>.jpg" alt="" />
                    </a>
                    <div class="card-body">

                        <?= nl2br(htmlspecialchars_decode($post['content'])) ?>

                        <hr />

                        <h3>Comments</h3>

                        <?php
                        while ($comment = $comments->fetch()) {
                            ?>
                            <div class="media mb-3">
                                <div class="text-center">
                                    <img class="mr-3 rounded-circle" src="./public/images/avatars/3.png" alt="<?= htmlspecialchars($comment['author']) ?>" width="100" height="100">
                                    <h6 class="mt-1 mb-0 mr-3"><?= htmlspecialchars($comment['author']) ?></h6>
                                </div>
                                <div class="media-body">
                                    <p class="mt-3 mb-2"><?= $comment['comment'] ?></p>
                                    <p><?= $comment['comment_date_fr'] ?></p>
                                </div>
                            </div>
                        <?php
                    }
                    $comments->closeCursor();
                    ?>
                    </div>
                </article><!-- /.card -->

            </div>
            <div class="col-md-3 ml-auto">

                <aside class="sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">About</h4>
                            <p class="card-text">Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam <a href="#">semper libero</a>, sit amet adipiscing sem neque sed ipsum. </p>
                        </div>
                    </div><!-- /.card -->
                </aside>

                <aside class="sidebar sidebar-sticky">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Tags</h4>
                            <a class="btn btn-light btn-sm mb-1" href="page-category.html">Journey</a>
                            <a class="btn btn-light btn-sm mb-1" href="page-category.html">Work</a>
                            <a class="btn btn-light btn-sm mb-1" href="page-category.html">Lifestype</a>
                            <a class="btn btn-light btn-sm mb-1" href="page-category.html">Photography</a>
                            <a class="btn btn-light btn-sm mb-1" href="page-category.html">Food & Drinks</a>
                        </div>
                    </div><!-- /.card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Popular stories</h4>

                            <a href="#" class="d-inline-block">
                                <h4 class="h6">The blind man</h4>
                                <img class="card-img" src="./public/images/articles/2.jpg" alt="" />
                            </a>
                            <time class="timeago" datetime="2017-10-03 20:00">3 october 2017</time> in Lifestyle

                            <a href="#" class="d-inline-block mt-3">
                                <h4 class="h6">Crying on the news</h4>
                                <img class="card-img" src="./public/images/articles/3.jpg" alt="" />
                            </a>
                            <time class="timeago" datetime="2017-07-16 20:00">16 july 2017</time> in Work

                        </div>
                    </div><!-- /.card -->
                </aside>

            </div>
        </div>
        <?php if (!isset($_POST['connected'])) : ?>
            <div class="alert alert-danger m-5">
                Pour laisser un commentaire vous devez d'abord vous connecter. <a href="index.php?action=connexion">Me connecter</a>
            </div>
        <?php else : ?>
            <button class="btn btn-primary m-5" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Ajouter un commentaire
            </button>

        <?php endif; ?>
    </div>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
