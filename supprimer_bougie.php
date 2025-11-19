<?php
include('config.php'); // Connexion à la base

if (isset($_GET['id'])) {
  $id = (int) $_GET['id']; // Je force l’ID en entier pour sécuriser un minimum

  try {
    // Je supprime d’abord le stock lié à la bougie
    $pdo->prepare("DELETE FROM Stock WHERE bougie_id = ?")->execute([$id]);

    // Puis je supprime la bougie elle-même
    $pdo->prepare("DELETE FROM Bougies WHERE id = ?")->execute([$id]);

    // Message de confirmation renvoyé à l’index
    header("Location: index.php?message=suppression");
    exit;
  } catch (PDOException $e) {
    // En cas d’erreur SQL, j’affiche le message
    die("Erreur : " . $e->getMessage());
  }
} else {
  // Si aucun ID n’est fourni, je retourne simplement à l’index
  header("Location: index.php");
  exit;
}
?>

