<?php

namespace SearchApi\Models;

/**
 * Class SearchRequest - User-provided request parameters
 *
 * @var $document       string                Large body of text from a document to be used for NER
 * @var $text           string|null           Additional keywords
 * @var $coord          Models\GeoCoordinate  User-specified lat/long for reverse geocoding
 * @var $resultsPerPage int                   Number of results per page
 * @var $page           int                   Which page to retrieve
 */
class SearchRequest {
  public $document;
  public $text;
  public $coord;
  public $resultsPerPage;
  public $page;
}
