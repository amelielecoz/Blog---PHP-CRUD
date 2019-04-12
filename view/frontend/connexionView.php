<?php
$title = 'Connexion';
?>

<?php ob_start(); ?>

<div class="container">
    <pre>
  <?php var_dump($_SESSION)  ?>
  <?php var_dump($_POST)  ?>
</pre>

    <?= $erreur ?>

    <form action="index.php?action=connected" method="POST">
        <div class="form-group row">
            <label for="pseudo" class="col-form-label">Pseudo</label>
            <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Pseudo">
        </div>
        <div class="form-group row">
            <label for="password" class="col-form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Confirm</button>
    </form>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
