#!/usr/bin/env bash

echo "Provisioning vm in Vagrantfile included script"
set PROJECT_DIR = "/var/www/project/"

echo "running apt update"
apt-get update && apt-get install -y
apt-get install apt-utils -y

echo "installing build essential, curl vim etc"
apt-get install build-essential vim curl silversearcher-ag -y > /dev/null

echo "installing git"
apt-get install git -y > /dev/null

echo "installing nginx"
apt-get install nginx -y > /dev/null

echo "configuring nginx"
rm -rf /etc/nginx/sites-available/default
rm -rf /etc/nginx/sites-available/nginx_vhost
rm -rf /etc/nginx/sites-enabled/default
rm -rf /etc/nginx/sites-enabled/nginx_vhost
cp /var/www/project/config/common_provision/nginx_provision/nginx_vhost /etc/nginx/sites-available/nginx_vhost
ln -s /etc/nginx/sites-available/nginx_vhost /etc/nginx/sites-enabled/

service nginx restart

echo "installing mongo"
# https://docs.mongodb.com/manual/tutorial/install-mongodb-on-ubuntu/
# The MongoDB instance stores its data files in /var/lib/mongodb and its log files in /var/log/mongodb
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 0C49F3730359A14518585931BC711F9BA15703C6
echo "deb http://repo.mongodb.org/apt/ubuntu xenial/mongodb-org/3.4 multiverse" | tee /etc/apt/sources.list.d/mongodb-org-3.4.list
apt-get update
apt-get install -y mongodb-org 2>/dev/null
service mongod start

echo "installing node"
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
apt install nodejs -y

echo "running node -v"
node -v
echo "running npm -v"
npm -v

echo "installing global node.js packages"
npm install -g npm@latest

echo "Installing modules in packages.json"
echo "installing without --no-bin-links option so install as admin and change back afterwards"
cd /var/www/project/frontend/
npm install
npm update
echo "running npm outdated"
npm outdated

echo "change permissions and ownership of /usr/lib/node_modules"
chown -R root.vagrant /usr/lib/node_modules
chmod -R 775 /usr/lib/node_modules

