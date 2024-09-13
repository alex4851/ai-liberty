<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';
$mail = new PHPMailer(true);

                    try {
                        // Configurer le serveur SMTP
                        $mail->isSMTP();
                        $mail->Host = 'smtp.hostinger.com';  // Remplacez par votre serveur SMTP
                        $mail->SMTPAuth = true;
                        $mail->Username = $my_email;  // Votre email SMTP
                        $mail->Password = $my_pass;  // Votre mot de passe SMTP
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                    
                        // Destinataire
                        $mail->setFrom($my_email, 'AI LIBERTY');
                        $mail->addAddress($email);
                    
                        // Contenu de l'email
                        $mail->isHTML(true);
                        $mail->Subject = 'Confirmation de votre adresse e-mail';
                        $mail->Body    = '
<html>
    <head>
        <style>
        *{
            text-align : center;
            color: black;
        }
            body {
                font-family: Arial, sans-serif;
                background-color: white;
                color: #141317;
                margin: 0;
                padding: 0;
                text-align: center;
                di
            }
            .container {
                border: 1px solid black;
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                max-width: 600px;
                margin: 0 auto;
            }
            .header {
                text-align: center;
                font-size: 24px;
                color: black;
                margin-bottom: 20px;
            }
            .content {
                font-size: 16px;
                color: black;
                margin-bottom: 30px;
                text-align: center;
            }
            .button-container {
                margin: 20px 0;
            }
            .button {
                background-color: #6b3bf4;
                color: #fff;
                text-decoration: none;
                padding: 15px 25px;
                border-radius: 50px;
                font-size: 18px;
                transition: background-color 0.3s ease;
            }
            .button:hover {
                background-color: #5a2bd9;
            }
            .footer {
                font-size: 12px;
                color: #dcdde1;
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                Bienvenue dans AI LIBERTY  '.$prenom.' !
            </div>
            <div class="content">
                Merci de rejoindre notre plateforme. Cliquez sur le bouton ci-dessous pour vérifier votre compte :
            </div>
            <div class="button-container">
                <a href="ai-liberty.fr/verify.php?code=' . $cle . '" class="button">Vérifier mon compte</a>
            </div>
            <div class="footer">
                Si vous n\'avez pas demandé cette vérification, vous pouvez ignorer cet email.
            </div>
            <img src="img/logo.png" src="ai-liberty logo">
        </div>
    </body>
    </html>';
                        $mail->send();
                        $message_alert = "show";
                    } catch (Exception $e) {
                        echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
                    }

                    $requete = $bdd->prepare("SELECT * FROM users WHERE email = :email and mdp = :mdp");
                    $requete->bindParam(':email', $email);
                    $requete->bindParam(':mdp', $pass_hashed);
                    $requete->execute();
                    $data = $requete->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['nom'] = $data['nom'];
                    $_SESSION['niveau'] = $data['niveau'];
                    $_SESSION['mdp'] = $data['mdp'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['date_inscription'] = $data['date_inscription'];
                    $_SESSION['ia_admin'] = $data['ia_admin'];
                    $_SESSION['insta'] = $data['insta'];
                    $_SESSION['confirme'] = $data['confirme'];
?>