<?php

namespace SearchApi\Providers;
use SearchApi\Models\Keyword;
use SearchApi\Services\Tagger;
use StanfordNLP\NERTagger as StanfordNERTagger;
use StanfordNLP\POSTagger as StanfordPOSTagger;
use Nectary\Configuration as Configuration;

/**
 * NerTagger - This is a tagger implementation that uses the Named Entity Recognizer and returns an array of keywords.

 * @seeAlso: http://nlp.stanford.edu/software/CRF-NER.shtml
 */
class NerTagger implements Tagger {
  private $nerTagger;
  private $posTagger;

  public function __construct() {
    // Get path to Stanford NER & POS taggers from config.
    Configuration::set_configuration_path( 'config.conf' );
    $stanford_ner_path = realpath( rtrim(
        Configuration::get_instance()->get( 'StanfordNerPath', 'lib/stanford-ner/' )
    ) );
    $stanford_pos_path = realpath( rtrim(
        Configuration::get_instance()->get( 'StanfordPosPath', 'lib/stanford-ner/' )
    ) );

    // Instantiate the tagger objects
    $this->nerTagger = new \StanfordNLP\NERTagger(
        $stanford_ner_path . '/classifiers/english.all.3class.distsim.crf.ser.gz',
        $stanford_ner_path . '/stanford-ner.jar'
    );
    $this->posTagger = new \StanfordNLP\POSTagger(
        $stanford_pos_path . '/classifiers/english-left3words-distsim.tagger',
        $stanford_pos_path . '/stanford-pos.jar'
    );

    $errors = $this->nerTagger->getErrors() + ' ' + $this->posTagger->getErrors();
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

    $errors = $this->nerTagger->getErrors() + ' ' + $this->posTagger->getErrors();
    // getErrors() shows more than just errors, so only display if 'exception' is found in text
    if ( strpos( $errors, 'Exception' ) || strpos( $errors, 'exception' ) ) {
      error_log( $errors );
    }

    return $keywords;
  }

  // Call the NER service and return its raw results
  public function get_tags( $request_string = '' ) {
    if ( empty( $request_string ) ) {
      return null;
    }

    // Tokenize the request and push it through the tagger
    $ner_tagger_results = $this->nerTagger->tag( explode( ' ', $request_string ) );
    $pos_tagger_results = $this->posTagger->tag( explode( ' ', $request_string ) );

    return $ner_tagger_results;
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
      array_push( $keywords, new Keyword( $result[0], $result[1], 0.5 ) );
    }

    return $keywords;
  }
}
