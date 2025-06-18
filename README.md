# README #

### Requirements ###

PHP 8.3  
&nbsp;&nbsp;&nbsp;&nbsp; - Please make sure your PHP ini has file_uploads = On

Node  
NPM  
Composer
MySQL
MySQL Workbench


### Setup ###
To get the App running please call `build.bat` ... which will execute the build steps for you. 

If you are not running a windows environment please copy the following commands into your terminal and to setup the app
    
    composer install
    npm install
    grunt

If you are running this in a windows environment you need to run the `initialSetup.bat` file. if not please run the
file in the scripts folder in numerical order.

### Data Structure ###

The Data structure of the Objects is built with an interface to enforce structure for additional messages that may need
to be created by future developers. This make further additions clearer, two examples have been included an Email and
Telephone Class. Although the task only requires the ingestion and display of SMS data in a real world environment it
would be likely additional information of this kind will be requested in the future.

Also to aid further developers an abstract class has been created to contain the most common functions that are likely
to be required for further additions. Although normally I would not look to create abstract classes' until a couple of
classes were already created that contained similar functionality.
