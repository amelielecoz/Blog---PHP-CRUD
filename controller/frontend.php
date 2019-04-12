<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

function listPosts()
{
    $postManager = new PostManager(); // Create object
    $posts = $postManager->getPosts(); // Call object function

    require('view/frontend/homeView.php');
}

function post()
{
    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new CommentManager(); // Create object
    $affectedLines = $commentManager->postComment($postId, $author, $comment); // Call object function

    if ($affectedLines === false) {
        die('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}
function connexion()
{
    $erreur = null;
    require('view/frontend/connexionView.php');
}

function connexionAnswer()
{
    $erreur = null;
    if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
        if ($_POST['pseudo'] === 'John' && $_POST['password'] === 'Doe') {
            connectUser();
        } else {
            $erreur = "Identifiants incorrects";
            echo 'bug';
        }
    } else {
        echo 'bugggg';
    }
}

function connectUser()
{
    $_SESSION['connected'] = 1;
    require('view/frontend/dashboardView.php');
}

function isConnected(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['connected']);
    require('view/frontend/dashboardView.php');
}

function forceUserConnected(): void
{
    if (!isConnected()) {
        header('Location: index.php'); //If user is not connected, it will be redirected to login page
        exit();
    } else {
        require('view/frontend/connexionView.php');
    }
}

function subscription()
{
    require('view/frontend/subscriptionView.php');
}

function acceptSubscription($userEmail, $userPassword, $userFirstName, $userLastName)
{
    $userManager = new UserManager(); // Create object
    $emailCheck = $userManager->getUserId($userEmail);
    if (!$emailCheck) {
        $newUser = $userManager->addNewUser($userEmail, $userPassword, $userFirstName, $userLastName);
        $userId = $userManager->getUserId($userEmail);
        $_SESSION['user'] = [
            'userFirstName' => $userFirstName,
            'userLastName' => $userLastName,
            'userEmail' => $userEmail,
            'userPassword' => $userPassword,
            'userId' => $userId['id']
        ];
        $_SESSION['connected'] = 1;
        require('view/frontend/subscriptionAcceptedView.php');
    } else {
        refuseSubscription();
    }
}

function refuseSubscription()
{
    require('view/frontend/subscriptionRefusedView.php');
}
