<?php

namespace SearchApi\Builders;

use SearchApi\Builders\QueryBuilder;

/**
 * Responsible for building a query string for SolrSearch
 */
class SolrQueryBuilder implements QueryBuilder {
  /**
   * Build a query string from provided search terms and search options
   */
  function build( $keywords, $options = null ) {
    $keywordStrings = '';

    foreach ($keywords as &$word) {
      $keywordStrings = $keywordStrings . $word->value . '%20';
    }

    return '?q=collector%3A(' . $keywordStrings . ')&wt=json&indent=true';
  }
}
