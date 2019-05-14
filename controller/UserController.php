<?php

require_once('controller/PostController.php');
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

class UserController {
    public function connexionForm()
    {
        require('view/frontend/connexionView.php');
    }

    public function connexionFormAnswer()
    {
        $erreur = null;
        $userManager = new UserManager();
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $userId = $userManager->getUserInfo('id', 'email', $_POST['email']);
            if ($userId) {
                $userPassword = $userManager->getUserInfo('password', 'id', $userId['id']);
                $userFirstName = $userManager->getUserInfo('firstname', 'id', $userId['id']);
                $userLastName = $userManager->getUserInfo('lastname', 'id', $userId['id']);
                $userEmail = $userManager->getUserInfo('email', 'id', $userId['id']);
                $userAdminStatus = $userManager->getUserInfo('admin', 'id', $userId['id']);
                if (password_verify($_POST['password'], $userPassword['password'])) {
                    $_SESSION['user'] = [
                        'userId' => $userId['id'],
                        'userFirstName' => $userFirstName['firstname'],
                        'userLastName' => $userLastName['lastname'],
                        'userEmail' => $userEmail['email'],
                        'admin' => $userAdminStatus['admin']
                    ];
                    $_SESSION['connected'] = 1;
                    $postController = new PostController();
                    $postController->dashboardListPosts();
                } else {
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

    public function subscriptionForm()
    {
        require('view/frontend/subscriptionView.php');
    }

    public function subscriptionFormAnswer()
    {
        if (!empty($_POST['email']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
            if ($_POST['password1'] === $_POST['password2']) {
                $this->acceptSubscription($_POST['email'], password_hash($_POST['password1'], PASSWORD_DEFAULT), $_POST['firstname'], $_POST['lastname']);
            } else {
                $this->refuseSubscription();
                $error_subscription = "Veuillez vérifier que les mots de passe coresspondent";
                return $error_subscription;
            }
        } else {
            $error_subscription = "L'adresse email est déjà utilisée";
            $this->refuseSubscription();
            return $error_subscription;
        }
    }

    public function acceptSubscription($userEmail, $userPassword, $userFirstName, $userLastName)
    {
        $userManager = new UserManager();
        $emailCheck = $userManager->getUserInfo('id', 'email', $userEmail);;
        if (!$emailCheck) {
            $newUser = $userManager->addNewUser($userEmail, $userPassword, $userFirstName, $userLastName);
            $userId = $userManager->getUserInfo('id', 'email', $userEmail);
            $userPassword = $userManager->getUserInfo('password', 'id', $userId['id']);
            $userFirstName = $userManager->getUserInfo('firstname', 'id', $userId['id']);
            $userLastName = $userManager->getUserInfo('lastname', 'id', $userId['id']);
            $userEmail = $userManager->getUserInfo('email', 'id', $userId['id']);
            $userAdminStatus = $userManager->getUserInfo('admin', 'id', $userId['id']);
            $_SESSION['user'] = [
                'userId' => $userId['id'],
                'userFirstName' => $userFirstName['firstname'],
                'userLastName' => $userLastName['lastname'],
                'userEmail' => $userEmail['email'],
                'admin' => $userAdminStatus['admin']
            ];
            $_SESSION['connected'] = 1;
            $postManager = new PostController();
            $postManager->dashboardListPosts();
        } else {
            $this->refuseSubscription();
        }
    }

    public function refuseSubscription()
    {
        require('view/frontend/subscriptionRefusedView.php');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION);
        header('Location: index.php');
    }
}
