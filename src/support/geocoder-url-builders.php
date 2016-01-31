<?php
namespace SearchApi\Support;

use SearchApi\Models as Models;

/**
 * Class URL_Builder - builds the urls for the curl call to the geocoders
 *
 * add more url builder functions for each geocoder
 */
class GeoCoderURLBuilder {

  // keys
  private $Google_Key = null;
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
  public function Url_Selector( $url_pick ) {
    if( $url_pick == "Google" ) {
      return $this->Google_URL();
    }
    // default url builder
    return $this->Google_URL();
  }

  /**
   * Function for generating google's url for the curl call
   */
  public function Google_URL() {
    $service_url = 'https://maps.googleapis.com/maps/api/geocode/json?'.
       "latlng={$this->geo_coordinate->lat},{$this->geo_coordinate->lng}";

    // checking if api key is given, if so adding it to url
    if ( $this->Google_Key !== null ) {
      $service_url = $service_url."&key={$this->Google_Key}";
    }

    return $service_url;
  }
}