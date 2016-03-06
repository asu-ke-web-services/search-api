<?php

namespace SearchApi\Providers;

use SearchApi\Models as Models;
use SearchApi\Support as Support;
use SearchApi\Commands as Commands;
use SearchApi\Services\ReverseGeocoder as ReverseGeocoder;

//TODO: add error exception that if hit then end of the url builders say fetch failed

/**
 * Class ReverseGeocoder - Given a latlin or place id to find a point
 * or polygon that can represent that location via GoogleMaps.
 */
class Google_Reverse_Geocoder implements ReverseGeocoder {
  private $geo_coords;

  public function get_url( Models\GeoCoordinate $coords ) {
  	// building the url
  	$url_builder = new Support\Google_URLBuilder( $coords );
    return $url_builder->google_url();
  }

  /**
   * Function to gather the location data for the coordinates given
   *
   * @param Models\GeoCoordinate $geo_coordinate
   * @throws Exception - error in curl call
   */
  public function get_locations( Models\GeoCoordinate $coords ) {

    // building the url
    $url_builder = new Support\Google_URLBuilder( $coords );

    // implementing a curl call using http-get curl call
    $curl_caller = new Commands\HttpGet();

    // attempting to call google's service
    try {
    $curl_caller->setUrl( $url_builder->google_url() );
    $geocoding_results = $curl_caller->execute();
    // informing that the service failed is down
    } catch (Exception $e) {
      throw new Exception ( 'The Google Service is Unavailable:\n\t{$e}' );
    }

    // calling json decoder
    $geo_json_decoder = new Support\JsonDecoder();
    $decoded_json = $geo_json_decoder->reverse_geocoder_json_decoder( $geocoding_results );
    // calling parser
    $geo_parser = new Support\Google_Reverse_geocoder_Parser( $decoded_json );
    // returns array of search terms
    return $geo_parser->google_reverse_geocoder_parser();
  }
}
