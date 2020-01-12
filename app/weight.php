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

require __DIR__ . "/vendor/autoload.php";
// Database Connection Settings
require_once "config.php";
// Creating PDO Object
$pdo = createPDO(DB_HOST, DB_NAME, DB_CHAR, DB_USER, DB_PASS);
// Creating Fluent PDO Object
$fpdo = new FluentPDO($pdo);

// detalization
switch ($_REQUEST["detalization"]) {
	case "day" :
		$selectTxt = "weight_date AS period, ROUND(AVG(weight_value)) AS avg";
		break;
	case "week" :
		$selectTxt = "DATE_FORMAT(weight_date, '%Y-%u') AS period, ROUND(AVG(weight_value)) AS avg";
		break;
	case "month" :
		$selectTxt = "DATE_FORMAT(weight_date, '%Y-%m') AS period, ROUND(AVG(weight_value)) AS avg";
		break;
}

// conditions: date_start & date_end
$whereTxt = [];
$whereVal = [];
if (isset($_REQUEST["date_start"])) {
	$whereTxt[] = "weight_date >= :date_start";
	$whereVal[":date_start"] = $_REQUEST["date_start"];
}
if (isset($_REQUEST["date_end"])) {
	$whereTxt[] = "weight_date <= :date_end";
	$whereVal[":date_end"] = $_REQUEST["date_end"];
}
$whereTxt = implode(" AND ", $whereTxt);

// Load data
$rows = [];
$query = $fpdo->from("weight")->select($selectTxt)->where($whereTxt, $whereVal)->groupBy("period");
foreach ($query as $row) {
	$rows[] = [ $row["period"], $row["avg"] ];
}

// Output data
header("Content-type: text/html; charset=utf-8");
http_response_code(200);
exit(json_encode($rows, JSON_UNESCAPED_UNICODE));

////////////////////////////////////////////////////////////////////////////////////////////////////

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
