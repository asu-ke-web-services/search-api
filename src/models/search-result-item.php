<?php

namespace SearchApi\Models;

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