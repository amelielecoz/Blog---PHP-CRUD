<?php

$title = 'Inscription';

?>

<?php ob_start(); ?>

<div class="container">

    <form action="index.php?action=subscribe" method="POST">
        <div class="form-group row">
            <label for="firstname" class="col-form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Votre prénom" required>
        </div>
        <div class="form-group row">
            <label for="lastname" class="col-form-label">Nom de famille</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Votre nom" required>
        </div>
        <div class="form-group row">
            <label for="email" class="col-form-label">Adresse e-mail</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="email" aria-describedby="emailHelpBlock" required>
            <small id="emailHelpBlock" class="form-text text-muted"> Veuillez entrer une adresse e-mail valide </small>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password1" name="password1" placeholder="Mot de passe" aria-describedby="passwordHelpBlock" required>
            <small id="passwordHelpBlock" class="form-text text-muted"> Votre mot de passe doit comporter entre 8 et 30 caractères et contenirau moins une minuscule, une majuscule, un symbole et un chiffre </small>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-form-label">Confirmez votre mot de passe</label>
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Valider</button>
    </form>


</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
