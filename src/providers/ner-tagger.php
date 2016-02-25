<?php

namespace SearchApi\Providers;
use SearchApi\Models\Keyword;
use SearchApi\Services\Tagger;
use StanfordNLP\NERTagger as StanfordNERTagger;
use Nectary\Configuration as Configuration;

/**
 * NerTagger - This is a tagger implementation that uses the Named Entity Recognizer and returns an array of keywords.

 * @seeAlso: http://nlp.stanford.edu/software/CRF-NER.shtml
 */
class NerTagger implements Tagger {
  private $tagger;

  public function __construct() {
    // Get path to Stanford NER from config.
    Configuration::set_configuration_path( 'config.conf' );
    $stanfordNerPath = realpath( rtrim(
        Configuration::get_instance()->get( 'StanfordNerPath', 'lib/stanford-ner/' )
    ) );

    // Instantiate the tagger object
    $this->tagger = new \StanfordNLP\NERTagger(
        $stanfordNerPath . '/classifiers/english.all.3class.distsim.crf.ser.gz',
        $stanfordNerPath . '/stanford-ner.jar'
    );
  }

  // Convert a search string into an array of Keyword objects
  public function tagger_service( $request_string = '' ) {
    // Call the NER Tagger service
    $tagger_results = $this->get_tags( $request_string );
    // Convert results into keywords
    $keywords = $this->results_to_keywords( $tagger_results );

    return $keywords;
  }

  // Call the NER service and return its raw results
  public function get_tags( $request_string = '' ) {
    if ( empty( $request_string ) ) {
      return null;
    }

    // Tokenize the request and push it through the tagger
    // TO-DO: find new ways to tokenize the search string
    $tagger_results = $this->tagger->tag( explode( ' ', $request_string ) );

    return $tagger_results;
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
    // TO-DO: implement relevance
    foreach ( $tagger_results as $result ) {
      array_push( $keywords, new Keyword( $result[0], $result[1], 1.0 ) );
    }

    return $keywords;
  }
}
