# Setup Instructions

## Solr Test Server

### Solr Configuration
See `solr_conf` directory for example configuration files for the Solr core.

### setup-test-docs.py

This is used to populate a SOLR core with a collection of documents. All of the documents will be in the form:

```
{
    "title":"<SOME TITLE>",
    "body": "<DOC BODY>"
}
```

Note that other fields is not specified.

The purpose of this script is to ensure that a SOLR test server can be spun up with the same set of documents every time. We want to be able to easily start/reset a test SOLR instance with a predictable state.

**Requirements:**
 - Linux environment assumed
 - Python 2.7
 - Solr test server already set up. (See the wiki for how to set up a Solr test server for `search-api`.)

**Usage:** `python setup-test-docs.py <Solr Endpoint Url>`
Where `<Solr Endpoint Url>` is in the form `https://example.com/solr/<core-name>/`, and `core-name` is the name of the core you wish to populate with the test docs.
