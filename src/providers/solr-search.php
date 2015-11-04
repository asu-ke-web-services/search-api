<?php

namespace SearchApi\Providers;

use SearchApi\Services\Search;
use SearchApi\Models\SearchTerm;
use SearchApi\Models\SearchResult;
use SearchApi\Models\SearchOptions;

use SearchApi\Builders\QueryBuilder;
use SearchApi\Builders\SolrQueryBuilder;

/**
 * Class SolrSearch - This is a placeholder class that will be an interface to a Solr Search Index
 *
 * @var QueryBuilder queryBuilder Obj with implementation of QueryBuilder constructing Solr-specific query string.
 * @method SearchResult query (SearchTerm[]|null $keywords, SearchOptions|null options) Interface defined in Services\Search
 */
class SolrSearch implements Search {

  private $queryBuilder;

  /**
   * Constructor
   *
   * @param queryBuilder QueryBuilder Should be able to inject dependency to use any solr-specific impl. of QueryBuilder
   */
  function __construct( QueryBuilder $queryBuilder = null ) {
    if ( $queryBuilder ) {
      $this->queryBuilder = $queryBuilder;
    } else {
      $this->queryBuilder = new SolrQueryBuilder();
    }
  }

  function query( $keywords, $options = null ) {
    // This is just a placeholder
    if ( $keywords === null ) {
      return null;
    }

    $queryString = $this->queryBuilder->build_query( $keywords, $options );

    // do something with query string

    return new SearchResult();
  }
}
