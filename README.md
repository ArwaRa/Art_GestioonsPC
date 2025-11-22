# ArtConnect - Plateforme de Gestion de Projets Artistiques

ArtConnect est une plateforme web complète développée avec Symfony 7.2 qui permet de gérer des projets artistiques, des artistes et des catégories. Le système propose un back-office d'administration et un front-office pour l'affichage public.

## 🎨 Fonctionnalités

### Front-Office (Public)
- **Page d'accueil** : Slogan attractif, galerie de projets récents et artistes en vedette
- **Galerie de projets** : Affichage de tous les projets avec filtrage par catégorie
- **Détails d'un projet** : Vue complète avec description, artiste, catégorie et projets similaires
- **Liste des artistes** : Présentation de tous les artistes avec leurs informations
- **Profil d'artiste** : Biographie complète et portfolio de projets

### Back-Office (Administration)
- **Dashboard** : Vue d'ensemble avec statistiques et projets récents
- **CRUD Projets** : Gestion complète des projets artistiques
- **CRUD Artistes** : Gestion des artistes avec upload de photos de profil
- **CRUD Catégories** : Organisation des projets par catégorie
- **CRUD Utilisateurs** : Gestion des comptes administrateurs

## 🛠️ Technologies utilisées

- **Symfony 7.2** : Framework PHP
- **Doctrine ORM** : Gestion de la base de données
- **Twig** : Moteur de templates
- **Bootstrap 5.3** : Framework CSS
- **Font Awesome 6.4** : Icônes
- **MySQL/PostgreSQL** : Base de données

## 📋 Structure du projet

### Entités
- **Project** : Titre, description, image, date de création, relations avec Artist et Category
- **Artist** : Nom, biographie, email, site web, photo de profil
- **Category** : Nom, description
- **User** : Username, email, mot de passe, rôles

### Architecture MVC
- **Controllers** :
  - Front-Office : `HomeController`, `ProjectController`, `ArtistController`
  - Back-Office : `Admin\AdminDashboardController`, `Admin\AdminProjectController`, etc.
- **Forms** : `ProjectType`, `ArtistType`, `CategoryType`, `UserType`
- **Templates** :
  - Base layouts : `base.html.twig`, `admin/base.html.twig`
  - Front-Office : Templates pour l'accueil, projets et artistes
  - Back-Office : Templates CRUD complets pour toutes les entités

## 🚀 Installation

1. **Cloner le repository**
```bash
git clone <repository-url>
cd ArtConnect
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer la base de données**
Éditer le fichier `.env` et configurer la variable `DATABASE_URL` :
```
DATABASE_URL="mysql://user:password@127.0.0.1:3306/artconnect?serverVersion=8.0.32&charset=utf8mb4"
```

4. **Créer la base de données et exécuter les migrations**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Créer un utilisateur administrateur (optionnel)**
```bash
php bin/console doctrine:fixtures:load
```

6. **Lancer le serveur de développement**
```bash
symfony server:start
# ou
php -S localhost:8000 -t public/
```

## 📁 Structure des dossiers

```
ArtConnect/
├── src/
│   ├── Controller/
│   │   ├── Admin/          # Contrôleurs du back-office
│   │   ├── HomeController.php
│   │   ├── ProjectController.php
│   │   └── ArtistController.php
│   ├── Entity/             # Entités Doctrine
│   ├── Form/               # Types de formulaires
│   └── Repository/         # Repositories Doctrine
├── templates/
│   ├── admin/              # Templates back-office
│   ├── home/               # Page d'accueil
│   ├── project/            # Templates projets
│   ├── artist/             # Templates artistes
│   └── base.html.twig      # Layout de base
├── public/
│   └── uploads/            # Fichiers uploadés
│       ├── projects/       # Images de projets
│       └── artists/        # Photos d'artistes
└── migrations/             # Migrations de base de données
```

## 🔐 Accès

- **Front-Office** : http://localhost:8000/
- **Back-Office** : http://localhost:8000/admin

## 🎨 Design

L'application utilise un design moderne avec :
- Palette de couleurs : Dégradés violet/indigo (#6366f1, #8b5cf6)
- Interface responsive avec Bootstrap 5
- Animations et transitions CSS
- Cards avec effets hover
- Navigation intuitive

## 📝 Fonctionnalités à venir

- Système d'authentification complet
- Gestion des commentaires sur les projets
- Système de likes/favoris
- Recherche avancée
- Export de projets en PDF
- Galerie d'images multiples par projet
- API REST pour les applications mobiles

## 👨‍💻 Développement

Le projet suit les bonnes pratiques Symfony :
- Architecture MVC stricte
- Validation des formulaires
- Gestion des erreurs
- Upload sécurisé de fichiers
- Protection CSRF
- Code propre et documenté

## 📄 Licence

Ce projet est sous licence MIT.

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou une pull request.

---

**ArtConnect** - Connecter les artistes et leurs créations 🎨