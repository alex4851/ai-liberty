<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';
include("bdd.php");
session_start();

if (isset($_POST['valider']) && isset($_POST["email"])) {
    extract($_POST);

    // Vérification des mots de passe
    if ($pass !== $pass2) {
        echo '<p>Mots de passe différents</p><br/><INPUT TYPE="button" VALUE="RETOUR" onclick=" history.back();">';
        exit;
    }

    // Génération de la clé unique
    $cle = rand(1000000, 999999999999);

    // Vérification si l'email existe déjà
    $email_verif = $bdd->prepare("SELECT * FROM users WHERE email = :email");
    $email_verif->execute(['email' => $email]);
    $email_verif_test = $email_verif->fetch();

    if (!$email_verif_test) {
        // Si l'email n'existe pas encore
        if (!empty($email) && !empty($prenom)) {
            $confirme = 0;
            $pass_hashed = md5(strip_tags($pass));
            $date_inscription = date('Y-m-d H:i:s'); // Si tu veux mettre la date courante

            // Insertion dans la base de données
            $requete = $bdd->prepare("
                INSERT INTO users (nom, niveau, mdp, email, date_inscription, ia_admin, cle, confirme, insta)
                VALUES (:nom, 'undefined', :mdp, :email, :date_inscription, :ia_admin, :cle, :confirme, '')
            ");
            $requete->execute([
                'nom' => strip_tags($prenom),
                'mdp' => $pass_hashed,
                'email' => strip_tags($email),
                'date_inscription' => $date_inscription,
                'ia_admin' => $ia_admin,
                'cle' => $cle,
                'confirme' => $confirme,
            ]);

            include("email_content.php");

            // Redirection après l'insertion
            header("Location: https://ai-liberty.fr/result.php?iatype_demande={$iatype_demande}&spe_demande={$spe_demande}&prix_demande={$prix_demande}&valider=Rechercher");
            exit;
        }
    } else {
        echo 'Email déjà utilisé <br/><INPUT TYPE="button" VALUE="RETOUR" onclick="history.back();">';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez les outils IA de pointe qui vous correspondent. En seulement 5 minutes. Accéder gratuitement.">
    <link rel="website icon" type="png" href="img/logo_head.png">
    <title>AI LIBERTY</title>
</head>

<body id="quest" <?php echo isset($_SESSION['nom']) ? 'class="quest_connecte"' : 'class="body_pas_co"'; ?> >

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne" ><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautés</li></a></div>
            <?php 
            if(isset($_SESSION['ia_admin'])){
                if($_SESSION["ia_admin"] === "true"){
                echo '<div class="ligne"><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
                }
            }
            ?>
            <div class="ligne" id="active"><a href="questionnaire.php"><img src="img/quiz.png"><li>Questionnaire</li></a></div>
            <?php
                if(isset($_SESSION['nom']))
                { ?>   
                       
                        <div class="ligne"><a href="user.php"><img src="img/account.png"><li>Mon compte</li></a></div>   
                        <div class="ligne"><a href="logout.php"><img src="img/logout.png"><li>Se déconnecter</li></a></div>
                    
                <?php  }
                else{
                    echo '<div class="ligne"><a href="connexion.php"><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo "<div class='ligne' id='ligne_inscription'><a href='inscription.php'><img src='img/login.png'><li id='inscription'>S'inscrire</li></a></div>";
                }
            ?>      
        </ul>
    </nav>
</header>


<div class="content" id="questionnaire_content">
    <?php if (isset($_SESSION["nom"])){ ?>
        <form class="questionnaire" method="get" action="result.php">
    <?php } else{ ?>
        <form class="questionnaire" method="post" action="">
    <?php } ?>

    <div class="card_container" id="container_a">
        <div class="card_quest" id="card_a">
            <label for="iatype_demande">Pour quel domaine cherchez vous un assistant basé sur l'intelligence artificielle ?</label><br/>
            <select name="iatype_demande" id="iatype_demande">
                <option value="content_creation">Creation de contenu</option>
                <option value="productivite">Productivité</option>
                <option value="website" required>Site web</option>
                <option value="taches_repetitives">Tâches répetitives</option>
                <option value="vente">Vente</option>
            </select> <br />
            <div class=button_direction>
                <a href="https://ai-liberty.fr" id="less">Accueil</a>
                <button class="next" id="next_a">Suivant</button>
            </div>
        </div>
    </div>
        

    <div class="card_container" id="container_b">
        <div class="card_quest" id="card_b">
            <label for="spe_demande">Pour quel type de tâches cherchez-vous cet outil ?</label><br />
            <select name="spe_demande" id="spe_demande">

                    <option class="content_creation" value="video">Creation de videos</option>
                    <option class="content_creation" value="auto_post">Posts automatisés</option>
                    <option class="content_creation" value="avatar" required>Avatar vidéo, audio</option>
                    <option class="content_creation" value="narration">Narration</option>
                    <option class="content_creation" value="voice_clonage">Clonage de voix</option>
                    <option class="content_creation" value="sous_titre">Sous-titres</option>
                    <option class="content_creation" value="background_remover">Retirer l'arrière plan</option>
                    <option class="content_creation" value="youtube_algo">Optimisation pour algorithme Youtube</option>


                    <option class="productivite" value="recherche_assistant">Assistant de recherche</option>
                    <option class="productivite" value="pro_assistant">Assistant professionnel</option> 
                    <option class="productivite" value="agenda">Gestion de l'agenda</option> 
                    <option class="productivite" value="mindset">Mindset</option> 


                    <option class="taches_repetitives" value="automatisation">Automatisation</option>
                    <option class="taches_repetitives" value="recherche">Recherche</option>
                    <option class="taches_repetitives" value="recherche_pdf">Recherche dans PDF</option>
                    <option class="taches_repetitives" value="note_taking">Prise de notes</option>
                    <option class="taches_repetitives" value="note_taking_teams">Prise de notes pour Microsoft Teams</option>
                    <option class="taches_repetitives" value="excel_assistant">Assistant pour Excel</option> 
                    <option class="taches_repetitives" value="mails">Gestion des mails</option> 
                    <option class="taches_repetitives" value="copilote">Copilote</option>
                    <option class="taches_repetitives" value="trad">Traduction</option>
                    <option class="taches_repetitives" value="mindmap">Présentation carte mentale</option>
                    <option class="taches_repetitives" value="analyse_image">Analyse d'image</option>
                    <option class="taches_repetitives" value="analyse_texte">Analyse de texte</option>
                    <option class="taches_repetitives" value="transformation_texte">Transformation de texte</option>
                   <!-- <option class="taches_repetitives" value="creation_texte">Création de texte ou de script</option> -->

                    <option class="website" value="seo">SEO</option> 

                    <option class="vente" value="strategie">Stratégie</option> 
                    <option class="vente" value="marketing_linkedin">Marketing Linkedin</option> 
                    <option class="vente" value="marketing_insta">Marketing Instagram</option> 

            </select> <br />
            <div class=button_direction>
                <a href="#container_a" id="less">Précédent</a>
                <button class="next" id="next_b">Suivant</button>
            </div>
        </div>
    </div>       
        

    <div class="card_container" id="container_c">
        <div class="card_quest" id="card_c">   
                <h4>Quelle somme d'argent seriez vous prêts à débourser mensuellement pour accéder à ce service ?</h4>        
                <div class="wrapper_container">
                    <div class="wrapper">
                        <input value="0" id="0" name="prix_demande" type="radio" class="state" />
                        <label for="0" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">Rien</span>
                            </div>
                        </label>
                    </div>
                    <div class="wrapper">
                        <input value="5" id="5" name="prix_demande" type="radio" class="state" />
                        <label for="5" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">0 à 5 € par mois</span>
                            </div>
                        </label>
                    </div>
                    <div class="wrapper">
                        <input value="10" id="10" name="prix_demande" type="radio" class="state" />
                        <label for="10" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">5 à 20 € par mois</span>
                            </div>
                        </label>
                    </div>
                    <div class="wrapper">
                        <input value="20" id="20" name="prix_demande" type="radio" class="state" />
                        <label for="20" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">20 à 30 € par mois</span>
                            </div>
                        </label>
                    </div>
                    <div class="wrapper">
                        <input value="1000" id="1000" name="prix_demande" type="radio" class="state"/>
                        <label for="1000" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">Je ne sais pas</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class=button_direction id="c">
                            <a href="#container_b" id="less">Précédent</a>
                            <button class="next" id="next_c">Suivant</button>
                        </div>
        </div>
    </div>

        <?php 
        if(isset($_SESSION['nom'])){?>
            <div class="card_container" id="container_d">
                <div class="card_quest" id="card_d">
                    <h4>Vous avez remplis les principaux critères pour trouver votre IA :</h4>
                    <div class=button_direction id="d">
                            <a href="#container_c" id="less">Précédent</a>
                            <input type="submit" id="result" value="Rechercher" name="valider" class="valider" >
                    </div>
                </div>

            </div>
        <?php 
        }
        else{
        ?>
        <div class="card_container" id="container_d">
        
            <div class="card_quest" id="card_d">
                <h4>Vous avez remplis les principaux critères pour trouver votre IA :</h4>
                <div class="form">
                    <div class="field">
                        <input type="text" class="input-field" placeholder="Entrez votre prenom ..." id="prenom" name="prenom" required> <br/>
                    </div>

                    <div class="field">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"></path>
                        </svg>
                        <input class="input-field" type="email" placeholder="Entrez votre email ..." id="email" name="email" required>
                    </div>
                    <div class="field">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                        </svg>
                        <input class="input-field" type="password" placeholder="Entrez votre mot de passe ..." id="pass" name="pass" required>
                        <button type="button" id="togglePassword" class="password_changer" >Afficher</button><script src="password.js"></script>

                    </div>
                    <div class="field">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                        </svg>
                        <input type="password" class="input-field" placeholder="Confirmez votre mot de passe ..." id="pass2" name="pass2" required>
                    </div>   
                </div>
                <div class=button_direction id="d">
                            <a href="#container_c" id="less">Précédent</a>
                            <input type="submit" value="Chercher l'IA" name="valider" id="result" class="valider">
                    </div>
            </div>
        </div>    
        <?php } ?>

        </form>
    </div>
</body>
</html>

<script src="script.js"></script>

<script src="algo.js"></script>
