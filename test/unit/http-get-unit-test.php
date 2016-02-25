<?php
/**
 * Http-get Unit tests
 */
namespace SearchApi\Test\Unit;

use SearchApi;

/**
 * Http-get Unit_Tests - Unit tests for the http (lower level functions)
 */
class Http_Get_Unit_Test extends \PHPUnit_Framework_TestCase {

  public function test_that_the_class_HttpGet_is_defined() {
    $this->assertTrue( class_exists( 'SearchApi\Commands\HttpGet' ) );
  }

  /**
   * Test to check that httpget throws an exception on without a url
   *
   * @expectedException Exception
   * @expectedExceptionMessage error occured during curl exec. Additioanl info:
   */
  public function test_that_HttpGet_throws_exception_with_no_url() {
    $http_class = new SearchApi\Commands\HttpGet();
    $http_class->setUrl( '' );
    $http_class->execute();
  }

  /**
   * Test to check that httpget throws an exception on with bad url
   *
   * @expectedException Exception
   * @expectedExceptionMessage error occured during curl exec. Additioanl info:
   */
  public function test_that_HttpGet_throws_exception_with_bad_website() {
  	$http_class = new SearchApi\Commands\HttpGet();
  	$http_class->setUrl( 'BadWebSite' );
  	$http_class->execute();
  }
}
