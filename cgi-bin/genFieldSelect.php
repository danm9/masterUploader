<?php

session_start();

define('db_username', 'root');
define('db_password', 'nef');
define('db_host', '127.0.0.1');
define('db_name', 'testdb_2');

$conn = new mysqli(db_host, db_username, db_password, db_name);

if (mysqli_connect_errno()) {
	echo "Failed to connect to database: " . mysqli_connect_error();
}

$table_name = $_POST['selected_table'];

function genFieldSelect($conn, $table_name) {
	echo "<select class=\"field_sel\" id=\"field_selector_1\" form=\"mainform\">";
	$result = $conn->query("DESCRIBE " . $table_name);
	while ($row = $result->fetch_assoc()) {
		$s = ($row['Field']);
		echo "<option value=\"$s\">$s</option>";
	}
	echo "</select>";
}

genFieldSelect($conn, $table_name);
