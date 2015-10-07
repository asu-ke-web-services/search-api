<?php 
/**
 * Search Engine Unit test
 */
namespace SearchApi\Test\Unit;

use SearchApi;

class Search_Engine_App_Test extends \PHPUnit_Framework_TestCase {

  public function test_that_the_class_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\SearchEngine' ) );
  }

}