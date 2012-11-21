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

	# Create the .ssh directory and authorized_keys file:
	sudo -H -u $COLLABORATORY_GIT_USER mkdir /home/$COLLABORATORY_GIT_USER/.ssh
	sudo -H -u $COLLABORATORY_GIT_USER touch /home/$COLLABORATORY_GIT_USER/.ssh/authorized_keys

	# The .ssh directory and authhorized_keys file should be writable:
	sudo chmod -R 0777 /home/$COLLABORATORY_GIT_USER/.ssh
fi

# Install or update Collaboratory:
if [ -d "$COLLABORATORY_HOME" ]; then
	cd $COLLABORATORY_HOME

	# Update Collaboratory:
	sudo -H -u $COLLABORATORY_GIT_USER git pull origin

	# Collaboratory uses Composer to install its dependencies, let's do so:
	sudo -H -u $COLLABORATORY_GIT_USER php composer.phar update
else
	# Install Collaboratory in the user's home directory:
	sudo -H -u $COLLABORATORY_GIT_USER git clone https://github.com/pixelpolishers/collaboratory.git $COLLABORATORY_HOME

	# The shell should have executable rights:
	sudo chmod +x $COLLABORATORY_HOME/data/shell/ssh-shell

	# The logs directory should be writable:
	sudo chmod -R 0777 $COLLABORATORY_HOME/logs

	# The repositories directory should be writable as well:
	sudo chmod -R 0777 $COLLABORATORY_HOME/data/projects

	# Collaboratory uses Composer to install its dependencies, let's do so:
	sudo -H -u $COLLABORATORY_GIT_USER cd $COLLABORATORY_HOME && php composer.phar install
fi

# The IP address that should be used to browse to:
IP_ADDRESS=`ifconfig | awk -F':' '/inet addr/&&!/127.0.0.1/{split($2,_," ");print _[1]}'`

# Add the virtual host:
if [ !(-f "$COLLABORATORY_VHOST") ]; then
	# Add a new virtual host so that apache can find Collaboratory:
	echo "<virtualhost *:80>
		# Server information:
		ServerName $IP_ADDRESS

		# The document index:
		DirectoryIndex index.php
		DocumentRoot $COLLABORATORY_HOME/public

		# PHP settings:
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
echo "- StrictModes no"
echo "- PasswordAuthentication no"
echo "- UsePAM no"
echo
echo "Don't forget to restart SSH: sudo service ssh restart"
echo
echo "When that is done, please visit http://$IP_ADDRESS"
