<?php
	include_once("conn.php");

    $trip_id = $_POST['trip_id'];
    $teach_ids = $_POST['teach_ids'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $start_date = date("Y-m-d H:i:s", strtotime($date . " " . $start_time));
    $end_date = date("Y-m-d H:i:s", strtotime($date . " " . $end_time));

    $teach_id_array = explode(" ", $teach_ids);

    $new_id = $db->query("SELECT max(id) FROM trip_sched")->fetchColumn() + 1;
    if ($new_id == NULL) $new_id = 1;

    for ($t = 0; $t < count($teach_id_array) - 1; $t++) {
        $query = $db->prepare("INSERT INTO trip_sched (id, trip_id, start_time, end_time, wknd_id, teach_id) 
                                VALUES ('$new_id', '$trip_id', '$start_date', '$end_date', 1, '$teach_id_array[$t]')");
        $query->execute();
    }
?>