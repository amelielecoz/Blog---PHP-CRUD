<?php

$title = 'Formulaire de contact';

?>

<?php ob_start(); ?>

<main>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">

                <?php if (isset($confirmation)) : ?>
                    <div class="alert alert-success" role="alert"><?= $confirmation ?></div>
                <?php endif ?>

                <h2>Formulaire de contact</h2>

                <form action="index.php?action=contactAnswer" method="POST">
                    <div class="form-group row">
                        <label for="firstname" class="col-form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Votre prénom" required>
                    </div>
                    <div class="form-group row">
                        <label for="lastname" class="col-form-label">Nom</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Votre nom" required>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-form-label">Adresse e-mail</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="email" aria-describedby="emailHelpBlock" required>
                        <small id="emailHelpBlock" class="form-text text-muted"> Veuillez entrer une adresse e-mail valide </small>
                    </div>
                    <div class="form-group row">
                        <label for="message" class="col-form-label" required>Votre message</label>
                        <textarea class="form-control" name="message" id="message" rows="3" required></textarea>
                    </div>
                    <div class="checkbox row m-2 my-4">
                        <label>
                            <input type="checkbox" value="remember-me" required> En soumettant ce formulaire, j'accepte que les informations saisies soient utilisées pour me recontacter. <br />
                            Pour connaître et exercer vos droits, notamment de retrait de votre consentement à l'utilisation des données collectées par ce formulaire, veuillez consulter notre <a href="#">politique de confidentialité</a>. </label>
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">Valider</button>
                </form>

            </div>
        </div>

</main>


</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
