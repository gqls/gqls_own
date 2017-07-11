#!/usr/bin/env bash

echo "testing nvm has been installed 2"
command -v nvm

echo "installing yarn"
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list

sudo apt-get update && sudo apt-get install yarn

echo "testing yarn version"
yarn --version

yarn init
yarn add node
