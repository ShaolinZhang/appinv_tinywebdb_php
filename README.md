PHP TinyWebDB Script for MIT App Inventor 2
====================
Developed by Shaolin Zhang, at Shanghai World Foreign Language Middle School.
Submit issues on GitHub or send email with logs to shaolin@shaolinzhang.com, I'll look into it.

For more information and user manual, please access http://www.shaolinzhang.com/php-tinywebdb-service/

USAGE:
===================
Customize the table name:
Replace ‘test’ with any name you want for data to store in, then execute the code.
CREATE TABLE IF NOT EXISTS `test` (
`tag` varchar (32) NOT NULL,
`value` varchar (255) NOT NULL,
PRIMARY KEY (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

Set ServiceURL in App Inventor, TinyWebDB component to
http://<HOST NAME>/TinyWebDB_Service.php/

Set the following parameters according to your own MySQL information:
$MYSQL_HOST_ADDR = SAE_MYSQL_HOST_M; // Server Address or IP 

$MYSQL_HOST_PORT = SAE_MYSQL_PORT; // Server Port 

$MYSQL_USERNAME = SAE_MYSQL_USER; // Database Username 

$MYSQL_PASSWORD = SAE_MYSQL_PASS; // Database Password 

$MYSQL_DBNAME = SAE_MYSQL_DB; // Database Name

Set table name according to the SQL Query to create table:
$DATA_TABLE_NAME = test; // Set table name

After all these steps, open your browser and access
http://<HOST NAME>/TinyWebDB_Service.php/getvalue, if there’s something like:

["VALUE","",""]

Congratulations! The database is up and running!

ACKNOWLEDGEMENT
===================
Special thanks to WEIHUA LI at MIT CML.

LICENSE
===================
This file is released under MIT License.
