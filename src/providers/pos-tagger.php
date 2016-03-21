<?php

namespace SearchApi\Providers;
use SearchApi\Models\Keyword;
use SearchApi\Services\Tagger;
use StanfordNLP\POSTagger as StanfordPOSTagger;
use Nectary\Configuration as Configuration;

/**
 * PosTagger - This is a tagger implementation that uses the Part-Of-Speech tagger and returns an array of keywords.
 *             This implementation will filter tagged words so only NOUNS are returned!
 * @seeAlso: Stanford Log-Linear POS Tagger http://nlp.stanford.edu/software/tagger.html
 */
class PosTagger implements Tagger {
  /**
   * Constructor with required param
   *
   * @param string $stanfordPosTaggerPath Root path of Stanford POS tagger library
   */
  function __construct( $stanford_pos_tagger_path ) {
    $path = realpath( rtrim( $stanford_pos_tagger_path ) );
    $this->pos = new \StanfordNLP\POSTagger(
        $path . '/models/english-left3words-distsim.tagger',
        $path . '/stanford-postagger.jar'
    );
  }

  function tagger_service ( $request_string = '' ) {

    $result = $this->pos->tag(explode(' ', $request_string));
    return $result;
  }
}
