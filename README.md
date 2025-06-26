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

### Code Logic ###

I have used PHP-DI for dependancy injection for the app. This should allow be to preload objects that are likely to
commonly be called as well as abstract away their implementation to make them as loosely coupled as possible.

The Controller contains only the business Logic of the application checking if the request has been passed in the right 
format and the logic around setting up the pages requested.

As the App is a basic CRUD (Create, Read, Update, Delete) app I have used a service class into handle the insert of the
data and Factory classes to get the Data Out.

I could have saved the data as JSON in the DB, which would of made upload quicker, but this could lead to longer load
times when getting reports out of the app as the DB increases in size and all records would have to be passed to get the
full data.

THe DB has been normalised to prevent repeated data from appearing in the DB where it is likely to reoccur such as child
ID, teacher Id, provider ID, Status and Webhook. When inserting via a stored procedure, I check each item to see if it
already exists in the DB and then assign the ID of the table if it does to the main table. If it doesn't it would add a
new one eg.teacher Id

### Missing Code ###

Given more time I would expand the code to use a Factory pattern to get the data out into Objects/Groups of Objects and
use this to display to the screen