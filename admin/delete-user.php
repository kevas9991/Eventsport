<?php
session_start(); // Démarre la session pour accéder aux données de session

// Vérifie si un utilisateur est connecté ET s'il a le rôle 'admin'
// Sinon, redirige vers la page de connexion admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirige vers la page de connexion admin, car c'est une action d'administration
    header('Location: login.php');
    exit; // Stoppe l'exécution après redirection
}

include '../includes/db.php'; // Inclut la connexion à la base de données (remonte d'un niveau)

$id = $_GET['id'] ?? null; // Récupère l'identifiant de l'utilisateur à supprimer depuis l'URL, ou null

// Vérifie si l'ID est valide
if (!$id || !is_numeric($id)) {
    // Redirige avec un message d'erreur si l'ID est manquant ou invalide
    header('Location: users.php?status=error&message=ID utilisateur invalide.');
    exit;
}

try {
    // Prépare une requête SQL pour supprimer l'utilisateur dont l'id correspond
    $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");

    // Exécute la requête
    $stmt->execute([$id]);

    // Redirige vers la page listant tous les utilisateurs avec un message de succès
    header('Location: users.php?status=deleted');
    exit; // Termine le script
} catch (PDOException $e) {
    // En cas d'erreur de base de données, redirige avec un message d'erreur
    error_log("Erreur lors de la suppression de l'utilisateur ID: " . $id . " - " . $e->getMessage()); // Log l'erreur
    header('Location: users.php?status=error&message=Erreur lors de la suppression de l\'utilisateur.');
    exit;
}
?>