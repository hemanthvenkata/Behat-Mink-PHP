# Behat-Mink-PHP
Cross Browser Sample Tests on Saucelabs

#Usage

##Clone this repo:

      $ git clone git@github.com:hemanthvenkata/Behat-Mink-PHP.git
      $ cd Behat-Mink-php

Now install Behat, Mink, MinkExtension and their dependencies with composer:

      $curl http://getcomposer.org/installer | php
      $php composer.phar install

Now You will have additional dependencies in your project 

      $ ls
      README.md     bin           composer.json composer.phar report
      behat.yml     build.xml     composer.lock features      vendor

Download Selenium Server and launch server 

      $ java -jar selenium-server-standalone-2.30.0.jar

Now to launch Behat, just run:

      $ant run

Watch Tests running in the Firefox, Internet Explorer and GoogleChrome in parallel. 

To run in local, just run:

      $ant local

Watch Tests running in Firefox. 
