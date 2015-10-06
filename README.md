# Search API

[![Build Status](https://travis-ci.org/gios-asu/search-api.svg)](https://travis-ci.org/gios-asu/search-api) [![Coverage Status](https://coveralls.io/repos/gios-asu/search-api/badge.svg?branch=develop&service=github)](https://coveralls.io/github/gios-asu/search-api?branch=develop)

Search API for documents, data, research, people, etc


# Getting Started
* Install PHP and Composer
* then Run:
```
composer install
```
To run the unit tests:
```
phpunit
```



# Developing the Search API
If you add a new class (or rename a class) file in the ```src``` folder you will need to run
```
composer update
```
This will regenerate the class auto-loader which does dependency mapping and creates static load order in the vendor folder.


