#!/bin/sh

# This is an install script for Ubuntu that helps to install Collaboratory.
# See http://pixelpolishers.com for more information.
# Created by Walter Tamboer - Pixel Polishers

# First off, we exit when there is an error
set -e

# We assume that the target machine is a clean machine. Before we start the
# installation we make sure the machine is up-to-date:
sudo apt-get update
sudo apt-get upgrade

# Now we install all the needed packages. The following packages are needed:
# Git; Collaboratory is able to manage git repositories.
# Subversion; Collaboratory is able to manage subversion repositories.
# Apache; we need a web server since we want to access Collaboratory through the web.
# PHP; We at least need PHP 5.3.3 to run Zend Framework 2.
# MySQL; The application settings of Collaboratory are saved in a MySQL database.
# Postfix; we need to send mails from within Collaboratory.
# OpenSSH Server; we want users to connecto over SSH.
sudo apt-get install -y git git-core subversion apache2 mysql-server php5 php5-mysql php5-intl postfix openssh-server

# People will be able to clone repositories with their own public keys. Gitolite
# handles that for us. To do that we need to create a single which Gitolite will
# use to manage connections. We call this user "git".
sudo adduser \
    --system \
    --shell /bin/sh \
    --gecos 'git version control' \
    --group \
    --disabled-password \
    --home /home/git \
    git

# Move to the new home directory:
cd /home/git

# Install Collaboratory in Git's home directory:
sudo -H -u git git clone https://github.com/pixelpolishers/collaboratory.git /home/git

# Collaboratory uses Composer to install its dependencies, let's do so:
sudo -H -u git php composer.phar install

# The IP address that should be used to browse to:
IP_ADDRESS=`ifconfig | awk -F':' '/inet addr/&&!/127.0.0.1/{split($2,_," ");print _[1]}'`

# Add a new virtual host so that apache can find Collaboratory:
echo "<virtualhost *:80>
    # Server information:
    ServerName $IP_ADDRESS

    # The document index:
    DirectoryIndex index.php
    DocumentRoot /home/git/public

    # PHP settings:
    php_value error_reporting 32767
    php_flag display_errors on
    php_flag display_startup_errors on

    # Log information:
    LogLevel warn
    ErrorLog  /home/git/logs/error.log
    CustomLog /home/git/logs/access.log combined
</virtualhost>" | sudo tee /etc/apache2/sites-available/collaboratory > /dev/null

# Enable the new virtual host:
sudo a2ensite collaboratory
sudo a2enmod rewrite
sudo service apache2 restart

# We're done now. Step 2 of the installation is done through the webbrowser. Enjoy!
echo "Installation was successful. Please visit http://$IP_ADDRESS"
