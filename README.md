# collaboratory

Master: [![Build Status](https://secure.travis-ci.org/pixelpolishers/collaboratory.png?branch=master)](http://travis-ci.org/pixelpolishers/collaboratory)

An open source application that enables software developers to manager their projects.

## What is Collaboratory?

Collaboratory is a project management package that helps project managers as well as developers to 
manage and develop projects. By providing support for various software development methods, Collaboratory 
tries is truly the ultimate Agile Software Development tool.

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

To installation of Collaboratory exists out of 5 steps:

1. Install and update the needed packages
2. Install [Gitolite](https://github.com/sitaramc/gitolite)
3. Configure the system by creating the needed users.
4. Install Collaboratory
5. Access Collaboratory through the webbroser and finish the installation.

To simplify these steps we have created an installation script that can be executed as follow:

`$ curl https://raw.github.com/pixelpolishers/collaboratory/master/data/install/ubuntu.sh | sh`

## Acknowledgements

We would like to thank everyone that contributed to this project, our sponsors, the people that donated and you, 
the user. Want to find out more? Please visit us at [pixelpolishers.com](http://pixelpolishers.com)
