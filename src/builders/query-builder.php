<?php

namespace SearchApi\Builders;

/**
 * Interface QueryBuilder - Responsible for building a query string for search providers.
 *
 * @method string build_query (SearchTerm[]|null $keywords, SearchApi\Models\SearchOptions|null)
 *   Build a query string from provided search terms and search options
 */
interface QueryBuilder {
  function build_query( $keywords, $options = null );
}
