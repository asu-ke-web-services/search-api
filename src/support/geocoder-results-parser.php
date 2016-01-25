<?php

namespace SearchApi\Support;


use Exception;
use SearchApi\Models as Models;

/**
 * Class Geo_Parser - Parses the returned result from a Geocoder
 *
 * @throws Exception - error if bad json object or json string
 */
class GeoParser {

  /**
   * Function: reverse_geocoder_json_decoder
   *
   * @param Json obj $json_results
   * @throws Exception -  error if bad json object or json string
   */
  public function reverse_geocoder_json_decoder( $json_results ) {
    // code that decodes the json object into anrray
    // make sure utf8 format
    $json_results = utf8_encode( $json_results );
    // decode json into associate array
    $returnArrays = true;
    $geocoder_results = json_decode( $json_results, $returnArrays );

    // checking if received Json was valid
    if ( $geocoder_results === null ) {
      throw new Exception( 'Invalid Json Object' );
    }

    // check for valid key
    if ( array_key_exists( 'status', $geocoder_results ) &&
        $geocoder_results['status'] !== 'OK' ) {
      // UPDATE: update with new "Invalid Key" status
      if ( $geocoder_results['status'] === 'REQUEST_DENIED' ) {
        throw new Exception( 'Invalid Key' );
      }
      throw new Exception( 'Invalid Json String' );
    }

    if ( array_key_exists( 'status', $geocoder_results ) ) {
      throw new Exception( 'Invalid Json String' );
    }

    // return decoded json
    return $geocoder_results;
  }

  /**
   * Function: reverse_geocoder_parser
   *
   * @param Json Array $geocoder_results
   */
  public function reverse_geocoder_parser( $geocoder_results ) {
    // creating array of search terms to return
    $search_term_array = array();

    // checking for if the input is null case
    if ( $geocoder_results === null ) {
      return $search_term_array;
    }

    // code that parses the array from the json object
    // making sure results is there and moving $geocoder_results to the inner array
    if ( array_key_exists( 'results', $geocoder_results ) ) {
      $geocoder_results = $geocoder_results['results'];
      // loopin through each address found and getting the locations
      foreach ( $geocoder_results as $result ) {
        // checking if address_components exists
        if ( array_key_exists( 'address_components', $result ) ) {
          $result = $result['address_components'];
          // looping through each address component
          foreach ( $result as $component ) {
            // loopin through the search_term array to see if term already exists
            $element_exists = false;
            foreach ( $search_term_array as $term ) {
              if ( $term !== null && $term->value === $component['long_name'] ) {
                $term->count = $term->count + 1;
                $element_exists = true;
              }
            }

            // checking if element was not found
            if ( ! $element_exists ) {
              // createing new SearchTerm
              $new_item = new Models\SearchTerm();
              $new_item->value = $component['long_name'];
              $new_item->category = 'location';
              if ( $component['long_name'] !== $component['short_name'] ) {
                $new_item->related = array( $component['short_name'] );
              }
              $new_item->count = 1;
              $new_item->isUserInput = false;

              // adding the search term to the term array
              array_push( $search_term_array, $new_item );
            } // checking that an element was not found
          } // loopin through address componets
        } // the check to make sure there is an "address component" section in the array
      } // locations array foreach loop
    } // making sure results is there and moving $geocoder_results to the inner array

    // returning an array of SearchTerms
    return $search_term_array;
  }
}
