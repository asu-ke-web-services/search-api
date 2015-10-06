<?php 
/**
 * Search Engine Unit test
 */
namespace Search_Api\Test;

use Search_Api;

class Search_Engine_App_Test extends \PHPUnit_Framework_TestCase {

  public function test_that_the_class_is_defined() {
    $this->assertTrue( class_exists( 'Search_Api\Search_Engine' ) );
  }

}