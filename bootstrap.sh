#!/bin/bash

#isso daqui é um comentario.
apt-get update
apt-get install -y apache2
rm -rf /var/www
ln -fs /vagrant /var/www