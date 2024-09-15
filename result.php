<?php

include("bdd.php");
session_start();


             ##Pour favorite :
             @$user_id = $_SESSION['id'];
             @$ia_id = $_POST['ia_id'];
if(isset($_POST['add_fav'])){
    //Verif que existe pas deja
    $sql = "SELECT * FROM favorites WHERE ia_id = :ia_id and user_id = :user_id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(":ia_id", $ia_id , PDO::PARAM_INT);
    $stmt->bindValue(":user_id", $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $fav_existe = $stmt->fetch(PDO::FETCH_ASSOC);
    if($fav_existe == ''){
        // Insérer la recherche dans la base de données
        $sql = "INSERT INTO favorites (user_id, ia_id) VALUES (:user_id, :ia_id)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location:index.php");
    }

}

if(isset($_POST["remove_fav"])){
    //Supprimer des favoris
    $sql2 = 'DELETE FROM favorites WHERE user_id = :user_id and ia_id = :ia_id';
    $stmt = $bdd->prepare($sql2);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location:index.php");
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
                echo '<div class="ligne" ><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
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
                    ?><div class="ligne" id="ligne_inscription"><a href="inscription.php"><img src="img/login.png"><li id="inscription">S'inscrire</li></a></div><?php
                }
            ?>      
        </ul>
    </nav>
</header>

<main class="content">


<input class="button_back" type="button" value="RETOUR" onclick="history.back();">

<div class="resultat_reste">

<?php if(@$message_alert == "show"){echo 'Email de vérification envoyé à '.$email. ". Merci de revenir une fois l'opération effectuée";} ?>


