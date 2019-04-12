<?php
session_start();
require('controller/frontend.php');
// isConnected();
// forceUserConnected();


try {
    if (isset($_GET['action'])) {
        //Home Page with posts listed
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        }
        //Page with 1 post + comments
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            } else {
                throw new Exception('aucun identifiant de billet envoyé');
            }
        }
        //Connexion page
        elseif ($_GET['action'] == 'connexion') {
            connexion();
        }

        //connexion form answer
        elseif ($_GET['action'] == 'connected') {
            connexionAnswer();
        }

        //Subscription page
        elseif ($_GET['action'] == 'subscription') {
            subscription();
        }
        //Validate subscription
        elseif ($_GET['action'] == 'subscribe') {
            if (!empty($_POST['email']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
                if ($_POST['password1'] === $_POST['password2']) {
                    acceptSubscription($_POST['email'], $_POST['password1'], $_POST['firstname'], $_POST['lastname']);
                } else {
                    refuseSubscription();
                }
            } else {
                refuseSubscription();
            }
        }
        //Allow user to add comments=
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    throw new Exception('tous les champs ne sont pas remplis !');
                }
            } else {
                throw new Exception('aucun identifiant de billet envoyé');
            }
        }
    } else {
        listPosts();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
