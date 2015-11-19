<?php

namespace SearchApi\Services;

/**
 * Interface Search - Should make a search query and return the search results as an object
 *
 * @method SearchResult query (SearchTerm[]|null $keywords, SearchApi\Models\SearchOptions|null $options)
 *   Make a search query with options for pagination, sorting, etc.
 */
interface Search {
  function query( $keywords, $options = null );
}
