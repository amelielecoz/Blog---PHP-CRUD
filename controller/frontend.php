<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');


//POSTS VIEW

function listPosts()
{
    $postManager = new PostManager(); // Create object
    if (isset($_GET['page'])) {
        $offset = ($_GET['page'] - 1) * 5;
    } else {
        $offset = 0;
    }
    $posts = $postManager->getPosts($offset); // Call object function
    $postCount = $postManager->countPosts();
    require('view/frontend/homeView.php');
}

function showOnePost()
{
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $postManager = new PostManager();
        $commentManager = new CommentManager();

        $post = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        require('view/frontend/postView.php');
    } else {
        throw new Exception('aucun identifiant de billet envoyé');
    }
}

//ADDING COMMENTS
function comment()
{
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

function addComment($postId, $author, $comment)
{
    $commentManager = new CommentManager(); // Create object
    $affectedLines = $commentManager->postComment($postId, $author, $comment); // Call object function

    if ($affectedLines === false) {
        die('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?action=dashboardPost&id=' . $postId);
    }
}

// CONNEXION VIEW
function showConnexionForm()
{
    $erreur_connexion = null;
    require('view/frontend/connexionView.php');
}

function connexionFormAnswer()
{
    $erreur = null;
    //$userPassword = null;
    $userManager = new UserManager(); // Create object
    if (!empty($_POST['email']) && !empty($_POST['password'])) {  // If the fields are filled
        $userId = $userManager->getUserInfo('id', 'email', $_POST['email']); // Check if email is saved in the DB, get the corresponding ID
        if ($userId) {  // If there is an email saved, $userId is an array, we get the corresponding password
            $userPassword = $userManager->getUserInfo('password', 'id', $userId['id']);
            $userFirstName = $userManager->getUserInfo('firstname', 'id', $userId['id']);
            $userEmail = $userManager->getUserInfo('email', 'id', $userId['id']);
            $userAdminStatus = $userManager->getUserInfo('admin', 'id', $userId['id']);
            if (password_verify($_POST['password'], $userPassword['password'])) {
                $_SESSION['user'] = [
                    'userId' => $userId['id'],
                    'userFirstName' => $userFirstName['firstname'],
                    'userEmail' => $userEmail['email'],
                    'admin' => $userAdminStatus['admin']
                ];
                $_SESSION['connected'] = 1;
                dashboardListPosts();
            } else { //If there is no email saved $userId is a bool(false)
                $erreur = "Identifiants incorrects";
                echo 'Identifiants incorrects';
            }
        } else {
            $erreur = "Email non enregistré";
            echo 'Email non enregistré ///';
            echo !$userId;
        }
    } else {
        echo 'Un des champs n\'est pas rempli';
    }
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

function logout()
{
    session_start();
    session_destroy();
    unset($_SESSION);
    header('Location: index.php');
}

// SUBSCRIPTION VIEW

function showSubscriptionForm()
{
    require('view/frontend/subscriptionView.php');
}

function subscriptionFormAnswer()
{
    if (!empty($_POST['email']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
        if ($_POST['password1'] === $_POST['password2']) {
            acceptSubscription($_POST['email'], password_hash($_POST['password1'], PASSWORD_DEFAULT), $_POST['firstname'], $_POST['lastname']);
        } else {
            refuseSubscription();
        }
    } else {
        $error_subscription = "L'adresse email est déjà utilisée";
        refuseSubscription();
    }
}

function acceptSubscription($userEmail, $userPassword, $userFirstName, $userLastName)
{
    $userManager = new UserManager(); // Create object
    $emailCheck = $userManager->getUserInfo('id', 'email', $userEmail);;
    if (!$emailCheck) {
        $newUser = $userManager->addNewUser($userEmail, $userPassword, $userFirstName, $userLastName);
        $userId = $userManager->getUserInfo('id', 'email', $userEmail);;
        $_SESSION['user'] = [
            'userFirstName' => $userFirstName,
            'userLastName' => $userLastName,
            'userEmail' => $userEmail,
            'userPassword' => $userPassword,
            'userId' => $userId['id']
        ];
        $_SESSION['connected'] = 1;
        dashboardListPosts();
    } else {
        refuseSubscription();
    }
}

function refuseSubscription()
{
    require('view/frontend/subscriptionRefusedView.php');
}

function dashboard()
{
    if (isset($_SESSION['connected'])) {
        require('view/frontend/dashboardView.php');
    }
}

function dashboardPostByAuthor()
{
    $postManager = new PostManager(); // Create object
    $posts = $postManager->getPostsByAuthor($_SESSION['user']['userId']); // Call object function
    require('view/frontend/dashboardPostView.php');
}

function dashboardListPosts()
{
    $postManager = new PostManager(); // Create object
    if (isset($_GET['page'])) {
        $offset = ($_GET['page'] - 1) * 5;
    } else {
        $offset = 0;
    }
    $posts = $postManager->getPosts($offset); // Call object function
    $postCount = $postManager->countPosts();
    require('view/frontend/dashboardListPostsView.php');
}

function dashboardAddPost()
{
    $postManager = new PostManager(); // Create object
    //$postAdded = $postManager->addPost($title, $content, $id_user);
    require('view/frontend/dashboardAddNewPost.php');
}

function addPost()
{
    $postManager = new PostManager(); // Create object
    $postAdded = $postManager->addPost($_POST['title'], $_POST['content'], $_SESSION['user']['userId']);
    $_POST = null;
    dashboardListPosts();
}
