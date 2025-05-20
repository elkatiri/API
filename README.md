# E-commerce API with Laravel

Une API RESTful pour une application e-commerce construite avec Laravel et Sanctum pour l'authentification.

## Fonctionnalités

- Authentification avec Laravel Sanctum
- Gestion des catégories
- Gestion des produits avec images
- Gestion des couleurs de produits
- Gestion des commandes
- Upload et gestion des images

## Prérequis

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (pour le frontend)

## Installation

1. Cloner le repository
```bash
git clone [URL_DU_REPO]
cd [NOM_DU_PROJET]
```

2. Installer les dépendances PHP
```bash
composer install
```

3. Copier le fichier .env
```bash
cp .env.example .env
```

4. Générer la clé d'application
```bash
php artisan key:generate
```

5. Configurer la base de données dans le fichier .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Exécuter les migrations
```bash
php artisan migrate
```

7. Créer le lien symbolique pour le stockage
```bash
php artisan storage:link
```

## Utilisation de l'API

### Authentification

#### Inscription
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Connexion
```http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

### Endpoints Protégés

Tous les endpoints suivants nécessitent un token d'authentification dans le header :
```
Authorization: Bearer {your_token}
```

#### Catégories
- GET /api/categories
- POST /api/categories
- GET /api/categories/{id}
- PUT /api/categories/{id}
- DELETE /api/categories/{id}

#### Produits
- GET /api/products
- POST /api/products
- GET /api/products/{id}
- PUT /api/products/{id}
- DELETE /api/products/{id}

#### Images de Produits
- GET /api/product-images
- POST /api/product-images (multipart/form-data)
- GET /api/product-images/{id}
- PUT /api/product-images/{id}
- DELETE /api/product-images/{id}

#### Couleurs de Produits
- GET /api/product-colors
- POST /api/product-colors
- GET /api/product-colors/{id}
- PUT /api/product-colors/{id}
- DELETE /api/product-colors/{id}

#### Images de Couleurs
- GET /api/color-images
- POST /api/color-images (multipart/form-data)
- GET /api/color-images/{id}
- PUT /api/color-images/{id}
- DELETE /api/color-images/{id}

#### Commandes
- GET /api/orders
- POST /api/orders
- GET /api/orders/{id}
- PUT /api/orders/{id}
- DELETE /api/orders/{id}

## Sécurité

- Toutes les routes sont protégées par Sanctum
- Les mots de passe sont hashés
- Validation des données d'entrée
- Protection CSRF
- Limitation de taux d'API

## Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.
