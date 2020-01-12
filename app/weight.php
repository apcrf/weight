<?php

// "date_start"=>$_REQUEST["date_start"],
// "date_end"=>$_REQUEST["date_end"],
// "detalization"=>$_REQUEST["detalization"],


// Database Connection Settings
require_once "config.php";

// Creating PDO Object
$pdo = createPDO(DB_HOST, DB_NAME, DB_CHAR, DB_USER, DB_PASS);

// Load data
$sql = "
	SELECT weight_date, weight_value
	FROM weight
	WHERE true
";
$stmt = $pdo->prepare($sql);
$params = [
];
if ($stmt->execute($params)) {
	if ($rows = $stmt->fetchAll()) {
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
