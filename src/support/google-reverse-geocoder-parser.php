<?php

namespace SearchApi\Support;


use SearchApi\Models as Models;

/**
 * Class Geo_Json_Parser - Parses the returned result from a Geocoder
 */
class GoogleReverseGeocoderParser {

  private $json_results;

  public function __construct( $results ) {
    $this->json_results = $results;
  }

  /**
   * Function for parsing google's geocoder
   */
  public function google_reverse_geocoder_parser() {
    // creating array of search terms to return
    $search_term_array = array();

    // checking for if the input is null case
    if ( $this->json_results === null ) {
      return $search_term_array;
    }

    // code that parses the array from the json object
    // making sure results is there and moving $geocoder_results to the inner array
    if ( array_key_exists( 'results', $this->json_results ) ) {
      $this->json_results = $this->json_results['results'];
      // loopin through each address found and getting the locations
      foreach ( $this->json_results as $result ) {
        // checking if address_components exists
        if ( array_key_exists( 'address_components', $result ) ) {
          $result = $result['address_components'];
          // looping through each address component
          foreach ( $result as $component ) {
            // loopin through the search_term array to see if term already exists
            $element_exists = false;
            if ( array_key_exists( $component['long_name'], $search_term_array) ) {
              $search_term_array[$component['long_name']]->count += 1;
              $element_exists = true;
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
              $search_term_array[$new_item->value] = $new_item;
            } // checking that an element was not found
          } // loopin through address componets
        } // the check to make sure there is an "address component" section in the array
      } // locations array foreach loop
    } // making sure results is there and moving $geocoder_results to the inner array

    // returning an array of SearchTerms
    return $search_term_array;
  }
}
