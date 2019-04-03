<?php require('header.php') ?>

<p><a href="index.php">Retour à la liste des billets</a></p>
 


<div class="container">
    <div class="row d-flex">
       
        <div class="col-12 m-3 card " style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?=htmlspecialchars($data['title']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $data['creation_date_fr'] ?></h6>
                <p class="card-text"><?= $data['content'] ?></p>
            </div>
        </div>
        <h2>Commentaires</h2>
        
        <?php
        $req->closeCursor(); // Important : on libère le curseur pour la prochaine requête

        // Récupération des commentaires
        $req = $db->prepare('SELECT author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date');
        $req->execute(array($_GET['id']));

        while ($data = $req->fetch())
        {
        ?>
        <div class="col-12 m-3 card " style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?=htmlspecialchars($data['author']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">le <?= $data['comment_date_fr'] ?>, a commenté : </h6>
                <p class="card-text"><?= $data['comment'] ?></p>
            </div>
        </div>
        <?php
        } // Fin de la boucle des commentaires
        $req->closeCursor();
        ?>
    </div>  
</div>



<?php require('footer.php') ?>