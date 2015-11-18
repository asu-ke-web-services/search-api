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
    // TODO: This is just a placeholder
    return '?q=collector%3Aurbanization&wt=json&indent=true';
  }
}
