<?php

namespace SearchApi\Providers;

use SearchApi\Services\Search;

/**
 * Class SolrSearch - This is a placeholder class that will be an interface to a Solr Search Index
 */
class SolrSearch implements Search {

  function query( $query_text ) {
    // This is just an placeholder
    return array( $query_text );
  }
}
