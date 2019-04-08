<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>




<div class="container">
<h2>Derniers billets du blog :</h2>

<?php
while ($data = $posts->fetch())
{
    ?>
    <div class="row ">
        <div class="col-sm-12 m-3 card ">
            <div class="card-body">
                <h5 class="card-title"><?=htmlspecialchars($data['title']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $data['creation_date_fr'] ?></h6>
                <p class="card-text"><?= nl2br(htmlspecialchars($data['content'])) ?></p>
                <a href="index.php?action=post&id=<?= $data['id'] ?>"><button type="button" class="btn btn-outline-primary">Commentaires</button></a>
            </div>
        </div>
       
    </div>



 
<?php
} 
$posts->closeCursor();
?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>