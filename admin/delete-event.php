<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

$id = $_GET['id'];

// Supprimer l'événement
$stmt = $pdo->prepare("DELETE FROM event WHERE id = ?");
$stmt->execute([$id]);

header('Location: events.php');
exit;
?>