<?php
$title = 'Tableau de bord';

?>

<?php ob_start(); ?>

<div class="container">
    <h1>Bienvenue, <?= ucwords($_SESSION['user']['userFirstName'])  ?></h1>
    <?php if ($_SESSION['user']['admin'] === '1') : ?>
        <div class="d-flex justify-content-around m-5">
            <a href="index.php?action=addPostForm"><button type="button" class="btn btn-outline-dark">Ecrire un nouveau billet</button></a>
            <a href="index.php?action=commentAdmin"><button type="button" class="btn btn-outline-dark">Administration des commentaires</button></a>
        </div>
    <?php endif; ?>

    <h1 class="d-flex justify-content-around m-5">Commentaires signalés</h1>


    <div class="row">
        <div class="col-md-6 col-sm-10 col-xs-10 mx-auto">
            <?php
            if (isset($confirmationComment)) :
                ?>
                <div class="alert alert-success"><?= $confirmationComment ?> </div>
                <?php
                $confirmationComment = null;
            endif; ?>
            <?php
            while ($comment = $comments->fetch()) {
                ?>

                <article class="card mb-4">
                    <header class="card-header">
                        <h4 class="card-title"><?= htmlspecialchars_decode($comment['author']) ?> a écrit :</h4>
                        <div class="card-meta">
                            <p>le <?= $comment['comment_date_fr'] ?></p>
                        </div>
                    </header>

                    <div class="card-body">
                        <p class="card-text"><?= nl2br(htmlspecialchars_decode($comment['comment'])) ?> </p>
                    </div>
                    <?php if ($_SESSION['user']['admin'] === '1') : ?>
                        <div class="card-footer">
                            <form onsubmit="return authorizeComment();" action="index.php?action=authorizeComment&id=<?= $comment['id'] ?>" method="post">
                                <button class="btn btn-outline-success btn-sm float-right" type="submit"> <i class="fas fa-check"></i> Autoriser sur le site </button>
                            </form>
                            <form onsubmit="return confirmationDeleteComment();" action="index.php?action=deleteComment&id=<?= $comment['id'] ?>" method="post">
                                <button class="btn btn-outline-danger btn-sm float-right mr-2" type="submit"> <i class="fas fa-trash-alt"></i> Confirmer la suppression </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </article>

            <?php
        }
        $comments->closeCursor();
        ?>

        </div>

    </div>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
