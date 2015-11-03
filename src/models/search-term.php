<?php

namespace SearchApi\Models;

/**
 * Class SearchTerm - A search term is a basic unit that will be used to build a query for
 * Search providers.
 */
class SearchTerm {
  public $value;          // (string)     This will be a keyword from NerTagger, location from ReverseGeocoder, etc.
  public $category;       // (string)     Category as string: 'location', 'person', 'organization', etc.
  public $related;        // (string[])   Array of related keywords
  public $count;          // (int)        Occurences of keyword
  public $isUserInput;    // (bool)       TRUE if term is a user-specified keyword, FALSE if it is not

  function __construct( $value, $category, $related, $count, $isUserInput ) {
    $this->value = $value;
    $this->category = $category;
    $this->related = $related;
    $this->count = $count;
    $this->isUserInput = $isUserInput;
  }
}
