<?php
/**
 * Front controller — point d'entrée unique de l'application.
 * V1 : uniquement consultation (accueil filtrable + détail d'article).
 */

require_once __DIR__ . '/config.php';
require_once ROOT_PATH . '/controllers/HomeController.php';
require_once ROOT_PATH . '/controllers/ArticleController.php';

$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'home':
        (new HomeController())->index();
        break;

    case 'article':
        (new ArticleController())->show();
        break;

    default:
        http_response_code(404);
        echo 'Page introuvable.';
        break;
}
