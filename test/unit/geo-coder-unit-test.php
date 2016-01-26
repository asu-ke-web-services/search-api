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

	public function test_that_the_class_ReverseGeocoderClass_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Providers\ReverseGeocoderClass' ) );
  }

  public function test_that_the_class_GeoCoderURLBuilder_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Support\GeoCoderURLBuilder' ) );
  }

  public function test_that_the_class_JsonDecoder_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Support\JsonDecoder' ) );
  }

  public function test_that_the_class_GeoJsonParsers_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Support\GeoJsonParsers' ) );
  }
}
