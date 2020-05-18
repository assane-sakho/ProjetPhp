---

# Projet php - Dépôt de candidature

Assane Sakho

cf. Documentation du projet <http://assanesakho.fr/documentation/ProjetPhp.pdf>


Lien du projet <http://projetphp.assanesakho.fr>

## Installation

cf. Documentation de Laravel 7 <https://laravel.com/docs/7.x/installation#installation>

Cloner le dépôt

    git clone https://github.com/assane-sakho/ProjetPhp.git

Rendez vous dans le dossier du dépôt

    cd projetPhp

Instaler toutes les dépenndances du projet via composer

    composer install

Copier l'exemple de fichier de configuration .env.exemple en .env et renseigner les informations de connection à la base de données

    cp .env.example .env

Générer une nouvelle clé pour l'application

    php artisan key:generate

Renseigner les informations de connexion à la base de données

-   `DB_CONNECTION=mysql` - Type de base (Ici: MySQL)
-   `DB_HOST=localhost` - Hote (Ex: localhost)
-   `DB_PORT=3306` - Port de connexion (Ex: 3306)
-   `DB_DATABASE=registrations` - Nom de la base de données (Ex: registrations)
-   `DB_USERNAME=root` - Utilisateur ( Ex: root)
-   `DB_PASSWORD` - Mot de passe de la base

Lancer une migration pour créer la base et insérer les données requises

    php artisan migrate

Définir l'administrateur de l'application

-   `APP_ADMIN=admin@parisnanterre.fr`

Définir où seront stockés les fichiers

-   `APP_SOURCE_DISK=local` - Les fichiers seront stockés en local

OU

-   `APP_SOURCE_DISK=s3` - Les fichiers seront stockés sur Amazon S3
-   `AWS_ACCESS_KEY_ID=VOTRE_CLE_D_ACCESS`
-   `AWS_SECRET_ACCESS_KEY=VOTRE_CLE_D_ACCES_SECRETE`
-   `AWS_DEFAULT_REGION=eu-west-3`
-   `AWS_BUCKET=NOM_DU_BUCKET`

Lancer le projet

    php artisan serve

Vous pouvez accéder au serveur à l'adresse http://localhost:8000

**Résumé**

    https://github.com/assane-sakho/ProjetPhp.git
    cd projetPhp
    composer install
    cp .env.example .env
    php artisan key:generate

**Renseigner les informations de connexion à la base de données puis**

    php artisan migrate
    php artisan serve

---

# Détails du code

## Dossiers

-   `app` - Contient les models Eloquent
-   `app/Http/Middleware` - Contains les middleware (par exemple pour l'authentification)
-   `app/Http/Controllers` - Contient les controllers
-   `app/Http/Composers` - Contient les composeurs de vues
-   `app/Helpers` - Contient les helpers/services
-   `resources/views` - Contient les vues
-   `config` - Contient les fichiers de configurations de l'application
-   `database/migrations` - Contient les migrations pour la base de données
-   `database/seeds` - Contient les seeds pour insérer des données après une migration
-   `routes` - Contient les routes
-   `storage/app/registrations` - Contient temporairement les candidatures zipées
-   `storage/app/uploads` - Contient les candidatures des candidat, chaque candidat possède un dossier intitulé par son ID (Ex: storage/app/uploads/12)

## Jeu d'essai

Jeu d'essai de connexion à la base de données

| **Identifiant**              | **Mot de passe** | **Type d'utilisateur** |
| ---------------------------- | ---------------- | ---------------------- |
| admin@parisnanterre.fr       | admin            | Administrateur         |
| &nbsp;                       | &nbsp;           | &nbsp;                 |
| professeur@parisnanterre.fr  | professeur       | Professeur             |
| &nbsp;                       | &nbsp;           | &nbsp;                 |
| BrunellaBourgouin@rhyta.com  | yoCh7choo        | Candidat               |
| FanchonMainville@armyspy.com | ohXie9baeX8      | Candidat               |
| EricTanguay@gmail.com        | hooWixee7oh      | Candidat               |
| NicanorIsayev@gmail.com      | ahwohj4oCh       | Candidat               |
