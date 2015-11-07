<?php

namespace SearchApi\Support;

/**
 * Class Geo_Parser - Parses the returned result from a Geocoder
 */
class GeoParser {
  public function reverse_geocoder_parser( $geocoder_results ) {
    // add code to parse either xml or json results returned by google

    // for now: pretends to parse the results and return address
  	return '277 Bedford Avenue, Brooklyn, NY 11211, USA';
  }
}
