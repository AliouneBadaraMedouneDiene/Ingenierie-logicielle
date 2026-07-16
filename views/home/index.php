<?php ?>

<section class="page-intro">
    <h1><?= $categorieCourante ? h($categorieCourante['libelle']) : 'Toutes les actualités' ?></h1>
    <p class="subtitle">
        <?= $categorieCourante
            ? 'Les dernières actualités de la catégorie ' . h($categorieCourante['libelle']) . '.'
            : 'Retrouvez toute l\'actualité de l\'École Supérieure Polytechnique.' ?>
    </p>
</section>

<?php if (empty($articles)): ?>
    <p class="empty-state">Aucun article disponible pour le moment dans cette catégorie.</p>
<?php else: ?>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
            <article class="article-card">
                <a href="<?= route_url('article', ['id' => $article['id']]) ?>" class="article-card-link">
                    <div class="article-card-image">
                        <div class="article-card-placeholder"><?= h($article['categorie_libelle']) ?></div>
                    </div>
                    <div class="article-card-body">
                        <span class="article-card-tag"><?= h($article['categorie_libelle']) ?></span>
                        <h2><?= h($article['titre']) ?></h2>
                        <p><?= h(extrait_auto($article['contenu'])) ?></p>
                        <time><?= formater_date($article['dateCreation']) ?></time>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
