<?php

namespace SearchApi\Models;

/**
 * Class SearchOptions - Contains search options available to user.
 * TODO: Sorting and filtering options.
 *
 * @var $resultsPerPage int|null   Number of results per page, null for default
 * @var $page           int|null   Which page to retrieve, null for default
 */
class SearchOptions {
  public $resultsPerPage = null;
  public $page = null;
}
