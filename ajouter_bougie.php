<?php
include('config.php'); // Connexion PDO

// Récupération et nettoyage des données
$nom = trim($_POST['nom']);
$prix = floatval($_POST['prix']);
$vente = intval($_POST['vente']);
$quantite_total = intval($_POST['quantite_total']);
$quantite_dispo = intval($_POST['quantite_dispo']);

// FORMES : si l’utilisateur ajoute une nouvelle forme, je l’enregistre d’abord
if ($_POST['forme_id'] === '__new' && !empty($_POST['new_forme'])) {
  $stmt = $pdo->prepare("INSERT INTO Forme (nom) VALUES (:nom)");
  $stmt->execute([':nom' => trim($_POST['new_forme'])]);
  $forme_id = $pdo->lastInsertId();
} else {
  $forme_id = $_POST['forme_id'] ?: null; // sinon j’utilise celle choisie
}

// PARFUMS
if ($_POST['parfum_id'] === '__new' && !empty($_POST['new_parfum'])) {
  $stmt = $pdo->prepare("INSERT INTO Parfums (nom) VALUES (:nom)");
  $stmt->execute([':nom' => trim($_POST['new_parfum'])]);
  $parfum_id = $pdo->lastInsertId();
} else {
  $parfum_id = $_POST['parfum_id'] ?: null;
}

// COULEURS
if ($_POST['couleur_id'] === '__new' && !empty($_POST['new_couleur'])) {
  $stmt = $pdo->prepare("INSERT INTO Couleur (nom) VALUES (:nom)");
  $stmt->execute([':nom' => trim($_POST['new_couleur'])]);
  $couleur_id = $pdo->lastInsertId();
} else {
  $couleur_id = $_POST['couleur_id'] ?: null;
}

// Enregistrement du prix
$stmt = $pdo->prepare("INSERT INTO Prix (prix) VALUES (:prix)");
$stmt->execute([':prix' => $prix]);
$prix_id = $pdo->lastInsertId();

// Création de la bougie
$stmt = $pdo->prepare("
  INSERT INTO Bougies (nom, forme_id, parfum_id, couleur_id, prix_id, vente)
  VALUES (:nom, :forme_id, :parfum_id, :couleur_id, :prix_id, :vente)
");
$stmt->execute([
  ':nom'        => $nom,
  ':forme_id'   => $forme_id,
  ':parfum_id'  => $parfum_id,
  ':couleur_id' => $couleur_id,
  ':prix_id'    => $prix_id,
  ':vente'      => $vente
]);
$bougie_id = $pdo->lastInsertId();

// Création du stock lié à la bougie
$stmt = $pdo->prepare("
  INSERT INTO Stock (bougie_id, quantite_total, quantite_dispo)
  VALUES (:bid, :qt, :qd)
");
$stmt->execute([
  ':bid' => $bougie_id,
  ':qt'  => $quantite_total,
  ':qd'  => $quantite_dispo
]);

// Retour à la liste
header("Location: index.php");
exit;
