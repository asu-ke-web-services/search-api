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
  private $geo_json_decoder;
  private $geo_parser;

  /**
   * Constructor with optional params
   *
   * @param $coords coordinates for the reverse geocoding
   * @param $url_builder builds the url
   * @param $http_get_command Preferred http get command for making simple GET requests.
   * @param $decoder init the decoder var
   */
  function __construct( Support\GoogleURLBuilder $url_builder = null,
    Commands\HttpGet $curl_caller = null,
    Support\JsonDecoder $geo_json_decoder = null,
    Support\GoogleReverseGeocoderParser $geo_parser = null ) {
    // building the url initalization
    if ( $url_builder ) {
      $this->url_builder = $url_builder;
    } else {
      $this->url_builder = new Support\GoogleURLBuilder();
    }

    // curl caller initalization
    if ( $curl_caller ) {
      $this->curl_caller = $curl_caller;
    } else {
      $this->curl_caller = new Commands\HttpGet();
    }

    // decoder initalization
    if ( $geo_json_decoder ) {
      $this->geo_json_decoder = $geo_json_decoder;
    } else {
      $this->geo_json_decoder = new Support\JsonDecoder();
    }

    // parser initalization
    if ( $geo_parser ) {
      $this->geo_parser = $geo_parser;
    } else {
      $this->geo_parser = new Support\GoogleReverseGeocoderParser();
    }
  }

  public function get_reverse_url( Models\GeoCoordinate $coords ) {
    // building the url and returning
    $this->url_builder->set_coords( $coords );
    return $this->url_builder->reverse_google_url();
  }

  public function get_forward_url( $address ) {
    // building the url and returning
    $this->url_builder->set_address( $address );
    return $this->url_builder->forward_google_url();
  }

  /**
   * Function to make the call for the geo coding
   *
   * @param String url
   * @throws Exception - error in curl call
   */
  public function get_data( $url ) {
    // attempting to call google's service
    try {
      $this->curl_caller->setUrl( $url );
      $geocoding_results = $this->curl_caller->execute();
      // informing that the service failed is down
    } catch ( Exception $e ) {
      throw new Exception( "The Google Service is Unavailable:\n\t{$e}" );
    }

    // calling json decoder
    return $this->geo_json_decoder->reverse_geocoder_json_decoder( $geocoding_results );
  }

  /**
   * Function to gather the location data for the coordinates given
   *
   * @param Models\GeoCoordinate $geo_coordinate
   */
  public function get_locations( Models\GeoCoordinate $coords ) {
    // setting url coords
    $this->url_builder->set_coords( $coords );

    $decoded_json = $this->get_data( $this->url_builder->reverse_google_url() );

    // calling parser
    // returns array of search terms
    return $this->geo_parser->google_reverse_geocoder_parser( $decoded_json );
  }

  /**
   * Function to gather the lat and long data for the address given
   *
   * @param address $address
   */
  public function get_coordinates( $address ) {
    // setting url coords
    $this->url_builder->set_address( $address );

    $decoded_json = $this->get_data( $this->url_builder->forward_google_url() );

    // calling parser
    // returns array of search terms
    return $this->geo_parser->google_reverse_geocoder_parser( $decoded_json );
  }
}
