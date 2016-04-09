<?php

namespace SearchApi\Providers;
use SearchApi\Models\Keyword;
use SearchApi\Services\Tagger;
use StanfordNLP\NERTagger as StanfordNERTagger;
use Nectary\Configuration as Configuration;

/**
 * NerTagger - This is a tagger implementation that uses the Named Entity Recognizer and returns an array of keywords.
 *
 * @seeAlso: http://nlp.stanford.edu/software/CRF-NER.shtml
 */
class NerTagger implements Tagger {
  /**
   * Constructor with required param
   *
   * @param string $stanfordPosTaggerPath Root path of Stanford POS tagger library
   */
  function __construct( $stanford_ner_path = null ) {
    if ( ! $stanford_ner_path ) {
      $path = realpath( 'lib/stanford-ner-2015-04-20' );
    } else {
      $path = realpath( rtrim( $stanford_ner_path ) );
    }
    $this->tagger = new \StanfordNLP\NERTagger(
        $path . '/classifiers/english.all.3class.distsim.crf.ser.gz',
        $path . '/stanford-ner.jar'
    );

    $errors = $this->tagger->getErrors();
    // getErrors() shows more than just errors, so only display if 'exception' is found in text
    if ( strpos( $errors, 'Exception' ) || strpos( $errors, 'exception' ) ) {
      error_log( $errors );
    }
  }

  // Convert a search string into an array of Keyword objects
  public function tagger_service( $request_string = '' ) {
    // Call the NER Tagger service
    $tagger_results = $this->get_tags( $request_string );
    // Convert results into keywords
    $keywords = $this->results_to_keywords( $tagger_results );

    $errors = $this->tagger->getErrors();
    // getErrors() shows more than just errors, so only display if 'exception' is found in text
    if ( strpos( $errors, 'Exception' ) || strpos( $errors, 'exception' ) ) {
      error_log( $errors );
    }

    $keywords = $this->condense_keywords( $keywords );
    return $keywords;
  }

  // Call the NER service and return its raw results
  public function get_tags( $request_string = '' ) {
    if ( empty( $request_string ) ) {
      return null;
    }

    // Tokenize the request and push it through the tagger
    $tagger_results = $this->tagger->tag( explode( ' ', $request_string ) );

    // Output of tagger -> tag is a nested array. Output is split by sentences, so let's
    // flatten the array because we only care about the tagged words, not the sentences.
    $flattened_results = array();
    foreach ( $tagger_results as $result ) {
      $flattened_results = array_merge( $flattened_results, $result );
    }

    return $flattened_results;
  }

  // Interpret the tagger results into Keyword objects
  public function results_to_keywords( $tagger_results ) {
    // Return null if there are no results
    if ( empty( $tagger_results ) ) {
      return null;
    }

    // Prepare the array of keyword objects
    $keywords = array();

    // convert each term into a keyword object
    foreach ( $tagger_results as $result ) {
      array_push( $keywords, new Keyword( $result[0], $result[1], 0.5, 1 ) );
    }

    return $keywords;
  }

  // Group the keywords which contain the same text
  public function condense_keywords( $keywords ) {
    // Return null if there are no results
    if ( empty( $keywords ) ) {
      return null;
    }

    // sort keywords alphabetically
    usort( $keywords, array( $this, 'compare_text' ) );

    // group keywords if they are the same
    $num_keywords = count( $keywords );
    for ( $i = 0; $i < $num_keywords -1 ; $i++ ) {
      if ( strcmp( $keywords[ $i ]->text, $keywords[ $i + 1 ]->text ) === 0 ) {
        $keywords[ $i ]->occurences++;
        unset( $keywords[ $i + 1 ] );
        $keywords = array_values( $keywords );
        $i--;
        $num_keywords--;
      }
    }

    // sort keywords by occurences most to least
    usort( $keywords, array( $this, 'compare_occurences' ) );
    return $keywords;
  }

  public function compare_text( $keyword1, $keyword2 ) {
    return strcmp( $keyword1->text, $keyword2->text );
  }

  public function compare_occurences( $keyword1, $keyword2 ) {
    return $keyword2->occurences - $keyword1->occurences;
  }
}
