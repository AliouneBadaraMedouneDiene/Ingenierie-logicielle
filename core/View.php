<?php
/**
 * Moteur de rendu des vues : englobe une vue entre le layout header/footer.
 */
class View
{
    /**
     * @param string $view      Chemin de la vue relatif à /views (sans .php), ex: 'home/index'
     * @param array  $data      Variables rendues disponibles dans la vue (extract)
     * @param string|null $pageTitle Titre affiché dans <title> et repris par le layout
     */
    public static function render(string $view, array $data = [], ?string $pageTitle = null): void
    {
        extract($data);

        require ROOT_PATH . '/views/layout/header.php';
        require ROOT_PATH . '/views/' . $view . '.php';
        require ROOT_PATH . '/views/layout/footer.php';
    }
}
