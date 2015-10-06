<?php

namespace Search_Api;

/**
 *
 */
class Search_Engine {
  
  public function handle_request ( Search_Request $request ) {
    return new Search_Result();
  }

}