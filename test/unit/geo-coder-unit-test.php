<?php
/**
 * Geo Coder Unit tests
 */
namespace SearchApi\Test\Unit;

use SearchApi;

/**
 * Geo_coder__Unit_Tests - Unit tests for the geo coders (lower level functions)
 */
class Geo_Coder_Unit_Test extends \PHPUnit_Framework_TestCase {

  public function test_that_the_class_GoogleReverseGeocoder_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Providers\GoogleReverseGeocoder' ) );
  }

  public function test_that_the_class_GoogleURLBuilder_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Support\GoogleURLBuilder' ) );
  }

  public function test_that_the_class_JsonDecoder_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Support\JsonDecoder' ) );
  }

  public function test_that_the_class_GoogleReverseGeocoderParser_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Support\GoogleReverseGeocoderParser' ) );
  }

  public function test_that_the_class_GoogleForwardGeocoderParser_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Support\GoogleForwardGeocoderParser' ) );
  }
}
