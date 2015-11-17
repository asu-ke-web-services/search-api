<?php

namespace SearchApi\Providers;
use SearchApi\Models\Keyword;
use SearchApi\Services\Tagger;
use StanfordNLP\NERTagger as StanfordNERTagger;

/**
 * NerTagger - This is a tagger implementation that uses the Named Entity Recognizer and returns an array of keywords.
 * @seeAlso: http://nlp.stanford.edu/software/CRF-NER.shtml
 */
class NerTagger implements Tagger {
  // Convert a search string into an array of Keyword objects
  public function get_tags( $request_string = '' ) {
    // Call the NER Tagger service
    $tagger_results = $this->call_tagger_service( $request_string );
    // Convert results into keywords
    $keywords = $this->results_to_keywords( $tagger_results );

    return $keywords;
  }

  // Call the NER service and save results as a string containing an XML document
  public function call_tagger_service( $request_string = '' ) {
    if ( $request_string === null || $request_string === '' ) {
      return null;
    }

    $tagger_results = array(
      0 => array(
        0 => 'Phoenix',
        1 => 'LOCATION',
      ),
      1 => array(
        0 => 'Arizona',
        1 => 'LOCATION',
      ),
      2 => array(
        0 => 'Jim',
        1 => 'PERSON',
      ),
      3 => array(
        0 => 'ASU',
        1 => 'ORGANIZATION',
      ),
      4 => array(
        0 => 'November',
        1 => 'DATE',
      ),
      5 => array(
        0 => '12:00',
        1 => 'TIME',
      ),
    );

    return $tagger_results;
  }

  // Interpret the XML nodes to Keyword objects
  public function results_to_keywords( $tagger_results ) {
    if ( $tagger_results === null ) {
      return null;
    }

    for ( $count = 0; $count < count( $tagger_results ); $count++ ) {
      $keywords[] = new Keyword( $tagger_results[ $count ][0], $tagger_results[ $count ][1], 1.0 / ( $count + 1 ) );
    }

    return $keywords;
  }
}
