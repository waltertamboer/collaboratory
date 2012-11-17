#!/bin/sh

# This is an install script for Ubuntu that helps to install Collaboratory.
# See http://pixelpolishers.com for more information.
# Created by Walter Tamboer - Pixel Polishers

# First off, we exit when there is an error
set -e

# The parameters that are used in the script:
MYSQL_COLLAB_DATABASE="collaboratory"
MYSQL_COLLAB_USERNAME="collaboratory"
MYSQL_COLLAB_PASSWORD=$(cat /dev/urandom | tr -cd [:alnum:] | head -c ${1:-16})

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
sudo apt-get install -y git git-core subversion apache2 mysql-server php5 php5-mysql postfix

# Start the services:
sudo service apache2 start
sudo service mysqld start
sudo service postfix start

# The package have been installed. During the installation the user was asked to
# set the root password for MySQL, we need it for our instllation so let's ask him:
while true; do
    read -p "What is the MySQL root password? " MYSQL_COLLAB_ROOT_PASS
    if [ "$MYSQL_COLLAB_ROOT_PASS" != "" ]; then
        break;
    fi
    echo "Please enter your MySQL root password."
done

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

# For security reasons we let Collaboratory run under its own use:
sudo adduser --disabled-login --gecos 'collaboratory system' collaboratory

# The next step is very important. Gitolite expects a SSH key of the administrator
# and since we're using Collaboratory to manage the Git repositories, we need to
# create one.
sudo -H -u collaboratory ssh-keygen -q -N '' -t rsa -f /home/collaboratory/.ssh/id_rsa

# The next step is to actually install Gitolite. This needs to be done under the git user:
cd /home/git
sudo -u git -H mkdir bin
sudo -H -u git git clone git://github.com/sitaramc/gitolite.git /home/git/gitolite
sudo -u git sh -c 'echo -e "PATH=\$PATH:/home/git/bin\nexport PATH" >> /home/git/.profile'
sudo -u git sh -c 'gitolite/install -ln /home/git/bin'

# Copy over the public key to the git home and then setup Gitolite:
sudo cp /home/collaboratory/.ssh/id_rsa.pub /home/git/collaboratory.pub
sudo chmod 0444 /home/git/collaboratory.pub
sudo -u git -H sh -c "PATH=/home/git/bin:$PATH; gitolite setup -pk /home/git/collaboratory.pub"

# We have two users now (git and collaboratory), we add them to each other's groups so
# the system can easily manage each others directories:
sudo usermod -a -G git collaboratory
sudo usermod -a -G collaboratory git

# Set up the permissions:
sudo chmod -R g+rwX /home/git/repositories/
sudo chown -R git:git /home/git/repositories/

# Let's clone the admin repo of Gitolite so that our key gets recognized:
sudo -H -u collaboratory git clone git@localhost:gitolite-admin.git /tmp/gitolite-admin
sudo rm -rf /tmp/gitolite-admin

# It's now time to install Collaboratory:
cd /home/collaboratory
sudo -H -u collaboratory git clone https://github.com/nextphp/collaboratory.git collaboratory

# Copy over the database configuration file and set the correct values:
cp collaboratory/config/doctrine_orm.production.php.dist collaboratory/config/doctrine_orm.production.php
sed -i "s/collaboratory-database/$MYSQL_COLLAB_DATABASE/g" collaboratory/config/doctrine_orm.production.php
sed -i "s/collaboratory-username/$MYSQL_COLLAB_USERNAME/g" collaboratory/config/doctrine_orm.production.php
sed -i "s/collaboratory-password/$MYSQL_COLLAB_PASSWORD/g" collaboratory/config/doctrine_orm.production.php

# Now actually create the MySQL database and user:
mysql -u root -p$MYSQL_COLLAB_ROOT_PASS -e "CREATE DATABASE IF NOT EXISTS `$MYSQL_COLLAB_DATABASE` DEFAULT CHARACTER SET `utf8` COLLATE `utf8_unicode_ci`;"
mysql -u root -p$MYSQL_COLLAB_ROOT_PASS -e "CREATE USER '$MYSQL_COLLAB_USERNAME'@'localhost' IDENTIFIED BY '$MYSQL_COLLAB_PASSWORD';"
mysql -u root -p$MYSQL_COLLAB_ROOT_PASS -e "GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER ON `$MYSQL_COLLAB_DATABASE`.* TO '$MYSQL_COLLAB_USERNAME'@'localhost';"
mysql -u root -p$MYSQL_COLLAB_ROOT_PASS -e "FLUSH PRIVILEGES;"

# We're done now. Step 2 of the installation is done through the webbrowser. Enjoy!
IP_ADDRESS=`ifconfig | awk -F':' '/inet addr/&&!/127.0.0.1/{split($2,_," ");print _[1]}'`
echo "Installation was successful. Please visit http://$IP_ADDRESS"
