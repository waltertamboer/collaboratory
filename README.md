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
The installation of Collaboratory exists out of 3 steps:

### 1. Install Collaboratory

First run following script:

`$ curl https://raw.github.com/pixelpolishers/collaboratory/master/data/install/ubuntu.sh | sh`

This updates your system to the latest version and installs the needed packages such as Apache, MySQL and PHP.

### 2. Manually configure SSH if needed.

The installation script will finish and tells you to update some SSH settings, do this manually in

`/etc/ssh/sshd_config`

### 3. Access Collaboratory through the webbrowser and finish the installation.

Last you need to configure Collaboratory. Here you will enter your database information and create your user account.

## Acknowledgements

We would like to thank everyone that contributed to this project, our sponsors, the people that donated and you, 
the user. Want to find out more? Please visit us at [pixelpolishers.com](http://pixelpolishers.com)
