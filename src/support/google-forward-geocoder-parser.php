<?php

namespace SearchApi\Support;


use SearchApi\Models as Models;

/**	
 * Class Geo_Json_Parser - Parses the returned result from a forward Geocoder
 */
class GoogleForwardGeocoderParser {

  /**
   * Function for parsing google's geocoder
   *
   * @param $json_results array of decoded json
   */
  public function google_forward_geocoder_parser( $json_results ) {
    // creating array of search terms to return
    $geo_coordinates = array();

    // checking for if the input is null case
    if ( $json_results === null ) {
      return $geo_coordinates;
    }

    // code that parses the array from the json object
    // making sure results is there and moving $geocoder_results to the inner array
    if ( array_key_exists( 'results', $json_results ) ) {
      $json_results = $json_results['results'];
      // loopin through each address found and getting the coordinates
      foreach ( $json_results as $result ) {
        // checking if geometry exists
        if ( array_key_exists( 'geometry', $result ) ) {
          $result = $result['geometry'];
          // checking if location exists (the coordinates)
          if ( array_key_exists( 'location', $result ) ) {
          	$result = $result['location'];
            // making sure that coordinates exist
          	if ( array_key_exists( 'lat', $result ) && array_key_exists( 'lng', $result ) ) {
              // checking if the coordinates already exist in the array
              $element_exists = false;
              if ( array_key_exists( (string)$result['lat'], $geo_coordinates ) ) {
                $element_exists = true;
              }

              // checking if element was not found
              if ( ! $element_exists ) {
                // createing new geocoordinate
                $new_item = new Models\GeoCoordinate( $result['lat'], $result['lng']);

                // adding the coordinates to the array
                $geo_coordinates[ $new_item->lat ] = $new_item;
              } // checking that an element was not found
          	}
          } // loopin through location
        } // the check to make sure there is an "geometry" section in the array
      } // results array foreach loop
    } // making sure results is there and moving $geocoder_results to the inner array

    // returning an array of GeoCoordinate
    // resetting the array indexs to numbers
    $geo_coordinates = array_values( $geo_coordinates );
    return $geo_coordinates;
  }
}
