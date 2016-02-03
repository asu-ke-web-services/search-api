<?php

namespace SearchApi\Models;

/**
 * Class Keyword - This defines a searched keyword and its type
 *
 * @var     $text       string  The actual keyword
 * @var     $type       string  The type of info the keyword represents
 * @var     $relevance  double  The improtance of the keyword (0.0 - 1.0)
 */
class Keyword {
  public $text;
  public $type;
  public $relevance;

  function __construct( $text, $type, $relevance ) {
    $this->text = $text;
    $this->type = $type;
    $this->relevance = $relevance;
  }
}
