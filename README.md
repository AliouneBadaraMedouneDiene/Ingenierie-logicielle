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

Toute requête passe par **`index.php`** (front controller), qui lit `?route=` et `?action=` dans l'URL et appelle la méthode du **contrôleur** correspondant. Le contrôleur interroge un **modèle** (`Categorie`, `Article`) pour récupérer/écrire les données en base, puis transmet ces données à une **vue** via `View::render()`. La vue ne contient que de l'affichage — aucune requête SQL n'y est jamais faite directement.

### Schéma de la base (`mglsi_news`)

```
Categorie(id, libelle)
Article(id, titre, contenu, dateCreation, dateModification, categorie -> Categorie.id)
```

Pas de colonne `extrait`, `image` ni `auteur` : le résumé affiché sur l'accueil est généré automatiquement à partir du `contenu` via la fonction `extrait_auto()` (dans `config.php`), et `dateModification` est recalculée manuellement (`NOW()`) à chaque modification d'article puisque la table n'a pas de `ON UPDATE CURRENT_TIMESTAMP`.

### Routes disponibles

| URL | Contrôleur → méthode | Rôle |
|---|---|---|
| `index.php` ou `index.php?route=home` | `HomeController::index` | Accueil, tous les articles |
| `index.php?route=home&categorie=1` | `HomeController::index` | Accueil filtré par catégorie (id) |
| `index.php?route=article&id=5` | `ArticleController::show` | Détail d'un article |
| `index.php?route=admin` | `AdminController::list` | Liste admin des articles |
| `index.php?route=admin&action=form` | `AdminController::form` | Formulaire nouvel article |
| `index.php?route=admin&action=form&id=5` | `AdminController::form` | Formulaire modification |
| `index.php?route=admin&action=save` (POST) | `AdminController::save` | Enregistre création/modification |
| `index.php?route=admin&action=delete` (POST) | `AdminController::delete` | Supprime un article |

Tous les liens du site sont générés via l'helper `route_url()` (défini dans `config.php`), donc tu n'as jamais à écrire ces URLs à la main.

## Installation (WAMP)

1. Copie **tout le dossier** `actuesp` dans `C:\wamp64\www\` (ou `C:\wamp\www\` selon ta version — garde bien le nom `actuesp`, il correspond à la constante `BASE_URL` dans `config.php`).
2. Démarre **WAMP** et attends que l'icône dans la barre système passe au **vert** (clic droit → "Start All Services" si besoin), ce qui signifie qu'Apache et MySQL tournent tous les deux.
3. Ouvre **phpMyAdmin** (http://localhost/phpmyadmin), onglet **SQL**, colle le contenu de `install.sql` et exécute (crée la base `mglsi_news`, les tables `Categorie`/`Article`, et des données de démonstration).
   - Si la dernière ligne (`GRANT ... IDENTIFIED BY`) échoue, ignore-la ou remplace-la par les deux commandes suggérées en commentaire dans le fichier — les tables et les données sont déjà créées avant cette ligne.
4. Dans `config.php`, `DB_NAME` vaut déjà `mglsi_news` avec l'utilisateur `root` sans mot de passe (par défaut sous WAMP). Si tu préfères utiliser le compte dédié `mglsi_user` créé par le script, adapte `DB_USER`/`DB_PASS`.
5. Accède au site : http://localhost/actuesp/

> Tu migres depuis XAMPP ? Arrête complètement Apache/MySQL dans XAMPP (les deux utilisent le port 80 et le port 3306 par défaut — ils ne peuvent pas tourner en même temps) avant de démarrer WAMP, sinon WAMP restera orange/rouge.

## Fonctionnement

- **Catégories dynamiques** : la barre de navigation est générée depuis la table `Categorie` (`Categorie::all()`). Ajouter une ligne dans `Categorie` fait apparaître automatiquement un nouvel onglet.
- **Filtrage** : cliquer sur une catégorie recharge l'accueil avec `?categorie=<id>`, filtré via `Article::byCategorieId()`.
- **Détail d'article** : chaque carte pointe vers la route `article`, qui affiche le contenu complet via `Article::find()`.

## Administration (CRUD)

Accessible via le bouton **Administration** en haut à droite du site :

- **Liste** : tous les articles avec catégorie et date, boutons Modifier / Supprimer.
- **Ajouter / Modifier** : formulaire unique (`AdminController::form` / `save`) avec 3 champs — titre, catégorie, contenu — et validation serveur (titre et contenu obligatoires, catégorie valide), messages d'erreur affichés sous chaque champ.
- **Supprimer** : confirmation JavaScript avant suppression, requête POST protégée par un jeton CSRF (`AdminController::delete`).
- **Messages de confirmation** : un bandeau de succès/erreur s'affiche après chaque action (créé, modifié, supprimé).

⚠️ **Important — sécurité** : cette version n'a **pas de système de connexion/authentification**. N'importe qui connaissant l'URL peut accéder à l'espace admin. Pour un usage en production, il faut impérativement ajouter une authentification (page de login + session protégée) avant de déployer publiquement.

## Design

La feuille de style suit un système de design éditorial cohérent : typographie à deux registres (`Source Serif 4` pour les titres, `Inter` pour le texte courant), palette de couleurs sémantique (primaire bleu nuit, accent orange), échelle d'espacement régulière (8pt), composants réutilisables (boutons, badges, alertes, tableaux, formulaires), et attention à l'accessibilité (contrastes AA, focus visibles, zones tactiles ≥44px, lien d'évitement clavier). Comme la table `Article` n'a pas de colonne image, chaque carte affiche un bandeau coloré avec le nom de la catégorie en guise de vignette.

## Évolutions possibles (V3)

- Authentification pour l'espace admin (login/mot de passe).
- Gestion des catégories (CRUD) en plus des articles.
- URLs propres via `.htaccess` (`/article/5` au lieu de `?route=article&id=5`).
- Recherche par mot-clé, pagination des articles.
- Ajout d'une colonne image (upload) si le schéma évolue.
