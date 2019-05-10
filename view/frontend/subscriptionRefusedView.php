<?php
$title = 'Inscription';
?>

<?php ob_start(); ?>

<div class="container">
    <?php
        if (isset($error_subscription)) :
    ?>
        <div class="alert alert-danger"><?= $error_subscription ?> </div>
    <?php
        $error_subscription = null;
        endif;
    ?>

    <h1>Désolé, votre inscription n'a pas pu être enregistrée, veuillez réessayer!</h1>
    <a href="index.php?action=subscription" class="btn btn-dark m-2 my-sm-0">Revenir en arrière</a>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
