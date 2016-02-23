# Search API

[![Build Status](https://travis-ci.org/gios-asu/search-api.svg?branch=develop)](https://travis-ci.org/gios-asu/search-api) [![Coverage Status](https://coveralls.io/repos/gios-asu/search-api/badge.svg?branch=develop&service=github)](https://coveralls.io/github/gios-asu/search-api?branch=develop)

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
Make sure to add this line to your `config.conf`:
`TestSolrApiUrl=http://jilliantessa.me:8983/solr/gios-dev/select`
This will be the url to the Solr server the test will use.

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
composer dump-autoload
```
This will regenerate the class auto-loader which does dependency mapping and creates static load order in the vendor folder.


# Configuration
See `config.conf.example` for example configuration.

 * `SolrApiUrl=http://127.0.0.1:8983/solr/gios/select` specifies the SOLR endpoint URL.
 * `TestSolrApiUrl=http://jilliantessa.me:8983/solr/gios-dev/select`  specifies the SOLR endpoint URL used in tests.
 * `StanfordNerPath=lib/stanford-ner-2015-04-20/` specifies target path for Stanford's NER library.
