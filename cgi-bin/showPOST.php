<?php

print_r($_POST);

// Split textarea data by newline, then by tabs
$textAreaData = preg_split('/\r\n|\n|\r/', $_POST["textArea"]);
$textAreaData = array_map(function($substr) { return explode("\t", $substr); }, $textAreaData);

$errors = array();
$warnings = array();

$field_index = $_POST['field_index'];
$table_name = $_POST['table_name'];

// Run queries
foreach($textAreaData as $line) {
	$query = '';
	if (count($line) != $field_index) {
		exit("Field count does not equal number of columns in data!");
	}
	else {
		$query .= "INSERT INTO $table_name (";
	}
	$fields = array();
	$values = array();
	foreach(array_values($line) as $i => $item) {
		$fields[$i] = $_POST['data_'.$i];
		$values[$i] = $item;
	}
	$fields = implode(",", $fields);
	$values = implode(",", $values);
	$query .= "$fields) VALUES ($values)";
	echo $query;
}
