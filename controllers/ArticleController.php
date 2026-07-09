<?php
require_once ROOT_PATH . '/models/Article.php';

/**
 * Contrôleur de la page de détail d'un article.
 */
class ArticleController
{
    public function show(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $article = $id > 0 ? Article::find($id) : null;

        if (!$article) {
            http_response_code(404);
            View::render('article/not-found', [], 'Article introuvable');
            return;
        }

        View::render('article/show', ['article' => $article], $article['titre']);
    }
}
