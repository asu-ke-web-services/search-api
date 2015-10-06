<?php

namespace SearchApi;
use SearchApi\Models as Models;

/**
 *
 */
class SearchEngine {
  
  public function handle_request ( Models\SearchRequest $request ) {
    return new Models\SearchResult();
  }

}