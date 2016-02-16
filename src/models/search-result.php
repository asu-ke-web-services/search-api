<?php

namespace SearchApi\Models;

/**
 * Class SearchResult - This will be the class that defines the response to a search
 *
 * @var $results Models\SearchResultItem[]|null Should contain objects representing search results.
 * @var $count int Should contain the number of entries in $results
 * @var $originalRequest Models\SearchRequest The original search request
 */
class SearchResult {
  public $results;
  public $count = 0;
  public $originalRequest;
}

