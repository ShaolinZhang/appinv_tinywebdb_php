<?php

### This is a web service for use with App
### Inventor for Android (<http://appinventor.googlelabs.com>)
### This particular service stores and retrieves tag-value pairs 
### using the protocol necessary to communicate with the TinyWebDB
### component of an App Inventor app.


### Developer: Shaolin Zhang, reprogrammed by PHP code. Inspired by http://appinventorapi.com/program-an-api-php/

$postUrl=$_SERVER["REQUEST_URI"]; 
$tag=$_POST['tag'];
$value=$_POST['value'];

// Storage a value
if(strpos($postUrl,'storeavalue')){ 
  // Get that tag
  $tag = trim($tag); 
  // Get the value 
  $value = trim($value);
  
  if(get_magic_quotes_gpc()){
     $value=stripslashes($value);
  }
  $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);// Connect to MySQL Database
                if($link){
						mysql_select_db(SAE_MYSQL_DB,$link);                        // Connect to the Correct Database(May vary due to different platform)
                        $result=mysql_query("insert into test(tag,value) values('".$tag."','".$value."')");  
                        if($result){
							echo json_encode(array("VALUE",$tag,array_merge(array(array("AFFECTED_ROWS ".mysql_affected_rows($link)))))); // If the query is anything but a SELECT it will return the array eve$
                        } else {
							$result1=mysql_query("update test set value='".$value."' where tag='".$tag."'");
							if($result1){
								echo json_encode(array("VALUE",$tag,array_merge(array(array("AFFECTED_ROWS ".mysql_affected_rows($link)))))); // If the query is anything but a SELECT it will return the array eve$
                            }else{							
								echo json_encode(array("VALUE",$tag,array_merge(array(array(mysql_errno($link).": ".mysql_error($link)))))); // Return errors if the query is bad and spits the error back to the client
							}
                        }
						mysql_close($link);     //close the DB
                } else echo json_encode(array("VALUE",$tag,array_merge(array(array("ERROR Database Connection Failed"))))); // Return ERROR
} else {

  // Retrieving a Value

  // Get that tag
  $tag = trim($tag); 
  $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);   // Connect to MySQL Database
                if($link){
				        mysql_select_db(SAE_MYSQL_DB,$link);                        // Connect to the Correct Database(May vary due to different platform)
                        $result=mysql_query("select value from  test where tag='".$tag."'");  
                        if($result){
                          if(mysql_num_rows($result) == 1){
                           		$row = mysql_fetch_assoc($result);							                          
                          		echo json_encode(array("VALUE",$tag,array($row["value"]))); // Send out a JSON result with merged output data
                          }else
                            echo json_encode(array("VALUE",$tag,array(""))); // Send out a JSON result with merged output data 
                        } else {							
								echo json_encode(array("VALUE",$tag,array_merge(array(mysql_errno($link).": ".mysql_error($link))))); // Return errors if the query is bad and spits the error back to the client
                        }
						mysql_close($link);     //close the DB
                } 
				else echo json_encode(array("VALUE",$tag,array_merge(array("ERROR Database Connection Failed")))); // Return ERROR
} 
?> 
