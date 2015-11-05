<?php
/**
 * Search Engine Unit test
 */
namespace SearchApi\Test\Unit;

use SearchApi;

/**
 * Reverse_Geocoder_Test - Unit test for the reverse geocoder (lower level functions)
 */
class Reverse_Geocoder_Test extends \PHPUnit_Framework_TestCase {

  public function test_that_the_class_GoogleReverseGeocoder_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Providers\GoogleReverseGeocoder' ) );
  }
}
