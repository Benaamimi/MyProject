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

## Lancer des tests

```bash
php bin/phpunit --testdox
```
