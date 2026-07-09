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
// Doit correspondre exactement au nom du dossier dans www/htdocs.
define('BASE_URL', '/Ingenierie-logicielle');

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
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie un jeton CSRF reçu en POST.
 */
function csrf_verifie($token) {
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string) $token);
}

/**
 * Enregistre un message flash (succès/erreur) affiché après redirection.
 */
function flash_set($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Récupère et efface le message flash courant.
 */
function flash_get() {
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

/**
 * Formate une date SQL en français lisible.
 */
function formater_date($dateSql) {
    $mois = [
        1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
        5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
        9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre',
    ];
    $ts = strtotime($dateSql);
    return date('j', $ts) . ' ' . $mois[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}

/**
 * Construit une URL interne basée sur le routeur (index.php?route=...).
 */
function route_url($route, array $params = []) {
    $query = array_merge(['route' => $route], $params);
    return BASE_URL . '/index.php?' . http_build_query($query);
}

/**
 * Génère un résumé automatique à partir du contenu d'un article
 * (la table Article n'a pas de colonne "extrait").
 */
function extrait_auto($contenu, $longueur = 160) {
    $texte = trim(strip_tags($contenu));
    if (mb_strlen($texte) <= $longueur) {
        return $texte;
    }
    return mb_substr($texte, 0, $longueur) . '…';
}
