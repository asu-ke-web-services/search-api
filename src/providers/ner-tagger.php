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
  // Convert a search string into an array of Keyword objects
  public function tagger_service( $request_string = '' ) {
    // Call the NER Tagger service
    $tagger_results = $this->get_tags( $request_string );
    // Convert results into keywords
    $keywords = $this->results_to_keywords( $tagger_results );

    $keywords = $this->condense_keywords( $keywords );

    return $keywords;
  }

  // Call the NER service and save results as a string containing an XML document
  public function get_tags( $request_string = '' ) {
    if ( empty( $request_string ) ) {
      return null;
    }

    // Get path to Stanford NER from config.
    // TODO: Configuration path in constructor (?)
    Configuration::set_configuration_path( 'config.conf' );
    $stanfordNerPath = realpath( rtrim(
        Configuration::get_instance()->get( 'StanfordNerPath', 'lib/stanford-ner/' )
    ) );

    $tagger = new \StanfordNLP\NERTagger(
        $stanfordNerPath . '/classifiers/english.all.3class.distsim.crf.ser.gz',
        $stanfordNerPath . '/stanford-ner.jar'
    );

    // Explode the request and push it through the tagger
    $tagger_results = $tagger->tag( explode( ' ', $request_string ) );

    return $tagger_results;
  }

  // Interpret the tagger results into Keyword objects
  public function results_to_keywords( $tagger_results ) {
    // Return null if there are no results
    if ( empty( $tagger_results ) ) {
      return null;
    }

    // This works properly, but does not handle 'relevance' yet (temporary)
    $keywords = array();

    foreach ( $tagger_results as $result ) {
      array_push( $keywords, new Keyword( $result[0], $result[1], 1.0, 1 ) );
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
    for ( $i = 0; $i < count( $keywords ) -1 ; $i++ ) {
      if ( strcmp( $keywords[ $i ]->text, $keywords[ $i + 1 ]->text ) === 0 ) {
        $keywords[ $i ]->occurences++;
        unset( $keywords[ $i + 1 ] );
        $keywords = array_values( $keywords );
        $i--;
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
