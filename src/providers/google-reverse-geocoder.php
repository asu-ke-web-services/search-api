<?php

namespace SearchApi\Providers;

use SearchApi\Models as Models;
use SearchApi\Support as Support;
use SearchApi\Commands as Commands;
use SearchApi\Services\ReverseGeocoder as ReverseGeocoder;

/**
 * Class GoogleReverseGeocoder - Given a latlin or place id to find a point
 * or polygon that can represent that location via GoogleMaps.
 */
class GoogleReverseGeocoder implements ReverseGeocoder {
  public $api_key; // service key
  private $geo_parser; // injected parser

  public function __construct( $key = null, $parser = null ) {
    $this->api_key = $key;

    if ( $parser === null ) {
      // default parser
      $parser = new Support\GeoParser();
    }
    $this->geo_parser = $parser;
  }

  /**
   * Function for generating the url for the curl call
   */
  public function create_URL( Models\GeoCoordinate $geo_coordinate ) {
    $service_url = 'https://maps.googleapis.com/maps/api/geocode/json?'.
    "latlng={$geo_coordinate->lat},{$geo_coordinate->lng}";

    // checking if api key is given, if so adding it to url
    // SECOND PART OF IF: is meant for testing purposes
    if ( $this->api_key !== null && $this->api_key !== 'geokey' ) {
      $service_url = $service_url."&key={$this->api_key}";
    }

    return $service_url;
  }

  /**
   * Function to gather the location data for the coordinates given
   *
   * @param Models\GeoCoordinate $geo_coordinate
   * @throws Exception - error in curl call
   */
  public function get_locations( Models\GeoCoordinate $geo_coordinate ) {

    // building the url
    $service_url = $this->create_URL( $geo_coordinate );

    // implementing a curl call using http-get curl call
    $curl_caller = new Commands\HttpGet();
    $curl_caller->setUrl( $service_url );
    $geocoding_results = $curl_caller->execute();

    // checking if the curl was successful
    if ( $geocoding_results === false ) {
      $info = curl_getinfo( $curl );
      throw new Exception( 'error occured during curl exec. Additioanl info: ' . var_export( $info ) );
    }
    // end of the implementing a curl call using http-get curl call

    // calling json decoder
    $decoded_json = $this->geo_parser->reverse_geocoder_json_decoder( $geocoding_results );
    // calling parser
    return $this->geo_parser->reverse_geocoder_parser( $decoded_json );
  }
}
