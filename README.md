# collaboratory

Master: [![Build Status](https://secure.travis-ci.org/pixelpolishers/collaboratory.png?branch=master)](http://travis-ci.org/pixelpolishers/collaboratory)

An open source application that enables software developers and project managers to manager their projects.

## What is Collaboratory?

Collaboratory is a project management package that helps project managers as well as developers to 
manage and develop projects. By providing support for various software development methods, Collaboratory 
is truly the ultimate Agile Software Development tool.

## Features

Collaboratory contains a lot of features. The most important ones:

* Manage projects using **Scrum**, **Kanban**, **RUP**, **DSDM** and **Prince II**.
* Create and manage repositories using **Git**
* Manage users and **teams**.
* SSH key management through the web interface.
* Bug and issue tracking that can be synchronized with existing software such as **Mantis** or **Jira**
* Merge requests and protected Git branches.
* Browse souce code online.
* Code snippet library.

## Hardware Requirements

* At least 512 MB of RAM

## Software Requirements

**Collaboratory does not work on Windows.**

* Ubuntu Server
* PHP >5.3.3
* Apache 2
* MySQL

## Installing

Currently Collaboratory only works on Ubuntu. We assume you have a clean machine to work with.
The installation of Collaboratory exists out of 4 steps:

### 1. Install Collaboratory

First run following script:

    $ curl https://raw.github.com/pixelpolishers/collaboratory/master/data/install/ubuntu.sh | sh

This updates your system to the latest version and installs the needed packages such as Apache, MySQL and PHP.

### 2. Configure SSH

The installation script will finish and tells you to update some SSH settings, do this manually:

    $ sudo vi /etc/ssh/sshd_config

### 3. Setup MySQL

    # First you need to log in to MySQL:
    $ mysql -u root -p

    # Create the database:
    mysql> CREATE DATABASE IF NOT EXISTS `collaboratory` DEFAULT CHARACTER SET `utf8` COLLATE `utf8_unicode_ci`;

    # Create a new MySQL user, do not forget to set a password:
    mysql> CREATE USER 'collaboratory'@'localhost' IDENTIFIED BY 'MyPassword';

    # And last we give the new user access to the created database:
    mysql> GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER ON `collaboratory`.* TO 'collaboratory'@'localhost';

### 4. Configure Collaboratory

Last you need to configure Collaboratory. Here you will enter the database information from the step before. Here you will also create your user account.

## Acknowledgements

We would like to thank everyone that contributed to this project, our sponsors, the people that donated and you, 
the user. Want to find out more? Please visit us at [pixelpolishers.com](http://pixelpolishers.com)
