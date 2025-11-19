# Inventaire de Bougies Artisanales -- CRUD Complet (PHP / MySQL)

## Présentation du projet

Ce projet consiste à développer un **mini-système de gestion
d'inventaire** pour des bougies artisanales.\
Il s'agit d'une application **PHP / MySQL** avec une interface simple
permettant :

-   d'ajouter une bougie,
-   de gérer ses caractéristiques (forme, parfum, couleur, prix),
-   de suivre son stock (quantité totale et disponible),
-   de modifier ou supprimer une bougie,
-   de mettre à jour le stock en direct via AJAX.

Ce projet illustre un **CRUD complet** ainsi que des interactions entre
plusieurs tables SQL via des clés étrangères.

------------------------------------------------------------------------

# Architecture du projet

    /inventaire-bougies
    │
    ├── index.php               → Page principale (formulaire + tableau inventaire)
    ├── ajouter_bougie.php      → Traitement de l’ajout d’une bougie
    ├── supprimer_bougie.php    → Suppression d'une bougie
    ├── update_stock.php        → Mise à jour du stock (AJAX)
    ├── config.php              → Connexion PDO à la base
    ├── style.css               → Style global
    ├── script.js               → Logique JS (AJAX + champs dynamiques)
    └── database.sql            → Structure SQL complète

------------------------------------------------------------------------

# Structure de la base de données

Le projet repose sur **6 tables relationnelles** :

  Table         Rôle
  ------------- -------------------------------------------------------
  **Forme**     Stocke les formes de bougies
  **Parfums**   Répertorie les parfums
  **Couleur**   Liste les couleurs possibles
  **Prix**      Gère les prix (permet de moduler la grille tarifaire)
  **Bougies**   Table principale contenant les produits
  **Stock**     Stock lié aux bougies (1 ligne par bougie)

------------------------------------------------------------------------

# Fonctionnalités principales

### 1. Ajout d'une bougie

Formulaire complet + logique d'ajout conditionnel (création automatique
des nouvelles formes/parfums/couleurs).

### 2. Gestion dynamique des listes

Apparition du champ "nouvelle valeur" via JavaScript.

### 3. Inventaire complet

Affichage via jointures SQL.

### 4. Mise à jour du stock (AJAX)

Modification en direct via `fetch()`.

### 5. Suppression sécurisée

Suppression du stock + suppression de la bougie.

------------------------------------------------------------------------

# Installation

1.  Importer `database.sql`
2.  Configurer `config.php`
3.  Lancer avec votre serveur local

------------------------------------------------------------------------

# Technologies

PHP, MySQL, PDO, CSS, JavaScript, AJAX.

------------------------------------------------------------------------

# Objectifs pédagogiques

CRUD complet + gestion SQL + relations + sécurité via PDO + AJAX + DOM.
