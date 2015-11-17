<?php

namespace SearchApi\Providers;

use SearchApi\Models as Models;
use SearchApi\Support as Support;
use SearchApi\Test\Support\Mocks as Mocks;
use SearchApi\Services\ReverseGeocoder as ReverseGeocoder;

/**
 * Class GoogleReverseGeocoder - Given a latlin or place id to find a point or polygon that can represent that
 * location via GoogleMaps.
 */
class GoogleReverseGeocoder implements ReverseGeocoder {
  public $api_key; // service key
  private $geo_parser; // injected parser

  public function __construct( $key = null, $parser = null ) {
  	$this->api_key = $key;

  	if ( $parser === null ) {
      // default parser
      $parser = new Support\GeoParser;
  	}
  	$this->geo_parser = $parser;
  }

  // returns array of terms based on latitude and longitude
  public function get_locations( Models\GeoCoordinate $geo_coordinate ) {
    // code to call the google geocoder service
    // creating base url
    $service_url = 'https://maps.googleapis.com/maps/api/geocode/json?'.
    "latlng={$geo_coordinate->lat},{$geo_coordinate->lng}";

    // checking if api key is given, if so adding it to url
    // second half of if statement is for testing purposes
    if ( $this->api_key !== null && $this->api_key !== 'geokey' ) {
      $service_url = $service_url.'&key={$this->api_key}';
    }

    // implementing a curl call to the service
    $curl = curl_init( $service_url );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    $geocoding_results = curl_exec( $curl );

    // checking if the curl was successful
    if ( $geocoding_results === false ) {
      $info = curl_getinfo( $curl );
      curl_close( $curl );
      throw new Exception( 'error occured during curl exec. Additioanl info: ' . var_export( $info ) );
    }

    // closing the curl
    curl_close( $curl );

    // calling parser
    return $this->geo_parser->reverse_geocoder_parser( $geocoding_results );
  }
}
