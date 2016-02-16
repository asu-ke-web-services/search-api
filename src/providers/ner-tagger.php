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
  public function tagger_service( $request_string = '' ) {
    // Call the NER Tagger service
    $tagger_results = $this->get_tags( $request_string );
    // Convert results into keywords
    $keywords = $this->results_to_keywords( $tagger_results );

    return $keywords;
  }

  // Call the NER service and save results as a string containing an XML document
  public function get_tags( $request_string = '' ) {
    if ( empty( $request_string ) ) {
      return null;
    }

    // This is a mock return value
    $tagger_results = array(
      [ 'Phoenix', 'LOCATION' ],
      [ 'Arizona', 'LOCATION' ],
      [ 'Jim', 'PERSON' ],
      [ 'ASU', 'ORGANIZATION' ],
      [ 'November', 'DATE' ],
      [ '12:00', 'TIME' ],
    );

    return $tagger_results;
  }

  // Interpret the XML nodes to Keyword objects
  public function results_to_keywords( $tagger_results ) {
    if ( $tagger_results === null ) {
      return null;
    }

    $keywords = array();
    // This works properly, but does not handle 'relevance' yet
    foreach ( $tagger_results as $result ) {
      $keywords[] = new Keyword( $result[0], $result[1], 1.0 );
    }

    return $keywords;
  }
}
