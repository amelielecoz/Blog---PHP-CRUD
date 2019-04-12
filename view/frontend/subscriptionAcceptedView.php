<?php


$title = 'Mettre à jour mon profil'; ?>

<?php ob_start(); ?>

<div class="container">

    <h1>Inscription enregistrée ! Bienvenue <?= $_SESSION['user']['userFirstName'] ?> ! </h1>

    <pre>
<?php
var_dump($_SESSION);
?>
</pre>



</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
