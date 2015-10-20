<?php
/**
 * Search Engine Unit test
 */
namespace SearchApi\Test\Unit;

use SearchApi;

/**
 * Search_Engine_Test - Unit test for the search engine (lower level functions)
 */
class Search_Engine_Test extends \PHPUnit_Framework_TestCase {

  public function test_that_the_class_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\SearchEngine' ) );
  }
}
