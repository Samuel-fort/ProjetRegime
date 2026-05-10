CREATE DATABASE IF NOT EXISTS Regime_DB;
USE Regime_DB;

CREATE TABLE admins (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    email         VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe  VARCHAR(255) NOT NULL
);

CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe  VARCHAR(255) NOT NULL,
    genre         ENUM('homme','femme') NOT NULL,
    taille        FLOAT NOT NULL COMMENT 'en cm',
    poids         FLOAT NOT NULL COMMENT 'en kg',
    imc           FLOAT,
    wallet        DECIMAL(10,2) NOT NULL DEFAULT 0,
    is_gold       TINYINT(1)    NOT NULL DEFAULT 0,
    date_gold     DATETIME DEFAULT NULL,
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE regimes (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    nom              VARCHAR(150) NOT NULL,
    description      TEXT,
    pct_viande       INT    NOT NULL DEFAULT 0  COMMENT '% de viande',
    pct_poisson      INT    NOT NULL DEFAULT 0  COMMENT '% de poisson',
    pct_volaille     INT    NOT NULL DEFAULT 0  COMMENT '% de volaille',
    variation_poids  FLOAT  NOT NULL DEFAULT 0  COMMENT 'kg gagnés/perdus',
    objectif         ENUM('augmenter','reduire','imc_ideal') NOT NULL,
    actif            TINYINT(1) NOT NULL DEFAULT 1
);


CREATE TABLE regime_prix (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    regime_id   INT           NOT NULL,
    duree_jours INT           NOT NULL COMMENT 'ex: 30, 60, 90',
    prix        DECIMAL(12,2) NOT NULL,
    CONSTRAINT fk_rp_regime FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE
);


CREATE TABLE activites_sportives (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(150) NOT NULL,
    description     TEXT,
    duree_minutes   INT          NOT NULL,
    calories_heure  INT          NOT NULL,
    objectif        ENUM('augmenter','reduire','imc_ideal') NOT NULL,
    actif           TINYINT(1)   NOT NULL DEFAULT 1
);


CREATE TABLE codes_wallet (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    code     VARCHAR(50)   NOT NULL UNIQUE,
    montant  DECIMAL(10,2) NOT NULL,
    is_used  TINYINT(1)    NOT NULL DEFAULT 0,
    used_by  INT               NULL,
    used_at  DATETIME          NULL,
    CONSTRAINT fk_cw_user FOREIGN KEY (used_by) REFERENCES users(id) ON DELETE SET NULL
);


CREATE TABLE commandes (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    user_id        INT           NOT NULL,
    regime_id      INT           NOT NULL,
    duree_jours    INT           NOT NULL,
    prix_original  DECIMAL(12,2) NOT NULL,
    remise_gold    DECIMAL(12,2) NOT NULL DEFAULT 0,
    prix_paye      DECIMAL(12,2) NOT NULL,
    date_achat     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cmd_user   FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE,
    CONSTRAINT fk_cmd_regime FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE
);


CREATE TABLE parametres (
    cle    VARCHAR(100) NOT NULL PRIMARY KEY,
    valeur VARCHAR(255) NOT NULL
);


