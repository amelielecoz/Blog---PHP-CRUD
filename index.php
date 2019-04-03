<?php require('header.php') ?>

<h2>Derniers billets du blog :</h2>
 
<?php
// Connect to the db
try
{
	$bd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// On récupère les 5 derniers billets
$req = $bd->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts ORDER BY creation_date LIMIT 0, 5');

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
} // Fin de la boucle des billets
$req->closeCursor();
?>


<?php require('footer.php') ?>