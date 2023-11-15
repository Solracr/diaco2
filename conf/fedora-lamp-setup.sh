#!/bin/sh

# Apache
sudo dnf update
sudo dnf install httpd -y
sudo systemctl enable httpd.service
sudo systemctl start httpd.service
httpd -v

#Maria DB

sudo dnf install mariadb-server -y

sudo systemctl start mariadb.service
sudo systemctl enable mariadb.service

mysql_secure_installation

#Php

sudo dnf install php php-common -y
sudo dnf install php php-common php-mysqlnd php-gd php-imap php-xml php-cli php-opcache php-mbstring -y

sudo systemctl restart httpd
php -v

#Test file
sudo touch /var/www/html/info.php
sudo echo '<?php echo phpinfo(); ?>' | sudo tee /var/www/html/info.php
