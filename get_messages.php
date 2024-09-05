
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('bdd.php');

session_start();
$user_id = $_SESSION['id'];  // ID de l'utilisateur connecté
$shared = 'shared';

// Récupération des messages depuis la base de données
$query = $bdd->query('SELECT messages.message, messages.timestamp, users.nom, users.ia_admin, messages.user_id 
                      FROM messages 
                      JOIN users ON messages.user_id = users.id 
                      WHERE messages.place = "shared"
                      ORDER BY messages.timestamp ASC');
$query->execute();

$messages = $query->fetchAll(PDO::FETCH_ASSOC);

// Ajouter un champ 'is_me' pour indiquer si le message a été envoyé par l'utilisateur connecté
foreach ($messages as &$message) {
    $message['is_me'] = ($message['user_id'] == $user_id);  // Comparer avec l'ID de l'utilisateur connecté
}

// Retourner les messages au format JSON
echo json_encode($messages);
?>

