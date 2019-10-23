<?php
	// Open file .env
	$file = fopen('../../.env', 'r');

	if($file) {
		while(!feof($file)){
	        $line = fgets($file, 4096);
	        $str_arr = explode('=', $line);

	        // Get db config
	        if ($str_arr[0] == "DB_CONNECTION") $conn = trim($str_arr[1]);
	        if ($str_arr[0] == "DB_HOST") $host = trim($str_arr[1]);
	        if ($str_arr[0] == "DB_PORT") $port = trim($str_arr[1]);
	        if ($str_arr[0] == "DB_DATABASE") $db = trim($str_arr[1]);
	        if ($str_arr[0] == "DB_USERNAME") $user = trim($str_arr[1]);
	        if ($str_arr[0] == "DB_PASSWORD") $pwd = trim($str_arr[1]);
	    }

	    fclose($file);
	}

	// Set connect db
	$db = new PDO($conn. ":host=" .$host ."; dbname=" .$db. "; charset=utf8", $user, $pwd);
    $db->exec("set names utf8");
    $db->exec("COLLATE utf8_general_ci");

    function thainumDigit($num) {
	    return str_replace(
	            array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), 
	            array("๐", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙"), 
	            $num
	    );
	}

	function thaimonth($monthparam) {
	    switch ($monthparam) {
	        case 1:
	            $month = 'มกราคม';
	            return $month;
	            break;
	        case 2:
	            $month = 'กุมภาพันธ์';
	            return $month;
	            break;
	        case 3:
	            $month = 'มีนาคม';
	            return $month;
	            break;
	        case 4:
	            $month = 'เมษายน';
	            return $month;
	            break;
	        case 5:
	            $month = 'พฤษภาคม';
	            return $month;
	            break;
	        case 6:
	            $month = 'มิถุนายน';
	            return $month;
	            break;
	        case 7:
	            $month = 'กรกฎาคม';
	            return $month;
	            break;
	        case 8:
	            $month = 'สิงหาคม';
	            return $month;
	            break;
	        case 9:
	            $month = 'กันยายน';
	            return $month;
	            break;
	        case 10:
	            $month = 'ตุลาคม';
	            return $month;
	            break;
	        case 11:
	            $month = 'พฤศจิกายน';
	            return $month;
	            break;
	        case 12:
	            $month = 'ธันวาคม';
	            return $month;
	            break;
	    }
	}