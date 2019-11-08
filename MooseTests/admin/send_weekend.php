<?php
include_once("../conn.php");

$teach_ids = $_POST['teach_ids'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$wknd_id = $db->query("SELECT max(id) FROM wknd_def")->fetchColumn() + 1;

foreach($teach_ids as $teach) {
    $insert_weekend = $db->prepare("INSERT INTO wknd_def (id, start_date, end_date, teach_id) VALUES ('$wknd_id', '$start_date', '$end_date', '$teach')");
    $insert_weekend->execute();
    
}

?>