-- 1 admin  (mdp en clair : password)
INSERT INTO admins (email, mot_de_passe) VALUES
('admin@gmail.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- 5 utilisateurs (mdp en clair : password)
INSERT INTO users (nom, email, mot_de_passe, genre, taille, poids, imc, wallet, is_gold, date_gold, created_at) VALUES
('Alice Martin',  'alice@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'femme', 165, 55,  ROUND(55  /(1.65*1.65),2),  50.00, 0, NULL,                 '2025-12-01 10:00:00'),
('Bob Dupont',    'bob@gmail.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'homme', 178, 95,  ROUND(95  /(1.78*1.78),2),  20.00, 1, '2026-01-15 09:00:00','2025-12-05 11:00:00'),
('Clara Morel',   'clara@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'femme', 158, 48,  ROUND(48  /(1.58*1.58),2),   0.00, 0, NULL,                 '2026-01-10 14:00:00'),
('David Leroy',   'david@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'homme', 182, 110, ROUND(110 /(1.82*1.82),2), 100.00, 0, NULL,                 '2026-02-03 08:30:00'),
('Emma Bernard',  'emma@gmail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'femme', 170, 70,  ROUND(70  /(1.70*1.70),2),  35.00, 0, NULL,                 '2026-03-20 16:00:00');

-- 5 régimes
INSERT INTO regimes (nom, description, pct_viande, pct_poisson, pct_volaille, variation_poids, objectif, actif) VALUES
('Régime Méditerranéen',  'Riche en poisson et légumes, idéal pour atteindre un poids sain.',      20, 50, 30, -4.0, 'imc_ideal',  1),
('Régime Hyperprotéiné',  'Fort apport en volaille et viande pour développer la masse musculaire.', 50, 10, 40,  5.0, 'augmenter',  1),
('Régime Détox Poisson',  'À base de poisson léger pour accélérer la perte de poids.',              10, 70, 20, -6.0, 'reduire',    1),
('Régime Équilibré Plus', 'Équilibre optimal entre les trois sources pour IMC idéal.',              33, 34, 33, -2.0, 'imc_ideal',  1),
('Régime Prise de Masse', 'Maximise les apports caloriques via viande et volaille.',                60,  5, 35,  8.0, 'augmenter',  1);

-- Prix (30 / 60 / 90 jours pour chaque régime)
INSERT INTO regime_prix (regime_id, duree_jours, prix) VALUES
(1,30,80000),(1,60,140000),(1,90,220000),
(2,30,100000),(2,60,190000),(2,90,250000),
(3,30,950000),(3,60,175000),(3,90,235000),
(4,30,110000),(4,60,200000),(4,90,270000),
(5,30,200000),(5,60,350000),(5,90,500000);

-- 5 activités sportives
INSERT INTO activites_sportives (nom, description, duree_minutes, calories_heure, objectif, actif) VALUES
('Natation',        'Nage libre ou dos crawlé, cardio doux.',                45, 500, 'reduire',   1),
('Musculation',     'Renforcement musculaire en salle.',                      60, 400, 'augmenter', 1),
('Vélo elliptique', 'Cardio à faible impact articulaire.',                    30, 450, 'imc_ideal', 1),
('Course à pied',   'Jogging modéré en extérieur ou sur tapis.',              40, 600, 'reduire',   1),
('Yoga dynamique',  'Postures et étirements pour équilibre corps/esprit.',    50, 250, 'imc_ideal', 1);

-- 15 codes wallet (tous is_used = 0)
INSERT INTO codes_wallet (code, montant, is_used) VALUES
('BIENV-A1B2C3',  10.00, 0),
('BIENV-D4E5F6',  10.00, 0),
('PROMO-G7H8I9',  20.00, 0),
('PROMO-J1K2L3',  20.00, 0),
('SUPER-M4N5O6',  50.00, 0),
('SUPER-P7Q8R9',  50.00, 0),
('FLASH-S1T2U3',   5.00, 0),
('FLASH-V4W5X6',   5.00, 0),
('GOLD-Y7Z8A1B',  30.00, 0),
('GOLD-B2C3D4E',  30.00, 0),
('VIP-E5F6G7H8', 100.00, 0),
('VIP-H8I9J1K2', 100.00, 0),
('MINI-K2L3M4N',   2.00, 0),
('MINI-N5O6P7Q',   2.00, 0),
('BONUS-Q8R9S1',  15.00, 0);

-- Paramètres globaux
INSERT INTO parametres (cle, valeur) VALUES
('prix_gold',        '90000'),
('taux_remise_gold', '15');

ALTER TABLE users ADD COLUMN objectif ENUM('augmenter','reduire','imc_ideal') NULL DEFAULT NULL;