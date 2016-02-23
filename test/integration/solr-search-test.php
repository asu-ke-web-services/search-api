<?php
/**
 * Solr Search integration test
 */
namespace SearchApi\Test\Unit;

use SearchApi;
use SearchApi\Providers\SolrSearch;
use SearchApi\Models;

use Nectary\Configuration as Configuration;

/**
 * SolrSearch_Integration_test - Integration test for SOLR search
 */
class SolrSearch_Integration_test extends \PHPUnit_Framework_TestCase {
  private function get_solr_search() {
    Configuration::set_configuration_path( 'config.conf' );
    $apiPath = trim( Configuration::get_instance()->get( 'TestSolrApiUrl' ) );

    return new SolrSearch( null, null, $apiPath );
  }

  private function create_searchterms_from_array( $keywords_as_string ) {
    $search_terms = array();
    foreach ( $keywords_as_string as &$word ) {
      array_push( $search_terms, new Models\SearchTerm( $word, null, null, 1, true ) );
    }
    return $search_terms;
  }

  public function test_solr_returns_one_result_for_unique_keyword() {
    $solr = $this->get_solr_search();

    $user_words = array( 'reification' );
    $search_terms = $this->create_searchterms_from_array( $user_words );

    $results = $solr->query( $search_terms );

    $this->assertTrue( count( $results ) === 1 );
  }

  public function test_solr_returns_no_result_for_nothing() {
    $solr = $this->get_solr_search();

    $user_words = array();
    $search_terms = $this->create_searchterms_from_array( $user_words );

    $results = $solr->query( $search_terms );

    $this->assertTrue( count( $results ) === 0 );
  }

  public function test_solr_returns_multiple_results_for_common_words() {
    $solr = $this->get_solr_search();

    $user_words = array( 'arid', 'environment' );
    $search_terms = $this->create_searchterms_from_array( $user_words );

    $results = $solr->query( $search_terms );

    $this->assertTrue( count( $results ) > 1 );
  }
}
