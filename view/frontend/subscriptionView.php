<?php $title = 'S\'inscrire'; ?>

<?php ob_start(); ?>

<div class="container">

<form action="#" method="POST">
  <div class="form-group row">
    <label for="staticEmail" class="col-form-label">Adresse e-mail</label>
    <input type="text" readonly class="form-control" id="staticEmail" placeholder="email">
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-form-label">Mot de passe</label>
    <input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe">
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-form-label">Confirmez votre mot de passe</label>
    <input type="password" class="form-control" id="inputPassword" placeholder="Confirmation">
  </div>
    <button type="submit" class="btn btn-primary mb-2">Confirm</button>
</form>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>