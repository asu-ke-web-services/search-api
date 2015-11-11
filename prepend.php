<?php
    include ('src/search-api/search-engine.php');
    foreach (glob("{src/models/*.php,src/services/*.php,src/providers/*.php}", GLOB_BRACE) as $filename)
    {
        include $filename;
    }

    $searchEngine = new SearchApi\SearchEngine();
    $request = new SearchApi\Models\SearchRequest();
    $response = $searchEngine->handle_request( $request );
