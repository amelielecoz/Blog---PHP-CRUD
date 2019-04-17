<?php
$title = 'Tableau de bord';

?>

<?php ob_start(); ?>

<div class="container">
    <h1 class="m-3">Bienvenue, <?= ucwords($_SESSION['user']['userFirstName'])  ?></h1>
    <h3 class="m-3 mb-5">Que voulez vous faire ?</h3>

    <div class="d-flex justify-content-around m-5">
        <a href="index.php?action=dashboardListPosts"><button type="button" class="btn btn-outline-info">Voir les billets</button></a>

        <?php if (ucwords($_SESSION['user']['userFirstName']) === 'Jean' && $_SESSION['user']['admin'] === '1') : ?>
            <a href="index.php?action=dashboardAddPost"><button type="button" class="btn btn-outline-info">Ecrire un nouveau billet</button></a>
            <a href="index.php?action=dashboardPost"><button type="button" class="btn btn-outline-info">Modifier/Supprimer un billet</button></a>
        <?php endif; ?>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
