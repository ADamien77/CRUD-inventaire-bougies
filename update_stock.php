<?php
include('config.php'); // Connexion à la base

// Récupération et typage des données envoyées en POST
$id = intval($_POST['id']);
$qte_total = intval($_POST['qte_total']);
$qte_dispo = intval($_POST['qte_dispo']);

// Je vérifie d’abord si une entrée de stock existe déjà pour cette bougie
$stmt = $pdo->prepare("SELECT id FROM Stock WHERE bougie_id = :id");
$stmt->execute([':id' => $id]);
$exists = $stmt->fetch();

if ($exists) {
  // Si le stock existe, je fais une mise à jour des quantités
  $stmt = $pdo->prepare("
    UPDATE Stock
    SET quantite_total = :qt, quantite_dispo = :qd
    WHERE bougie_id = :id
  ");
  $stmt->execute([
    ':qt' => $qte_total,
    ':qd' => $qte_dispo,
    ':id' => $id
  ]);
  echo "✅ Stock mis à jour avec succès !";
} else {
  // Sinon, je crée une nouvelle ligne de stock pour cette bougie
  $stmt = $pdo->prepare("
    INSERT INTO Stock (bougie_id, quantite_total, quantite_dispo)
    VALUES (:id, :qt, :qd)
  ");
  $stmt->execute([
    ':qt' => $qte_total,
    ':qd' => $qte_dispo,
    ':id' => $id
  ]);
  echo "✅ Stock créé avec succès !";
}
?>
