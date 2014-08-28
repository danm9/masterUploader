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

function genTableSelect($conn, $db_name) {
	echo "<select id=\"table_selector\" form=\"mainform\">";
	$result = $conn->query("SHOW TABLES");
	while ($row = $result->fetch_assoc()) {
		$s = $row["Tables_in_".$db_name];
		echo "<option value=\"$s\">$s</option>";
	}
	echo "</select>";
}

?>

<!DOCTYPE html>

<HTML>

<head>
	<link rel="stylesheet" href="../css/style.css">
	<title>HLA Completion Database Upload</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="../cgi-bin/script.js"></script>
</head>

<div class="container">
	<h1>Master Database Uploader</h1>
	<div class="spacer"></div>
	<div>
		<form method="post" name="mainform" id="mainform">
			<textarea name="maininput" id="maininput" placeholder="Input data" required></textarea>
			<div class="spacer"></div>
			<h2>Select Table to Upload to:</h2>
			<?php genTableSelect($conn, db_name); ?>
			<h2 id="field_header">Select Fields to insert:</h2>
			<div class="spacer"></div>
			<button name="submit_button" class="btn-green btn-blank" type="submit" form="mainform" value="1">Submit</button>
		</form>
	</div>
	<div class="spacer"></div>
</div>

</HTML>
