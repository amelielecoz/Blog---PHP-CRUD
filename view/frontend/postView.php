<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<p><a href="index.php">Retour à la liste des billets</a></p>
 
<div class="container">
    <div class="row d-flex">
       
        <div class="col-12 m-3 card " style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?=htmlspecialchars($post['title']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $post['creation_date_fr'] ?></h6>
                <p class="card-text"><?= $post['content'] ?></p>
            </div>
        </div>
        <h2>Commentaires</h2>
        
        <?php
        while ($comment = $comments->fetch())
        {
        ?>
        <div class="col-12 m-3 card " style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?=htmlspecialchars($comment['author']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">le <?= $comment['comment_date_fr'] ?>, a commenté : </h6>
                <p class="card-text"><?= $comment['comment'] ?></p>
            </div>
        </div>
        <?php
        } // Fin de la boucle des commentaires
        $comments->closeCursor();
        ?>
    </div>  
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
