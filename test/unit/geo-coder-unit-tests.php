<?php
/**
 * Search Engine Unit test
 */
namespace SearchApi\Test\Unit;

use SearchApi;

/**
 * Geo_coder__Unit_Tests - Unit tests for the geo coders (lower level functions)
 */
class Geo_coder_Unit_Tests extends \PHPUnit_Framework_TestCase {

	public function test_that_the_class_ReverseGeocoder_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Providers\ReverseGeocoder' ) );
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
