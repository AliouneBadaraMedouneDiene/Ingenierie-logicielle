<?php
/**
 * Layout partagé — en-tête HTML, menu dynamique.
 * Variables disponibles : $pageTitle (optionnel, injecté par View::render).
 */

$categories = Categorie::all();
$categorieActiveId = isset($_GET['categorie']) ? (int) $_GET['categorie'] : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) && $pageTitle ? h($pageTitle) . ' — ' : '' ?>Actualités Polytechniciennes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<a href="#main-content" class="skip-link">Aller au contenu principal</a>

<header class="site-header">
    <div class="container site-header-inner">
        <a href="<?= route_url('home') ?>" class="brand">
            <span class="brand-esp">ESP</span> Actualités Polytechniciennes
        </a>
    </div>
</header>

<nav class="site-nav" aria-label="Rubriques">
    <div class="container">
        <ul>
            <li><a href="<?= route_url('home') ?>" class="<?= $categorieActiveId === 0 ? 'active' : '' ?>">Accueil</a></li>
            <?php foreach ($categories as $c): ?>
                <li>
                    <a href="<?= route_url('home', ['categorie' => $c['id']]) ?>"
                       class="<?= $categorieActiveId === (int) $c['id'] ? 'active' : '' ?>">
                        <?= h($c['libelle']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<main class="container" id="main-content">
