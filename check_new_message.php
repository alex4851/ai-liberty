<?php
include('bdd.php');
session_start();
$user_id = $_SESSION['id'];  // ID de l'utilisateur connecté

// Si aucune vérification précédente, définir une date par défaut (temps très ancien)
$last_checked = isset($_SESSION['last_checked']) ? $_SESSION['last_checked'] : '1970-01-01 00:00:00';

// Requête pour voir s'il y a au moins un nouveau message
$query = $pdo->prepare('SELECT 1 FROM messages WHERE place = :place AND timestamp > :last_checked LIMIT 1');
$query->execute(['place' => 'shared', 'last_checked' => $last_checked]);

// Vérifier si un nouveau message a été reçu
if ($query->fetch()) {
    echo json_encode(['new_message' => true]);
} else {
    echo json_encode(['new_message' => false]);
}

// Mettre à jour la session avec le nouveau timestamp après chaque requête
$_SESSION['last_checked'] = date('Y-m-d H:i:s');
?>
