<?php

namespace SearchApi\Models;

/**
 * Class TextMapper - This will be the class that defines how synonyms are structured
 * @var $word     string      The word used to look up synonyms
 * @var	$synonyms string[]    A list of synonyms
 */
class Synonym {
  public $word;
  public $synonyms;

  function __construct( $word = null, $synonyms = null ) {
    $this->word = $word;
    $this->synonyms = $synonyms;
  }
}
