-- =====================================================
-- Actualités Polytechniciennes - Script d'installation
-- Base de données : actuesp
-- =====================================================

CREATE DATABASE IF NOT EXISTS actuesp
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE actuesp;

-- ---------------------------------------------------
-- Table : menus
-- Les menus affichés dans la barre de navigation.
-- ---------------------------------------------------
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS menus;

CREATE TABLE menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    ordre INT NOT NULL DEFAULT 0,
    actif TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table : articles
-- Chaque article est rattaché à un menu (catégorie).
-- ---------------------------------------------------
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_id INT NOT NULL,
    titre VARCHAR(255) NOT NULL,
    extrait VARCHAR(500) DEFAULT NULL,
    contenu TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    auteur VARCHAR(100) DEFAULT 'Rédaction ESP',
    date_publication DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_articles_menu
        FOREIGN KEY (menu_id) REFERENCES menus(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Données de démonstration : menus
-- ---------------------------------------------------
INSERT INTO menus (nom, slug, ordre) VALUES
    ('Sport',     'sport',     1),
    ('Santé',     'sante',     2),
    ('Education', 'education', 3),
    ('Politique', 'politique', 4);

-- ---------------------------------------------------
-- Données de démonstration : articles
-- ---------------------------------------------------
INSERT INTO articles (menu_id, titre, extrait, contenu, image, auteur, date_publication) VALUES
(1, 'L''ESP remporte le tournoi inter-écoles de basketball',
    'L''équipe de basketball de l''ESP décroche le titre après une finale disputée.',
    'L''équipe de basketball de l''École Supérieure Polytechnique a remporté ce week-end le tournoi inter-écoles face à l''ESMT sur le score de 78 à 71.',
    NULL, 'Rédaction Sport', '2026-07-05 10:00:00'),
(2, 'Campagne de sensibilisation contre le paludisme au campus',
    'Le service médical de l''ESP lance une campagne de distribution de moustiquaires.',
    'Dans le cadre de la lutte contre le paludisme, l''infirmerie de l''ESP organise une campagne de distribution gratuite de moustiquaires imprégnées.',
    NULL, 'Service Médical', '2026-07-01 14:30:00'),
(3, 'Ouverture des inscriptions pour le master en Intelligence Artificielle',
    'Le nouveau master IA de l''ESP ouvre ses candidatures pour la rentrée prochaine.',
    'L''École Supérieure Polytechnique annonce l''ouverture des candidatures pour son nouveau master en Intelligence Artificielle et Data Science.',
    NULL, 'Rédaction Education', '2026-07-08 11:00:00'),
(4, 'Visite du ministre de l''Enseignement supérieur à l''ESP',
    'Le ministre a visité les nouveaux laboratoires de recherche de l''école.',
    'Le ministre de l''Enseignement supérieur, de la Recherche et de l''Innovation a effectué une visite officielle des nouveaux laboratoires de recherche de l''ESP.',
    NULL, 'Rédaction Politique', '2026-07-03 17:20:00');
