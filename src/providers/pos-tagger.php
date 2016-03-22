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

  function tagger_service( $request_string = '' ) {
    $tagger_results = $this->pos->tag( explode( ' ', $request_string ) );

    // Return null if there are no results
    if ( empty( $tagger_results ) ) {
      return null;
    }

    // Output of pos-> tag is a nested array. Output is split by sentences, so let's
    // flatten the array because we only care about the tagged words, not the sentences.
    $flattened_results = array();
    foreach ( $tagger_results as $result ) {
      $flattened_results = array_merge( $flattened_results, $result );
    }
    // Next, let's make a list of unique words found.
    $found_words = array();
    array_walk_recursive( $tagger_results, function( $a ) use ( &$found_words ) {
        if ( strlen( $a ) > 1 )
            $found_words[] = $a;
    } );
    $found_words = array_unique( $found_words );

    // Now, let's use the list of unique words to build a new array with results for unique words.
    // While we're at it, let's filter by noun phrases too (NN*)
    $tagged_words = array();
    foreach ( $found_words as $word ) {
      foreach ( $flattened_results as $tagged_word ) {
        if ( $tagged_word[0] === $word && strpos( $tagged_word[1], 'NN' ) !== false ) {
          $tagged_words[] = array( $word, $tagged_word[1] );
        }
      }
    }

    $keywords = array();

    foreach ( $tagged_words as $result ) {
      array_push( $keywords, new Keyword( $result[0], 'NOUN', null ) );
    }

    return $keywords;
  }
}
