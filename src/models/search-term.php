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
 * @var $is_user_input bool        TRUE if term is a user-specified keyword, FALSE if it is not
 */
class SearchTerm {
  public $value;
  public $category;
  public $related;
  public $count;
  public $is_user_input;

  function __construct( $value = null, $category = null, $related = null, $count = null, $is_user_input = null ) {
    $this->value = $value;
    $this->category = $category;
    $this->related = $related;
    $this->count = $count;
    $this->is_user_input = $is_user_input;
  }
}
