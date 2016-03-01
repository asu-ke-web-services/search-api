<?php

namespace SearchApi\Models;

/**
 * Class Keyword - This defines a searched keyword and its type
 *
 * @var     $text       string  The actual keyword
 * @var     $type       string  The type of info the keyword represents
 * @var     $relevance  double  The improtance of the keyword (0.0 - 1.0)
 * @var	    $occurences int	The number of times a tagged word occured in the search text
 */
class Keyword {
  public $text;
  public $type;
  public $relevance;
  public $occurences;

  function __construct( $text, $type, $relevance, $occurences ) {
    $this->text = $text;
    $this->type = $type;
    $this->relevance = $relevance;
    $this->occurences = $occurences;
  }
}
