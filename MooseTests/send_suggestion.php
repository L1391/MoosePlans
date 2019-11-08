<?php
include_once("conn.php");

$name = addslashes($_POST['name']);
$location = $_POST['location'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$capacity = $_POST['capacity'];
$cost = $_POST['cost'];
$bring_money = $_POST['bring_money'];
$on_campus = $_POST['on_campus'];
$bus_needed = $_POST['bus_needed'];
$vans = $_POST['vans'];
$description = $_POST['description'];

$existing_trip = $db->query("SELECT COUNT(*) FROM trip_def WHERE name='$name'")->fetchColumn();

if ($existing_trip == 0) {
    $add_trip_def = $db->prepare("INSERT INTO trip_def (name, location,description, on_campus, cost, vans_needed, capacity, bring_money, bus_needed)
                                VALUES ('$name', '$location','$description', '$on_campus', '$cost', '$vans', '$capacity', '$bring_money', '$bus_needed')");
    $add_trip_def->execute();
    
}
$existing_trip = $db->query("SELECT id FROM trip_def WHERE name='$name'")->fetch();
$weekend_id = $db->query("SELECT id FROM wknd_def WHERE '$date' BETWEEN start_date AND end_date")->fetch();
$start_date = date("Y-m-d H:i:s", strtotime($date . " " . $start_time));
$end_date = date("Y-m-d H:i:s", strtotime($date . " " . $end_time));
$id = $db->query("SELECT max(id) FROM trip_sched")->fetchColumn() + 1;
if ($id == NULL) $id = 0;

$existing_trip = $existing_trip['id'];
$weekend_id = $weekend_id['id'];

$insert_sched = $db->prepare("INSERT INTO trip_sched (id, trip_id, wknd_id, start_time, end_time)
                            VALUES ('$id','$existing_trip', '$weekend_id','$start_date', '$end_date')");
$insert_sched->execute();
?>