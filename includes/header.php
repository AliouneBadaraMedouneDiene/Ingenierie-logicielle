<?php
require_once __DIR__ . '/../config.php';

$stmtMenus = $pdo->query('SELECT id, nom, slug FROM menus WHERE actif = 1 ORDER BY ordre ASC');
$menus = $stmtMenus->fetchAll();

$menuActif = isset($_GET['menu']) ? $_GET['menu'] : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? h($pageTitle) . ' — ' : '' ?>Actualités Polytechniciennes</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="index.php" class="brand">
            <span class="brand-esp">ESP</span> Actualités Polytechniciennes
        </a>
    </div>
</header>

<nav class="site-nav">
    <div class="container">
        <ul>
            <li><a href="index.php" class="<?= $menuActif === '' ? 'active' : '' ?>">Accueil</a></li>
            <?php foreach ($menus as $m): ?>
                <li>
                    <a href="index.php?menu=<?= h($m['slug']) ?>"
                       class="<?= $menuActif === $m['slug'] ? 'active' : '' ?>">
                        <?= h($m['nom']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<main class="container">
