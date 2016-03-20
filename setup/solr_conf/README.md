# Solr Core Configuration
Use the example `schema.xml` and `solrconfig.xml` to configure the Solr core.

## Dependencies
Yes, there are dependencies for our Solr instance! To have the Solr instance perform index-time synonym expansion properly, we need the following library:
https://github.com/MiladAlshomary/auto-phrase-tokenfilter

This is a fork of `lucidworks/auto-phrase-tokenfilter`, modified to work for Solr 5.x.

Use `ant` to compile the library, and copy the the resulting `.jar` package from `dist` to `/opt/solr/contrib/autophrasing/`. If your Solr installation exists somewhere else besides `/opt/solr/`, you can just edit the following line in `solrconfig.xml`:

`<lib dir="/opt/solr/contrib/autophrasing" regex=".*\.jar" />`

Just point `dir` to wherever you copied the `jar` file.
