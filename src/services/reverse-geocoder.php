<?php

namespace SearchApi\Services;

use SearchApi\Models as Models;

interface ReverseGeocoder {
  function reverse_geocoding_with_latlin( Models\GeoCoordinate $geo_coordinate, $key );
  function reverse_geocoding_with_place_id( $place_id, $key );
}
