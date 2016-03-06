<?php
namespace SearchApi\Support;

use SearchApi\Models as Models;

/**
 * Class URL_Builder - builds the url for google's curl call
 */
class GoogleURLBuilder {

  // keys
  private $Google_Key = null;
  // end of keys

  private $geo_coordinate;

  public function __construct( Models\GeoCoordinate $coordinate ) {
    $this->geo_coordinate = $coordinate;
  }

  /**
   * Function for generating google's url for the curl call
   */
  public function google_url() {
    $service_url = 'https://maps.googleapis.com/maps/api/geocode/json?'.
    "latlng={$this->geo_coordinate->lat},{$this->geo_coordinate->lng}";

    // checking if api key is given, if so adding it to url
    if ( $this->Google_Key !== null ) {
      $service_url = $service_url."&key={$this->Google_Key}";
    }

    return $service_url;
  }
}
