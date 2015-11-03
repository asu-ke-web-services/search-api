<?php

namespace SearchApi\Services;

/**
 * Class Search - Should make a search query and return the search results as an object
 *
 * @method SearchResult query (SearchTerm[]|null $keywords, SearchApi\Models\SearchOptions|null)
 *   Make a search query with options for pagination, sorting, etc.
 */
interface Search {
  function query( $keywords, $options = null );
}
