<?php 
session_start();
if(isset($_SESSION['id'])){ 
include('bdd.php');
@$name_ia = $_GET['name_ia'];
@$min_price = $_GET['min_price'];
@$max_price = $_GET['max_price'];
@$cdc_active = $_GET['cdc_active'];
$afficher = "non";
if(isset($_GET['rechercher'])){
    $words = explode(" ",trim($name_ia));
    for($i=0; $i<count($words);$i++)
        $kw[$i]="nom like '%".$words[$i]."%'";
    if($cdc_active == 'true'){
    $res2 = $bdd->prepare("SELECT * FROM ia_infos WHERE ".implode(" or ", $kw)." AND coup_de_coeur = 'oui' AND prix <= $max_price AND prix >= $min_price");}
    else{
    $res2 = $bdd->prepare("SELECT * FROM ia_infos WHERE ".implode(" or ", $kw)." AND prix <= $max_price AND prix >= $min_price");}
    $res2->setFetchMode(PDO::FETCH_ASSOC);
    $res2->execute();
    $tab = $res2->fetchAll();
    $afficher = "oui";
}
##Pour favorite :

        $user_id = $_SESSION['id'];
        @$ia_id = $_POST['ia_id'];
        

        if(isset($_POST['add_fav'])){
            //Verif que existe pas deja
            $sql = "SELECT * FROM favorites WHERE ia_id = :ia_id and user_id = :user_id";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(":ia_id", $ia_id , PDO::PARAM_INT);
            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $fav_existe = $stmt->fetch(PDO::FETCH_ASSOC);
            if($fav_existe == ''){
                // Insérer la recherche dans la base de données
                $sql = "INSERT INTO favorites (user_id, ia_id) VALUES (:user_id, :ia_id)";
                $stmt = $bdd->prepare($sql);
                $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            header("refresh");

        }

        if(isset($_POST["remove_fav"])){
            //Supprimer des favoris
            $sql2 = 'DELETE FROM favorites WHERE user_id = :user_id and ia_id = :ia_id';
            $stmt = $bdd->prepare($sql2);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
            $stmt->execute();
            header("refresh");

        }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.css">

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
            <div class="search_bar_all">
                <input type="text" value='<?php echo $name_ia; ?>' name="name_ia" placeholder="Rechercher de l'IA" class="search_bar">
                <button type="submit" name="rechercher" value="Rechercher" class="recherche_button"><img src="img/search.png"></button>
            </div>
            <div class="critere_recherche">
                <h4>Critères de recherche</h4>
                <div class="price-range">
                    <label for="min_price"></label>
                    <span id="min_price_val">0</span>€

                    <label for="max_price">à  </label>
                    <span id="max_price_val">100</span>€

                    <div id="price-slider" class="range-slider"></div>
                    
                    <input type="hidden" id="min_price" name="min_price" value="0">
                    <input type="hidden" id="max_price" name="max_price" value="100">
                    </div>
                
                <input type="checkbox" value="true" <?php if($cdc_active == "true"){echo "checked";} ?> name="cdc_active"><label for="cdc_active">Coup de coeur</label>
            </div>
            
            </form>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>

                <script>
var slider = document.getElementById('price-slider');

noUiSlider.create(slider, {
    start: [0, 100],
    connect: true,
    range: {
        'min': 0,
        'max': 100
    },
    step: 5
});

var minPriceInput = document.getElementById('min_price');
var maxPriceInput = document.getElementById('max_price');
var minPriceVal = document.getElementById('min_price_val');
var maxPriceVal = document.getElementById('max_price_val');

slider.noUiSlider.on('update', function(values, handle) {
    var value = Math.round(values[handle]);

    if (handle === 0) {
        minPriceInput.value = value;
        minPriceVal.textContent = value;
    } else {
        maxPriceInput.value = value;
        maxPriceVal.textContent = value;
    }
});
    </script>
    </main>

    <?php 
        if($afficher == "oui"){ ?>
        <div class="result">
            <h3><?=count($tab)." ".(count($tab)>1?"résultats trouvés de ".$min_price." à ".$max_price." €":"résultat trouvé de ".$min_price." à ".$max_price." €") ?></h3>
            <div class='cards_result'>
                <?php for($i=0; $i<count($tab);$i++){ 
                     ?>
            
                    <div class="card" id="recherche_card">
                                               <div class="header">
                                                   <span><?php echo $tab[$i]["nom"] ?></span> 
                                                   <form method="post" action="">
<input type="int" class="hidden" name="ia_id" value="<?php echo $tab[$i]["id"] ?>">

<?php 
$sql = "SELECT * FROM favorites WHERE ia_id = :ia_id and user_id = :user_id";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(":ia_id", $tab[$i]["id"] , PDO::PARAM_INT);
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
                                               <?php if($tab[$i]["coup_de_coeur"] == 'oui'){ ?> <p class="info_cdc">Coup de coeur</p> <?php } ?>
                                               <div class="img"><img src="<?php echo $tab[$i]["ia_img"] ?>"/></div>
                                               <p class="info"><?php echo $tab[$i]["ia_description"] ?></p>
                                               <div class="share">
                                                   <p>Prix :  <?php echo $tab[$i]["prix"]; ?>€</p>
                                               </div>
                                               <a href="<?php echo $tab[$i]["ia_url"] ?>" class="button_position" target="_blank"><button>Aller sur le site</button></a>
                                               <?php if($tab[$i]["affiliation"] == 'oui'){ ?> <p class="info_affiliation">Lien affilié</p> <?php } ?>

                    </div>



                <?php } ?>
            </div>
        </div>
    <?php } 



 
}
else{
    header('Location : index.php');
}

?>


</section>
</body>
</html>