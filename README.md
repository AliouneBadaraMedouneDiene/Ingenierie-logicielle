# Actualités Polytechniciennes — V2 (architecture MVC)

Site d'actualités : catégories dynamiques (depuis la BDD), page d'accueil filtrable par catégorie, page de détail d'article, et **interface d'administration (CRUD)** pour gérer les articles. Le code est organisé en **MVC** (Modèle / Vue / Contrôleur) avec un point d'entrée unique. Base de données : `mglsi_news`.

## Structure du projet

```
actuesp/
├── config.php                    # Bootstrap : session, connexion, constantes, helpers
├── index.php                      # Front controller unique (routeur)
├── install.sql                     # Script de création de la BDD mglsi_news + données de démo
├── core/
│   ├── Database.php                # Connexion PDO (singleton)
│   └── View.php                     # Moteur de rendu (englobe une vue dans le layout)
├── models/
│   ├── Categorie.php                # Requêtes SQL sur la table `Categorie`
│   └── Article.php                   # Requêtes SQL sur la table `Article` (CRUD)
├── controllers/
│   ├── HomeController.php            # Accueil + filtrage par catégorie
│   ├── ArticleController.php          # Détail d'un article
│   └── AdminController.php             # CRUD complet (liste, formulaire, save, delete)
├── views/
│   ├── layout/{header,footer}.php      # Gabarit HTML partagé
│   ├── home/index.php                   # Vue accueil
│   ├── article/{show,not-found}.php      # Vue détail article
│   └── admin/{list,form}.php              # Vues d'administration
└── assets/
    └── css/style.css                      # Design system (typo, couleurs, composants)
```

### Comment ça circule (MVC)

Toute requête passe par **`index.php`** (front controller), qui lit `?route=` et `?action=` dans l'URL et appelle la méthode du **contrôleur** correspondant. Le contrôleur interroge un **modèle** (`Categorie`, `Art