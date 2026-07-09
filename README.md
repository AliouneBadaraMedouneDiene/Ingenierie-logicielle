# Actualités Polytechniciennes — V1

Site d'actualités de l'ESP : menus dynamiques (depuis la BDD), page d'accueil filtrable par rubrique, page de détail d'article.

## Structure du projet

```
actuesp/
├── config.php              # Connexion PDO à MySQL
├── index.php                # Accueil + filtrage par menu (?menu=slug)
├── article.php               # Détail d'un article (?id=...)
├── install.sql                # Script de création de la BDD + données de démo
├── includes/
│   ├── header.php             # <head>, en-tête, menu dynamique
│   └── footer.php               # Pied de page, fermeture HTML
└── assets/
    ├── css/style.css             # Feuille de style
    └── img/                        # Images des articles (optionnel)
```

## Installation (XAMPP)

1. Copie le dossier `actuesp` dans `C:\xampp\htdocs\`.
2. Démarre **Apache** et **MySQL** depuis le panneau de contrôle XAMPP.
3. Ouvre **phpMyAdmin** (http://localhost/phpmyadmin), onglet **SQL**, et exécute le contenu de `install.sql`.
4. Vérifie les identifiants dans `config.php` si besoin (utilisateur `root`, mot de passe vide par défaut).
5. Accède au site : http://localhost/actuesp/

## Fonctionnement

- **Menus dynamiques** : la barre de navigation est générée depuis la table `menus` (colonnes `nom`, `slug`, `ordre`).
- **Filtrage** : cliquer sur un menu recharge `index.php?menu=<slug>`, qui filtre les articles via une jointure SQL sur `menu_id`.
- **Détail d'article** : chaque carte pointe vers `article.php?id=<id>`, qui affiche le contenu complet.

## Évolutions possibles

- Interface d'administration (CRUD).
- Recherche par mot-clé, pagination.
- Architecture MVC (voir branche `v2`).
