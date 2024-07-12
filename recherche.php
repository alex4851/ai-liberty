<?php 
session_start();
if(isset($_SESSION['id'])){ 
include('bdd.php');
@$name_ia = $_GET['name_ia'];
$afficher = "non";
if(isset($_GET['rechercher'])){
    $words = explode(" ",trim($name_ia));
    for($i=0; $i<count($words);$i++)
        $kw[$i]="nom like '%".$words[$i]."%'";
    $res = $bdd->prepare("SELECT * FROM ia_infos WHERE ".implode(" or ", $kw));
    $res->setFetchMode(PDO::FETCH_ASSOC);
    $res->execute();
    $tab = $res->fetchAll();
    $afficher = "oui";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="website icon" type="png" href="img/logo_head.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA TOOLS</title>
</head>

<body <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?> >

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne" id="active"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
            <?php 
            if(isset($_SESSION['ia_admin'])){
                if($_SESSION["ia_admin"] === "true"){
                echo '<div class="ligne"><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
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
        <script src="navigation.js"></script>       
    </nav>
</header>







<section class="content" id="recherche">
    <main class="recherche">
        <form method="get" action="">
            <input type="text" value='<?php echo $name_ia; ?>' name="name_ia" placeholder="Rechercher de l'IA" class="search_bar">
            <input type="submit" name="rechercher" value="Rechercher" class="recherche_button">
        </form>
    </main>

    <?php 
        if($afficher == "oui"){ ?>
        <div class="result">
            <h3><?=count($tab)." ".(count($tab)>1?"résultats trouvés":"résultat trouvé") ?></h3>
            <div class='cards_result'>
                <?php for($i=0; $i<count($tab);$i++){ ?>
            
                    <div class="card_result">
                        <div class="header_result"><h1><strong> <?php echo $tab[$i]["nom"]; ?></strong></div>
                        <h3>Prix :  </h3><?php echo $tab[$i]["prix"]; ?>€ par mois<br />
                        <p><h3>Description :</h3><br/><?php echo $tab[$i]["ia_description"]; ?></p><br/>
                        <p><h3>Lien :</h3><a target="_blank" href= <?php echo $tab[$i]["ia_url"]; ?> ><?php echo $tab[$i]["ia_url"]; ?></a></p>
                        <form method="post" action=""><input class="hidden" type="int" value=<?php echo $tab[$i]["id"] ?> name="ia_id">
                        <?php
                            // Verification si deja ajoutée
                            $ia_id = $tab[$i]["id"];
                            $user_id = $_SESSION["id"];
                            $sql = "SELECT * FROM favorites WHERE ia_id = :ia_id and user_id = :user_id";
                            $stmt = $bdd->prepare($sql);
                            $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
                            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                            $stmt->execute();
                            $deja_fav = $stmt->fetch(PDO::FETCH_ASSOC);
                            if($deja_fav == ""){?>
                            <input type="submit" value="Ajouter aux favoris" name="add_favorite" class="add_favorite"></form>
                        <?php } else{?>
                            <input type="submit" value="Retirer aux favoris" name="remove_favorite" class="add_favorite"></form>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } 


        ##Pour favorite :
        $user_id = $_SESSION['id'];
        @$ia_id = $_POST['ia_id'];
        

        if(isset($_POST['add_favorite'])){
        
            // Insérer la recherche dans la base de données
            $sql = "INSERT INTO favorites (user_id, ia_id) VALUES (:user_id, :ia_id)";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
            $stmt->execute();

        }
        if(isset($_POST["remove_favorite"])){
            //Supprimer des favoris
            $sql2 = 'DELETE FROM favorites WHERE user_id = :user_id and ia_id = :ia_id';
            $stmt = $bdd->prepare($sql2);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
            $stmt->execute();

        }
 
}
else{
    header('Location : index.php');
}

?>


</section>
</body>
</html>