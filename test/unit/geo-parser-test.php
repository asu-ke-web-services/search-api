<?php
/**
 * Search Engine Unit test
 */
namespace SearchApi\Test\Unit;

use SearchApi;

/**
 * Reverse_Geocoder_Test - Unit test for the geo parser (lower level functions)
 */
class Geo_Parser_Test extends \PHPUnit_Framework_TestCase {

  public function test_that_the_class_Geo_Parser_is_defined() {
  	$this->assertTrue( class_exists( 'SearchApi\Support\GeoParser' ) );
  }
}
