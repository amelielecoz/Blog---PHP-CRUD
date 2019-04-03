<?php require('header.php') ?>

<h2>Derniers billets du blog :</h2>

<?php
while ($data = $req->fetch())
{
    ?>

<div class="container">
    <div class="row d-flex">
       
            <div class="col-12 m-3 card " style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?=htmlspecialchars($data['title']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $data['creation_date_fr'] ?></h6>
                    <p class="card-text"><?= $data['content'] ?></p>
                    <a href="comments.php?id=<?= $data['id']; ?>" class="card-link">Commentaires</a>
                </div>
            </div>
       
    </div>
</div>


 
<?php
} 
$req->closeCursor();
?>


<?php require('footer.php') ?>