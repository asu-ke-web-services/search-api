<?php

namespace SearchApi\Models;

/**
 * Class SearchTerm - A search term is a basic unit that will be used to build a query for
 * Search providers.
 *
 * @var $value       string      This will be a keyword from NerTagger, location from ReverseGeocoder, etc.
 * @var $category    string      'location', 'person', 'organization', etc.
 * @var $related     string[]    Array of related keywords
 * @var $count       int         Occurences of keyword
 * @var $isUserInput bool        TRUE if term is a user-specified keyword, FALSE if it is not
 */
class SearchTerm {
  public $value;
  public $category;
  public $related;
  public $count;
  public $isUserInput;

  function __construct( $value = null, $category = null, $related = null, $count = null, $isUserInput = null ) {
    $this->value = $value;
    $this->category = $category;
    $this->related = $related;
    $this->count = $count;
    $this->isUserInput = $isUserInput;
  }
}
