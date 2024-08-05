<?php
session_start();
if(isset($_SESSION['email']) and isset($_SESSION['mdp']))
{
  include("bdd.php");
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="website icon" type="png" href="img/logo_head.png">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA TOOLS</title>
</head>

<body id="quest" <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?> >

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
            <?php 
            if(isset($_SESSION['ia_admin'])){
                if($_SESSION["ia_admin"] === "true"){
                echo '<div class="ligne"><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
                }
            }
            ?>
            <div class="ligne"  id="active"><a href="questionnaire.php"><img src="img/quiz.png"><li>Questionnaire</li></a></div>
            <?php
                if(isset($_SESSION['nom']))
                { ?>   
                       
                        <div class="ligne"><a href="user.php"><img src="img/account.png"><li>Mon compte</li></a></div>   
                        <div class="ligne"><a href="logout.php"><img src="img/logout.png"><li>Se déconnecter</li></a></div>
                    
                <?php  }
                else{
                    echo '<div class="ligne"><a href="connexion.php"><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo '<div class="ligne" id="ligne_inscription"><a href="inscription.php"><img src="img/login.png"><li id="inscription">S"inscrire</li></a></div>';
                }
            ?>      
        </ul>
        <script src="navigation.js"></script>       
    </nav>
</header>



<div class="container"></div>

<div class="content" id="questionnaire_content">
    <form class="questionnaire" method="post" action="result.php" >
        

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
                <a href="https://ai-liberty.fr" >Accueil</a>
                <button class="next" id="next_a">Suivant</button>
            </div>
            <div class="chargement"><div class="chargement1"></div></div>
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
                <button class="precedant" id="precedant_b">Précédent</button>
                <button class="next" id="next_b">Suivant</button>
            </div>
            <div class="chargement"><div class="chargement2"></div></div>
        </div>
        </div>       
        

        <div class="card_container" id="container_c">

        <div class="card_quest" id="card_c">   
                <h4>Quelle somme d'argent seriez vous prêts à débourser pour accéder à ce service ?</h4>        
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
                                <span class="text">0 à 5 €</span>
                            </div>
                        </label>
                    </div>
                    <div class="wrapper">
                        <input value="10" id="10" name="prix_demande" type="radio" class="state" />
                        <label for="10" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">5 à 20 €</span>
                            </div>
                        </label>
                    </div>
                    <div class="wrapper">
                        <input value="20" id="20" name="prix_demande" type="radio" class="state" />
                        <label for="20" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">20 à 30 €</span>
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
                            <button class="precedant" id="precedant_c">Précédent</button>
                            <button class="next" id="next_c">Suivant</button>
                        </div>
                <div class="chargement"><div class="chargement3"></div></div>
        </div>
        </div>

        <?php 
        if(isset($_SESSION['nom'])){?>
        <div class="card_container" id="container_d">

        <div class="card_quest" id="card_d">
            <h4>Vous avez remplis les principaux critères pour trouver votre IA :</h4>
            <div class="card_4_child">
                <input type="submit" id="result" value="Rechercher" name="valider" class="valider" >
            </div>
            <div class="chargement"><div class="chargement4"></div></div>
        </div>
        </div>
        <?php 
        }
        else{
        ?>
        <div class="card_container" id="container_d">
        
        <div class="card_quest" id="card_d">
            <h4>Vous avez remplis les principaux critères pour trouver votre IA :</h4>
            <div class="infos">
                <p>Mais avant nous avons besoin de quelques informations :</p>
                <div class="reste">
                    
                <label for="prenom">Votre prenom : *</label>
                <input type="text" placeholder="Entrez votre prenom ..." id="prenom" name="prenom" required> <br/>
                
                <label for="email">Votre email : *</label>
                <input type="email" placeholder="Entrez votre email ..." id="email" name="email" required> <br />

                <label for="pass">Votre mot de passe : *</label>
                <input type="password" placeholder="Entrez votre mot de passe ..." id="pass" name="pass" required> <br />
                
                <label for="pass2">Confirmer mot de passe : *</label>
                <input type="password" placeholder="Confirmer votre mot de passe ..." id="pass2" name="pass2" required> <br />
            </div>    
        </div>
            <div class="card_4_child">
                <input type="submit" value="Chercher l'IA" name="valider" id="result" class="valider">
            </div>
           
            <div class="chargement"><div class="chargement4"></div></div>
        </div>
        </div>
        <?php } ?>
    </form>
</div>


</body>
</html>
<script src="script.js"></script>
<script src="algo.js"></script>
