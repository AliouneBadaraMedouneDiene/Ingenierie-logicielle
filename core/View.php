<?php
class View
{
    public static function render(string $view, array $data = [], ?string $pageTitle = null): void
    {
        extract($data);

        require ROOT_PATH . '/views/layout/header.php';
        require ROOT_PATH . '/views/' . $view . '.php';
        require ROOT_PATH . '/views/layout/footer.php';
    }
}
