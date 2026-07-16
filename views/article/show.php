<?php ?>

<article class="article-detail">
    <a href="<?= route_url('home', ['categorie' => $article['categorie']]) ?>" class="back-link">&larr; Retour à <?= h($article['categorie_libelle']) ?></a>

    <span class="article-card-tag"><?= h($article['categorie_libelle']) ?></span>
    <h1><?= h($article['titre']) ?></h1>
    <div class="article-meta">
        <time>Publié le <?= formater_date($article['dateCreation']) ?></time>
    </div>

    <div class="article-content">
        <?= nl2br(h($article['contenu'])) ?>
    </div>
</article>
