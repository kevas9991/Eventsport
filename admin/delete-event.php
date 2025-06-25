<?php
session_start(); // Démarre une session PHP pour accéder aux données de session

// Vérifie que l'utilisateur est connecté et qu'il a le rôle 'admin'
// Sinon, il est redirigé vers la page de connexion admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirige vers la page de connexion admin, car c'est une action d'administration
    header('Location: login.php');
    exit; // Arrête l'exécution du script après la redirection
}

include '../includes/db.php'; // Inclusion du fichier de connexion à la base de données (remonte d'un niveau)

$id = $_GET['id'] ?? null; // Récupère l'identifiant de l'événement à supprimer, ou null

// Vérifie si l'ID est valide
if (!$id || !is_numeric($id)) {
    // Redirige avec un message d'erreur si l'ID est manquant ou invalide
    header('Location: events.php?status=error&message=ID événement invalide.');
    exit;
}

try {
    // Prépare une requête SQL pour supprimer un événement dont l'id correspond
    $stmt = $pdo->prepare("DELETE FROM event WHERE id = ?");

    // Exécute la requête en passant l'id récupéré pour supprimer l'événement
    $stmt->execute([$id]);

    // Après suppression, redirige vers la page listant tous les événements avec un message de succès
    header('Location: events.php?status=deleted');
    exit; // Termine le script
} catch (PDOException $e) {
    // En cas d'erreur de base de données, redirige avec un message d'erreur
    error_log("Erreur lors de la suppression de l'événement ID: " . $id . " - " . $e->getMessage()); // Log l'erreur
    header('Location: events.php?status=error&message=Erreur lors de la suppression de l\'événement.');
    exit;
}
?>