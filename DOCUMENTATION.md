# 📚 Documentation du Projet Garage App

## 🎯 Présentation du Projet

**Garage App** est une application web de gestion de garage automobile développée avec le framework **Laravel 12**. Elle permet de gérer les véhicules, les techniciens et les réparations.

---

## 📁 Structure des Dossiers

### 🔧 Dossiers Principaux

| Dossier | Rôle |
|---------|------|
| `app/` | Contient le cœur de l'application (contrôleurs, modèles, logique métier) |
| `bootstrap/` | Initialisation de l'application Laravel |
| `config/` | Fichiers de configuration (base de données, services, etc.) |
| `database/` | Migrations, seeders et factories pour la base de données |
| `public/` | Point d'entrée web, fichiers accessibles publiquement (CSS, JS, images) |
| `resources/` | Vues Blade, fichiers CSS/JS sources |
| `routes/` | Définition des routes de l'application |
| `storage/` | Fichiers générés (logs, cache, uploads) |
| `tests/` | Tests unitaires et fonctionnels |
| `vendor/` | Dépendances PHP installées via Composer |
| `node_modules/` | Dépendances JavaScript installées via npm |

---

## 📂 Détail du Dossier `app/`

### 📌 `app/Http/Controllers/`
Les contrôleurs gèrent la logique de l'application et répondent aux requêtes HTTP.

| Fichier | Rôle |
|---------|------|
| `Controller.php` | Contrôleur de base dont héritent tous les autres |
| `HomeController.php` | Gère la page d'accueil du site |
| `AuthController.php` | Gère l'authentification (connexion, inscription, déconnexion, OAuth Google) |
| `VehiculeController.php` | CRUD complet pour la gestion des véhicules |
| `TechnicienController.php` | CRUD complet pour la gestion des techniciens |
| `ReparationController.php` | CRUD complet pour la gestion des réparations |

### 📌 `app/Models/`
Les modèles représentent les tables de la base de données et contiennent les relations.

| Fichier | Table | Rôle |
|---------|-------|------|
| `User.php` | `users` | Utilisateurs de l'application |
| `Vehicule.php` | `vehicules` | Véhicules enregistrés dans le garage |
| `Technicien.php` | `techniciens` | Techniciens du garage |
| `Reparation.php` | `reparations` | Réparations effectuées sur les véhicules |

### 📌 `app/Providers/`
Les providers enregistrent les services de l'application.

---

## 📂 Détail du Dossier `resources/views/`

Les vues utilisent le moteur de template **Blade** de Laravel.

| Dossier/Fichier | Rôle |
|-----------------|------|
| `layouts/app.blade.php` | Template principal (navbar, footer, structure HTML) |
| `home.blade.php` | Page d'accueil du site |
| `auth/login.blade.php` | Formulaire de connexion |
| `auth/register.blade.php` | Formulaire d'inscription (avec Google OAuth) |
| `vehicules/` | Vues CRUD pour les véhicules (index, create, edit, show) |
| `techniciens/` | Vues CRUD pour les techniciens (index, create, edit, show) |
| `reparations/` | Vues CRUD pour les réparations (index, create, edit, show) |

---

## 📂 Détail du Dossier `database/migrations/`

Les migrations définissent la structure des tables de la base de données.

| Fichier | Rôle |
|---------|------|
| `create_users_table.php` | Crée la table des utilisateurs |
| `create_cache_table.php` | Crée les tables de cache |
| `create_jobs_table.php` | Crée les tables pour les jobs en file d'attente |
| `create_techniciens_table.php` | Crée la table des techniciens |
| `create_vehicules_table.php` | Crée la table des véhicules |
| `create_reparations_table.php` | Crée la table des réparations |
| `add_social_login_fields_to_users_table.php` | Ajoute les champs pour la connexion OAuth |

---

## 📂 Détail du Dossier `routes/`

| Fichier | Rôle |
|---------|------|
| `web.php` | Routes web principales de l'application |
| `console.php` | Commandes Artisan personnalisées |

### Routes Définies dans `web.php`

| Route | Méthode | Contrôleur | Description |
|-------|---------|------------|-------------|
| `/` | GET | HomeController | Page d'accueil |
| `/login` | GET/POST | AuthController | Connexion |
| `/register` | GET/POST | AuthController | Inscription |
| `/logout` | POST | AuthController | Déconnexion |
| `/login/google` | GET | AuthController | Connexion OAuth Google |
| `/vehicules/*` | CRUD | VehiculeController | Gestion des véhicules |
| `/techniciens/*` | CRUD | TechnicienController | Gestion des techniciens |
| `/reparations/*` | CRUD | ReparationController | Gestion des réparations |

---

## 📄 Fichiers de Configuration Importants

| Fichier | Rôle |
|---------|------|
| `.env` | Variables d'environnement (base de données, clés API, etc.) - **NE JAMAIS PARTAGER** |
| `.env.example` | Exemple de fichier .env à copier |
| `composer.json` | Dépendances PHP du projet |
| `package.json` | Dépendances JavaScript du projet |
| `vite.config.js` | Configuration du bundler Vite pour CSS/JS |
| `config/services.php` | Configuration des services tiers (Google OAuth, etc.) |
| `config/database.php` | Configuration de la base de données |

---

## 🔐 Authentification

L'application utilise deux méthodes d'authentification :

1. **Authentification classique** : Email + Mot de passe
2. **OAuth Google** : Inscription via compte Google (package Laravel Socialite)

---

## 🛠️ Technologies Utilisées

- **Backend** : Laravel 12, PHP 8.2
- **Frontend** : Blade, Bootstrap 5, Font Awesome
- **Base de données** : MySQL
- **Authentification** : Laravel Socialite (Google OAuth)
- **Bundler** : Vite

---

## 📝 Commandes Utiles

```bash
# Démarrer le serveur de développement
php artisan serve

# Exécuter les migrations
php artisan migrate

# Créer un contrôleur
php artisan make:controller NomController

# Créer un modèle avec migration
php artisan make:model NomModele -m

# Vider le cache
php artisan cache:clear
php artisan config:clear
```

---

## 📊 Schéma de la Base de Données

```
┌─────────────┐     ┌──────────────┐     ┌──────────────┐
│   users     │     │  vehicules   │     │ techniciens  │
├─────────────┤     ├──────────────┤     ├──────────────┤
│ id          │     │ id           │     │ id           │
│ name        │     │ marque       │     │ nom          │
│ email       │     │ modele       │     │ specialite   │
│ password    │     │ immatriculation│   │ telephone    │
│ google_id   │     │ annee        │     │ email        │
│ avatar      │     │ user_id      │     │ created_at   │
│ created_at  │     │ created_at   │     │ updated_at   │
│ updated_at  │     │ updated_at   │     └──────────────┘
└─────────────┘     └──────────────┘
       │                   │
       │                   │
       └───────┬───────────┘
               │
        ┌──────────────┐
        │ reparations  │
        ├──────────────┤
        │ id           │
        │ vehicule_id  │
        │ technicien_id│
        │ description  │
        │ date_debut   │
        │ date_fin     │
        │ statut       │
        │ cout         │
        │ created_at   │
        │ updated_at   │
        └──────────────┘
```

---

**Document créé le** : 9 février 2026
