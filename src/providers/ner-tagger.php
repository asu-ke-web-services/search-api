<?php

namespace SearchApi\Providers;
use SearchApi\Models\Keyword;
use SearchApi\Services\Tagger;
use SearchApi\Services\StanfordNLP\NERTagger as StanfordNERTagger;

/**
 * NerTagger - This is a tagger implementation that uses the Named Entity Recognizer and returns an array of keywords.
 * @seeAlso: http://nlp.stanford.edu/software/CRF-NER.shtml
 */
class NerTagger implements Tagger {
  // Convert a search string into an array of Keyword objects
  public function get_tags( $request_string = '' ) {
    // Call the NER Tagger service
    $tagger_results = $this->call_tagger_service( $request_string );
    // Parse the service results
    $parsed_results = $this->parse_tagger_results( $tagger_results );
    // Convert results into keywords
    $keywords = $this->result_to_keyword( $parsed_results );

    return $keywords;
  }

  // Call the NER service and save results as a string containing an XML document
  public function call_tagger_service( $request_string = '' ) {
    if ( $request_string === null || $request_string === '' ) {
      return null;
    }

    // $pos = new StanfordNERTagger ( 'SearchApi/Services/StandfordNER/classifiers/english.all.3class.distsim.crf.ser.gz', 'SearchApi/Services/StandfordNER/stanford-ner.jar' );
    // $result = $pos->tag( explode (' ', $request_string ) );

    return '<wi num="0" entity="O">phoenix</wi> <wi num="1" entity="O">arizona</wi>';
  }

  // Parse the tagger results into an array of terms
  public function parse_tagger_results( $tagger_results = '' ) {
    if ( $tagger_results === null || $tagger_results === '' ) {
      return null;
    }

    // Replace using SimpleXML?
    $parsed_results = array();
    $substring = '';
    $offset = 0;
    $pos = strpos( $tagger_results, '</wi>', $offset );

    while ( $pos !== false ) {
      $pos = $pos + 5;
      $substring = substr( $tagger_results, $offset, $pos - $offset );
      array_push( $parsed_results, $substring );
      if ( $pos + 1 < strlen( $tagger_results ) ) {
        $offset = $pos + 1;
        $pos = strpos( $tagger_results, '</wi>', $offset );
      } else {
        $pos = false;
      }
    }

    return $parsed_results;
  }

  // Interpret the XML nodes to Keyword objects
  public function result_to_keyword( $parsed_results = '' ) {
    if ( $parsed_results === null || $parsed_results === '' ) {
      return null;
    }

    $keywords[] = new Keyword( 'phoenix', 'location', 1.0 );
    $keywords[] = new Keyword( 'arizona', 'location', 1.0 );

    return $keywords;
  }
}
