<?php
$title = 'Tableau de bord';

?>

<?php ob_start(); ?>

<div class="container">
    <h1>Bienvenue, <?= ucwords($_SESSION['user']['userFirstName'])  ?></h1>
    <?php if (ucwords($_SESSION['user']['userFirstName']) === 'Jean' && $_SESSION['user']['admin'] === '1') : ?>
        <div class="d-flex justify-content-around m-5">
            <a href="index.php?action=addPostForm"><button type="button" class="btn btn-outline-dark">Ecrire un nouveau billet</button></a>
            <a href="index.php?action=commentAdmin"><button type="button" class="btn btn-outline-dark">Administration des commentaires</button></a>
        </div>
    <?php endif; ?>

    <h1 class="d-flex justify-content-around m-5">Modifier l'article</h1>

    <form action="index.php?action=modifyPost&id=<?= htmlspecialchars($post['id']) ?>" method="post">

        <div class="form-group">
            <label for="myeditable-h5">Titre</label>
            <input type="text" class="form-control" id="myeditable-h5" name="title" value="<?= htmlspecialchars($post['title']) ?>" />
        </div>

        <div class="form-group">
            <label for="myeditable-div"></label>
            <textarea class="form-control" id="myeditable-div" name="content" rows="15"><?= htmlspecialchars($post['content']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
