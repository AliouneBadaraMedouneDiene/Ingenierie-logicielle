<?php
/**
 * Modèle Categorie : accès à la table `Categorie` (id, libelle).
 */
class Categorie
{
    /**
     * Toutes les catégories, dans l'ordre de création.
     */
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT id, libelle FROM Categorie ORDER BY id ASC'
        );
        return $stmt->fetchAll();
    }

    /**
     * Retrouve une catégorie par son identifiant.
     */
    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id, libelle FROM Categorie WHERE id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $categorie = $stmt->fetch();

        return $categorie ?: null;
    }
}
