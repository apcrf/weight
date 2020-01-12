<?php

// Checking parameters
if (isset($_REQUEST["date_start"]) && !dateCheck($_REQUEST["date_start"])) {
	exit("Error parameter: date_start");
}
if (isset($_REQUEST["date_end"]) && !dateCheck($_REQUEST["date_end"])) {
	exit("Error parameter: date_end");
}
if (!isset($_REQUEST["detalization"]) || !in_array($_REQUEST["detalization"], ["day", "week", "month"])) {
	$_REQUEST["detalization"] = "day";
}

// Database Connection Settings
require_once "config.php";

// Creating PDO Object
$pdo = createPDO(DB_HOST, DB_NAME, DB_CHAR, DB_USER, DB_PASS);

// SQL
switch ($_REQUEST["detalization"]) {
	case "day" :
		$sql = "SELECT `weight_date` AS `period`, ROUND(AVG(`weight_value`)) AS `avg`";
		break;
	case "week" :
		$sql = "SELECT DATE_FORMAT(`weight_date`, '%Y-%u') AS `period`, ROUND(AVG(`weight_value`)) AS `avg`";
		break;
	case "month" :
		$sql = "SELECT DATE_FORMAT(`weight_date`, '%Y-%m') AS `period`, ROUND(AVG(`weight_value`)) AS `avg`";
		break;
}

$sql .= " FROM `weight`";

// date_start & date_end
$dates = [];
if (isset($_REQUEST["date_start"])) {
	$dates[] = "`weight_date` >= '{$_REQUEST["date_start"]}'";
}
if (isset($_REQUEST["date_end"])) {
	$dates[] = "`weight_date` <= '{$_REQUEST["date_end"]}'";
}
if ($dates) {
	$sql .= " WHERE " . implode(" AND ", $dates);
}

$sql .= " GROUP BY `period`";

// Load data
// PDO::FETCH_NUM возвращает массив, индексированный номерами столбцов (для использования в highcharts)
$stmt = $pdo->prepare($sql);
$params = [
];
if ($stmt->execute($params)) {
	if ($rows = $stmt->fetchAll(PDO::FETCH_NUM)) {
		header("Content-type: text/html; charset=utf-8");
		http_response_code(200);
		exit(json_encode($rows, JSON_UNESCAPED_UNICODE));
	}
	else {
		exit("Error fetching data");
	}
}
else {
	exit("Query execution error");
}

// Date check
function dateCheck($date) {
	return preg_match('/\d{4}\-\d{2}\-\d{2}/', $date) && checkdate(substr($date,5,2), substr($date,8,2), substr($date,0,4));
}

// Creating PDO Object
function createPDO($db_host, $db_name, $db_char, $db_user, $db_pass) {
	$dsn = "mysql:unix_socket=" . $db_host . ";dbname=" . $db_name . ";charset=" . $db_char;
	$opt  = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => TRUE,
	);
	try {
		return new PDO($dsn, $db_user, $db_pass, $opt);
	}
	catch (PDOException $e) {
		http_response_code(500);
		die($e->getMessage());
	}
}

?>
