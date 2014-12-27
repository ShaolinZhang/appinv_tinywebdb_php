PHP TinyWebDB Script for MIT App Inventor 2
====================
Developed by Shaolin Zhang, at Shanghai World Foreign Language Middle School.
Submit issues on GitHub or send email with logs to shaolin@shaolinzhang.com, I'll look into it.

USAGE:
===================
Replace SAE_MYSQL_HOST_M with your Main Database Host Name
Replace SAE_MYSQL_PORT with your Database Connection Port
Replace SAE_MYSQL_USER with your Database Username
Replace SAE_MYSQL_PASS with your Database Password
Replace SAE_MYSQL_DB with your Database Name

Initialize a table in your database using the following SQL code:

CREATE TABLE IF NOT EXISTS `test` (
 `tag` varchar (32) NOT NULL,
 `value` varchar (255) NOT NULL,
 PRIMARY KEY (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

Replace 'test' to any name you want to call the table.

ACKNOWLEDGEMENT
===================
Special thanks to WEIHUA LI at MIT CML.