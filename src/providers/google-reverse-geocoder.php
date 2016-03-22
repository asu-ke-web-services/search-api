<?php

namespace SearchApi\Providers;

use SearchApi\Models as Models;
use SearchApi\Support as Support;
use SearchApi\Commands as Commands;
use SearchApi\Services\ReverseGeocoder as ReverseGeocoder;

/**
 * Class ReverseGeocoder - Given a latlin or place id to find a point
 * or polygon that can represent that location via GoogleMaps.
 */
class GoogleReverseGeocoder implements ReverseGeocoder {
  private $geo_coords;
  private $curl_caller;
  private $url_builder;

  /**
   * Constructor with optional params
   *
   * @param $coords coordinates for the reverse geocoding
   * @param $url_builder builds the url
   * @param $http_get_command Preferred http get command for making simple GET requests.
   */
  function __construct( Support\GoogleURLBuilder $url_builder = null,
    Commands\HttpGet $curl_caller = null ) {
    // building the url
    if ( $url_builder ) {
      $this->url_builder = $url_builder;
    } else {
      $this->url_builder = new Support\GoogleURLBuilder();
    }

    if ( $curl_caller ) {
      $this->curl_caller = $curl_caller;
    } else {
      $this->curl_caller = new Commands\HttpGet();
    }
  }

  public function get_url( Models\GeoCoordinate $coords ) {
    // building the url and returning
    $this->url_builder->set_coords( $coords );
    return $this->url_builder->google_url();
  }

  /**
   * Function to gather the location data for the coordinates given
   *
   * @param Models\GeoCoordinate $geo_coordinate
   * @throws Exception - error in curl call
   */
  public function get_locations( Models\GeoCoordinate $coords ) {
    // setting url coords
    $this->url_builder->set_coords( $coords );

    // attempting to call google's service
    try {
      $this->curl_caller->setUrl( $this->url_builder->google_url() );
      $geocoding_results = $this->curl_caller->execute();
      // informing that the service failed is down
    } catch ( Exception $e ) {
      throw new Exception( "The Google Service is Unavailable:\n\t{$e}" );
    }

    // calling json decoder
    $geo_json_decoder = new Support\JsonDecoder();
    $decoded_json = $geo_json_decoder->reverse_geocoder_json_decoder( $geocoding_results );
    // calling parser
    $geo_parser = new Support\GoogleReverseGeocoderParser( $decoded_json );
    // returns array of search terms
    return $geo_parser->google_reverse_geocoder_parser();
  }
}
