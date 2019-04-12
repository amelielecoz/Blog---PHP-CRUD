<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<div class="container">
    <div class="btn-group dropleft">
        <a href="index.php"><button class="btn btn-secondary dropdown-toggle">Retour à la liste des billets</button></a>
    </div>

    <div class="row d-flex">

        <div class="col-12 m-3 card " style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $post['creation_date_fr'] ?></h6>
                <p class="card-text"><?= $post['content'] ?></p>
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
                </div>
            </div>
        <?php
    } // Fin de la boucle des commentaires
    $comments->closeCursor();
    ?>
    </div>
    <button class="btn btn-primary " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Ajouter un commentaire
    </button>

    <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post" class="collapse col-sm-12 justify-content-center" id="collapseExample">
        <h2 class="mt-3 mb-4">Ajouter un commentaire</h2>
        <div class="form-group">
            <label for="author">Auteur</label><br />
            <input type="text" id="author" name="author" class="form-control col-sm-3" />
        </div>
        <div class="form-group">
            <label for="comment">Commentaire</label><br />
            <textarea id="comment" name="comment" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>

    </form>
</div>




<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
