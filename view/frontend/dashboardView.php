<?php
$title = 'Tableau de bord';

?>

<?php ob_start(); ?>

<div class="container">
    <h1>Page administrateur</h1>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
