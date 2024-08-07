<?php
session_start();
if(isset($_SESSION['email']) and isset($_SESSION['mdp']) and $_SESSION['ia_admin']=='true')
{
  include("bdd.php");
}
else{
    header('Location:connexion.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="website icon" type="png" href="img/logo_head.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA TOOLS</title>
</head>
<body <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?> >

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
            <?php 
            if(isset($_SESSION['ia_admin'])){
                if($_SESSION["ia_admin"] === "true"){
                echo '<div class="ligne" id="active"><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
                }
            }
            ?>
            <div class="ligne"><a href="questionnaire.php"><img src="img/quiz.png"><li>Questionnaire</li></a></div>
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
    </nav>
</header>

<section class="new_ia">
<a href="ia.php"><button class="button_back">Retour</button></a>

<form  method="post" action="add_ia.php" id="new_ia">

            <h2>Ajouter une nouvelle IA à la base de donnée</h2>
            
            <label for="nom">Nom de l'IA :</label>
            <input type="text" placeholder="Entrez nom IA ..." id="nom" name="nom" required> <br/>

            <label for="ia_url">URL de l'IA :</label>
            <input type="text" placeholder="Entrez url de l'IA ..." id="ia_url" name="ia_url" required> <br/>
            
            <label for="prix_demande">Prix de l'IA :</label>
            <input type="number" class="range"  name="prix_demande" placeholder="0" step="1" min="0" max="100" required><br/>
            
            <label for="iatype_demande">Type : </label>
            <select name="iatype_demande" id="iatype_demande">
                <option value="productivite">Productivité</option>
                <option value="website">Site web</option>
                <option value="content_creation">Creation de contenu</option>
                <option value="taches_repetitives">Tâches répetitives</option>
                <option value="vente">Vente</option>

            </select> <br />

            <label for="spe_demande">Specialite :</label>
            <select name="spe_demande" id="spe_demande">


                    <option class="content_creation" value="video">Creation de videos</option>
                    <option class="content_creation" value="auto_post">Posts automatisés</option>
                    <option class="content_creation" value="avatar">Avatar vidéo, audio</option>
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
                    <option class="taches_repetitives" value="creation_texte">Création de texte ou de script</option>

                    <option class="website" value="seo">SEO</option> 


                    <option class="vente" value="strategie">Stratégie</option> 
                    <option class="vente" value="marketing_linkedin">Marketing Linkedin</option> 
                    <option class="vente" value="marketing_insta">Marketing Instagram</option> 

        

            </select> <br />


            <script src="algo.js"></script>

            <label for="niveau">Niveau : </label>
                    <select name="niveau" id="niveau" required>
                        <option value="lyceen" >Lyceen</option>
                        <option value="entrepreneur">Entrepreneur</option>
                        <option value="professionnel">Professionnel</option>
                        <option value="undefined">Aucun</option>
                    </select><br/>

            
            <label for="affiliation">Affiliation : </label>
            <select name="affiliation" id="affiliation">
                <option value="oui">Oui</option>
                <option value="non">Non</option>
            </select><br />
            
            <label for="coup_de_coeur">Coup de coeur : </label>
            <select name="coup_de_coeur" id="coup_de_coeur">
                <option value="oui">Oui</option>
                <option value="non">Non</option>
            </select> <br/>

            <label for="ia_description">Description :</label>
            <textarea type="text" placeholder="Entrez une description ..." id="ia_description" name="ia_description" required></textarea> <br />

            <label for="ia_description">Description courte :</label>
            <textarea type="text" placeholder="Entrez la description courte ..." id="ia_description_short" name="ia_description_short" required></textarea> <br />
            
            <label for="ia_description">URL image :</label>
            <textarea type="text" placeholder="Entrez l'url de l'image de l'IA ..." id="ia_img" name="ia_img" required></textarea> <br />
            
            <input type="submit" value="Ajouter IA" name="add_ia" class="add_ia">
</form>
</section>

</body>
</html>


<?php

if(isset($_POST['add_ia'])){
    
    extract($_POST);
    
    $date = date('l jS \of F Y h:i:s A');
    $requete = $bdd->prepare("INSERT INTO ia_infos VALUES (0, :nom, :ia_url, :prix, :iatype, :specialite, :ia_description, :affiliation, :coup_de_coeur, :ajout, :ia_description_short, :ia_img, :niveau)");
    $requete->execute(
        array(
            "nom" => $nom,
            "ia_url" => $ia_url,
            "prix" => intval($prix_demande),
            "iatype" => $iatype_demande,
            "specialite" => $spe_demande,
            "ia_description" => $ia_description,
            "affiliation" => $affiliation,
            "coup_de_coeur" => $coup_de_coeur,
            "ajout" => $date,
            "ia_description_short" => $ia_description_short,
            "ia_img" => $ia_img,
            "niveau" => $niveau,
        )
    );
}
?>