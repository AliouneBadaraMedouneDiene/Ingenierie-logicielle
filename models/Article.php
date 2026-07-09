<?php
/**
 * Modèle Article : lecture des articles (V1 — pas de création/modification/suppression).
 * Colonnes réelles : id, titre, contenu, dateCreation, dateModification, categorie (FK -> Categorie.id).
 */
class Article
{
    /**
     * Tous les articles, du plus récent au plus ancien, avec le libellé de la catégorie.
     */
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT a.id, a.titre, a.contenu, a.dateCreation, a.dateModification,
                    c.id AS categorie_id, c.libelle AS categorie_libelle
             FROM Article a
             INNER JOIN Categorie c ON c.id = a.categorie
             ORDER BY a.dateCreation DESC'
        );
        return $stmt->fetchAll();
    }

    /**
     * Articles filtrés par identifiant de catégorie.
     */
    public static function byCategorieId(int $categorieId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT a.id, a.titre, a.contenu, a.dateCreation, a.dateModification,
                    c.id AS categorie_id, c.libelle AS categorie_libelle
             FROM Article a
             INNER JOIN Categorie c ON c.id = a.categorie
             WHERE a.categorie = :categorie_id
             ORDER BY a.dateCreation DESC'
        );
        $stmt->execute(['categorie_id' => $categorieId]);
        return $stmt->fetchAll();
    }

    /**
     * Un article complet (pour la page de détail).
     */
    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT a.*, c.libelle AS categorie_libelle
             FROM Article a
             INNER JOIN Categorie c ON c.id = a.categorie
             WHERE a.id = :id
             LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();

        return $article ?: null;
    }
}
