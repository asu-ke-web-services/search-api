<?php

namespace SearchApi\Services;

use SearchApi\Models as Models;

interface ReverseGeocoder {
  function get_reverse_url( Models\GeoCoordinate $coords );
  function get_forward_url( $address );
  function get_locations( Models\GeoCoordinate $geo_coordinate );
  function get_coordinates( $address );
}
