<?php
require_once __DIR__ . '/includes/header.php';

$menuSlug = isset($_GET['menu']) ? trim($_GET['menu']) : '';
$menuCourant = null;

if ($menuSlug !== '') {
    $stmt = $pdo->prepare('SELECT id, nom, slug FROM menus WHERE slug = :slug AND actif = 1 LIMIT 1');
    $stmt->execute(['slug' => $menuSlug]);
    $menuCourant = $stmt->fetch();

    if (!$menuCourant) {
        $menuSlug = '';
    }
}

if ($menuCourant) {
    $stmtArticles = $pdo->prepare(
        'SELECT a.id, a.titre, a.extrait, a.image, a.date_publication, m.nom AS menu_nom, m.slug AS menu_slug
         FROM articles a
         INNER JOIN menus m ON m.id = a.menu_id
         WHERE a.menu_id = :menu_id
         ORDER BY a.date_publication DESC'
    );
    $stmtArticles->execute(['menu_id' => $menuCourant['id']]);
} else {
    $stmtArticles = $pdo->query(
        'SELECT a.id, a.titre, a.extrait, a.image, a.date_publication, m.nom AS menu_nom, m.slug AS menu_slug
         FROM articles a
         INNER JOIN menus m ON m.id = a.menu_id
         ORDER BY a.date_publication DESC'
    );
}

$articles = $stmtArticles->fetchAll();
?>

<section class="page-intro">
    <h1><?= $menuCourant ? h($menuCourant['nom']) : 'Toutes les actualités' ?></h1>
    <p class="subtitle">
        <?= $menuCourant
            ? 'Les dernières actualités de la rubrique ' . h($menuCourant['nom']) . '.'
            : 'Retrouvez toute l\'actualité de l\'École Supérieure Polytechnique.' ?>
    </p>
</section>

<?php if (empty($articles)): ?>
    <p class="empty-state">Aucun article disponible pour le moment dans cette rubrique.</p>
<?php else: ?>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
            <article class="article-card">
                <a href="article.php?id=<?= (int) $article['id'] ?>" class="article-card-link">
                    <div class="article-card-image">
                        <?php if (!empty($article['image'])): ?>
                            <img src="assets/img/<?= h($article['image']) ?>" alt="<?= h($article['titre']) ?>">
                        <?php else: ?>
                            <div class="article-card-placeholder"><?= h($article['menu_nom']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="article-card-body">
                        <span class="article-card-tag"><?= h($article['menu_nom']) ?></span>
                        <h2><?= h($article['titre']) ?></h2>
                        <?php if (!empty($article['extrait'])): ?>
                            <p><?= h($article['extrait']) ?></p>
                        <?php endif; ?>
                        <time><?= formater_date($article['date_publication']) ?></time>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
