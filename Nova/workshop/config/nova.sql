-- Création de la base de donnée

CREATE DATABASE IF NOT EXISTS nova
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE nova;

-- Création des tables

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    id_adresse INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('client','admin') DEFAULT 'client'
)ENGINE INNODB;

CREATE TABLE categories (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
)ENGINE INNODB;

CREATE TABLE types (
    id_type INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    couleur VARCHAR(50)
)ENGINE INNODB;

CREATE TABLE produits (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    image_banniere VARCHAR(255),
    id_category INT NOT NULL,
    id_type INT NULL,
    FOREIGN KEY (id_category) REFERENCES categories(id_category),
    FOREIGN KEY (id_type) REFERENCES types(id_type)
)ENGINE INNODB;

CREATE TABLE formats (
    id_format INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
)ENGINE INNODB;

CREATE TABLE produit_format (
    id_produit_format INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_format INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    FOREIGN KEY (id_produit) REFERENCES produits(id_produit),
    FOREIGN KEY (id_format) REFERENCES formats(id_format)
)ENGINE INNODB;

CREATE TABLE adresses (
    id_adresse INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    rue VARCHAR(255) NOT NULL,
    rue_numero INT NOT NULL,
    ville VARCHAR(50) NOT NULL,
    code_postal INT NOT NULL,
    pays VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
)ENGINE INNODB;

CREATE TABLE commandes (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    date_commande DATETIME DEFAULT CURRENT_TIMESTAMP,
    nom_client VARCHAR(100),
    prenom_client VARCHAR(100),
    email_client VARCHAR(255),
    statut ENUM(
        'En attente',
        'Payee',
        'Expediee',
        'Livree'
    ) DEFAULT 'En attente'
)ENGINE INNODB;

CREATE TABLE detail_commande (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_commande INT NOT NULL,
    id_produit_format INT NOT NULL,
    id_adresse INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_commande) REFERENCES commandes(id_commande),
    FOREIGN KEY (id_produit_format) REFERENCES produit_format(id_produit_format),
    FOREIGN KEY (id_adresse) REFERENCES adresses(id_adresse)
)ENGINE INNODB;

-- Insertion de données de test
INSERT INTO users (nom, prenom, email, mot_de_passe, role)
VALUES
(
    'Admin',
    'Anthony',
    'admin.anthony@workshop.be',
    'Admin2026_workshop!',
    'admin'
);

INSERT INTO categories (nom)
VALUES
('Produit'),
('Shaker');

INSERT INTO types (nom, couleur)
VALUES
('Void', '#1A1A1A'),
('Distortion', '#F113BE'),
('Amplifier', '#00BBF9'),
('Signature', '#FFD166');

INSERT INTO formats (libelle)
VALUES
('30 portions'),
('50 portions'),
('500 ml'),
('750 ml'),
('1000 ml');

INSERT INTO produits (nom, description, image, id_category, id_type)
VALUES

(
    'Null Star',
    'Condense the infinite.',
    'Null.Star 1_preview_rev_1.png',
    1, 1
),

(
    'Antimatter Drop',
    'Harness forbidden instability.',
    'antimatter-drop.png',
    1, 2
),

(
    'Wormhole',
    'Open a breach through reality.',
    'wormhole.png',
    1, 3
),

(
    'Molecular Prime',
    'Perfect matter engineered beyond physics.',
    'molecular-prime.png',
    1, 4
);

INSERT INTO produit_format (id_produit, id_format, prix, stock)
VALUES

(1, 1, 29.99, 100),
(1, 2, 49.99, 100),

(2, 1, 29.99, 100),
(2, 2, 49.99, 100),

(3, 1, 29.99, 100),
(3, 2, 49.99, 100),

(4, 1, 29.99, 100),
(4, 2, 49.99, 100);