<?php
require_once __DIR__ . '/config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(404);
    require_once __DIR__ . '/includes/header.php';
    echo '<p class="empty-state">Article introuvable.</p>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$stmt = $pdo->prepare(
    'SELECT a.*, m.nom AS menu_nom, m.slug AS menu_slug
     FROM articles a
     INNER JOIN menus m ON m.id = a.menu_id
     WHERE a.id = :id
     LIMIT 1'
);
$stmt->execute(['id' => $id]);
$article = $stmt->fetch();

if (!$article) {
    http_response_code(404);
    require_once __DIR__ . '/includes/header.php';
    echo '<p class="empty-state">Cet article n\'existe pas ou a été supprimé.</p>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $article['titre'];
require_once __DIR__ . '/includes/header.php';
?>

<article class="article-detail">
    <a href="index.php?menu=<?= h($article['menu_slug']) ?>" class="back-link">&larr; Retour à <?= h($article['menu_nom']) ?></a>

    <span class="article-card-tag"><?= h($article['menu_nom']) ?></span>
    <h1><?= h($article['titre']) ?></h1>
    <div class="article-meta">
        <span>Par <?= h($article['auteur']) ?></span>
        <span>&middot;</span>
        <time><?= formater_date($article['date_publication']) ?></time>
    </div>

    <?php if (!empty($article['image'])): ?>
        <div class="article-detail-image">
            <img src="assets/img/<?= h($article['image']) ?>" alt="<?= h($article['titre']) ?>">
        </div>
    <?php endif; ?>

    <div class="article-content">
        <?= nl2br(h($article['contenu'])) ?>
    </div>
</article>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
