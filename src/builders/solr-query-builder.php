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
   * @param SearchTerm[]|null $search_terms Search terms to search
   * @param SearchApi\Models\SearchOptions|null $options Query options
   */
  function build( $search_terms, $options = null ) {
    $keyword_strings = '';

    assert( gettype( $options ) === 'NULL' || gettype( $options ) === 'object' );

    foreach ( $search_terms as &$word ) {
      $keyword_strings = $keyword_strings . urlencode($word->value) . ' ';
    }

    return '?df=collector&indent=on&q=' . $keyword_strings . '&wt=json';
  }
}
