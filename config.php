<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'mglsi_news');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('BASE_URL', '/Ingenierie-logicielle');

define('ROOT_PATH', __DIR__);

require_once ROOT_PATH . '/core/Database.php';
require_once ROOT_PATH . '/core/View.php';
require_once ROOT_PATH . '/models/Categorie.php';
require_once ROOT_PATH . '/models/Article.php';

function h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function formater_date($dateSql) {
    $mois = [
        1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
        5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
        9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre',
    ];
    $ts = strtotime($dateSql);
    return date('j', $ts) . ' ' . $mois[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}

function route_url($route, array $params = []) {
    $query = array_merge(['route' => $route], $params);
    return BASE_URL . '/index.php?' . http_build_query($query);
}

function extrait_auto($contenu, $longueur = 160) {
    $texte = trim(strip_tags($contenu));
    if (mb_strlen($texte) <= $longueur) {
        return $texte;
    }
    return mb_substr($texte, 0, $longueur) . '…';
}
