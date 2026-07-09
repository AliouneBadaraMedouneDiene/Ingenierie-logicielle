<?php
require_once ROOT_PATH . '/models/Categorie.php';
require_once ROOT_PATH . '/models/Article.php';

/**
 * Contrôleur de la page d'accueil : liste des articles, filtrage par catégorie.
 */
class HomeController
{
    public function index(): void
    {
        $categorieId = isset($_GET['categorie']) ? (int) $_GET['categorie'] : 0;
        $categorieCourante = $categorieId > 0 ? Categorie::find($categorieId) : null;

        $articles = $categorieCourante ? Article::byCategorieId($categorieCourante['id']) : Article::all();

        $pageTitle = $categorieCourante ? $categorieCourante['libelle'] : null;

        View::render('home/index', [
            'articles'          => $articles,
            'categorieCourante' => $categorieCourante,
        ], $pageTitle);
    }
}
