#!/usr/bin/python
#
# SCRIPT FOR POPULATING TEST SOLR SERVER CORE WITH TEST DOCUMENTS
#
# Usage: python setup-test-docs.py <Solr Endpoint Url>
#
# Solr endpoint URL should be in the form:
# https://example.com/solr/<core-name>/
#
# .txt files in the directory ./txt/ will be committed to user-provided Solr
# core matching the name <core-name>.

import os
from os import listdir
from os.path import isfile, join
import json
import sys

TEST_DOC_DIR = 'test_docs'

arguments = sys.argv

solrApiUrl = arguments[1]

filePaths = [f for f in listdir(TEST_DOC_DIR) if isfile(join(TEST_DOC_DIR, f))]

TEMPLATE = """
{
    "add": {
        "doc":
            {"title":"%s", "body": %s},
        "boost":1.0,
        "overwrite":true,
        "commitWithin":1000
    }
}
"""

headers = {'Content-type': 'application/json'}

# os.system("curl " + solrApiUrl + "update?stream.body=<delete><query>*:*</query></delete>&commit=true")

for i, path in enumerate(filePaths):
    print str(i) + '\tProcessing ' + path
    f = open(TEST_DOC_DIR + '/' + path)
    text = f.read()

    commandJson = TEMPLATE % (path.replace('.txt', ''), json.dumps(text))

    os.system("curl " + solrApiUrl + "update?commit=true -H 'Content-type:application/json' -d '%s'" % commandJson)
    print '\nDone.\n----------------------------------'