<?php
if(isset($_GET['valider']) OR isset($_GET['submit_ia']) OR isset($_GET['submit_ia_short'])){
    @$phrase_supp = false;
    @$affiliation_p = false;
    if(!isset($_GET['submit_ia_short'])){
    ##Pour l'IA
        if(isset($_GET["prix_demande"])){
        $prix_demande = intval($_GET["prix_demande"]);
        }
        else{
            $prix_demande = 1000;
        }
        @$iatype_demande = $_GET["iatype_demande"];
        @$spe_demande = $_GET["spe_demande"];
        
        if(isset($prix_demande) and isset($iatype_demande) and isset($spe_demande)){
            $ans = $bdd->query("SELECT * FROM ia_infos WHERE prix <= '$prix_demande' AND  specialite = '$spe_demande' AND affiliation = 'oui' ");
            $best_ia_2 =  $ans->fetch();
            $affiliation_p = true;
            @$search_query = $best_ia_2['id'];
            $ans = $bdd->query("SELECT * FROM ia_infos WHERE prix <= '$prix_demande'  AND specialite = '$spe_demande' ");
            $best_ia = $ans->fetchAll(PDO::FETCH_ASSOC);
            if($best_ia_2 == ''){
                    $ans2 = $bdd->query("SELECT * FROM ia_infos WHERE specialite = '$spe_demande' AND prix <= '$prix_demande' ");
                    $best_ia_2 =  $ans2->fetch();
                    $affiliation_p = false;
                    if($best_ia_2 == ''){
                        $affiliation_p = false;
                        $phrase_supp = true;
                        $ans2 = $bdd->query("SELECT * FROM ia_infos WHERE specialite = '$spe_demande' ");
                        $best_ia_2 =  $ans2->fetch();
                        @$search_query = $best_ia_2['id'];
                        $best_ia = $ans2->fetchAll(PDO::FETCH_ASSOC);
                        if($best_ia_2 == ''){
                            echo   "Il y a du avoir une erreur lors du chargement ... Nous travailons pour que ce genre d'incidents ne se reproduisent pas";
                        }
                    }
                    @$search_query = $best_ia_2['id'];
                    $ans2 = $bdd->query("SELECT * FROM ia_infos WHERE specialite = '$spe_demande' ");
                    $best_ia = $ans2->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    else{
        $ia_id = $_GET['ia_value_id'];
        $ans2 = $bdd->query("SELECT * FROM ia_infos WHERE id = '$ia_id' ");
        $best_ia = $ans2->fetchAll(PDO::FETCH_ASSOC);
    }

        if(isset($_SESSION["nom"])){    
            
        
            foreach ($best_ia as $row) {
                $sql = "SELECT * FROM ia_infos WHERE id = :ia_id ";
                $stmt = $bdd->prepare($sql);
                $stmt->bindValue(":ia_id", $row['id'], PDO::PARAM_INT);
                $stmt->execute();
                $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if($phrase_supp == true){
                    echo "<p>Nous n'avons pas d'IA qui correspondent à votre besoin dans le prix demandé mais voici celle qui correspond à votre attente :</p> ";
                    }
             
         
  ?>
            <div class="card" id="result_card">

                                               <div class="header">
                                                   <span><?php echo $row2["nom"] ?></span> 
                                                    <form method="post" action="result.php">
                                                        <input type="int" class="hidden" name="ia_id" value="<?php echo $row2["id"] ?>">

                                                        <?php 
                                                        $sql = "SELECT * FROM favorites WHERE ia_id = :ia_id and user_id = :user_id";
                                                        $stmt = $bdd->prepare($sql);
                                                        $stmt->bindValue(":ia_id", $row2["id"] , PDO::PARAM_INT);
                                                        $stmt->bindValue(":user_id", $_SESSION['id'], PDO::PARAM_INT);
                                                        $stmt->execute();
                                                        $fav_existe = $stmt->fetch(PDO::FETCH_ASSOC);
                                                        if($fav_existe == ''){ ?>
                                                            <button id="button_submit" type="submit" name="add_fav"><img src="img/not_favorite.png" alt="Add to Favorites" class="favorite-icon" name="add_fav"></button>
                                                            <?php }
                                                        else{
                                                            ?>
                                                            <button id="button_submit" type="submit" name="remove_fav" ><img src="img/favorite.png" alt="Add to Favorites" class="favorite-icon"></button>
                                                            <?php } ?>
                                                        </form>


                                                </div>
                                               <p id="coup_de_coeur_p"><?php if($row2["coup_de_coeur"] == 'oui'){echo "Coup de coeur de l'équipe";} ?></p>

                                               <div class="img"><img src="<?php echo $row2["ia_img"] ?>"/></div>

                                               <p class="info"><?php echo $row2["ia_description"] ?></p>
                                               <div class="share">
                                                   <p>Prix par mois : <?php echo $row2["prix"]; ?>€</p>
                                               </div>
                                               <a href="<?php echo $row2["ia_url"] ?>" class="button_position" target="_blank"><button>Aller sur le site</button></a>
                                              <!-- <p id="affiliation_p"><?php //if($affiliation_p == true){echo "Lien affilié";} ?></p> -->
            </div>


                <?php } ?>


            <?php
        }}
        ?>












        <?php 
        ##Pour historique :
        $user_id = $_SESSION['id'];


        // Récupérer la recherche de l'utilisateur
        if(isset($best_ia_2) and $best_ia_2 != ""){

        // Insérer la recherche dans la base de données
        $sql = "INSERT INTO search (user_id, search_query) VALUES (:user_id, :search_query)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':search_query', $search_query, PDO::PARAM_STR);
        $stmt->execute();
        


        //Supprimer recherche la plus ancienne si plus de 4 recherches
        $sql = "DELETE FROM search 
                    WHERE user_id = :user_id 
                    AND id NOT IN (
                        SELECT id 
                        FROM (SELECT id 
                            FROM search 
                            WHERE user_id = :user_id 
                            ORDER BY search_date DESC 
                            LIMIT 4) as subquery
                    )";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    



?>

</div>
<script>
    // Fonction pour scroller vers le haut
function scrollToTop() {
    window.scrollTo({top: 0, behavior: 'smooth'}); // Défilement en douceur vers le haut
}
</script>
<div class="btn-up"><button onclick="scrollToTop()" id="scrollTopBtn" title="Retour en haut">↑</button></div>

</main>
</body>