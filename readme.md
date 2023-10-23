# MonProjet

MonProjet est un site internet présentant des peintures

## Environnement de développement

### Pré-requis

* PHP 8.2
* Composer
* Symfony CLI
* Docker
* Docker-Composer
* nodejs et npm

Vous pouvez vérifier les prérequis (sauf Docker_composer) avec la commande suivante (de la CLI Symfont) :

```bash
symfony check:requirements
```

### lancer l'environnement de développement

```bash
composer install 
npm install
npm run build
docker-composer up -d
symfony serve -d
```

### Ajouter des données de tests
```bash
composer require --dev orm-fixtures
composer require fakerphp/faker
composer require bluemmb/faker-picsum-photos-provider ^2.0
 symfony console d:f:l
```
## Lancer des tests

```bash
php bin/phpunit --testdox
```
