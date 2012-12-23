#!/bin/sh

# This is an install script for Ubuntu that helps to install Collaboratory.
# See http://pixelpolishers.com for more information.
# Created by Walter Tamboer - Pixel Polishers

# First off, we exit when there is an error
set -e

# The git user that will be created:
COLLABORATORY_GIT_USER="git"

# The directory to install Collaboratory in.
COLLABORATORY_HOME="/home/$COLLABORATORY_GIT_USER/collaboratory"

# The file of the virtual host file:
COLLABORATORY_VHOST="/etc/apache2/sites-available/collaboratory"

# The apache user and group:
COLLABORATORY_APACHE_USER="www-data"
COLLABORATORY_APACHE_GROUP="www-data"

# The location of the public SSH key of Apache:
COLLABORATORY_APACHE_PUBKEY="/home/$COLLABORATORY_GIT_USER/$COLLABORATORY_APACHE_USER.pub"

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

# People will be able to clone repositories with their own public keys using a single user:
if [ -z "$(getent passwd $COLLABORATORY_GIT_USER)" ]; then
	sudo adduser \
		--system \
		--shell /bin/sh \
		--gecos 'git version control' \
		--group \
		--disabled-password \
		--home /home/$COLLABORATORY_GIT_USER \
		$COLLABORATORY_GIT_USER

fi

# Git management is done using Gitolite. We need to make changes to Gitolite using
# Apache, Apache therefor needs an SSH key.
if [ -f "$COLLABORATORY_APACHE_PUBKEY" ]; then
    echo "Skipped public key generation for Apache since the key already exist."
else
    sudo chmod 0777 /var/www
    sudo -u $COLLABORATORY_APACHE_USER ssh-keygen -q -N '' -t rsa -f /var/www/.ssh/$COLLABORATORY_APACHE_USER
fi

# Now setup Gitolite:
if [ -d "/home/$COLLABORATORY_GIT_USER/bin" ]; then
    echo "Skipped installation of Gitolite since it's already present."
else
    # Download Gitolite:
    cd /home/$COLLABORATORY_GIT_USER
    sudo -H -u $COLLABORATORY_GIT_USER git clone git://github.com/sitaramc/gitolite

    # Install:
    sudo -H -u $COLLABORATORY_GIT_USER mkdir /home/$COLLABORATORY_GIT_USER/bin
    sudo -H -u $COLLABORATORY_GIT_USER gitolite/install -to /home/$COLLABORATORY_GIT_USER/bin

    # Make sure the public key of Apache is readable:
    sudo cp /var/www/.ssh/$COLLABORATORY_APACHE_USER.pub $COLLABORATORY_APACHE_PUBKEY
    sudo chmod 0444 $COLLABORATORY_APACHE_PUBKEY

    # Now setup Gitolite
    sudo -H -u $COLLABORATORY_GIT_USER sh -c "echo \"PATH=\$PATH:/home/$COLLABORATORY_GIT_USER/bin\nexport PATH\" >> /home/$COLLABORATORY_GIT_USER/.profile"
    sudo -H -u $COLLABORATORY_GIT_USER sh -c "PATH=/home/$COLLABORATORY_GIT_USER/bin:$PATH; gitolite setup -pk $COLLABORATORY_APACHE_PUBKEY"

    # We need to setup the SSH config file for the Apache user:
    sudo -H -u $COLLABORATORY_APACHE_USER sh -c "echo \"Host localhost\n\tIdentityFile /var/www/.ssh/$COLLABORATORY_APACHE_USER\" >> /var/www/.ssh/config"

    # Now let's checkout the admin repository so we can set the host:
    sudo -H -u $COLLABORATORY_APACHE_USER git clone $COLLABORATORY_GIT_USER@localhost:gitolite-admin /tmp/gitolite-admin
    sudo rm -rf /tmp/gitolite-admin
fi

# Install or update Collaboratory:
if [ -d "$COLLABORATORY_HOME" ]; then
	cd $COLLABORATORY_HOME

	# Update Collaboratory:
	sudo -H -u $COLLABORATORY_GIT_USER git pull origin

	# Collaboratory uses Composer to install its dependencies, let's do so:
	sudo -H -u $COLLABORATORY_GIT_USER php composer.phar self-update
	sudo -H -u $COLLABORATORY_GIT_USER php composer.phar update
else
	# Install Collaboratory in the user's home directory:
	sudo -H -u $COLLABORATORY_GIT_USER git clone https://github.com/pixelpolishers/collaboratory.git $COLLABORATORY_HOME
	cd $COLLABORATORY_HOME

	# We want git to ignore file mode changes:
	sudo git config core.filemode false

	# We let apache own Collaboratory:
	sudo chown -R $COLLABORATORY_APACHE_USER:$COLLABORATORY_APACHE_GROUP $COLLABORATORY_HOME

	# The logs directory should be writable:
	sudo chmod -R 0666 $COLLABORATORY_HOME/logs

    # Install Composer and install:
    sudo -H -u $COLLABORATORY_APACHE_USER php composer.phar self-update
	sudo -H -u $COLLABORATORY_APACHE_USER php composer.phar install
fi

# The IP address that should be used to browse to:
IP_ADDRESS=`ifconfig | awk -F':' '/inet addr/&&!/127.0.0.1/{split($2,_," ");print _[1]}'`

# Add the virtual host:
if [ -f "$COLLABORATORY_VHOST" ]; then
	echo "Skipped creation of virtual host since it already exists."
else
    # The current time zone to set:
    TIMEZONE=`cat /etc/timezone`

	# Add a new virtual host so that apache can find Collaboratory:
	echo "<virtualhost *:80>
		# Server information:
		ServerName $IP_ADDRESS

		# The document index:
		DirectoryIndex index.php
		DocumentRoot $COLLABORATORY_HOME/public

		# PHP settings:
		php_value date.timezone $TIMEZONE
		php_value error_reporting 32767
		php_flag display_errors on
		php_flag display_startup_errors on

		# Log information:
		LogLevel warn
		ErrorLog  $COLLABORATORY_HOME/logs/error.log
		CustomLog $COLLABORATORY_HOME/logs/access.log combined
	</virtualhost>" | sudo tee $COLLABORATORY_VHOST > /dev/null

	# Enable the new virtual host:
	sudo a2ensite collaboratory
	sudo a2enmod rewrite
fi

# Restart Apache to make sure the latest changes are loaded:
sudo service apache2 restart

# We're done now. Step 2 of the installation is done manually. Enjoy!
echo
echo "The setup of your system was successful but you're not done yet!"
echo "Changes to sshd_config need to be made that we cannot automate."
echo "Please set the following values in /etc/ssh/sshd_config"
echo "- AllowUsers $COLLABORATORY_GIT_USER"
echo "- PasswordAuthentication no"
echo
echo "Don't forget to restart SSH: sudo service ssh restart"
echo
echo "When that is done, please visit http://$IP_ADDRESS"
