<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

class FrontController
{
    public function contactForm()
    {
        require('view/frontend/contactFormView.php');
    }

    public function contactFormAnswer()
    {
        $to      = 'lecozamelie@hotmail.com';

        $subject = 'Blog de Jean : Vous avez un nouveau message';

        $message = htmlspecialchars($_POST["firstname"]) . " " . htmlspecialchars($_POST["lastname"]) . " vous a envoyé le message suivant : \r\n"
            . htmlspecialchars($_POST["message"]) . "\r\n \r\n"
            . "Vous pouvez lui répondre à l'adresse email : \r\n "
            . htmlspecialchars($_POST["email"]);

        $message = wordwrap($message, 70, "\r\n");

        $headers = 'From: blog@amelielecoz.com' . "\r\n" .
            'Reply-To: blog@amelielecoz.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        try {
            mail($to, $subject, $message, $headers);
            $confirmation = "Votre message a bien été envoyé aux administrateurs";
            $_POST = null;
        } catch (Exception $e) {
            echo "Message could not be sent";
        }
        require('view/frontend/contactFormView.php');
    }

    public function about()
    {
        require('view/frontend/aboutView.php');
    }


    public function privacy()
    {
        require('view/frontend/privacyView.php');
    }

    public function credits()
    {
        require('view/frontend/creditsView.php');
    }
}
