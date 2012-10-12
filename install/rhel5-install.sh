#!/bin/bash

# Variables:
export CL_GIT_USER=git
export CL_ROOT_PATH=/var/www/collaboratory
export CL_GITHUB_BRANCH=master

# Quit the script when an error does occur:
set -e

# We always work from the home directory:
cd ~

# Define the die function, that helps us to write a cleaner script:
die()
{
	returnCode=$1
	shift

	echo $@
	exit $returnCode
}

# Make sure that we run this script as a root user:
[[ $EUID -eq 0 ]] || die 1 "You do not have root access."

# Install the EPEL repository:
[[ "$(rpm -q 'epel-release-5-4')" == "epel-release-5-4" ]] || \
	rpm -Uvh http://mirrors.kernel.org/fedora-epel/5/$(uname -i)/epel-release-5-4.noarch.rpm

# Install Remi Collet's repository so we can install PHP:
[[ "$(rpm -q 'remi-release')" == "remi-release-5-8.el5.remi" ]] || \
	rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-5.rpm

# Make sure the system is up-to-date:
yum update -y

# Make sure that all the packages are installed that we depend on:
yum install -y \
	postfix \
	mysql-server mysql php-mysql \
	git

# Install Apache and PHP from Remi Collet's repository:
yum -y --enablerepo=remi,remi-test install \
	httpd php php-common php-pecl-apc php-cli php-pear php-pdo php-mysql \
	php-pgsql php-pecl-mongo php-sqlite php-pecl-memcache php-pecl-memcached \
	php-gd php-mbstring php-mcrypt php-xml

# Create the user "git", all git services will be ran under this user:
if [[ `grep "^$CL_GIT_USER" /etc/passwd` ]]; then
	userdel -r $CL_GIT_USER
fi
if [[ `grep "^$CL_GIT_USER" /etc/group` ]]; then
	groupdel $CL_GIT_USER
fi
useradd -r -m --shell /bin/bash --comment 'git version control' $CL_GIT_USER

# Log in as the user "git" and create a public and private key:
su - $CL_GIT_USER -c 'ssh-keygen -q -N "" -t rsa -f ~/.ssh/id_rsa'

# Install Gitolite:
su - $CL_GIT_USER -c "mkdir -p ~/bin"
su - $CL_GIT_USER -c 'rm -rf gitolite'
su - $CL_GIT_USER -c 'git clone git://github.com/sitaramc/gitolite'
su - $CL_GIT_USER -c "~/gitolite/install -to ~/bin"
su - $CL_GIT_USER -c "gitolite setup -pk ~/.ssh/id_rsa.pub"

# Install Collaboratory:
rm -rf $CL_ROOT_PATH
git clone git://github.com/nextphp/collaboratory.git -b $CL_GITHUB_BRANCH $CL_ROOT_PATH

# Make sure that the group "git" is part of "apache":
usermod -G $CL_GIT_USER apache

# Also make sure that Apache owns the Collaboratory directory:
chown -R apache:apache $CL_ROOT_PATH

# Next we install the scripts from Composer:
cd $CL_ROOT_PATH
php composer.phar self-update
php composer.phar install
cd ~

# Create a virtual host for Collaboratory:
cat > /etc/httpd/conf.d/collaboratory.conf << EOF
<VirtualHost *:80>
    ServerName $HOSTNAME
    DocumentRoot $CL_ROOT_PATH/public
    
    php_flag display_errors on 
    php_flag display_startup_errors on 
    php_value error_reporting 32767

    <Directory $CL_ROOT_PATH/public>
        AllowOverride all
        Options -MultiViews
    </Directory>
</VirtualHost>
EOF

# Enable virtual hosts in Apache:
cat > /etc/httpd/conf.d/enable-virtual-hosts.conf << EOF
NameVirtualHost *:80
EOF

# Open port 80 so that the system can be reached:
iptables -I INPUT -p tcp -m tcp --dport 80 -j ACCEPT

# Make sure that the needed services are on on system startup:
chkconfig httpd on

# Start the services that are needed to run the application:
service iptables save
service postfix start
service mysqld start
service httpd restart
