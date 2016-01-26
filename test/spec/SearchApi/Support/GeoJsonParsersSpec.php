<?php

namespace spec\SearchApi\Support;

use SearchApi;
use SearchApi\Models as Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GeoJsonParsersSpec - Spec integration test for the Geo Parser Geocoder (higher level functions)
 */
class GeoJsonParsersSpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'SearchApi\Support\GeoParser' );
  }

  // reverse_geocoder_json_decoder tests
  function it_should_throw_invalid_key() {
    $this->shouldThrow( new \Exception( 'Invalid Key' ) )
    ->during( 'reverse_geocoder_json_decoder', array( '{"status" : "REQUEST_DENIED"}' ) );
  }

  function it_should_throw_invalid_json_object() {
    $this->shouldThrow( new \Exception( 'Invalid Json Object' ) )
    ->during( 'reverse_geocoder_json_decoder', array( '{bad_json : isbad}' ) );
  }
  // end of reverse_geocoder_json_decoder tests

  // reverse_geocoder_parser tests
  function it_should_return_an_empty_array_when_passed_null() {
    $result = $this->reverse_geocoder_parser( null );
    $result->shouldBeArray();
    $result->shouldHaveCount( 0 );
  }

  function it_should_return_an_empty_array_when_passed_empty_array() {
    $result = $this->reverse_geocoder_parser( array() );
    $result->shouldBeArray();
    $result->shouldHaveCount( 0 );
  }

  function it_should_return_an_empty_array_when_passed_bad_formatted_array() {
    $result = $this->reverse_geocoder_parser( array( 'a', 'b', 'f' ) );
    $result->shouldBeArray();
    $result->shouldHaveCount( 0 );
  }

  function it_should_return_an_array_of_search_terms() {
    // testing string
    $test_string =
    '{
      "results": [
        {
  	      "address_components": [
            {
  				    "long_name": "Bedford Avenue",
  				    "short_name": "Bedford Ave",
  				    "types": [
  			  		  "route"
  				    ]
  			    },
  			    {
  				    "long_name": "Williamsburg",
  				    "short_name": "Williamsburg",
  				    "types": [
  				 		  "neighborhood",
  						  "political"
  				    ]
  			    }
  			  ],
  			  "place_id": "ChIJd8BlQ2BZwokRAFUEcm_qrcA"
  		  },
  		  {
  			  "address_components": [
  			    {
  				    "long_name": "Williamsburg",
  				    "short_name": "Williamsburg",
  				    "types": [
  						  "neighborhood",
  						  "political"
  				    ]
  			    }
  			  ],
  			  "place_id": "ChIJi27VXGBZwokRM8ErPyB91yk"
  		  }
  		],
  		"status": "OK"
  	}';
    // end of the test string

    // turning test string into json_decoder array
    $test_string = json_decode( $test_string, true );

    // checking it is array and has 2 elements
    $result = $this->reverse_geocoder_parser( $test_string );
    $result->shouldBeArray();
    $result->shouldHaveCount( 2 );

    // checking the first element value and count
    $value_checker = $result[0];
    $value_checker->value->shouldBe( 'Bedford Avenue' );
    $value_checker->count->shouldBe( 1 );

    // checking the second element value and count
    $value_checker = $result[1];
    $value_checker->value->shouldBe( 'Williamsburg' );
    $value_checker->count->shouldBe( 2 );
  }
  // end of reverse_geocoder_parser tests

  // combined reverse_geocoder_json_decoder and reverse_geocoder_parser tests
  function it_should_return_an_empty_array_after_json_decoding_and_parsing() {
    $result = $this->reverse_geocoder_json_decoder( '{"test":"test"}' );
    $result = $this->reverse_geocoder_parser( $result );
    $result->shouldBeArray();
    $result->shouldHaveCount( 0 );
  }
  // end of combined reverse_geocoder_json_decoder and reverse_geocoder_parser tests
}
