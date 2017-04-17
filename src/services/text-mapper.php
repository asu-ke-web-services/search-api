<?php

namespace SearchApi\Services;

/**
 * Interface TextMapper - Given an array of words, it should make a request to a text mapping service and
 * return results in an array of synonym objects
 */
interface TextMapper {
  function get_synonyms( $words );
}
