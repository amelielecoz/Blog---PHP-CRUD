<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$error_subscription = null;
require_once('controller/FrontendManager.php');
require_once('controller/BackendManager.php');


try {
    $frontendManager = new FrontendManager();
    $backendManager = new BackendManager();

    if (!isset($_SESSION['connected'])) { // if user is not connected

        if (isset($_GET['action'])) {

            if ($_GET['action'] == 'contact') {
                $frontendManager->contactForm();
            }
            //Contact form answer
            elseif ($_GET['action'] == 'contactAnswer') {
                $frontendManager->contactFormAnswer();
            }
            //About page
            elseif ($_GET['action'] == 'about') {
                $frontendManager->about();
            }
            //Privacy page
            elseif ($_GET['action'] == 'privacy') {
                $frontendManager->privacy();
            }

            //Connexion page
            elseif ($_GET['action'] == 'connexion') {
                $frontendManager->connexionForm();
            }

            //connexion form answer
            elseif ($_GET['action'] == 'connexionAnswer') {
                $backendManager->connexionFormAnswer();
            }

            //Subscription page
            elseif ($_GET['action'] == 'subscription') {
                $frontendManager->subscriptionForm();
            }

            //Subscription form answer
            elseif ($_GET['action'] == 'subscribe') {
                $frontendManager->subscriptionFormAnswer();
            }

            //Home Page with posts listed
            elseif ($_GET['action'] == 'listPosts') {
                $frontendManager->listPosts();
            }

            //Page with 1 post + comments
            elseif ($_GET['action'] == 'post') {
                $frontendManager->showOnePost();
            } else { // if action does not correspond to any possibility listed
                $frontendManager->listPosts();
            }
        } else { // if no action specified
            $frontendManager->listPosts();
        }
    } elseif (isset($_SESSION['connected'])) { // If user is connected

        if (isset($_GET['action'])) {

            //Logout
            if ($_GET['action'] == 'logout') {
                $backendManager->logout();
            }

            //Dashboard with the list of posts
            if ($_GET['action'] == 'dashboardListPosts' || $_GET['action'] == 'dashboard') {
                $backendManager->dashboardListPosts();
            }

            //One post only
            elseif ($_GET['action'] == 'post') {
                $backendManager->dashboardOnePost();
            }

            //Redirect to form to write new article
            elseif ($_GET['action'] == 'addPostForm') {
                $backendManager->addPostForm();
            }

            //Confirm form and send article content in the db
            elseif ($_GET['action'] == 'addPost') {
                $backendManager->addPostFormAnswer();
            }

            //Confirm form and send article content in the db
            elseif ($_GET['action'] == 'modifyPostForm') {
                $backendManager->modifyPostForm();
            }

            //Confirm form and send article content in the db
            elseif ($_GET['action'] == 'modifyPost') {
                $backendManager->modifyPostFormAnswer();
            }

            //Allow user to add comments=
            elseif ($_GET['action'] == 'addComment') {
                $backendManager->comment();
            }

            //Report comment
            elseif ($_GET['action'] == 'report') {
                $backendManager->reportComment();
            }

            //Delete post
            elseif ($_GET['action'] == 'delete') {
                $backendManager->deletePost();
            }

            //Comments administration view
            elseif ($_GET['action'] == 'commentAdmin') {
                $backendManager->commentAdmin();
            }

            //Authorize comment
            elseif ($_GET['action'] == 'authorizeComment') {
                $backendManager->authorizeComment();
            }

            //Confirm comment deletion
            elseif ($_GET['action'] == 'deleteComment') {
                $backendManager->deleteComment();
            }

            //Contact form
            if ($_GET['action'] == 'contact') {
                $frontendManager->contactForm();
            }

            //Contact form answer
            elseif ($_GET['action'] == 'contactAnswer') {
                $frontendManager->contactFormAnswer();
            }
            //About page
            elseif ($_GET['action'] == 'about') {
                $frontendManager->about();
            }

            //Privacy page
            elseif ($_GET['action'] == 'privacy') {
                $frontendManager->privacy();
            }

            //For all the other entry of action
        } else {
            $backendManager->dashboardListPosts();
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
