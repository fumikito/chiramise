#!/usr/bin/env bash

set -ex

npm install
npm start
curl -L https://raw.githubusercontent.com/fumikito/wp-readme/master/wp-readme.php | php

rm -rf node_modules
rm .travis.yml
rm .gitignore
rm readme.md
