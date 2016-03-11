<?php
namespace SearchApi\Support;

use SearchApi\Models as Models;

/**
 * Class URL_Builder - builds the urls for the curl call to the geocoders
 *
 * Add more url builder functions for each geocoder
 */
class GeoCoderURLBuilder {

  // keys
  private $google_key = null;
  // end of keys

  private $geo_coordinate;

  public function __construct( Models\GeoCoordinate $coordinate ) {
    $this->geo_coordinate = $coordinate;
  }

  /**
   * Function to select the url builder
   *
   * @param url_pick - used to select correct url to build
   */
  public function url_selector( $url_pick ) {
    if ( $url_pick === 'Google' ) {
      return $this->google_url();
    }
    // default url builder
    return $this->google_url();
  }

  /**
   * Function for generating google's url for the curl call
   */
  public function google_url() {
    $service_url = 'https://maps.googleapis.com/maps/api/geocode/json?'.
    "latlng={$this->geo_coordinate->lat},{$this->geo_coordinate->lng}";

    // checking if api key is given, if so adding it to url
    if ( $this->google_key !== null ) {
      $service_url = $service_url."&key={$this->google_key}";
    }

    return $service_url;
  }
}