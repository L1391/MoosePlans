<?php
include_once("../conn.php");

//$teach_id = $_SESSION['user_id'];

$trip_ids = $_POST['trip_ids'];
$wknd_id = $_POST['wknd_id'];

$meal1 = $_POST['meal_1'];
$meal2 = $_POST['meal_2'];
$meal3 = $_POST['meal_3'];

$shift1 = $_POSR['shift_off_1'];
$shift2 = $_POSR['shift_off_2'];
$shift3 = $_POSR['shift_off_3'];

foreach($trip_ids as $trip) {
    $add_pref = $db->prepare("INSERT INTO teach_pref (teach_id, wknd_id, shift_off_first, shift_off_second, shift_off_third, meal_on_first, meal_on_second, meal_on_third, trip_id)
    VALUES ('$teach_id', '$wknd_id', '$shift1', '$shift2', '$shift3', '$meal1', '$meal2', '$meal3', '$trip')");

    //$add_pref->execute();
}

?>