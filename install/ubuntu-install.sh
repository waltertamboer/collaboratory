#!bin/sh

# This is an install script for Ubuntu that helps to install Collaboratory.
# See http://pixelpolishers.com for more information.
# Created by Walter Tamboer - Pixel Polishers

# We assume that the target machine is a clean machine. Before we start the
# installation we make sure the machine is up-to-date:
sudo apt-get update
sudo apt-get upgrade

# Now we install all the needed packages. The following packages are needed:
# Git; Collaboratory is able to manage git repositories.
# Subversion; Collaboratory is able to manage subversion repositories.
# PHP; We at least need PHP 5.3.3 to run Zend Framework 2.
# MySQL; The application settings of Collaboratory are saved in a MySQL database.
# Nginx; we need a web server, Nginx is perfect for us.
sudo apt-get install git svn nginx php mysql

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

# We have two users now (git and collaboratory), we add them to each other's groups so
# the system can easily manage each others directories:
sudo usermod -a -G git collaboratory
sudo usermod -a -G collaboratory git

# We're done now. Step 2 of the installation is done through the webbrowser. Enjoy!
IP_ADDRESS=`ifconfig | awk -F':' '/inet addr/&&!/127.0.0.1/{split($2,_," ");print _[1]}'`
echo "Installation was successful. Please visit http://$IP_ADDRESS to start using Collaboratory."