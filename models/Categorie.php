<?php
class Categorie
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT id, libelle FROM Categorie ORDER BY id ASC'
        );
        return $stmt->fetchAll();
    }

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
