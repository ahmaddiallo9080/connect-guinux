# Guinux Connect — site vitrine + boutique (Laravel 12 / MySQL)

Site public (accueil, services, boutique, fiche produit, contact) et espace d'administration
pour **ajouter, modifier, masquer et supprimer les produits**, gérer les catégories et lire
les messages reçus.

## Prérequis
- PHP 8.2 ou plus (extensions : pdo_mysql, mbstring, fileinfo, gd)
- Composer
- MySQL 8 (ou MariaDB 10.6+) — par exemple via XAMPP, Laragon ou WAMP

## Installation

```bash
cd guinux-connect
composer install
cp .env.example .env          # sous Windows : copy .env.example .env
php artisan key:generate
```

1. Créez une base vide dans MySQL (phpMyAdmin ou ligne de commande) :
   ```sql
   CREATE DATABASE guinux_connect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Ouvrez `.env` et renseignez :
   - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (votre accès MySQL)
   - `GUINUX_PHONE`, `GUINUX_WHATSAPP` (format international sans « + », ex. 224620000000), `GUINUX_EMAIL`, `GUINUX_ADDRESS`
   - `ADMIN_EMAIL` et `ADMIN_PASSWORD` (votre compte administrateur)
3. Créez les tables et les données de départ :
   ```bash
   php artisan migrate --seed
   ```
4. Lancez le site :
   ```bash
   php artisan serve
   ```
   - Site : http://localhost:8000
   - Administration : http://localhost:8000/admin

Les 11 produits créés par le seeder sont des exemples (prix indicatifs) : modifiez-les ou
supprimez-les depuis l'admin.

## Fonctionnalités
**Site public**
- Accueil animé aux couleurs du logo, services, produits mis en avant
- Boutique : filtre par catégorie, recherche, tri par prix, pagination
- Fiche produit : prix en GNF, promo barrée, stock, bouton « Commander sur WhatsApp »
- Formulaire de contact / devis (enregistré en base, anti-spam intégré)
- Bouton WhatsApp flottant, responsive mobile

**Administration** (`/admin`)
- Tableau de bord : nombre de produits, ruptures de stock, messages non lus
- Produits : ajout, modification, suppression, masquer/publier, image (glisser-déposer),
  ancien prix, stock, « mis en avant »
- Catégories : ajout, renommage, suppression
- Messages : lecture, réponse par e-mail ou WhatsApp, suppression

## Mise en ligne (hébergement mutualisé)
- Faites pointer le domaine vers le dossier `public/`.
- Dans `.env` : `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://votre-domaine`.
- Le dossier `public/uploads/products` doit être accessible en écriture (images produits).
- Les dossiers `storage/` et `bootstrap/cache/` doivent être accessibles en écriture.

## Structure utile
- `app/Http/Controllers` — pages publiques ; `Admin/` — administration
- `app/Models` — Product, Category, Message
- `database/migrations` — tables MySQL ; `database/seeders/DatabaseSeeder.php` — données de départ
- `resources/views` — gabarits Blade ; `public/css` — styles ; `public/images` — logo
