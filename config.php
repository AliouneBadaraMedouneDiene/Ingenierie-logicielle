<?php
/**
 * Bootstrap de l'application : session, connexion BDD, constantes, helpers.
 * À adapter selon ton environnement (XAMPP/WAMP par défaut ci-dessous).
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Paramètres de connexion (à modifier si besoin) ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'mglsi_news');
define('DB_USER', 'root');   // remplace par 'mglsi_user' / 'passer' si tu utilises le compte dédié créé par install.sql
define('DB_PASS', '');       // vide par défaut sous XAMPP/WAMP
define('DB_CHARSET', 'utf8mb4');

// --- Chemin de base du site ---
// Si le dossier du projet dans htdocs s'appelle autrement que "actuesp",
// modifie cette constante (ex: '/mon-dossier').
define('BASE_URL', '/actuesp');

define('ROOT_PATH', __DIR__);

// --- Chargement des classes du noyau, modèles et contrôleurs ---
require_once ROOT_PATH . '/core/Database.php';
require_once ROOT_PATH . '/core/View.php';
require_once ROOT_PATH . '/models/Categorie.php';
require_once ROOT_PATH . '/models/Article.php';

/**
 * Petit helper pour échapper proprement les sorties HTML.
 */
function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Génère (ou réutilise) un jeton CSRF pour sécuriser les formulaires admin.
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    r