<?php

namespace SearchApi\Builders;

use SearchApi\Builders\QueryBuilder;

/**
 * Responsible for building a query string for SolrSearch
 */
class SolrQueryBuilder implements QueryBuilder {
  /**
   * Build a query string from provided search terms and search options.
   * Returns a query string for a SOLR server.
   *
   * @param SearchTerm[]|null $searchTerms Search terms to search
   * @param SearchApi\Models\SearchOptions|null $options Query options
   */
  function build( $searchTerms, $options = null ) {
    $keywordStrings = '';

    error_log( var_dump( $options ) );

    foreach ( $searchTerms as &$word ) {
      $keywordStrings = $keywordStrings . $word->value . '%20';
    }

    return '?q=collector%3A(' . $keywordStrings . ')&wt=json&indent=true';
  }
}
