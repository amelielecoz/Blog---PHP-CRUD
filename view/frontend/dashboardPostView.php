<?php
$title = 'Tableau de bord';

?>

<?php ob_start(); ?>

<div class="container">
    <h1>Bienvenue, <?= ucwords($_SESSION['user']['userFirstName'])  ?></h1>
    <?php if (ucwords($_SESSION['user']['userFirstName']) === 'Jean' && $_SESSION['user']['admin'] === '1') : ?>
        <div class="d-flex justify-content-around m-5">
            <a href="index.php?action=dashboardListPosts"><button type="button" class="btn btn-outline-info">Voir les billets</button></a>
            <a href="index.php?action=dashboardAddPost"><button type="button" class="btn btn-outline-info">Ecrire un nouveau billet</button></a>
            <a href="index.php?action=dashboardPost"><button type="button" class="btn btn-outline-info">Modifier/Supprimer un billet</button></a>
        </div>
    <?php endif; ?>

    <div class="btn-group dropleft">
        <a href="index.php"><button class="btn btn-secondary dropdown-toggle">Retour à la liste des billets</button></a>
    </div>

    <div class="row d-flex">

        <div class="col-12 m-3 card " style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars_decode($post['title']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $post['creation_date_fr'] ?></h6>
                <p class="card-text"><?= htmlspecialchars_decode($post['content']) ?></p>
            </div>
        </div>

        <h2>Commentaires</h2>

        <?php
        while ($comment = $comments->fetch()) {
            ?>
            <div class="col-12 m-3 card " style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($comment['author']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">le <?= $comment['comment_date_fr'] ?>, a commenté : </h6>
                    <p class="card-text"><?= $comment['comment'] ?></p>
                    <a href="#" class="badge badge-dark" data-toggle="modal" data-target="#reportComment">Signaler</a>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="reportComment" tabindex="-1" role="dialog" aria-labelledby="reportCommentTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportCommentTitle">Signaler un commentaire</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                Etes vous sûr(e) de vouloir signaler ce commentaire aux modérateurs du blog?
                                <div class="form-group mt-2">
                                    <label for="message-text" class="col-form-label">Message aux modérateurs:</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info">Valider</button>
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    }
    $comments->closeCursor();
    ?>
    </div>



    <button class="btn btn-info m-5 " type="button" data-toggle="modal" data-target="#commentForm" aria-expanded="true" aria-controls="collapseExample">
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
                            <input type="text" id="author" name="author" class="form-control col-sm-3" value="<?= ucwords($_SESSION['user']['userFirstName']) ?>" readonly />
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
</div>




<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
