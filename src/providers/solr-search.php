<?php

namespace SearchApi\Providers;

use SearchApi\Services\Search;
use SearchApi\Models\SearchTerm;
use SearchApi\Models\SearchResult;
use SearchApi\Models\SearchOptions;

/**
 * Class SolrSearch - This is a placeholder class that will be an interface to a Solr Search Index
 *
 * @method SearchResult query (SearchTerm[]|null $keywords, SearchOptions|null) Interface defined in Services\Search
 */
class SolrSearch implements Search {

  function query( $keywords, $options = null ) {
    // This is just a placeholder
    if ( $keywords === null ) {
      return null;
    }

    $results = array();
    $searchResult = new SearchResult();

    foreach ( $keywords as $term ) {
      array_push( $results, $term );
    }

    $searchResult->results = $results;
    $searchResult->count = count( $results );

    return $searchResult;
  }
}
