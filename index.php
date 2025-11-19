<?php include('config.php'); // Connexion à la base de données ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventaire des Bougies</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1>Inventaire des Bougies Artisanales</h1>
  </header>

  <main>

    <!-- ===================== -->
    <!-- MESSAGE DE RETOUR (feedback après action) -->
    <!-- ===================== -->
    <?php if (isset($_GET['message']) && $_GET['message'] === 'suppression') : ?>
      <p class="success">✅ Bougie supprimée avec succès.</p>
    <?php endif; ?>
    <?php if (isset($_GET['message']) && $_GET['message'] === 'ajout') : ?>
      <p class="success">✅ Nouvelle bougie ajoutée avec succès.</p>
    <?php endif; ?>
    <?php if (isset($_GET['message']) && $_GET['message'] === 'update') : ?>
      <p class="success">💾 Stock mis à jour avec succès.</p>
    <?php endif; ?>

    <!-- ===================== -->
    <!-- FORMULAIRE D'AJOUT D'UNE BOUGIE -->
    <!-- ===================== -->
    <section>
      <h2>Ajouter une Bougie</h2>
      <!-- Je passe par un POST vers le script d’insertion -->
      <form action="ajouter_bougie.php" method="POST" class="form-grid">

        <div>
          <label for="nom">Nom :</label>
          <input type="text" name="nom" id="nom" required>
        </div>

        <!-- Sélection ou création d’une forme -->
        <div>
          <label for="forme_id">Forme :</label>
          <select name="forme_id" id="forme_id">
            <option value="">-- Choisir une forme --</option>
            <?php
            // Je récupère la liste des formes existantes
            $formes = $pdo->query("SELECT * FROM Forme ORDER BY nom")->fetchAll();
            foreach ($formes as $f) {
              echo "<option value='{$f['id']}'>" . htmlspecialchars($f['nom']) . "</option>";
            }
            ?>
            <option value="__new">+ Ajouter une nouvelle forme</option>
          </select>
          <input type="text" id="new_forme" name="new_forme" class="hidden" placeholder="Nouvelle forme">
        </div>

        <!-- Sélection ou création d’un parfum -->
        <div>
          <label for="parfum_id">Parfum :</label>
          <select name="parfum_id" id="parfum_id">
            <option value="">-- Choisir un parfum --</option>
            <?php
            $parfums = $pdo->query("SELECT * FROM Parfums ORDER BY nom")->fetchAll();
            foreach ($parfums as $p) {
              echo "<option value='{$p['id']}'>" . htmlspecialchars($p['nom']) . "</option>";
            }
            ?>
            <option value="__new">+ Ajouter un nouveau parfum</option>
          </select>
          <input type="text" id="new_parfum" name="new_parfum" class="hidden" placeholder="Nouveau parfum">
        </div>

        <!-- Sélection ou création d’une couleur -->
        <div>
          <label for="couleur_id">Couleur :</label>
          <select name="couleur_id" id="couleur_id">
            <option value="">-- Choisir une couleur --</option>
            <?php
            $couleurs = $pdo->query("SELECT * FROM Couleur ORDER BY nom")->fetchAll();
            foreach ($couleurs as $c) {
              echo "<option value='{$c['id']}'>" . htmlspecialchars($c['nom']) . "</option>";
            }
            ?>
            <option value="__new">+ Ajouter une nouvelle couleur</option>
          </select>
          <input type="text" id="new_couleur" name="new_couleur" class="hidden" placeholder="Nouvelle couleur">
        </div>

        <div>
          <label for="prix">Prix (€) :</label>
          <input type="number" name="prix" id="prix" step="0.01" required>
        </div>

        <div>
          <label for="quantite_total">Quantité totale :</label>
          <input type="number" name="quantite_total" id="quantite_total" min="0" required>
        </div>

        <div>
          <label for="quantite_dispo">Quantité disponible :</label>
          <input type="number" name="quantite_dispo" id="quantite_dispo" min="0" required>
        </div>

        <div>
          <label for="vente">En vente :</label>
          <select name="vente" id="vente">
            <option value="1">Oui</option>
            <option value="0">Non</option>
          </select>
        </div>

        <div style="grid-column: 1 / -1;">
          <button type="submit">Ajouter la bougie</button>
        </div>
      </form>
    </section>

    <!-- ===================== -->
    <!-- INVENTAIRE (LISTE AVEC JOINTURES) -->
    <!-- ===================== -->
    <section>
      <h2>Inventaire</h2>
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Forme</th>
            <th>Parfum</th>
            <th>Couleur</th>
            <th>Prix (€)</th>
            <th>Quantité totale</th>
            <th>Quantité dispo</th>
            <th>En vente</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Je récupère toutes les bougies avec leurs infos liées (forme, parfum, couleur, prix, stock)
          $bougies = $pdo->query("
            SELECT b.id, b.nom, f.nom AS forme, p.nom AS parfum, c.nom AS couleur, pr.prix,
                   s.quantite_total, s.quantite_dispo, b.vente
            FROM Bougies b
            LEFT JOIN Forme f ON b.forme_id = f.id
            LEFT JOIN Parfums p ON b.parfum_id = p.id
            LEFT JOIN Couleur c ON b.couleur_id = c.id
            LEFT JOIN Prix pr ON b.prix_id = pr.id
            LEFT JOIN Stock s ON b.id = s.bougie_id
            ORDER BY b.nom
          ")->fetchAll();

          // Affichage ligne par ligne dans le tableau
          foreach ($bougies as $b) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($b['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($b['forme']) . "</td>";
            echo "<td>" . htmlspecialchars($b['parfum']) . "</td>";
            echo "<td>" . htmlspecialchars($b['couleur']) . "</td>";
            echo "<td>" . htmlspecialchars($b['prix']) . "</td>";
            echo "<td><input type='number' class='qte_total' data-id='{$b['id']}' value='{$b['quantite_total']}' min='0'></td>";
            echo "<td><input type='number' class='qte_dispo' data-id='{$b['id']}' value='{$b['quantite_dispo']}' min='0'></td>";
            echo "<td>" . ($b['vente'] ? "Oui" : "Non") . "</td>";
            echo "<td>
                    <button class='save-btn' data-id='{$b['id']}'>💾 Sauvegarder</button>
                    <a href='supprimer_bougie.php?id={$b['id']}' class='delete-btn' onclick='return confirm(\"Supprimer cette bougie ?\")'>🗑️ Supprimer</a>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <!-- ===================== -->
    <!-- SCRIPT JS  -->
    <!-- ===================== -->
    <script src="app.js"></script>

  </main>

  <footer>
    <p>&copy; 2023 Bougie Artisanale</p>
  </footer>
</body>

</html>
