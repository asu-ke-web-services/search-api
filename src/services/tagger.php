<?php

namespace SearchApi\Services;

interface Tagger {

  /**
   * Interface Tagger - Should make an NER Tagger Call and return a Keywords array of tagged input
   *
   * @method Keywords[] tagger_service ( $request_string )
   *   Make a call to the NER Tagger to tag the request text
   */
  function tagger_service( $request_string = '' );

}
