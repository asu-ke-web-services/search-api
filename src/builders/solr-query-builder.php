<?php

namespace SearchApi\Builders;

use SearchApi\Builders\QueryBuilder;

/**
 * Class SolrQueryBuilder - Responsible for building a query string for SolrSearch.
 *
 * @method string build_query (SearchTerm[]|null $keywords, SearchApi\Models\SearchOptions|null)
 *   Build a query string from provided search terms and search options
 */
class SolrQueryBuilder implements QueryBuilder {
  function build_query( $keywords, $options = null ) {
    return null;
  }
}
