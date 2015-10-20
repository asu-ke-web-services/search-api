# Search API

[![Build Status](https://travis-ci.org/gios-asu/search-api.svg)](https://travis-ci.org/gios-asu/search-api) [![Coverage Status](https://coveralls.io/repos/gios-asu/search-api/badge.svg?branch=develop&service=github)](https://coveralls.io/github/gios-asu/search-api?branch=develop)

Search API for documents, data, research, people, etc.
You can search by subject (keyword), person, location, or time period.


# Getting Started
* Install PHP and Composer
* Install any project dependencies via composer:
```
composer install
composer create-project wp-coding-standards/wpcs:dev-master --no-dev -n standards/wpcs
./vendor/bin/phpcs -vvv -w --config-set installed_paths '../../../standards/gios/,../../../standards/wpcs/'

```

## To run the unit and integration tests:
```
vendor/bin/phpunit
```

## To run the spec tests:
```
vendor/bin/phpspec run -c .phpspec.yml
```

## To check the coding standards:
```
vendor/bin/phpcs --standard=GIOS src test
```



# Developing the Search API
If you add a new class (or rename a class) file in the ```src``` folder you will need to run
```
composer update
```
This will regenerate the class auto-loader which does dependency mapping and creates static load order in the vendor folder.


