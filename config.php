<?php
$host = "localhost";
$dbname = "gestion_bougies"; 
$username = "root";
$password = "root"; 

try {
  // Connexion à la base de données avec PDO
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

  // Activation du mode d'erreur pour afficher des exceptions en cas de problème
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  // Si la connexion échoue, j'affiche le message d’erreur et j’arrête l’exécution
  die("Erreur de connexion : " . $e->getMessage());
}
?>
