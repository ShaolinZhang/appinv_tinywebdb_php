<?php

/**
 * The TinyWebDB component communicates with a Web service to store
 * and retrieve information.
 * 
 * This particular script is written by 张劭麟 as a replacement
 * of GAE version TinyWebDB http://appinvtinywebdb.appspot.com/ .
 *
 * Prerequisites:
 * PHP and MySQL installed server. For more information, refer
 * to http://www.shaolinzhang.com/php-tinywebdb-service/ for user
 * manual.
 *
 * Special thanks to WEIHUA LI from MIT for guidance.
 * 
 * Please submit issues and bugs via GitHub or my e-mail address.
 * https://github.com/ShaolinZhang/appinv_tinywebdb_php
 * or shaolin@shaolinzhang.com
 */

##Pre-Configuration Sections, DO NOT MODIFY THIS PART!
$postUrl=$_SERVER["REQUEST_URI"]; 
$tag=$_POST['tag'];
$value=$_POST['value'];

##Change the following parameters to link to your own MySQL Database
$MYSQL_HOST_ADDR = SAE_MYSQL_HOST_M; // Server Address or IP
$MYSQL_HOST_PORT = SAE_MYSQL_PORT;  // Server Port
$MYSQL_USERNAME = SAE_MYSQL_USER;	   // Database Username
$MYSQL_PASSWORD = SAE_MYSQL_PASS;    // Database Password
$MYSQL_DBNAME = SAE_MYSQL_DB;        // Database Name

/**
 * Refer to http://www.shaolinzhang.com/php-tinywebdb-service/
 */
$DATA_TABLE_NAME = test;

##Store Value
if(strpos($postUrl,'storeavalue')){ 
	##Trim tag and value from POST
	$tag = trim($tag); 
	$value = trim($value);
	
	##If get_magic_quotes_gpc returns true: delete slashes added by addslashes()
	if(get_magic_quotes_gpc()){
		$value=stripslashes($value);
	}
	
	##Connect to MySQL Database
	$link=mysql_connect($MYSQL_HOST_ADDR.':'.$MYSQL_HOST_PORT,$MYSQL_USERNAME,$MYSQL_PASSWORD);
	if($link){
		mysql_select_db($MYSQL_DBNAME,$link);
		##Send INSERT query to MySQL and get status.
		$result=mysql_query("INSERT into test (tag,value) values('".$tag."','".$value."')");  
		##If tag does not exist,then execute INSERT query.
		if($result){
			echo json_encode(array("STORED",$tag,$value));
		}
		##If tag does exist,then execute UPDATE query.
		else{
			$result1=mysql_query("UPDATE test set value='".$value."' where tag='".$tag."'");
			if($result1){
				echo json_encode(array("STORED",$tag,$value));
			}
			##Return errors if the query is bad and spits the error back to the client
			else{							
				echo json_encode(array("STORED",$tag,array_merge(array(array(mysql_errno($link).": ".mysql_error($link))))));
			}
		}
		##Close connections
		mysql_close($link);
	}
	##Return ERROR if DB Connection Failed
	else
		echo json_encode(array("STORED",$tag,array_merge(array(array("ERROR Database Connection Failed")))));
}

##Get Value
if(strpos($postUrl,'getvalue')){
	##Trim tag from POST
	$tag = trim($tag);
	
	##Connect to MySQL Database
	$link=mysql_connect($MYSQL_HOST_ADDR.':'.$MYSQL_HOST_PORT,$MYSQL_USERNAME,$MYSQL_PASSWORD);
	if($link){
		mysql_select_db($MYSQL_DBNAME,$link);
		##Execute SELECT query to find value inquired by TinyWebDB
		$result=mysql_query("SELECT * FROM test WHERE tag='".$tag."'");
		if($result){
			##Send out a JSON result with merged output data
			if(mysql_num_rows($result) == 1){
				$row = mysql_fetch_array($result);
				echo json_encode(array("VALUE",$tag,$row["value"]));
			}
			else
				echo json_encode(array("VALUE",$tag,array("")));
		}
		##Return errors if the query is bad and spits the error back to the client
		else{
			echo json_encode(array("VALUE",$tag,array_merge(array(mysql_errno($link).": ".mysql_error($link)))));
		}
		##Close connections
		mysql_close($link);
	}
	##Return ERROR if DB Connection Failed
	else
		echo json_encode(array("VALUE",$tag,array_merge(array("ERROR Database Connection Failed"))));
}
?> 
