@echo off

php scripts/1.create_db.php
php scripts/2.create_tables.php
php scripts/3.create_storeprocedures.php

REM this will stop the console from closing to see any errors
pause