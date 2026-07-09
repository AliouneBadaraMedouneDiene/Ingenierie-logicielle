<?php
/**
 * Vue admin — liste des articles. Variable : $articles.
 */
?>

<section class="admin-toolbar">
    <div>
        <h1>Administration des actualités</h1>
        <p class="subtitle">Ajouter, modifier ou supprimer des articles.</p>
    </div>
    <a href="<?= route_url('admin', ['action' => 'form']) ?>" class="btn btn-primary">+ Nouvel article</a>
</section>

<?php if (empty($articles)): ?>
    <p class="empty-state">Aucun article pour le moment. Commence par en créer un.</p>
<?php else: ?>
    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Date</th>
                    <th scope="col" class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $a): ?>
                    <tr>
                        <td><?= h($a['titre']) ?></td>
                        <td><span class="article-card-tag"><?= h($a['categorie_libelle']) ?></span></td>
                        <td><?= formater_date($a['dateCreation']) ?></td>
                        <td class="col-actions">
                            <a href="<?= route_url('admin', ['action' => 'form', 'id' => $a['id']]) ?>" class="btn btn-small">Modifier</a>
                            <form method="post" action="<?= route_url('admin', ['action' => 'delete']) ?>" class="inline-form"
                                  onsubmit="return confirm('Supprimer définitivement l\'article « <?= h(addslashes($a['titre'])) ?> » ?');">
                                <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
                                <button type="submit" class="btn btn-small btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php end