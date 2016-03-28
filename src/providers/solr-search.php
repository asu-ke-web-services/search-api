<?php

namespace SearchApi\Providers;

use SearchApi\Services\Search;
use SearchApi\Models\SearchTerm;
use SearchApi\Models\SearchResult;
use SearchApi\Models\SearchResultItem;
use SearchApi\Models\SearchOptions;

use SearchApi\Builders\QueryBuilder;
use SearchApi\Builders\SolrQueryBuilder;

use SearchApi\Clients;
use SearchApi\Commands;

/**
 * Interface to Solr server.
 *
 * @var QueryBuilder $query_builder Obj with implementation of QueryBuilder constructing Solr-specific query string.
 * @var string $api_url Base URL for the solr query API
 * @var Command $http_get_command Preferred http get command for making simple GET requests.
 */
class SolrSearch implements Search {

  private $query_builder;
  private $api_url;
  private $http_get_command;

  /**
   * Constructor with optional params
   *
   * @param QueryBuilder $query_builder Should be able to inject dependency to use any solr-specific impl. of QueryBuilder
   * @param Command $http_get_command Preferred http get command for making simple GET requests.
   * @param string $api_url Base URL for the solr query API
   */
  function __construct( QueryBuilder $query_builder = null, Commands\Command $http_get_command = null, $api_url = null ) {
    if ( $query_builder ) {
      $this->query_builder = $query_builder;
    } else {
      $this->query_builder = new SolrQueryBuilder();
    }

    if ( $api_url ) {
      $this->api_url = $api_url;
    }

    if ( $http_get_command ) {
      $this->http_get_command = $http_get_command;
    } else {
      $this->http_get_command = new Commands\HttpGet( $this->api_url );
    }
  }

  /**
   * Create a search result from a JSON string.
   * returns SearchResultItem[]
   * @param string $response_string
   */
  function parse_query_response( $response_string ) {
    $results = array();

    $parsed_result = json_decode( $response_string );

    if ( ! $parsed_result || ! property_exists( $parsed_result, 'response' ) ) {
      return null;
    }

    $docs = $parsed_result->response->docs;
    foreach ( $docs as $doc ) {
      $item = new SearchResultItem();
      $item->id = $doc->id[0];
      if ( property_exists( $doc, 'title' ) ) {
        $item->title = $doc->title[0];
      }
      if ( property_exists( $doc, 'author' ) ) {
        $item->author = $doc->author;
      }
      if ( property_exists( $doc, 'publication_date' ) ) {
        $item->date = $doc->publication_date[0];
      }
      array_push( $results, $item );
    }

    return $results;
  }

  /**
   * Make a query to solr server, with options for pagination, sorting, etc.
   * Returns SearchResultItem[]
   *
   * @param SearchTerm[]|null $search_terms Search terms to search
   * @param SearchApi\Models\SearchOptions|null $options Query options
   */
  function query( $search_terms, $options = null ) {
    // This is just a placeholder
    if ( $search_terms === null || empty( $search_terms ) ) {
      return null;
    }

    $query_string = $this->query_builder->build( $search_terms, $options );

    $this->http_get_command->setUrl( $this->api_url . $query_string );
    $query_result = $this->http_get_command->execute();

    $search_results = $this->parse_query_response( $query_result );

    return $search_results;
  }
}
