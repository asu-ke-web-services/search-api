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

/**
 * Class SearchResultItem - Defines a particular item in a search result.
 *
 * @var $id mixed Unique id of the document
 * @var $title string Title of the document
 * @var $author string[] Author(s) of the document
 * @var $date DateTime Publish date
 */
class SearchResultItem {
  public $id;
  public $title;
  public $author;
  public $date;
}
