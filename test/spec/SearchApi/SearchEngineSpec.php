<?php

namespace spec\SearchApi;

use SearchApi;
use SearchApi\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SearchEngineSpec extends ObjectBehavior {

  function it_is_initializable() {
    $this->shouldHaveType('SearchApi\SearchEngine');
  }

  function it_should_handle_requests() {
    $empty_search_request = new Models\SearchRequest();
    $this->handle_request($empty_search_request)->shouldReturnAnInstanceOf('SearchApi\Models\SearchResult');
  }

}
