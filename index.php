<?php
// // Import PHPMailer classes into the global namespace
// // These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// // Load Composer's autoloader
// require '../../vendor/autoload.php';

// // Instantiation and passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->SMTPDebug = 2;                                       // Enable verbose debug output
//     $mail->isSMTP();                                            // Set mailer to use SMTP
//     $mail->Host       = 'smtp.office365.com';  // Specify main and backup SMTP servers
//     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//     $mail->Username   = 'blog@amelielecoz.com';                     // SMTP username
//     $mail->Password   = '?s8MkxL%75';                               // SMTP password
//     $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
//     $mail->Port       = 26;                                    // TCP port to connect to

//     //Recipients
//     $mail->setFrom('from@example.com', 'Mailer');
//     $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
//     $mail->addAddress('ellen@example.com');               // Name is optional
//     $mail->addReplyTo('info@example.com', 'Information');
//     $mail->addCC('cc@example.com');
//     $mail->addBCC('bcc@example.com');

//     // Attachments
//     // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//     // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

//     // Content
//     $mail->isHTML(true);                                  // Set email format to HTML
//     $mail->Subject = 'Here is the subject';
//     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }

session_start();
$error_subscription = null;
require('controller/frontend.php');
require('controller/backend.php');
// isConnected();
// forceUserConnected();


try {
    if (isset($_SESSION['connected'])) {
        if (isset($_GET['action'])) {
            //Dashboard by default
            if ($_GET['action'] == 'dashboard') {
                dashboard();
            }

            //Dashboard write new article
            elseif ($_GET['action'] == 'dashboardAddPost') {
                dashboardAddPost();
            }

            //Dashboard write new article
            elseif ($_GET['action'] == 'addPost') {
                addPost();
            }

            //Dashboard with the list of posts
            elseif ($_GET['action'] == 'dashboardListPosts') {
                dashboardListPosts();
            }

            //Dashboard modify/delete view
            elseif ($_GET['action'] == 'dashboardPost') {
                dashboardOnePost();
            }

            //Logout page
            elseif ($_GET['action'] == 'logout') {
                logout();
            }

            //Allow user to add comments=
            elseif ($_GET['action'] == 'addComment') {
                comment();
            }
        } else {
            dashboardListPosts();
        }
    } else {

        if (isset($_GET['action'])) {
            //Home Page with posts listed
            if ($_GET['action'] == 'listPosts') {
                listPosts();
            }

            //Page with 1 post + comments
            elseif ($_GET['action'] == 'post') {
                showOnePost();
            }



            //Connexion page
            elseif ($_GET['action'] == 'connexion') {
                showConnexionForm();
            }

            //connexion form answer
            elseif ($_GET['action'] == 'connexionAnswer') {
                connexionFormAnswer();
            }



            //Subscription page
            elseif ($_GET['action'] == 'subscription') {
                showSubscriptionForm();
            }

            //Subscription form answer
            elseif ($_GET['action'] == 'subscribe') {
                subscriptionFormAnswer();
            }
        } else {
            listPosts();
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
