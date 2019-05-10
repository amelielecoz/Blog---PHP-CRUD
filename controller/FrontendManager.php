<?php

// // Import PHPMailer classes into the global namespace
// // These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// // Load Composer's autoloader
// require '../../vendor/autoload.php';

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

class FrontendManager
{

    public function listPosts()
    {
        $postManager = new PostManager(); // Create object

        $postCount = $postManager->countPosts();
        $totalPost = $postCount["COUNT(*)"]; //
        if (($totalPost % 5) == 0) {
            $maxPage = $totalPost / 5;
        } else {
            $maxPage = ($totalPost / 5) + 1 - ($totalPost % 5) / 5;
        }
        if (isset($_GET['page'])) {
            if ($_GET['page'] <= 0 || $_GET['page'] > $maxPage) {
                $_GET['page'] = 1;
                $offset = 0;
            } else {
                $offset = ($_GET['page'] - 1) * 5;
            }
        } else {
            $offset = 0; //If offset = 0, we show 5 posts starting from the 1st
        }
        $posts = $postManager->getPosts($offset); // Call object public function

        require('view/frontend/homeViewWithPics.php');
    }


    public function showOnePost()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();

            $post = $postManager->getPost($_GET['id']);
            $comments = $commentManager->getComments($_GET['id']);

            require('view/frontend/postViewWithPics.php');
        } else {
            throw new Exception('aucun identifiant de billet envoyé');
        }
    }

    // CONNEXION VIEW
    public function connexionForm()
    {
        require('view/frontend/connexionView.php');
    }

    // SUBSCRIPTION VIEW

    public function subscriptionForm()
    {
        require('view/frontend/subscriptionView.php');
    }

    public function subscriptionFormAnswer()
    {
        if (!empty($_POST['email']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
            if ($_POST['password1'] === $_POST['password2']) {
                $frontendManager = new FrontendManager();
                $frontendManager->acceptSubscription($_POST['email'], password_hash($_POST['password1'], PASSWORD_DEFAULT), $_POST['firstname'], $_POST['lastname']);
            } else {
                $frontendManager = new FrontendManager();
                $frontendManager->refuseSubscription();
                $error_subscription = "Veuillez vérifier que les mots de passe coresspondent";
                return $error_subscription;
            }
        } else {
            $error_subscription = "L'adresse email est déjà utilisée";
            $frontendManager = new FrontendManager();
            $frontendManager->refuseSubscription();
            return $error_subscription;
        }
    }

    public function acceptSubscription($userEmail, $userPassword, $userFirstName, $userLastName)
    {
        $userManager = new UserManager(); // Create object
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
            $backendManager = new BackendManager();
            $backendManager->dashboardListPosts();
        } else {
            $frontendManager = new FrontendManager();
            $frontendManager->refuseSubscription();
        }
    }

    public function refuseSubscription()
    {
        require('view/frontend/subscriptionRefusedView.php');
    }

    public function contactForm()
    {
        require('view/frontend/contactFormView.php');
    }

    public function contactFormAnswer()
    {

        //mail()
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


        // // Instantiation and passing `true` enables exceptions
        // $mail = new PHPMailer(true);
        // $mail->CharSet = "UTF-8";

        // try {
        //     //Server settings
        //     //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
        //     $mail->isSMTP();                                            // Set mailer to use SMTP
        //     $mail->Host       = 'smtp.ionos.fr';  // Specify main and backup SMTP servers
        //     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        //     $mail->Username   = 'blog@amelielecoz.com';                     // SMTP username
        //     $mail->Password   = 'Niveac90!';                               // SMTP password
        //     $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        //     $mail->Port       = 587;                                    // TCP port to connect to
        //     $mail->SMTPOptions = array(
        //         'ssl' => array(
        //             'verify_peer' => false,
        //             'verify_peer_name' => false,
        //             'allow_self_signed' => true
        //         )
        //     );                                // TCP port to connect to

        //     //Recipients
        //     $mail->setFrom('blog@amelielecoz.com');
        //     $mail->addAddress('lecozamelie@hotmail.com');     // Add a recipient

        //     // Content
        //     $mail->isHTML(true);                                  // Set email format to HTML
        //     $mail->Subject = 'Blog de Jean : Vous avez un nouveau message';
        //     $mail->Body = htmlspecialchars($_POST['firstname']) . ' ' . htmlspecialchars($_POST['lastname']) . ' vous a envoyé le message suivant : </br>' . nl2br(htmlspecialchars($_POST['message'])) . '</br> Vous pouvez lui répondre à l\'adresse email : ' . htmlspecialchars($_POST['email']);

        //     $mail->send();
        //     $confirmation = "Votre message a bien été envoyé aux administrateurs";
        //     $_POST = null;
        // } catch (Exception $e) {
        //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // }

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
