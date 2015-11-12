<?php

namespace SearchApi\Services;

/**
 * Interface TextMapper - Should make a request to a text mapping service and return results in a synonym object
 */
interface TextMapper {
  function get_synonyms( $word );
}
