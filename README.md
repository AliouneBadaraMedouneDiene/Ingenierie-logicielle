# Actualités Polytechniciennes — V1 (architecture MVC, lecture seule)

Site d'actualités : catégories dynamiques (depuis la BDD), page d'accueil filtrable par catégorie, page de détail d'article. Architecture **MVC** avec un point d'entrée unique. Base de données : `mglsi_news`.

Cette V1 est **identique à la V2** à un détail près : elle ne propose pas encore la création, la modification ou la suppression d'articles (pas d'espace d'administration). Voir la branche `main`/`v2` pour la version avec CRUD.

## Structure du projet

```
Ingenierie-logicielle/
├── config.php                 # Bootstrap : session, connexion, constantes, helpers
├── index.php                   # Front controller unique (routeur)
├── install.sql                  # Script de création de la BDD mglsi_news + données de démo
├── core/
│   ├── Database.php             # Connexion PDO (singleton)
│   └── View.php                  # Moteur de rendu (englobe une vue dans le layout)
├── models/
│   ├── Categorie.php             # Requêtes SQL sur la table `Categorie`
│   └── Article.php                # Lecture seule : all(), byCategorieId(), find()
├── controllers/
│   ├── HomeController.php         # Accueil + filtrage par catégorie
│   └── ArticleController.php       # Détail d'un article
├── views/
│   ├── layout/{header,footer}.php   # Gabarit HTML partagé
│   ├── home/index.php                # Vue accueil
│   └── article/{show,not-found}.php   # Vue détail article
└── assets/
    └── css/style.css                  # Design system (typo, couleurs, composants)
```

### Routes disponibles

| URL | Contrôleur → méthode | Rôle |
|---|---|---|
| `index.php` ou `index.php?route=home` | `HomeController::index` | Accueil, tous les articles |
| `index.php?route=home&categorie=1` | `HomeController::index` | Accueil filtré par catégorie (id) |
| `index.php?route=article&id=5` | `ArticleController::show` | Détail d'un article |

## Installation (WAMP)

1. Copie **tout le dossier** dans `C:\wamp64\www\` en conservant le nom du dossier (`BASE_URL` dans `config.php` doit correspondre exactement).
2. Démarre **WAMP** (icône verte).
3. Ouvre **phpMyAdmin** (http://localhost/phpmyadmin), onglet **SQL**, colle le contenu de `install.sql` et exécute (crée la base `mglsi_news`). Si tu as déjà cette base via la branche `v2`, inutile de la recréer.
4. Accède au site : http://localhost/Ingenierie-logicielle/ (adapte le chemin selon le nom réel du dossier).

## Fonctionnement

- **Catégories dynamiques** : la barre de navigation est générée depuis la table `Categorie` (`Categorie::all()`).
- **Filtrage** : cliquer sur une catégorie recharge l'accueil avec `?categorie=<id>`.
- **Détail d'article** : chaque carte pointe vers la route `article`, affichage en lecture seule.

## Évolutions (branche `v2`)

- Ajout d'un espace d'administration (`AdminController`) avec création, modification et suppression d'articles (CRUD complet), formulaires avec validation, jetons CSRF, messages de confirmation.
