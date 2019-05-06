<?php
$title = 'Connexion';
?>

<?php ob_start(); ?>

<div class="container">

    <form action="index.php?action=connexionAnswer" method="POST">
        <div class="form-group row">
            <label for="email" class="col-form-label">email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="email">
        </div>
        <div class="form-group row has-feedback">
            <label for="password" class="col-form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
        </div>
        <div class="checkbox row">
            <label>
                <input type="checkbox" value="remember-me"> Se souvenir de moi
            </label>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Confirm</button>
    </form>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
