# CSM-CrowdSLR
This project was published in the Brazilian Software Conference in the Tools section (CBSOFT). Its purpose is to support the use of crowdsource to select primary studies in Systematic Literature Reviews.

## Brief Overview

Abstract 

## Demo

For more details and a demo of this running project access this video: 
https://www.youtube.com/watch?v=xxxxxxxx


## Roadmap

This tool was built using the following technologies:

* PHP 7.1
* Apache server
* Bootstrap

### Step 01: getting started
Clone/download this project to your computer and upload into a php web server (we recommend XAMPP server).

If you do not have the apache server installed, one option is to use XAMPP: https://www.apachefriends.org/download.html

This softwares was built to provide a flexible and lightweight tool for researchers, it does not use any database to allow the its portability. However, it is important to note that you will need a PHP server that allows internet users to access it. Therefore, it is recommended that you use some free host system for PHP.

So far it has been tested using the InfinityFree server.
https://infinityfree.net/

### Step 02: setup admin configs

The administrator's settings are necessary to prevent crowdworkers or anyone else from doing some kind of malicious operation while using the tool.

* Config 01: admin password
To change the administrator password, access the config.php file and change the administrator user and password.
OBS: please, insert a strong password. Until now, no protections were provided against bruteforce atacks or any other atacks.
* Config 02: setup config.json
In addition, the config.json file was created and contains the value "host". This value allows you to configure which domain you will use and use the links provided by our software.

### Step 03: execute the setup wizard

After setting the administrator passwords, go to the CrowdSLR homepage and access the configuration wizard.

This wizard has 4 stages: 
(1) configuring the set of studies used for training, 
(2) configuring the set of studies that will be classified, 
(3) previewing the data, 
(4) Download the links for submission to the crowdsource platform.

### step 04: collecting the results

After submitting the form to the crowdsource platform, workers will perform the tasks and the system will store the responses. 
You can follow the progress and collect the final results using the file /results/overview.php. There is a link to these results on the home page.

Results are also considered sensitive data, so it is protected by the administrator's user and password.

### Step 04: Enjoy

This project is OpenSource and still needs several contributions to allow the use of this tool in different scenarios. If you have identified issues that can be improved, leave them in the Issues section.

You can still contact me through github or my website: https://www.computersciencemaster.com.br


