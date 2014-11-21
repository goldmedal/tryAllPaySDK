<?php

function formatRowToCheck($row, $hashKey, $hashIV){

/*******

	1. sort by key
	2. link every key=value
	3. urlencode
	4. strToLower
	5. MD5 hash

 *******/

	ksort($row);
	$returnString = "";

	foreach($row as $key =>$value){  // link to string

		if(!(empty($value))) {
			$returnString = $returnString."&$key=$value";
		}

	}
	
	$returnString = "HashKey=".$hashKey.$returnString."&HashIV=".$hashIV;
	$urlEncode = urlencode($returnString);
	$toLower = strtolower($urlEncode);
	$md5Hash = md5($toLower);

	return $md5Hash;
}

?>