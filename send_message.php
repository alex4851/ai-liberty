<?php
session_start();
include('bdd.php');

if (isset($_POST['message_content'])) {
    // Vérification de la session utilisateur
    if (!isset($_SESSION['id'])) {
        echo "Utilisateur non authentifié.";
        exit;
    }

    $user_id = intval($_SESSION['id']);
    
    // Validation et nettoyage du message
    $message = trim($_POST['message_content']);
    $message = strip_tags($message);  // Supprimer toutes les balises HTML/JavaScript
    
    if (empty($message) || strlen($message) > 500) {
        echo "Message non valide.";
        exit;
    }

    // Valeur de la place
    $place = "shared";

    // Insertion sécurisée dans la base de données
    $stmt = $bdd->prepare("INSERT INTO messages (user_id, message, place) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $message, PDO::PARAM_STR);
    $stmt->bindParam(3, $place, PDO::PARAM_STR);
    $stmt->execute();
}
?>