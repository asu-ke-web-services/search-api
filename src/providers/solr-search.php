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
 * Class SolrSearch - This is a placeholder class that will be an interface to a Solr Search Index
 *
 * @var QueryBuilder queryBuilder Obj with implementation of QueryBuilder constructing Solr-specific query string.
 * @method SearchResult query (SearchTerm[]|null $keywords, SearchOptions|null options) Interface defined in Services\Search
 */
class SolrSearch implements Search {

  private $queryBuilder;
  private $apiUrl;
  private $httpClient;

  /**
   * Constructor with optional params
   *
   * @param queryBuilder QueryBuilder Should be able to inject dependency to use any solr-specific impl. of QueryBuilder
   * @param httpClient HttpClient Preferred http client wrapper. Defaults to CurlHttpClient
   */
  function __construct( QueryBuilder $queryBuilder = null, Clients\HttpClient $httpClient = null ) {
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

    $this->apiUrl = 'http://127.0.0.1:8983/solr/gios/select'; // TODO: get this url from a config file
  }

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
      $item->title = $doc->title;
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
