-- ==========================================================
-- Création de la base de données et sélection
-- ==========================================================
CREATE DATABASE IF NOT EXISTS gestion_bougies 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_general_ci;
USE gestion_bougies;

-- ==========================================================
-- Table : Forme
-- Stocke toutes les formes possibles des bougies
-- ==========================================================
CREATE TABLE Forme (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL
);

-- ==========================================================
-- Table : Couleur
-- Répertorie les différentes couleurs disponibles
-- ==========================================================
CREATE TABLE Couleur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50) NOT NULL
);

-- ==========================================================
-- Table : Parfums
-- Liste des parfums proposés
-- ==========================================================
CREATE TABLE Parfums (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL
);

-- ==========================================================
-- Table : Prix
-- Permet de gérer les prix séparément
-- ==========================================================
CREATE TABLE Prix (
  id INT AUTO_INCREMENT PRIMARY KEY,
  prix DECIMAL(10,2) NOT NULL
);

-- ==========================================================
-- Table : Bougies
-- Table principale contenant les caractéristiques des bougies
-- (liens vers forme, parfum, couleur et prix)
-- ==========================================================
CREATE TABLE Bougies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  forme_id INT,
  parfum_id INT,
  couleur_id INT,
  prix_id INT,
  vente BOOLEAN DEFAULT TRUE, -- booléen pour indiquer si la bougie est en vente
  FOREIGN KEY (forme_id) REFERENCES Forme(id),
  FOREIGN KEY (parfum_id) REFERENCES Parfums(id),
  FOREIGN KEY (couleur_id) REFERENCES Couleur(id),
  FOREIGN KEY (prix_id) REFERENCES Prix(id)
);

-- ==========================================================
-- Table : Stock
-- Gère les quantités en stock de chaque bougie
-- UNIQUE(bougie_id) : une seule ligne de stock par bougie
-- ==========================================================
CREATE TABLE Stock (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bougie_id INT NOT NULL,
  quantite_total INT DEFAULT 0,
  quantite_dispo INT DEFAULT 0,
  FOREIGN KEY (bougie_id) REFERENCES Bougies(id),
  UNIQUE (bougie_id)
);
