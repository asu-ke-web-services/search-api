<?php

namespace SearchApi\Models;

/**
 * Class GeoCoordinate - Longitude and Latitude coordinates
 *
 * @var $lat   float    latitude
 * @var $lng   float    longitude
 */
class GeoCoordinate {
  public $lat;
  public $lng;

  function __construct( $lat, $lng ) {
    $this->lat = $lat;
    $this->lng = $lng;
  }
}
