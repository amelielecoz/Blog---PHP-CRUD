<?php
$title = 'Inscription';
$error_subscription;
?>

<?php ob_start(); ?>

<div class="container">
    <div class="alert alert-danger"><?= $error_subscription ?></div>
    <h1>Désolé, votre inscription n'a pas pu être enregistrée, veuillez réessayer!</h1>
    <a href="index.php?action=subscription" class="btn btn-info m-2 my-sm-0">Revenir en arrière</a>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
