-- Création de la base de donnée

CREATE DATABASE IF NOT EXISTS nova
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE nova;

-- Création des tables

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin','client') DEFAULT 'client',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE INNODB;

CREATE TABLE categories (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
)ENGINE INNODB;

CREATE TABLE types (
    id_type INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    couleur VARCHAR(20) NOT NULL
)ENGINE INNODB;
CREATE TABLE produits (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL UNIQUE,
    slug VARCHAR(150) UNIQUE,
    description TEXT,
    image VARCHAR(255),
    image_banniere VARCHAR(255),
    id_category INT NOT NULL,
    id_type INT,
    FOREIGN KEY (id_category) REFERENCES categories(id_category),
    FOREIGN KEY (id_type) REFERENCES types(id_type)
)ENGINE INNODB;

CREATE TABLE formats (
    id_format INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL UNIQUE
)ENGINE INNODB;

CREATE TABLE produit_format (
    id_produit_format INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_format INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    UNIQUE(id_produit, id_format),
    FOREIGN KEY (id_produit) REFERENCES produits(id_produit) ON DELETE CASCADE,
    FOREIGN KEY (id_format) REFERENCES formats(id_format)
)ENGINE INNODB;

CREATE TABLE commandes (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    montant_total DECIMAL(10,2) DEFAULT 0,
    statut ENUM(
        'En attente',
        'Payee',
        'Expediee',
        'Livree'
    ) DEFAULT 'En attente',
    nom_client VARCHAR(100) NOT NULL,
    prenom_client VARCHAR(100) NOT NULL,
    email_client VARCHAR(255) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    code_postal VARCHAR(20) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    telephone VARCHAR(50),
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL
)ENGINE INNODB;

CREATE TABLE detail_commande (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_commande INT NOT NULL,
    id_produit_format INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_commande) REFERENCES commandes(id_commande) ON DELETE CASCADE,
    FOREIGN KEY (id_produit_format) REFERENCES produit_format(id_produit_format)
)ENGINE INNODB;

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

INSERT INTO produits (nom, slug, description, image, image_banniere, id_category, id_type)
VALUES

(
    'Null Star',
    'null-star',
    'Condense the infinite.',
    'Null.Star 1_preview_rev_1.png',
    '',
    1, 1
),

(
    'Molecular Prime',
    'molecular-prime',
    'Perfect matter engineered beyond physics.',
    'molecular-prime-banner_preview_rev_6.png',
    'molecular-prime-banner.png',
    1, 4
),

(
    'Antimatter Drop',
    'antimatter-drop',
    'Harness forbidden instability.',
    'antimatter-drop-banner_preview_rev_3.png',
    'antimatter-drop-banner.png',
    1, 2
),

(
    'Wormhole',
    'wormhole',
    'Open a breach through reality.',
    'wormhole-banner_preview_rev_4.png',
    'wormhole-banner.png',
    1, 3
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