<?php

namespace SearchApi\Services;

use SearchApi\Models as Models;

interface ReverseGeocoder {
  function get_locations( Models\GeoCoordinate $geo_coordinate );
}
