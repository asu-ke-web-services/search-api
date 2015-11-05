<?php

namespace spec\Providers;

use SearchApi\Providers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * GoogleReverseGeocoderSpec - Spec integration test for the Google Reverse Geocoder (higher level functions)
 */
class GoogleReverseGeocoderSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType( 'SearchApi\Providers\GoogleReverseGeocoder' );
	}
}
