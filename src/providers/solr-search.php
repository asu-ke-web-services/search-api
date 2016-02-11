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
 * @var QueryBuilder $queryBuilder Obj with implementation of QueryBuilder constructing Solr-specific query string.
 * @var string $apiUrl Base URL for the solr query API
 * @var Command $httpGetCommand Preferred http get command for making simple GET requests.
 */
class SolrSearch implements Search {

  private $queryBuilder;
  private $apiUrl;
  private $httpGetCommand;

  /**
   * Constructor with optional params
   *
   * @param QueryBuilder $queryBuilder Should be able to inject dependency to use any solr-specific impl. of QueryBuilder
   * @param Command $httpGetCommand Preferred http get command for making simple GET requests.
   * @param string $apiUrl Base URL for the solr query API
   */
  function __construct( QueryBuilder $queryBuilder = null, Commands\Command $httpGetCommand = null, $apiUrl = null ) {
    if ( $queryBuilder ) {
      $this->queryBuilder = $queryBuilder;
    } else {
      $this->queryBuilder = new SolrQueryBuilder();
    }

    if ( $apiUrl ) {
      $this->apiUrl = $apiUrl;
    }

    if ( $httpGetCommand ) {
      $this->httpGetCommand = $httpGetCommand;
    } else {
      $this->httpGetCommand = new Commands\HttpGet( $this->apiUrl );
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
   * @param SearchTerm[]|null $searchTerms Search terms to search
   * @param SearchApi\Models\SearchOptions|null $options Query options
   */
  function query( $searchTerms, $options = null ) {
    // This is just a placeholder
    if ( $searchTerms === null ) {
      return null;
    }

    $queryString = $this->queryBuilder->build( $searchTerms, $options );

    $this->httpGetCommand->setUrl( $this->apiUrl . $queryString );
    $queryResult = $this->httpGetCommand->execute();

    $searchResults = $this->parse_query_response( $queryResult );

    return $searchResults;
  }
}
