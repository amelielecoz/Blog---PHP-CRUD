<?php
$title = 'Blog de Jean';
?>

<?php ob_start(); ?>

<main class="main pt-4">
    <div class="container">
        <h1>Bienvenue, <?= ucwords($_SESSION['user']['userFirstName'])  ?></h1>
        <?php if (ucwords($_SESSION['user']['userFirstName']) === 'Jean' && $_SESSION['user']['admin'] === '1') : ?>
            <div class="d-flex justify-content-around m-5">
                <a href="index.php?action=addPostForm"><button type="button" class="btn btn-outline-dark">Ecrire un nouveau billet</button></a>
                <a href="index.php?action=commentAdmin"><button type="button" class="btn btn-outline-dark">Administration des commentaires</button></a>
            </div>
        <?php endif; ?>

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
                        <?php if ($_SESSION['user']['admin'] === '1') : ?>

                            <form action="index.php?action=modifyPostForm&id=<?= $post['id'] ?>" method="post">
                                <button class="btn btn-secondary btn-sm float-right" type="submit"> <span class="fas fa-pencil-alt"></span> Modifier </button>
                            </form>
                            <form onsubmit="return confirmationDelete();" action="index.php?action=delete&id=<?= $post['id'] ?>" method="post">
                                <button class="btn btn-secondary btn-sm float-right mr-2" type="submit"> <span class="fas fa-trash-alt"></span> Supprimer </button>
                            </form>
                        <?php endif; ?>
                    </header>
                    <a href="#">
                        <img class="card-img" src="./public/images/articles/<?= $_GET['id'] % 22 ?>.jpg" alt="" />
                    </a>
                    <div class="card-body">

                        <?= nl2br(htmlspecialchars_decode($post['content'])) ?>

                        <hr />

                        <h3>Commentaires</h3>

                        <?php
                        while ($comment = $comments->fetch()) {
                            ?>
                            <div class="media mb-3">
                                <div class="text-center">
                                    <img class="mr-3 rounded-circle" src="./public/images/avatars/<?= $comment['id_user'] % 4 + 1 ?>.png" alt="<?= htmlspecialchars($comment['author']) ?>" width="100" height="100">
                                    <h6 class="mt-1 mb-0 mr-3"><?= htmlspecialchars_decode($comment['author']) ?></h6>
                                </div>
                                <div class="media-body">
                                    <p class="mt-3 mb-2"><?= nl2br(htmlspecialchars_decode($comment['comment'])) ?></p>
                                    <p><?= $comment['comment_date_fr'] ?></p>
                                    <form onsubmit="return confirmationReport();" action="index.php?action=report&id=<?= $post['id'] ?>" method="post">
                                        <input type="text" class="form-control" id="comment_id" name="comment_id" style="display : none" value="<?= $comment['id'] ?>">
                                        <input type="text" class="form-control" id="comment_content" name="comment_content" style="display : none" value="<?= $comment['comment'] ?>">
                                        <input type="text" class="form-control" id="comment_author" name="comment_author" style="display : none" value="<?= $comment['author'] ?>">
                                        <input type="text" class="form-control" id="comment_date" name="comment_date" style="display : none" value="<?= $comment['comment_date_fr'] ?>">


                                        <button class="btn btn-secondary btn-sm float-right" type="submit"> <span class="fas fa-flag"></span> Signaler </button>

                                    </form>
                                </div>

                            </div>



                        <?php
                    }
                    $comments->closeCursor();
                    ?>
                    </div>
                </article>

            </div>
            <div class="col-md-3 ml-auto">

                <aside class="sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">About</h4>
                            <p class="card-text">Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam <a href="#">semper libero</a>, sit amet adipiscing sem neque sed ipsum. </p>
                        </div>
                    </div>
                </aside>

                <aside class="sidebar sidebar-sticky">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Tags</h4>
                            <a class="btn btn-light btn-sm mb-1" href="#">Voyage</a>
                            <a class="btn btn-light btn-sm mb-1" href="#">Travail</a>
                            <a class="btn btn-light btn-sm mb-1" href="#">Style de vie</a>
                            <a class="btn btn-light btn-sm mb-1" href="#">Photographie</a>
                            <a class="btn btn-light btn-sm mb-1" href="#">Boissons</a>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Histoires populaires</h5>

                            <a href="#" class="d-inline-block">
                                <h4 class="h6">The blind man</h4>
                                <img class="card-img" src="./public/images/articles/2.jpg" alt="" />
                            </a>
                            <p>3 october 2017</p> in Lifestyle

                            <a href="#" class="d-inline-block mt-3">
                                <h4 class="h6">Crying on the news</h4>
                                <img class="card-img" src="./public/images/articles/3.jpg" alt="" />
                            </a>
                            <p>16 july 2017</p> in Work

                        </div>
                    </div><!-- /.card -->
                </aside>

            </div>
        </div>
        <?php if (!isset($_SESSION['connected'])) : ?>
            <div class="alert alert-danger m-5">
                Pour laisser un commentaire vous devez d'abord vous connecter. <a href="index.php?action=connexion">Me connecter</a>
            </div>
        <?php else : ?>
            <button class="btn btn-dark m-5 " type="button" data-toggle="modal" data-target="#commentForm" aria-expanded="true" aria-controls="collapseExample">
                Ajouter un commentaire
            </button>
            <!-- Modal -->
            <div class="modal fade" id="commentForm" tabindex="-1" role="dialog" aria-labelledby="commentFormTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentFormTitle">Ajouter un commentaire</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="author">Auteur</label><br />
                                    <input type="text" class="form-control col-sm-3" id="author" name="author" value="<?= ucwords($_SESSION['user']['userFirstName']) ?>" readonly />
                                    <input type="text" class="form-control" id="id_user" name="id_user" style="display : none" value="<?= $_SESSION['user']['userId'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="comment">Commentaire</label><br />
                                    <textarea id="comment" name="comment" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
</main>


<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
