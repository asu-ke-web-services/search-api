<?php

namespace SearchApi\Models;

/**
 * Class Keyword - This defines a searched keyword and its type
 *
 * @var	$text		string	The actual keyword
 * @var	$type		string	The type of info the keyword represents
 * @var	$relevance	double	The improtance of the keyword (0.0 - 1.0)
 */
class Keyword {
  public $text;
  public $type;
  public $relevance;

  function __construct( $a1, $a2, $a3 ) {
    $this->text = $a1;
    $this->type = $a2;
    $this->relevance = $a3;
  }
}
