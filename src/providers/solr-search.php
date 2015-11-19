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

/**
 * Interface to Solr server.
 *
 * @var QueryBuilder $queryBuilder Obj with implementation of QueryBuilder constructing Solr-specific query string.
 * @var string $apiUrl Base URL for the solr query API
 * @var HttpClient $httpClient Preferred http client wrapper for making simple GET requests.
 */
class SolrSearch implements Search {

  private $queryBuilder;
  private $apiUrl;
  private $httpClient;

  /**
   * Constructor with optional params
   *
   * @param QueryBuilder $queryBuilder Should be able to inject dependency to use any solr-specific impl. of QueryBuilder
   * @param HttpClient $httpClient Preferred http client wrapper. Defaults to CurlHttpClient
   */
  function __construct( QueryBuilder $queryBuilder = null, Clients\HttpClient $httpClient = null, $apiUrl = null ) {
    if ( $queryBuilder ) {
      $this->queryBuilder = $queryBuilder;
    } else {
      $this->queryBuilder = new SolrQueryBuilder();
    }

    if ( $httpClient ) {
      $this->httpClient = $httpClient;
    } else {
       $this->httpClient = new Clients\CurlHttpClient();
    }

    // TODO: Require $apiUrl param
    if ( $apiUrl ) {
      $this->apiUrl = $apiUrl;
    } else {
      $this->apiUrl = 'http://127.0.0.1:8983/solr/gios/select'; // TODO: get this url from a config file
    }
  }

  /**
   * Create a search result from a JSON string.
   * returns SearchResult
   * @param string $responseString
   */
  function parse_query_response( $responseString ) {
    $result = new SearchResult();
    $result->results = array();

    $parsedResult = json_decode( $responseString );

    if ( ! $parsedResult || ! property_exists( $parsedResult, 'response' ) ) {
      return null;
    }

    $docs = $parsedResult->response->docs;
    foreach ( $docs as $doc ) {
      $item = new SearchResultItem();
      $item->id = $doc->id;
      if ( property_exists( $doc, 'title' ) ) {
        $item->title = $doc->title;
      }
      if ( property_exists( $doc, 'author' ) ) {
        $item->author = $doc->author;
      }
      if ( property_exists( $doc, 'publication_date' ) ) {
        $item->date = $doc->publication_date;
      }
      array_push( $result->results, $item );
    }

    $result->count = count( $result->results );

    return $result;
  }

  /**
   * Make a query to solr server, with options for pagination, sorting, etc.
   * Returns SearchResult
   *
   * @param SearchTerm[]|null $keywords Keywords to search
   * @param SearchApi\Models\SearchOptions|null $options Query options
   */
  function query( $keywords, $options = null ) {
    // This is just a placeholder
    if ( $keywords === null ) {
      return null;
    }

    $queryString = $this->queryBuilder->build( $keywords, $options );

    $queryResult = $this->httpClient->get( $this->apiUrl . $queryString );

    $searchResults = $this->parse_query_response( $queryResult );

    return $searchResults;
  }
}
