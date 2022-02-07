# Symfony

#### Initialiser le projet symfony

```
composer create-project symfony/skeleton nomDeMonProjet
```

#### Start the server

```
symfony server:start
```

#### Mises en place d'un CRUD

- Create
- Read
- Update
- Delete

#### Installation du MakerBundle

```
composer require --dev symfony/maker-bundle
```

### Créer l'entité en ligne de commande
```
php bin/console make:entity
```

Il est possible de définir les attribut directement via cette commande.

### Ajouter un nouveau controller
```
php bin/console make:controller
```

### .htacces + VarDumper

Ajout public/.htaccess
-> https://run.as/5v3zyj

Ajout VarDumper Component
-> https://run.as/97f9cv

### Module test unitaire php
```
composer require --dev symfony/phpunit-bridge phpunit/phpunit;
composer require --dev symfony/browser-kit symfony/css-selector;
```

#### Crée les test 
```
php bin/console make:test
- Choisir WebTestCase
- Ficher : CharacterControllerTest
```

### Lancer les test 
```
php bin/phpunit
```