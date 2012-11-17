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
# OpenSSH Server; we want users to connecto over SSH.
sudo apt-get install -y git git-core subversion apache2 mysql-server php5 php5-mysql postfix openssh-server

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
sudo -H -u collaboratory git clone https://github.com/pixelpolishers/collaboratory.git collaboratory

# Collaboratory uses Composer to install its dependencies, let's do so:
cd collaboratory
sudo -H -u collaboratory php composer.phar install

# The IP address that should be used to browse to:
IP_ADDRESS=`ifconfig | awk -F':' '/inet addr/&&!/127.0.0.1/{split($2,_," ");print _[1]}'`

# Add a new virtual host so that apache can find Collaboratory:
echo "<virtualhost *:80>
    # Server information:
    ServerName $IP_ADDRESS

    # The document index:
    DirectoryIndex index.php
    DocumentRoot /home/collaboratory/collaboratory/public

    # PHP settings:
    php_value error_reporting 32767
    php_flag display_errors on
    php_flag display_startup_errors on

    # Log information:
    LogLevel warn
    ErrorLog  /home/collaboratory/collaboratory/logs/error.log
    CustomLog /home/collaboratory/collaboratory/logs/access.log combined
</virtualhost>" | sudo tee /etc/apache2/sites-available/collaboratory > /dev/null

# Enable the new virtual host:
sudo a2ensite collaboratory
sudo a2enmod rewrite
sudo service apache2 restart

# We're done now. Step 2 of the installation is done through the webbrowser. Enjoy!
echo "Installation was successful. Please visit http://$IP_ADDRESS"
